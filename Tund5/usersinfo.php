<?php
	require("functions.php")
	
	//kas pole sisse loginud
	if (!isset($_SESSION["userId"])) {
		header("Location: login.php");
		exit();
	}
	
	//väljalogimine
	if(isset($_GET["logout"])) {
		session_destroy();
		header(("Location: login.php");
		exit();
	}
	
	

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sander Lukas veebiprogrammeerimine </title>
</head>
<body>
	<h1> Kasutajad </h1>
	<p><b> See leht on loodud õppetöö raames ning ei sisalda mingit tõsiseltvõetavat sisu. </b></p>
	<p> SL - 21 - Rapla </p>
	<p><a href = "?logout = 1"> Logi välja! </a></p>
	<hr>
	<table border = "1" style = "border-collapse: collapse">
		<tr> 
			<th>Eesnimi</th>
			
		</tr>
		
		<tr>
			<td> S </td>
		</tr>
	</table>
</body>
</html>