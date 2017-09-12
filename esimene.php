<?php
	//see on kommentaar, järgmisena paar muutujat
	$myName = "Sander";
	$my_lastname = "Lukas";
	
	//vaatame, mis kell on ja määrame päeva osa
	$hourNow = date("H");
	//echo $hourNow
	$partOfDay = "";
	
	if ($hourNow < 8) {
		$partOfDay = "varajane hommik";
	}
	if ($hourNow >= 8 and $hourNow < 16) {
		$partOfDay = "koolipäev";
	}
	if ($hourNow >= 16) {
		$partOfDay = "vaba aeg";
	}
	//echo $partOfDay
	
	//vaatame, kaua on koolipäeva lõpuni aega jäänud
	$timeNow = strtotime(date("d.m.Y H:i:s"));
	$schoolDayEnd = strtotime(date("d.m.Y" . " " . "15:45"));
	$tillEnd = $schoolDayEnd - $timeNow
	echo (round($tillEnd / 60));
	
	
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sander Lukas veebiprogrammeerimine </title>
</head>
<body>
	<hl>
	<?php
		echo $myName . " " . $my_lastname;
	?>
		veebiprogrammeerimine </hl>
	<p> See leht on loodud õppetöö raames ning ei sisalda mingit tõsiseltvõetavat sisu. </p>
	<p> SL - 21 - Rapla </p>
	
	<?php
		echo "<p> See on esimene jupp PHP väljastatud teksti! </p>";
		echo "<p> Täna on "; 
		echo date("d.m.Y") . ", kell lehe avamisel oli " . date("H:i:s");
		echo ". Käes on " . $partOfDay  . ".</p>";
	?>
	
</body>
</html>