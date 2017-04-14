<?php
	if(isset($_POST["token"])){
		$token = $_POST["token"];
		
		$con = new mysqli(
			"localhost",
			"root",
			"pass123",
			"fcmtest",
			"3306"
		);
		
		$stmt = $con->prepare("INSERT INTO users(token) values(?) ON DUPLICATE KEY UPDATE token = ?;");
		$stmt->bind_param("ss", $token, $token);
		$stmt->execute();
		
		$con->close();
	}
?> 