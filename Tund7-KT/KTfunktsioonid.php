<?php
	require("../config.php");
	$slDataBase = "if17_rinde";
	
	function saveDayNames($slUserFirstName, $slUserFamilyName, $slInsertedLanguage, $slSunday, $slMonday, $slTuesday, $slWednesday, $slThursday, $slFriday, $slSaturday) {
		
		$slSaveNotice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["slDataBase"]);
			
			$stmt = $mysqli -> prepare("INSERT INTO vptestweekdays (firstname, lastname, language, sunday, monday, tuesday, wednesday, thursday, friday, saturday) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			
			echo $mysqli -> error;
			
			$stmt -> bind_param("ssssssssss", $slUserFirstName, $slUserFamilyName, $slInsertedLanguage, $slSunday, $slMonday, $slTuesday, $slWednesday, $slThursday, $slFriday, $slSaturday);
		
			if ($stmt -> execute()) {
				$slSaveNotice = "Salvestatud!";
			
			}
			else {
				$slSaveNotice = "Salvestamisel tekkis viga: " .$stmt -> error;
			}
			
			$stmt -> close();
			$mysqli -> close();
			return $slSaveNotice;
	}
	
	//Kas keel on andmebaasis
	function languages() {
		$slLanguagesInDB = array();
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["slDataBase"]);
		
		$stmt = $mysqli -> prepare("SELECT language FROM vptestweekdays");
		$stmt -> bind_result($slLanguageInDB);
		$stmt -> execute();
		
		while ($stmt -> fetch()) {
			array_push($slLanguagesInDB, $slLanguageInDB);
		}
		
		$stmt -> close();
		$mysqli -> close();
		return $slLanguagesInDB;
	}







?>