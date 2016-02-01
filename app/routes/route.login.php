<?php
$route = function($handler) {
	try 
	{
		// Redirect if logged in
		if( C\User::getLoggedUser() )
			G\redirect('account');
		
		// Initialize variables
		$is_error = false;
		$is_success = false;
		$alert_message = NULL;
		
		// user forgot their password
		if($handler->getRoute(true) == 'login/forgot')
		{
			$handler->template = 'login-forgot';
		}
		
		// let the user reset their password
		if($handler->getRoute(true) == 'login/reset' && $_GET['token'])
		{
			$valid = C\User::verifyToken($_GET['token']); // ensure token matches database
			if($valid && $valid['status'] != 'banned')
			{
				$handler->template = 'login-reset';
			}
			else
			{
				$is_error = true;
				$alert_message = 'Password reset link is no longer valid.';
			}
		}
		
		// a user has clicked a confirmation email link
		if($handler->getRoute(true) == 'login/activate' && $_GET['token'] && !$_POST)
		{
			$valid = C\User::verifyToken($_GET['token']); // ensure token matches database
			if($valid && $valid['status'] == 'pending')
			{
				G\DB::update( 'users', array('status' => 'valid'), array('id' => $valid['id']) ); // set status to valid
				$is_success = true;
				$alert_message = 'Your account has been activated. You can now login.';
			}
			else
			{
				// check if user is already active
				$token_info = explode(":", $_GET['token']); // 0->id, 1->unhashed token, 2->timestamp
				$exists = G\DB::get('users', array('id' => $token_info[0]));
				if($exists && $exists[0]['status'] == 'valid')
				{
					$is_error = true;
					$alert_message = 'Your account is already active.';
				}
				else
				{
					$is_error = true;
					$alert_message = 'There was an error activating your account.';
				}
			}
		}
		
		if($_POST and !$handler::checkAuthToken($_REQUEST['auth_token'])) 
		{
			$handler->template = 'error'; 
			return;
		}
		
		if($_POST)
		{
		//	G\debug($_POST);
		
			// Send password reset email
			if($handler->getRoute(true) == 'login/forgot')
			{
				$user = G\DB::get('users', array('email' => $_POST['email']));
				if($user && !empty($user))
				{
					$token = C\User::createToken($user[0]['id']);
					
					$mail = new Mailer();
					$mail->setSMTP($mail);
					$mail->setToFrom($mail, $_POST['email']);
					$mail->setForgotBody($mail, $token);
					
					if(!$mail->send()) {
					    $is_error = true;
					    $alert_message = 'Password reset email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
					} else {
					    $is_success = true;
						$alert_message = 'An email has been sent to reset your password';
					}
				}
				else 
				{
					$is_error = true;
					$alert_message = 'Invalid email address';
				}
			}
			
			// Verify new password and save it
			if($handler->getRoute(true) == 'login/reset' && $_GET['token'])
			{
				$valid = C\User::verifyToken($_GET['token']); // ensure token matches database
				if($valid && $valid['status'] != 'banned')
				{
					// Input validations (ordered least to most important)
					if($_POST['newpassword'] !== $_POST['confirmpassword']) 
					{
						$alert_message = 'New password and confirm password don\'t match';
					}
					if(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $_POST['newpassword'])) // 1 upper, 1 lower, 1 number, 8 chars
					{
						$alert_message = 'Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number and a minimum of 8 characters';
					}
					if($alert_message != NULL) 
					{
						$is_error = true;
					}
					
					if(!$is_error)
					{
						$pass_hash = password_hash($_POST['newpassword'], PASSWORD_BCRYPT);
						try
						{
							$id = explode(':', $_GET['token'])[0];
							G\DB::update( 'users', array('password' => $pass_hash, 'remember_me' => NULL), array('id' => $id) );
							$is_success = true;
							$alert_message = 'Password successfully changed. Please login with your new password.';
						}
						catch(Exception $e)
						{
							throw new Exception("Could not change password", 400);
						}
					}
				}
			}
			
			// validate empty fields
			if($handler->getRoute(true) == 'login' && (trim($_POST['email_username']) == '' || trim($_POST['password']) == ''))
			{
				$is_error = true;
				$alert_message = 'Please fill out the email/username and password fields';
			}
			
			if(!$is_error && !$is_success) 
			{
				$remember_me = $_POST['remember_me'] ? true : false;
				$login_type = filter_var($_POST['email_username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
				
				$user_id = C\User::verifyPassword($_POST['email_username'], $_POST['password'], $login_type);
				// if $user_id is an actual id, login and redirect
				if(is_numeric($user_id))
				{
					C\User::login($user_id, $remember_me);
					G\redirect('account');
				}
				// otherwise a user status was returned
				else
				{
					$is_error = true;
					if($user_id == 'banned' || $user_id === false)
						$alert_message = 'Wrong email/username and/or password';
					if($user_id == 'pending')
						$alert_message = 'Please click the link in your email to confirm your account';
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