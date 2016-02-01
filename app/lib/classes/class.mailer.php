<?php

require_once G_APP_PATH_VENDOR . 'phpmailer/PHPMailerAutoload.php';

class Mailer extends PHPMailer {
	
	public function setSMTP(&$mail)
	{
		$mail->isSMTP();										// Set mailer to use SMTP
		$mail->Host = G\get_app_setting('smtp_host');			// Specify main and backup SMTP servers
		$mail->SMTPAuth = true;									// Enable SMTP authentication
		$mail->Username = G\get_app_setting('smtp_username');	// SMTP username
		$mail->Password = G\get_app_setting('smtp_password');	// SMTP password
		$mail->SMTPSecure = G\get_app_setting('smtp_secure');	// Enable TLS encryption, `ssl` also accepted
		$mail->Port = G\get_app_setting('smtp_port');			// TCP port to connect to
	}
	
	public function setToFrom(&$mail, $to)
	{
		$mail->From = G\get_app_setting('website_email');
		$mail->FromName = G\get_app_setting('website_name');
		$mail->addAddress($to);
		$mail->addReplyTo(G\get_app_setting('website_email'));
	}
	
	public function setRegisterBody(&$mail, $token)
	{
		$mail->isHTML(true);
		$mail->Subject = 'Welcome to ' . G\get_app_setting('website_name');
		$mail->Body    = 'Thank you for signing up at ' . G\get_app_setting('website_name') . '!<br><br> Please <a href="' . G\get_base_url('login/activate/?token=' . $token) . '">click here to confirm your account</a>.';
		$mail->AltBody = 'Thank you for signing up at ' . G\get_app_setting('website_name') . '!\r\n\r\n Please click the link below to activate your account.\r\n\r\n ' . G\get_base_url('login/activate/?token=' . $token);
	}
	
	public function setForgotBody(&$mail, $token)
	{
		$mail->isHTML(true);
		$mail->Subject = 'Password Reset';
		$mail->Body    = 'You have requested a password reset at ' . G\get_app_setting('website_name') . '!<br><br> Please <a href="' . G\get_base_url('login/reset/?token=' . $token) . '">click here to reset your password</a>.';
		$mail->AltBody = 'You have requested a password reset at ' . G\get_app_setting('website_name') . '!\r\n\r\n Please click the link below to reset your password.\r\n\r\n ' . G\get_base_url('login/reset/?token=' . $token);
	}
	
}