<?php

/* --------------------------------------------------------------------

  G\ library
  http://gbackslash.com

  @author	Rodolfo Berrios A. <http://rodolfoberrios.com/>

  Copyright (c) Rodolfo Berrios <inbox@rodolfoberrios.com> All rights reserved.
  
  Licensed under the MIT license
  http://opensource.org/licenses/MIT
  
  --------------------------------------------------------------------- */
  
  # This file is used to load G and your G APP
  # If you need to hook elements to this loader you can add them in loader-hook.php

namespace APP;
use G, C, Exception;

if(!defined('access') or !access) die('This file cannot be directly accessed.');

// G thing
(file_exists(dirname(dirname(__FILE__)) . '/lib/G/G.php')) ? require_once(dirname(dirname(__FILE__)) . '/lib/G/G.php') : die("Can't find lib/G/G.php");

// Define app path
define('G_APP_PATH_VENDOR', G_APP_PATH . 'vendor/');

// We're getting fancy
try {
	$hook_before = function($handler) 
	{
		$is_logged = C\User::isLogged();
		$handler::$cond['logged'] = $is_logged; // boolean
	};
	$hook_after = function($handler) {};
	$handy = new G\Handler(['before' => $hook_before, 'after' => $hook_before]);
} catch(Exception $e) {
	G\exception_to_error($e);
}

?>