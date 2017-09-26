<?php	
	$signupFirstName = "";
	$signupFamilyName = "";
	$signupEmail = "";
	$gender = "";
	$signupBirthDay = null;
	$signupBirthMonth = null;
	$signupBirthYear = null;
	$signupBirthDate = null;
	
	$loginEmail = "";
	
	//kas on kasutajanimi sisestatud
	if (isset ($_POST["loginEmail"])){
		if (empty ($_POST["loginEmail"])){
			//$loginEmailError ="NB! Ilma selleta ei saa sisse logida!";
		} else {
			$loginEmail = $_POST["loginEmail"];
		}
	}
	
	//kontrollime, kas kirjutati eesnimi
	if (isset ($_POST["signupFirstName"])){
		if (empty ($_POST["signupFirstName"])){
			//$signupFirstNameError ="NB! Väli on kohustuslik!";
		} else {
			$signupFirstName = $_POST["signupFirstName"];
		}
	}
	
	//kontrollime, kas kirjutati perekonnanimi
	if (isset ($_POST["signupFamilyName"])){
		if (empty ($_POST["signupFamilyName"])){
			//$signupFamilyNameError ="NB! Väli on kohustuslik!";
		} else {
			$signupFamilyName = $_POST["signupFamilyName"];
		}
	}
	
	//kontrollime, kas kirjutati kasutajanimeks email
	if (isset ($_POST["signupEmail"])){
		if (empty ($_POST["signupEmail"])){
			//$signupEmailError ="NB! Väli on kohustuslik!";
		} else {
			$signupEmail = $_POST["signupEmail"];
		}
	}
	
	if (isset ($_POST["signupPassword"])){
		if (empty ($_POST["signupPassword"])){
			//$signupPasswordError = "NB! Väli on kohustuslik!";
		} else {
			//polnud tühi
			if (strlen($_POST["signupPassword"]) < 8){
				//$signupPasswordError = "NB! Liiga lühike salasõna, vaja vähemalt 8 tähemärki!";
			}
		}
	}
	
	if (isset($_POST["gender"]) && !empty($_POST["gender"])){ //kui on määratud ja pole tühi
			$gender = intval($_POST["gender"]);
		} else {
			//$signupGenderError = " (Palun vali sobiv!) Määramata!";
	}
	
	//Kas kuu määratud
	if (isset($_POST["signupBirthMonth"])) {
		$signupBirthMonth = intval($_POST["signupBirthMonth"]);
	}
	
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
			<input type = "email" name = "loginEmail" value = "<?php echo $loginEmail; ?>"><br>
			
			<label> Salasõna: </label><br>
			<input type = "password" name = "loginPassword" placeholder = "Salasõna"><br>
			
			<input type = "submit" value = "Logi sisse">
		</fieldset>
	</form>
	
	<h3> Loo uus kasutaja </h3>
	<form method = "POST">
		<fieldset>
		<label> Kasutajanimi: </label><br>
		<input name = "signupFirstName" type = "text" value = "<?php echo $signupFirstName; ?>"><br>
		
		<label> Perekonnanimi: </label><br>
		<input name="signupFamilyName" type="text" value="<?php echo $signupFamilyName; ?>"><br>
		
		<label> Sünnikuupäev </label>
		<?php echo $signupMonthSelectHTML; ?><br>
		
		<label> Sugu: </label>
		<input type="radio" name="gender" value="1" <?php if ($gender == '1') {echo 'checked';} ?>><label> Mees </label>
		<input type="radio" name="gender" value="2" <?php if ($gender == '2') {echo 'checked';} ?>><label> Naine </label><br>
		
		<label> E-post: </label><br>
		<input name = "signupEmail" type= "email" value="<?php echo $signupEmail; ?>"><br>
		
		<label> Salasõna: </label><br>
		<input name = "signupPassword" type = "password"><br>
		
		<input type = "submit" value = "Esita">
		</fieldset>
	</form>
		
</body>
</html>