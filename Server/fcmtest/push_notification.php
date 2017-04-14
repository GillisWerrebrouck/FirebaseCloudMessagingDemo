<?php
	function send_notification($tokens, $message){
		$url = "https://fcm.googleapis.com/fcm/send";
		$fields = array(
			"registration_ids" => $tokens,
			"data" => $message
		);
		$headers = array(
			"Authorization:key = AAAAJ8szX6w:APA91bG3sNTjShwLLnft_eBUV_9X2gd2UFTYKqM_CLH2wkSPcnIxunJk-hmCibJF9itEJKg4YXdFMg7W9iAxSy6Hxd443XlGFH9FSPNVMW2GLlftQyI2eiE9B5_df6pD2_--R1kTRuy-",
			"Content-Type: application/json"
		);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);           
		if ($result === FALSE) {
			die('Curl failed: ' . curl_error($ch));
		}
		curl_close($ch);
		
		return $result;
	}
	
	$con = new mysqli(
		"localhost",
		"root",
		"pass123",
		"fcmtest",
		"3306"
	);
	
	$result = $con -> query("SELECT token FROM users;");

	$tokens = array();
    while($row = $result -> fetch_array(MYSQLI_ASSOC)){
        $tokens[] = $row["token"];
    }
		
	$con->close();
	
	$message = array("message" => "This is a FCM test message!");
	
	$message_status = send_notification($tokens, $message);
	echo $message_status;
?>