<?php
	$picsDir = "../pildid/";
	$picList = [];
	$allFiles = scandir($picsDir);
	//var_dump($allFiles);
	$picList = array_slice($allFiles, 2);
	$picCount = count($picList);
	$picNum = mt_rand(0, ($picCount - 1));
	$picFile = $picList[$picNum];
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sander Lukas veebiprogrammeerimine </title>
</head>
<body>
	<h1> SL veebiprogrammeerimine </h1>
	<hr>
	<p><b> See leht on loodud õppetöö raames ning ei sisalda mingit tõsiseltvõetavat sisu. </b></p>
	<p> SL - 21 - Rapla </p>
	<img src = "<?php echo $picsDir .$picFile; ?>" alt = "TLÜ">
</body>
</html>