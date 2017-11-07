<?php
	require("KTfunktsioonid.php");
	
	//Form inputs
	$slUserFirstName = "";
	$slUserFamilyName = "";
	$slInsertedLanguage = "";
	
	$slMonday = "";
	$slTuesday = "";
	$slWednesday = "";
	$slThursday = "";
	$slFriday = "";
	$slSaturday = "";
	$slSunday = "";
	
	//Teated, juhul kui mingi lahter tühjaks jäetud
	$slUserFirstNameError = "";
	$slUserFamilyNameError = "";
	$slInsertedLanguageError = "";
	$slMondayError = "";
	$slTuesdayError = "";
	$slWednesdayError = "";
	$slThursdayError = "";
	$slFridayError = "";
	$slSaturdayError = "";
	$slSundayError = "";
	
	
	//Andmete sisestus kontroll
	if (isset($_POST["insertButton"])) {
		if (isset ($_POST["userFirstName"])) {
			if (empty ($_POST["userFirstName"])) {
				$slUserFirstNameError ="NB! Väli on kohustuslik!";
			} 
			else {
				$slUserFirstName = ($_POST["userFirstName"]);
			}
		}
		
		if (isset($_POST["userFamilyName"])) {
			if (empty($_POST["userFamilyName"])) {
				$slUserFamilyNameError = "NB! Väli on kohustuslik!";
			} else {
				$slUserFamilyName = $_POST["userFamilyName"];
			}
		}
		
		
		if (empty($_POST["language"])) {
			$slInsertedLanguageError = "NB! Väli on kohustuslik!";
		} else {
			$slCurrentLanguagesInDB = languages();
			$slInsertedLanguage = $_POST["language"];
			if (in_array($_POST["language"], $slCurrentLanguagesInDB)) {
				echo "Selline keel on juba andmebaasis!";
			} else {
				saveDayNames($slUserFirstName, $slUserFamilyName, $slInsertedLanguage, $slSunday, $slMonday, $slTuesday, $slWednesday, $slThursday, $slFriday, $slSaturday);
			}
		}
		
		
		
		if (empty($_POST["monday"])) {
			$slMondayError = "NB! Väli on kohustuslik!";
		} else {
			$slMonday = $_POST["monday"];
		}
		
		if (empty($_POST["tuesday"])) {
			$slTuesdayError = "NB! Väli on kohustuslik!";
		} else {
			$slTuesday = $_POST["tuesday"];
		}			
		
		if (empty($_POST["wednesday"])) {
			$slWednesdayError = "NB! Väli on kohustuslik!";
		} else {
			$slWednesday = $_POST["wednesday"];
		}			
		
		if (empty($_POST["thursday"])) {
			$slThursdayError = "NB! Väli on kohustuslik!";
		} else {
			$slThursday = $_POST["thursday"];
		}			
		
		if (empty($_POST["friday"])) {
			$slFridayError = "NB! Väli on kohustuslik!";
		} else {
			$slFriday = $_POST["friday"];
		}
		
		if (empty($_POST["saturday"])) {
			$slSaturdayError = "NB! Väli on kohustuslik!";
		} else {
			$slSaturday = $_POST["saturday"];
		}
		
		if (empty($_POST["sunday"])) {
			$slSundayError = "NB! Väli on kohustuslik!";
		} else {
			$slSunday = $_POST["sunday"];
		}
		}
		
	
	

?>

<!DOCTYPE html>
<html lang = "et">
<head>
	<title> KT </title>
</head>
<body style = "background-color:PaleGoldenRod;">
	<h2> Sisesta nädalapäevad </h2>
	<form method = "POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<fieldset>
		<label> Eesnimi: </label>
		<input name = "userFirstName" type = "text" value = "<?php echo $slUserFirstName; ?>">
		<span> <?php echo $slUserFirstNameError; ?> </span><br>
		
		<label> Perekonnanimi: </label>
		<input name= "userFamilyName" type="text" value="<?php echo $slUserFamilyName; ?>">
		<span> <?php echo $slUserFamilyNameError; ?></span><br>
		
		<label> Keel: </label>
		<input name = "language" type = "text">
		<span> <?php echo $slInsertedLanguageError; ?></span><br>
		
		<label> Esmaspäev: </label>
		<input name = "monday" type = "text">
		<span>  <?php echo $slMondayError; ?></span><br>
		
		<label> Teisipäev: </label>
		<input name = "tuesday" type = "text">
		<span> <?php echo $slTuesdayError; ?> </span><br>
		
		<label> Kolmapäev: </label>
		<input name = "wednesday" type = "text">
		<span> <?php echo $slWednesdayError; ?></span><br>
		
		<label> Neljapäev: </label>
		<input name = "thursday" type = "text">
		<span> <?php echo $slThursdayError; ?></span><br>
		
		<label> Reede: </label>
		<input name = "friday" type = "text">
		<span> <?php echo $slFridayError; ?></span><br>
		
		<label> Laupäev: </label>
		<input name = "saturday" type = "text">
		<span> <?php echo $slSaturdayError; ?></span><br>
		
		<label> Pühapäev: </label>
		<input name = "sunday" type = "text">
		<span> <?php echo $slSundayError; ?></span><br>
		
		<input name = "insertButton" type = "submit" value = "Saada">
		</fieldset>
	</form>
		
</body>
</html>