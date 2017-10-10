<?php
	require("../../../config.php");
	$database = "if17_lukasand";
	
	//alustan sessiooni
	session_start();
	
	
	//Sisselogimine
	function signIn($email, $password) {
		$notice = "";
		//andmebaasi ühendus
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli -> prepare("SELECT id, First_name, Last_name, email, password FROM vpusers WHERE email = ?");
		$stmt -> bind_param("s", $email);
		$stmt -> bind_result($id, $FirstNameFromDB, $LastNameFromDB, $emailFromDB, $passwordFromDB);
		$stmt -> execute();
		
		//Kontrollin vastavust
		if ($stmt -> fetch()) {
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDB) {
				$notice = "Kõik õige. Logisite sisse!";
				
				//sessiooonimuutujad
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDB;
				$_SESSION["userFirstName"] = $FirstNameFromDB;
				$_SESSION["userLastName"] = $LastNameFromDB;
				//liigume pealehele
				header("Location: main.php");
				exit();
			}
			else {
				$notice = "Vale salasõna";
		}
		}
		
		else {
			$notice = "Sellist kasutajat (" .$email . ") ei leitud!";
		}
		$stmt -> close();
		$mysqli -> close();
		return $notice;
	}
		
			

	//Kasutaja andmebaasi salvestamine
	function signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword) {
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//käsk serverile
		$stmt = $mysqli -> prepare("INSERT INTO vpusers (First_name, Last_name, Birthday, Gender, Email, Password) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli -> error;
		//seome andmed
		$stmt->bind_param("sssiss", $signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword);
		// $stmt -> execute();
		if ($stmt -> execute()) {
			echo " > õnnestus!";
		} 
		else {
			echo "tekkis viga! " .$stmt->error;
		}
	}
	
	function saveIdea($idea, $color) {
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli -> prepare("INSERT INTO vpusers_ideas (userid, idea, color) VALUES (?, ?, ?)");
		
		echo $mysqli -> error;
		
		$stmt -> bind_param("iss", $_SESSION["userId"], $idea, $color);
	
		if ($stmt -> execute()) {
			$notice = "Mõte on salvestatud!";
		
		}
		else {
			$notice = "Mõtte salvestamisel tekkis viga: " .$stmt -> error;
		}
		
		$stmt -> close();
		$mysqli -> close();
		return $notice;
	}
	
	function listAllIdeas() {
		$ideasHTML = "";

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		//$stmt = $mysqli -> prepare ("SELECT idea, color FROM vpusers_ideas");
		//$stmt = $mysqli -> prepare ("SELECT idea, color FROM vpusers_ideas WHERE userid = ? ");
		$stmt = $mysqli -> prepare ("SELECT idea, color FROM vpusers_ideas WHERE userid = ? ORDER BY id DESC");
		$stmt -> bind_param("i", $_SESSION["userId"]);
		$stmt -> bind_result($idea, $color);
		$stmt -> execute();
		
		while ($stmt -> fetch()) {
			$ideasHTML .= '<p style = "background-color: ' .$color .'">' .$idea ."</p>\n";
		}
			
		$stmt -> close();
		$mysqli -> close();
		return $ideasHTML;
		
	}
	
	function latestIdea() {
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli -> prepare("SELECT idea FROM vpusers_ideas WHERE id = (SELECT MAX(id) FROM vpusers_ideas)");
		
		$stmt -> bind_result($idea);
		$stmt -> execute();
		$stmt -> fetch();
		
		$stmt -> close();
		$mysqli -> close();
		return $idea;
		
	}
	
	//Sisestuse testimise funktsioon
	function test_input($data) {
		$data = trim($data); //eemaldab lõpust tühikud, TAB jne.
		$data = stripcslashes($data); //eemaldab "\"
		$data = htmlspecialchars($data); //eemaldab keelatud märgid
		return $data;
	}
	
	function users_table() {
		$_SESSION["table"] = '<table border = "1" style = "border-collapse: collapse"> <tr><th>Eesnimi</th> <th>Perekonnanimi</th> <th>E-post</th> <th>Sünnipäev</th> <th>Sugu</th> </tr>';
		
		//andmebaasi ühendus
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli -> prepare("SELECT id, First_name, Last_name, Birthday, Email, Gender FROM vpusers");
		
		$stmt -> bind_result($id, $FirstNameFromDB, $LastNameFromDB, $BirthdayFromDB, $emailFromDB, $genderDB);
		$stmt -> execute();
		
		while($stmt -> fetch()) {
			if ($genderDB == 1) {
				$genderDB = "Mees";
			}
			else {
				$genderDB = "Naine";
			}
			$_SESSION["table"] .= "<tr><td>" .$FirstNameFromDB ."</td><td>" .$LastNameFromDB ."</td><td>" .$emailFromDB ."</td><td>" .$BirthdayFromDB ."</td><td>" .$genderDB ."</td></tr>";
			
		}
		$_SESSION["table"] .= "</table>";
		
		$stmt -> close();
		$mysqli -> close(); 
		return $_SESSION["table"];
		}
		
	
	
		
	/*$x = 4;
	$y = 9;
	echo "Esimene summa on : " .($x + $y);
	echo addValues();
	
	function addValues(){
		echo "Teine summa on : " .($x + $y);
		echo "Kolmas summa on : " .($GLOBALS["x"] + $GLOBALS["y"]);
		$a = 1;
		$b = 2;
		echo "Neljas summa on : " .($a + $b);
	}
	
	echo "Viies summa on: " .($a + $b); <-- Ei saa lokaalseid kutsuda(funktsioonist)*/
?>