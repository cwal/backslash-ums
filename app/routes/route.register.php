<?php
$route = function($handler) {
	try 
	{
		// Redirect if logged in
		if( C\User::getLoggedUser() )
			G\redirect('account');
		
		if($_POST and !$handler::checkAuthToken($_REQUEST['auth_token'])) 
		{
			$handler->template = 'error'; 
			return;
		}
		
		// Initialize variables
		$is_error = false;
		$is_success = false;
		$alert_message = NULL;
		
		if($_POST)
		{
		//	G\debug($_POST);
		
			// Input validations (ordered least to most important)
			if(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $_POST['password'])) // 1 upper, 1 lower, 1 number, 8 chars
			{
				$alert_message = 'Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number and a minimum of 8 characters';
			}
			if(!C\User::isValidUsername($_POST['username'])) 
			{ 
				$alert_message = 'Invalid username';
			}
			if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
			{
				$alert_message = 'Invalid email address';
			}
			if($alert_message != NULL) 
			{
				$is_error = true;
			}
			
			if(!$is_error)
			{
				$user_db = G\DB::get('users', array('username' => $_POST['username'], 'email' => $_POST['email']), 'OR', NULL);
				
				if($user_db) 
				{
					$is_error = true; // user already exists
					$alert_message = 'That email and/or username exists already';
				}
				else
				{
					// User info
					$pass_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
					$user_data = array(
						'username'	=> $_POST['username'],
						'email'		=> $_POST['email'],
						'password'	=> $pass_hash,
						'status'	=> 'pending'
					);
					
					// Create new user
					$new_user = C\User::createNewUser($user_data);
					
					if(!$new_user) {
						throw new Exception("Could not create a new user", 400);
					} else {
						$token = C\User::createToken($new_user);
						
						$mail = new Mailer();
						$mail->setSMTP($mail);
						$mail->setToFrom($mail, $_POST['email']);
						$mail->setRegisterBody($mail, $token);
						
						if(!$mail->send()) {
						    $is_error = true;
						    $alert_message = 'Confirmation email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
						} else {
						    $is_success = true;
							$alert_message = 'An email has been sent to confirm your account';
						}
					}
				}
			}
		}
		
		$handler::setCond('error', $is_error);
		$handler::setCond('success', $is_success);
		$handler::setVar('alert_message', $alert_message);
	}
	catch(Exception $e) 
	{
		G\exception_to_error($e);
	}
};