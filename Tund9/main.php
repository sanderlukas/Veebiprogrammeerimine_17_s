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
	
	
	$picsDir = "../pildid/";
	$picFileTypes = ["jpg", "jpeg", "png", "gif"];
	$picFiles = [];
	
	$allFiles = array_slice(scandir($picsDir), 2);
	//var_dump($allFiles);
	
	foreach ($allFiles as $file) {
		$fileType = pathinfo($file, PATHINFO_EXTENSION);
		if (in_array($fileType, $picFileTypes) == True) {
			array_push($picFiles, $file);
		}
	}
	
	$picCount = count($allFiles);
	$picNum = mt_rand(0, ($picCount - 1));
	$picFile = $allFiles[$picNum];
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sander Lukas veebiprogrammeerimine </title>
</head>
<body>
	<h1> Sisseloginud kui <?php echo $_SESSION["userFirstName"] ." " .$_SESSION["userLastName"]; ?> </h1>
	
	<p><a href = "?logout=1"> Logi välja! </a></p>
	<p><a href = "usersinfo.php"> Info süsteemi kasutajate kohta. </a></p>
	<p><a href = "usersideas.php"> *Kasutajate mõtted* </a></p>
	<p><a href = "photoupload.php"> Foto üleslaadimine </a></p>
	<hr>
	<img src = "<?php echo $picsDir .$picFile; ?>" alt = "TLÜ">
	<p> Kõik on õppetöö käigus loodud materjal! </p>
</body>
</html>