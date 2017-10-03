<?php
	$database = "if17_lukasand";
	
	//alustan sessiooni
	session_start();
	
	
	//Sisselogimine
	function signIn($email, $password) {
		$notice = "";
		//andmebaasi ühendus
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli -> prepare("SELECT id, email, password FROM vpusers WHERE email = ?");
		$stmt -> bind_param("s", $email);
		$stmt -> bind_result($id, $emailFromDB, $passwordFromDB);
		$stmt -> execute();
		
		//Kontrollin vastavust
		if ($stmt -> fetch()) {
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDB) {
				$notice = "Kõik õige. Logisite sisse!";
				
				//sessiooonimuutujad
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDB;
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
		} else {
			echo "tekkis viga! " .$stmt->error;
	}
	}
	
	
	
	//Sisestuse testimise funktsioon
	function test_input($data) {
		$data = trim($data); //eemaldab lõpust tühikud, TAB jne.
		$data = stripcslashes($data); //eemaldab "\"
		$data = htmlspecialchars($data); //eemaldab keelatud märgid
		return $data;
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