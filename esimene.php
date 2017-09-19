<?php
	//see on kommentaar, järgmisena paar muutujat
	$myName = "Sander";
	$my_lastname = "Lukas";
	
	$monthNamesET = ["jaanuar", "veebruar", "märts",
					 "aprill", "mai", "juuni", 
					 "juuli", "august", "september", 
					 "oktoober", "november", "detsember"];
	
	//var_dump($monthNamesET);
	//echo $monthNamesET[8];
	$monthNow = $monthNamesET[date("n") - 1];
	
	
	//vaatame, mis kell on ja määrame päeva osa
	$hourNow = date("H");
	//echo $hourNow;
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
	//echo $partOfDay;
	
	//vaatame, kaua on koolipäeva lõpuni aega jäänud
	$timeNow = strtotime(date("d.m.Y H:i:s"));
	$schoolDayEnd = strtotime(date("d.m.Y" . " " . "15:45"));
	$tillEnd = $schoolDayEnd - $timeNow;
	//echo "Koolipäeva lõpuni jäänud " . round($tillEnd / 60) . " minutit";
	
	//Tegeleme vanusega 
	$myBirthYear;
	$ageNotice = "";
	//var_dump($_POST);
	if (isset($_POST["birthYear"])) {
		$myBirthYear = $_POST["birthYear"]; 
		$myAge = date("Y") - $_POST["birthYear"];
		//echo $myAge;
		$ageNotice = "<p> Teie vanus on ligikaudu " .$myAge ." aastat. </p>";
		$ageNotice .= "<p> Olete elanud järgnevatel aastatel: </p>";
		$ageNotice .= "\n <ul> \n";
		$yearNow = date("Y");
		
		for ($i = $myBirthYear; $i <= $yearNow; $i ++) {
			$ageNotice .= "<li>" .$i ."</li> \n"; 
		}
		$ageNotice .= "</ul>";
	}
	//Teeme Tsükli
	/*for ($i = 0; $i < 10; $i ++) {
		echo "ha ";
	}*/
	
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sander Lukas veebiprogrammeerimine </title>
</head>

<body style = "background-color:PaleGoldenRod;">
	<h1>
	<?php
		echo $myName . " " . $my_lastname;
	?>
		veebiprogrammeerimine </h1>
	<p> See leht on loodud õppetöö raames ning ei sisalda mingit tõsiseltvõetavat sisu. </p>
	<p> SL - 21 - Rapla </p>
	
	<?php
		echo "<p> See on esimene jupp PHP väljastatud teksti! </p>";
		echo "<p> Täna on "; 
		echo date("d. ") .$monthNow .date(" Y") .", kell lehe avamisel oli " . date("H:i:s");
		echo ". Käes on " . $partOfDay  . ".</p>";
	?>
	
	<hr>
	<h2> Natuke aastaarvudest </h2>
	
	<form method = "POST">
		<label> Teie sünniaasta: </label>
		<input type = "number" name = "birthYear" id = "birthYear" min = "1900" max = "2017"
		value = "<?php echo $myBirthYear; ?>">
		<input type = "submit" name = "submitBirthYear" value = "Kinnita">
	</form>
	
	<?php
		if ($ageNotice != "") {
			echo $ageNotice;
		}
	?>
</body>
</html>