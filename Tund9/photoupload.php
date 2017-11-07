<?php
	require("functions.php");
	
	//kas pole sisse loginud
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	
	//väljalogimine
	if(isset($_GET["logout"])) {
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
	
	$errorNotice = "";
	// Kontroll pildile
	if(isset($_POST["submit"])) {
		if(!empty($_FILES["fileToUpload"]["name"])) {
			$target_dir = "../pildid/";
			$maxWidth = 600;
			$maxHeight = 400;
			$marginBottom = 10;
			$marginRight = 10;
			
			//Failitüüp
			$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION));
			
			//Ajatempel pildifailile
			$timestamp = microtime(1) * 10000;
			
			//Lõplik failinimi
			$target_file = $target_dir . pathinfo(basename($_FILES["fileToUpload"]["name"]))["filename"] ."_" .$timestamp ."." .$imageFileType;
			
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			
			if($check !== false) {
				$errorNotice = "Fail on pilt - " .$check["mime"] .".";
				$uploadOk = 1;
			} else {
				$errorNotice = "Fail ei ole pilt.";
				$uploadOk = 0;
			}
			
				// Kas pilt olemas juba
			if (file_exists($target_file)) {
				$errorNotice = "Selline pildifail on juba olemas.";
				$uploadOk = 0;
			}
			
			 // Pildi suuruse kontroll
			if ($_FILES["fileToUpload"]["size"] > 1000000) {
				$errorNotice = "Pilt on liiga suur.";
				$uploadOk = 0;
			 }
			 
			// Luba ainult teatud tüübid
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif") {
				$errorNotice = "Ainult JPG, JPEG, PNG & GIF failid on lubatud.";
				$uploadOk = 0;
			}
			
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				$errorNotice = "Tekkis viga, faili ei laetud üles.";
			// if everything is ok, try to upload file
			} else {
				/*if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					$errorNotice = "Fail ". basename($_FILES["fileToUpload"]["name"]). " laeti üles.";
				} else {
					$errorNotice = "Tekkis viga, faili ei laetud üles.";
				}*/
				if ($imageFileType == "jpg" or $imageFileType == "jpeg") {
					$myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
				}
				
				if ($imageFileType == "png") {
					$myTempImage = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
				}
				
				if ($imageFileType == "gif") {
					$myTempImage = imagecreatefromgif($_FILES["fileToUpload"]["tmp_name"]);
				}
				//Teeme kindlals originaal suuruse
				$imageWidth = imagesx($myTempImage);
				$imageHeight = imagesy($myTempImage);
				
				if ($imageWidth > $imageHeight) {
					$sizeRatio = $imageWidth / $maxWidth;
				} else {
					$sizeRatio = $imageHeight / $maxHeight;	
				}
				
				//Muudame pildi suuruse
				$myImage = resizeImage($myTempImage, $imageWidth, $imageHeight, round($imageWidth / $sizeRatio), round($imageHeight / $sizeRatio));
				
				//Lisame vesimärgi
				$watermark = imagecreatefrompng("../pildid/hmv_logo.png");
				$watermarkW = imagesx($watermark);
				$watermarkH = imagesx($watermark);
				$watermarkPosX = round($imageWidth / $sizeRatio) - $watermarkW - $marginRight;
				$watermarkPosY = round($imageHeight / $sizeRatio) - $watermarkH - $marginBottom;
				imagecopy($myImage, $watermark, $watermarkPosX, $watermarkPosY, 0, 0, $watermarkW, $watermarkH);
				
				$textToImage = "Heade mõtete veeb";
				$textColor = imagecolorallocatealpha($myImage, 255, 255, 255, 60);
				imagettftext($myImage, 20, 0, 10, 25, $textColor,,$textToImage);
				
				//Faili salvestamine
				if ($imageFileType == "jpg" or $imageFileType == "jpeg") {
					if(imagejpeg($myImage, $target_file, 90)) {
						$errorNotice = "Fail: " .$_FILES["fileToUpload"]["name"] ." laeti üles!";
					} else {
						$errorNotice = "Faili üleslaadimine ebaõnnestus!";
					}
				}
				
				if ($imageFileType == "png") {
					if(imagepng($myImage, $target_file, 6)) {
						$errorNotice = "Fail: " .$_FILES["fileToUpload"]["name"] ." laeti üles!";
					} else {
						$errorNotice = "Faili üleslaadimine ebaõnnestus!";
					}
				}
				
				if ($imageFileType == "gif") {
					if(imagegif($myImage, $target_file)) {
						$errorNotice = "Fail: " .$_FILES["fileToUpload"]["name"] ." laeti üles!";
					} else {
						$errorNotice = "Faili üleslaadimine ebaõnnestus!";
					}
				}
				imagedestroy($myTempImage);
				imagedestroy($myImage);
				imagedestroy($watermark);
			}
		} else {
			$errorNotice = "Palun vali fail!";
			}
	}
	
	function resizeImage($image, $origW, $origH, $w, $h) {
		$newImage = imagecreatetruecolor($w, $h);
		imagecopyresampled($newImage, $image, 0, 0, 0, 0, $w, $h, $origW, $origH);
		return $newImage;
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sander Lukas veebiprogrammeerimine </title>
</head>
<body>
	<h1> Sisseloginud kui <?php echo $_SESSION["userFirstName"] ." " .$_SESSION["userLastName"]; ?> </h1>
	<p><a href = "main.php"> Pealeht </a></p>
	<p><a href = "?logout=1"> Logi välja! </a></p>
	<hr>
	<form action= "photoupload.php" method = "POST" enctype = "multipart/form-data">
    <p> Vali pilt üleslaadimiseks: </p>
    <input type = "file" name = "fileToUpload" id = "fileToUpload">
    <input type = "submit" value = "Lae pilt" name = "submit">
	<span> <?php echo $errorNotice; ?> </span>
</form>
	<hr>
	<p> Kõik on õppetöö käigus loodud materjal! </p>
</body>
</html>