<?php	
	$yourloginEmail = "";
	if (isset($_POST["loginEmail"])) {
		$yourloginEmail = $_POST["loginEmail"];
	}
	//var_dump($_POST);
	//echo $yourloginEmail;
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
			<input type = "email" name = "loginEmail" value = "<?php echo $yourloginEmail; ?>"><br>
			
			<label> Salasõna: </label><br>
			<input type = "password" name = "loginPassword"><br>
			
			<input type = "submit" value = "Logi sisse">
		</fieldset>
	</form>
	
	<h3> Loo uus kasutaja </h3>
	<form method = "POST">
		<fieldset>
		<label> Kasutajanimi: </label><br>
		<input name = "signupFirstName" type = "text"><br>
		
		<label> Perekonnanimi: </label><br>
		<input name="signupFamilyName" type="text"><br>
		
		<label> Sugu: </label>
		<input type="radio" name="gender" value="1" checked>Mees
		<input type="radio" name="gender" value="2">Naine <br>
		
		<label> E-post: </label><br>
		<input name = "signupEmail" type= "email"><br>
		
		<label> Salasõna: </label><br>
		<input name = "signupPassword" type = "password"><br>
		
		<input type = "submit" value = "Esita">
		</fieldset>
	</form>
		
</body>
</html>