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
	
	$target_dir = "../pildid/";
	$target_file = $target_dir .basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
	// Kontroll pildile
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " .$check["mime"] .".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}
		// Kas pilt olemas juba
	if (file_exists($target_file)) {
		echo "Selline pildifail on juba olemas.";
		$uploadOk = 0;
	}
	
	 // Pildi suuruse kontroll
	if ($_FILES["fileToUpload"]["size"] > 500) {
		echo "Pilt on liiga suur.";
		$uploadOk = 0;
	 }
	 
	// Luba ainult teatud tüübid
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif") {
		echo "Ainult JPG, JPEG, PNG & GIF failid on lubatud.";
		$uploadOk = 0;
	}
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Tekkis viga, faili ei laetud üles.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "Fail ". basename($_FILES["fileToUpload"]["name"]). " laeti üles.";
		} else {
			echo "Tekkis viga, faili ei laetud üles.";
		}
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
	<form action= "upload.php" method = "POST" enctype = "multipart/form-data">
    <p> Vali pilt üleslaadimiseks: </p>
    <input type = "file" name = "fileToUpload" id = "fileToUpload">
    <input type = "submit" value = "Lae pilt" name = "submit">
</form>
	<p> Kõik on õppetöö käigus loodud materjal! </p>
</body>
</html>