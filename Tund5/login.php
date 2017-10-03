<?php	
	require("../../../config.php");
	require("functions.php");
	
	$loginEmail = "";
	$signupFirstName = "";
	$signupFamilyName = "";
	$signupEmail = "";
	$gender = "";
	$signupBirthDay = null;
	$signupBirthMonth = null;
	$signupBirthYear = null;
	$signupBirthDate = null;
	
	$loginEmailError = "";
	$signupFirstNameError = "";
	$signupFamilyNameError = "";
	$signupBirthDayError = "";
	$signupGenderError = "";
	$signupEmailError = "";
	$signupPasswordError = "";
	
	//kas on kasutajanimi sisestatud
	if (isset ($_POST["loginEmail"])){
		if (empty ($_POST["loginEmail"])){
			$loginEmailError ="NB! Ilma selleta ei saa sisse logida!";
		} 
		else {
			$loginEmail = $_POST["loginEmail"];
		}
	}
	
	if (isset($_POST["signupButton"])) {
		
	
	//kontrollime, kas kirjutati eesnimi
	if (isset ($_POST["signupFirstName"])){
		if (empty ($_POST["signupFirstName"])){
			$signupFirstNameError ="NB! Väli on kohustuslik!";
		} else {
			$signupFirstName = test_input($_POST["signupFirstName"]);
		}
	}
	
	//kontrollime, kas kirjutati perekonnanimi
	if (isset ($_POST["signupFamilyName"])){
		if (empty ($_POST["signupFamilyName"])){
			$signupFamilyNameError ="NB! Väli on kohustuslik!";
		} else {
			$signupFamilyName = test_input($_POST["signupFamilyName"]);
		}
	}
	
	//kontrollime, kas kirjutati kasutajanimeks email
	if (isset ($_POST["signupEmail"])){
		if (empty ($_POST["signupEmail"])){
			$signupEmailError ="NB! Väli on kohustuslik!";
		} else {
			$signupEmail = test_input($_POST["signupEmail"]);
			$signupEmail = filter_var($signupEmail, FILTER_SANITIZE_EMAIL);
			if (!filter_var($signupEmail, FILTER_VALIDATE_EMAIL)) {
				$signupEmailError = "Sisestatud e-mail pole nõutud kujul!";
			}
		}
	}
	
	if (isset ($_POST["signupPassword"])){
		if (empty ($_POST["signupPassword"])){
			$signupPasswordError = "NB! Väli on kohustuslik!";
		} else {
			//polnud tühi
			if (strlen($_POST["signupPassword"]) < 8){
				$signupPasswordError = "NB! Liiga lühike salasõna, vaja vähemalt 8 tähemärki!";
			}
		}
	}
	
	if (isset($_POST["gender"]) && !empty($_POST["gender"])){ //kui on määratud ja pole tühi
			$gender = intval($_POST["gender"]);
		} else {
			$signupGenderError = " (Palun vali sobiv!) Määramata!";
	}
	
	//Päeva määramine
	if (isset ($_POST["signupBirthDay"])){
		$signupBirthDay = $_POST["signupBirthDay"];
		//echo $signupBirthDay;
	}
	
	//Kas kuu määratud
	if (isset($_POST["signupBirthMonth"])) {
		$signupBirthMonth = intval($_POST["signupBirthMonth"]);
	}
	
	//Aasta määramine
	if (isset ($_POST["signupBirthYear"])){
		$signupBirthYear = $_POST["signupBirthYear"];
		//echo $signupBirthYear;
	}
	
	//kui sünnikuupäev on sisestatud, siis kontrollima, kas valiidne
	if (isset($_POST["signupBirthDay"]) and isset($_POST["signupBirthMonth"]) and isset($_POST["signupBirthYear"])) {
		if (checkdate(intval($_POST["signupBirthMonth"]), intval($_POST["signupBirthDay"]), intval($_POST["signupBirthYear"]))) {
			$birthDate = date_create($_POST["signupBirthMonth"] ."/" .$_POST["signupBirthDay"] ."/" .$_POST["signupBirthYear"]);
			$signupBirthDate = date_format($birthDate, "Y-m-d");
		} 
		else {
			$signupBirthDayError = "Viga sünnikuupäeva sisestamisel!";
			//echo $signupBirthDayError;
		}
	}
	} //Kas vajutati "Loo kasutaja" nuppu
	
	//Tekitame kuupäeva valiku
	$signupDaySelectHTML = "";
	$signupDaySelectHTML .= '<select name="signupBirthDay">' ."\n";
	$signupDaySelectHTML .= '<option value="" selected disabled>päev</option>' ."\n";
	for ($i = 1; $i < 32; $i ++){
		if($i == $signupBirthDay){
			$signupDaySelectHTML .= '<option value="' .$i .'" selected>' .$i .'</option>' ."\n";
		} else {
			$signupDaySelectHTML .= '<option value="' .$i .'">' .$i .'</option>' ." \n";
		}
		
	}
	$signupDaySelectHTML.= "</select> \n";
	
	
	//Tekitame sünnikuu valiku
	$monthNamesET = ["jaanuar", "veebruar", "märts",
					 "aprill", "mai", "juuni", 
					 "juuli", "august", "september", 
					 "oktoober", "november", "detsember"];
	
	$signupMonthSelectHTML = "";
	$signupMonthSelectHTML .= '<select name = "signupBirthMonth">' ."\n";
	$signupMonthSelectHTML .= '<option value = "" selected disabled> kuu </option>' ."\n";
	foreach ($monthNamesET as $key => $month) {
		if ($key + 1 === $signupBirthMonth) {
			$signupMonthSelectHTML .= '<option value = "' .($key + 1) .'" selected>' .$month ."</option> \n"; 
		} else {
			$signupMonthSelectHTML .= '<option value = "' .($key + 1) .'">' .$month ."</option> \n";
		}			
	}
	$signupMonthSelectHTML .= "</select \n>";	
	
	//Tekitame aasta valiku
	$signupYearSelectHTML = "";
	$signupYearSelectHTML .= '<select name="signupBirthYear">' ."\n";
	$signupYearSelectHTML .= '<option value="" selected disabled>aasta</option>' ."\n";
	$yearNow = date("Y");
	for ($i = $yearNow; $i > 1900; $i --){
		if($i == $signupBirthYear){
			$signupYearSelectHTML .= '<option value="' .$i .'" selected>' .$i .'</option>' ."\n";
		} else {
			$signupYearSelectHTML .= '<option value="' .$i .'">' .$i .'</option>' ."\n";
		}
		
	}
	$signupYearSelectHTML.= "</select> \n";
	
	//ANDMEBAAS
	if (empty($signupFirstNameError) and empty($signupFamilyNameError) and empty($signupBirthDayError) and empty($signupGenderError) and empty($signupEmailError) and empty($signupPasswordError) and !empty($signupBirthDate)) {
		echo "Hakkan salvestama";
		
		$signupPassword = hash("sha512", $_POST["signupPassword"]);
		//Ühendus serveriga
		signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword);
		}
		
?>

<!DOCTYPE html>
<html lang = "et">
<head>
	<meta charset="utf-8">
	<title> SL veeb </title>
</head>
<body style = "background-color:PaleGoldenRod;">
	<h3> Sisselogimine </h3>	
	<form method = "POST">
		<fieldset>
			<label> Kasutajanimi: </label><br>
			<input type = "email" name = "loginEmail" value = "<?php echo $loginEmail; ?>">
			<span> <?php echo $loginEmailError; ?> </span><br>
			
			<label> Salasõna: </label><br>
			<input type = "password" name = "loginPassword" placeholder = "Salasõna"><br>
			
			<input name = "signinButton" type = "submit" value = "Logi sisse">
		</fieldset>
	</form>
	
	<h3> Loo uus kasutaja </h3>
	<form method = "POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<fieldset>
		<label> Kasutajanimi: </label><br>
		<input name = "signupFirstName" type = "text" value = "<?php echo $signupFirstName; ?>">
		<span> <?php echo $signupFirstNameError; ?> </span><br>
		
		<label> Perekonnanimi: </label><br>
		<input name="signupFamilyName" type="text" value="<?php echo $signupFamilyName; ?>">
		<span> <?php echo $signupFamilyNameError; ?> </span><br>
		
		<label> Sünnikuupäev: </label><br>
		<?php echo $signupDaySelectHTML .$signupMonthSelectHTML .$signupYearSelectHTML ?><br>
		
		<label> Sugu: </label>
		<input type="radio" name="gender" value="1" <?php if ($gender == '1') {echo 'checked';} ?>><label> Mees </label>
		<input type="radio" name="gender" value="2" <?php if ($gender == '2') {echo 'checked';} ?>><label> Naine </label>
		<span> <?php echo $signupGenderError; ?> </span><br>
		
		<label> E-post: </label><br>
		<input name = "signupEmail" type= "email" value="<?php echo $signupEmail; ?>">
		<span> <?php echo $signupEmailError; ?> </span><br>
		
		<label> Salasõna: </label><br>
		<input name = "signupPassword" type = "password">
		<span> <?php echo $signupPasswordError; ?> </span><br>
		
		<input name = "signupButton" type = "submit" value = "Loo uus kasutaja">
		</fieldset>
	</form>
		
</body>
</html>