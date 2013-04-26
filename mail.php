<?php
    
	function enviar_mail($para,$assunto,$mensagem){
		date_default_timezone_set('UTC');
		require("phpmailer/class.phpmailer.php");
		$mail = new PHPMailer(); 
		$mail->IsSMTP(); // send via SMTP
		$mail->SMTPAuth = true; // turn on SMTP authentication
		$mail->Username = "ycfrenchgirl2"; // SMTP username
		$mail->Password = "poliushko"; // SMTP password
		
		$webmaster_email = "ycfrenchgirl2@gmail.com"; //Reply to this email ID
		$mail->From = $webmaster_email;
		$mail->FromName = "Central de testes";
		$mail->AddReplyTo($webmaster_email,"Webmaster");
		
		$email=$para; // Recipients email ID
		$name="Yasmmin"; // Recipient's name
		$mail->AddAddress($email,$name);
		
		$mail->WordWrap = 50; // set word wrap
		$mail->IsHTML(true); // send as HTML
		$mail->Subject = $assunto;
		$mail->Body = $mensagem; //HTML Body
		$mail->AltBody = "This is the body when user views in plain text format"; //Text Body
		
		return $mail->Send();
	}
	$login="nim_asay@hotmail.com";
	$mensagem="Sua senha é yasmmin";
	
	if(enviar_mail($login,"Lembrete de senha",$mensagem)){
		echo "Message has been sent";
	}
	else {
		echo "Mailer Error: " . $mail->ErrorInfo;
	}
?>