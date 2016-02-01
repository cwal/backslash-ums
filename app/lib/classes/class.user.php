<?php

namespace C; // C is for class
use G, App, Exception;

class User {
	
	static $logged_user;
	
	public static function getLoggedUser()
	{
		return self::$logged_user ? self::$logged_user : false;
	}
		
	/*
	 * Validate a users username before allowing them to register with it
	 * 
	 * Ensure wanted username fits criteria, is not a restricted word, not part of the existing URL structure and not an existing file
	 */
	public static function isValidUsername($string)
	{
		$restricted = array('profile','profiles','account','user','admin','administrator');
		$is_valid = preg_match('/^[a-z\d_]{2,20}$/i', $string) && 
					!in_array($string, $restricted) && 
					!G\isRouteAvailable($string) && 
					!file_exists(G_ROOT_PATH . $string);
		return $is_valid;
	}
	
	/*
	 * Insert a new user to the database
	 */
	public static function createNewUser($user_data)
	{
		if(!is_array($user_data))
			throw new G\DBException('Expecting array values, '.gettype($user_data).' given in ' . __METHOD__, 100);
		
		if(!$user_data['date_gmt'])
			$user_data['date_gmt'] = G\datetimegmt();
		
		return G\DB::insert('users', $user_data);
	}
	
	/*
	 * Check if entered email/username and password combo matches
	 */
	public static function verifyPassword($email_username, $password, $login_type)
	{
		$res = G\DB::get( 'users', array($login_type => $email_username) ); // use $login_type as the field, can be 'email', 'username' or 'id'
		$valid = password_verify($password, $res[0]['password']);
		if($valid)
		{
			// if an account status is anything other than 'valid' return its status
			if($res[0]['status'] != 'valid')
				return $res[0]['status'];
			// otherwise return user id
			return $res[0]['id'];
		}
		return false;
	}
	
	/*
	 * Check validity of token
	 * 
	 * Extract the unhashed token from session/cookie/activation and hash it to compare to the one stored in db
	 * Returns user data
	 */
	public static function verifyToken($public_token)
	{
		$token_info = explode(":", $public_token); // 0->id, 1->unhashed token, 2->timestamp
		$user_id = $token_info[0];
		$token = $token_info[1];
		$res = G\DB::get( 'users', array('id' => $user_id) );
		$token_hash = $res[0]['remember_me'];
		$valid = password_verify($token, $token_hash);
		if($valid)
			return $res[0];
		return false;
	}
	
	/*
	 * Create a formatted token
	 * 
	 * Hashed version of a random token is stored in users table as remember_me
	 * Returns id:(unhashed)Token:Timestamp
	 */
	public static function createToken($user_id)
	{
		$token = G\random_string(rand(128, 256));
		$token_hash = password_hash($token, PASSWORD_BCRYPT);
		G\DB::update( 'users', array('remember_me' => $token_hash), array('id' => $user_id) );
		return $user_id . ':' . $token . ':' . strtotime(G\datetimegmt());
	}
	
	/*
	 * Create sessions/cookies to keep the user logged in
	 */
	public static function login($user_id, $remember = false)
	{
		$cookie = self::createToken($user_id);
		$_SESSION['REMEMBER_ME'] = $cookie;
		if($remember)		
			setcookie('REMEMBER_ME', $cookie, time()+(60*60*24*7), G_ROOT_PATH_RELATIVE); // 7 days
	}
	
	/*
	 * Check if user is already logged in
	 * 
	 * This is called in loader.php before every page load
	 * 
	 * Check if the session/cookie exists
	 * Refresh the cookie if the cookie was used to log back in
	 * Don't re-login when session was used to check login.
	 */
	public static function isLogged()
	{
		$isLogged = false;
		$user_data = false;
		if (isset($_SESSION['REMEMBER_ME']) || isset($_COOKIE['REMEMBER_ME']))
		{
			$login_type = $_SESSION['REMEMBER_ME'] ? 'session' : 'cookie';
			$public_token = $_SESSION['REMEMBER_ME'] ? $_SESSION['REMEMBER_ME'] : $_COOKIE['REMEMBER_ME'];
			$user_data = self::verifyToken($public_token);
			if($user_data)
			{
				if($user_data['status'] != 'valid')
				{
					self::logout(); // destroy their session/cookie
					return false; // now they will have to try and log back in
				}
				if($login_type == 'cookie') // means the user left and is coming back
					self::login($user_data['id'], true); // so refresh the cookie, they want to be remembered!
				$isLogged = $user_data['id'];
			}
		}
		self::$logged_user = $user_data; // store all the user data
		return $isLogged;
	}
	
	/*
	 * Logout
	 * 
	 * Destroy session and cookies
	 */
	public static function logout()
	{
		session_destroy();
		if(isset($_COOKIE[session_name()]))
	        setcookie(session_name(), '',  time() - 3600, G_ROOT_PATH_RELATIVE);
		if(isset($_COOKIE['REMEMBER_ME']))
			setcookie('REMEMBER_ME', '',  time() - 3600, G_ROOT_PATH_RELATIVE);
	}

}

class UserException extends Exception {}