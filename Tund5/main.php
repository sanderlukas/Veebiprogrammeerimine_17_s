<?php
	require("functions.php")
	
	//kas pole sisse loginud
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	
	//väljalogimine
	if(isset($_GET["logout"])) {
		session_destroy();
		header(("Location: login.php");
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
	<h1> SL veebiprogrammeerimine </h1>
	<p><b> See leht on loodud õppetöö raames ning ei sisalda mingit tõsiseltvõetavat sisu. </b></p>
	<p> SL - 21 - Rapla </p>
	<p><a href = "?logout = 1"> Logi välja! </a></p>
	<p><a href = "usersinfo.php"> Info süsteemi kasutajate kohta. </a></p>
	<hr>
	<img src = "<?php echo $picsDir .$picFile; ?>" alt = "TLÜ">
</body>
</html>