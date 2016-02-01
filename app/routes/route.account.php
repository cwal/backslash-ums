<?php
$route = function($handler) {
	try 
	{
		// Set logged user data or redirect if not logged
		if( !$handler::$vars['user'] = $logged_user = C\User::getLoggedUser() )
			G\redirect('login');
		
		if($logged_user['is_admin'] && $_GET['id'] && ($_GET['status'] || $_GET['admin']))
		{
			$status_types = array('valid', 'pending', 'banned');
			if( $_GET['status'] && (in_array($_GET['status'], $status_types)) )
			{
				$field = 'status';
				$value = $_GET['status'];
			}
			if( $_GET['admin'] && ($_GET['admin'] == 'true' || $_GET['admin'] == 'false') )
			{
				$field = 'is_admin';
				$value = $_GET['admin'] == 'true' ? 1 : 0;
			}
			G\DB::update( 'users', array($field => $value), array('id' => $_GET['id']) );
			G\redirect('account#' . $_GET['id']);
		}
		
		// Initialize variables
		$is_error = false;
		$is_success = false;
		$alert_message = NULL;
		
		if($_POST and !$handler::checkAuthToken($_REQUEST['auth_token'])) 
		{
			$handler->template = 'error'; 
			return;
		}
		
		if($_POST)
		{
		//	G\debug($_POST);
			
			// Input validations (ordered least to most important)
			if($_POST['newpassword'] !== $_POST['confirmpassword']) 
			{
				$alert_message = 'New password and confirm password don\'t match';
			}
			if(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $_POST['newpassword'])) // 1 upper, 1 lower, 1 number, 8 chars
			{
				$alert_message = 'Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number and a minimum of 8 characters';
			}
			if( !C\User::verifyPassword($logged_user['id'], $_POST['currentpassword'], 'id') )
			{
				$alert_message = 'Current password is incorrect';
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
					G\DB::update( 'users', array('password' => $pass_hash), array('id' => $logged_user['id']) );
					$is_success = true;
					$alert_message = 'Password successfully changed';
				}
				catch(Exception $e)
				{
					throw new Exception("Could not change password", 400);
				}
			}
		}

		$all_users = G\DB::get('users', 'all');
		
		$handler::setCond('error', $is_error);
		$handler::setCond('success', $is_success);
		$handler::setVar('alert_message', $alert_message);
		$handler::setVar('all_users', $all_users);
	}
	catch(Exception $e) 
	{
		G\exception_to_error($e);
	}
};