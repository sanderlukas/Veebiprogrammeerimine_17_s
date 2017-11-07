<?php
	require("../../../config.php");
	$database = "if17_lukasand";
	
	//ühe mõtte lugemise funktsioon
	function getSingleIdea($id) {
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli -> prepare ("SELECT idea, color FROM vpusers_ideas WHERE id = ?");
		$stmt -> bind_param("i", $id);
		$stmt -> bind_result($idea, $color);
		$stmt -> execute();
		
		$ideaObject = new Stdclass();
		
		if ($stmt -> fetch()) {
			$ideaObject -> text = $idea;
			$ideaObject -> color = $color;
		} else {
			header("Location: usersideas.php");
			exit();
		
		
		
		$stmt -> close();
		$mysqli -> close();
		return $ideaObject;
		}
	}
	
	function updateIdea($id, $idea, $color) {
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli -> prepare("UPDATE vpusers_ideas SET idea = ?, color = ? WHERE id = ?");
		$stmt -> bind_param("ssi", $idea, $color, $id);
		$stmt -> execute();
		
		$stmt -> close();
		$mysqli -> close();
		
	}
	
	function deleteIdea($id) {
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli -> prepare("UPDATE vpusers_ideas SET deleted = NOW() WHERE id = ?");
		$stmt -> bind_param("i", $id);
		
		$stmt -> close();
		$mysqli -> close();
	
	}
?>