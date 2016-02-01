<?php

/* --------------------------------------------------------------------
  
  Backslash UMS
  http://ums.backslashmedia.ca

  @author	Christopher Waldau <http://chris.waldau.ca>

  Copyright (c) Christopher Waldau <chris@waldau.ca> All rights reserved.

  -------------------------------------------------------------------- 
  
  G\ library
  http://gbackslash.com

  @author	Rodolfo Berrios A. <http://rodolfoberrios.com/>

  Copyright (c) Rodolfo Berrios <inbox@rodolfoberrios.com> All rights reserved.
  
  Licensed under the MIT license
  http://opensource.org/licenses/MIT
  
  --------------------------------------------------------------------- */
  
  # This file is used to set static settings

$settings = [
	'theme'	=> 'bootstrap',
	
	// database details
	'db_driver' 		=> 'mysql',
	'db_host'			=> 'localhost',		// localhost is mostly default on all servers. Try to use an IP instead of a hostname (fastest)
	'db_port'			=> '',				// Some servers needs to indicate the port of the database hostname - default: don't set it
	'db_name'			=> '',				// Database name
	'db_user'			=> '',				// Database user with access to the above database name
	'db_pass'			=> '',				// Database user password
	'db_table_prefix'	=> '',				// Table prefix
	
	'error_reporting' 	=> true, 			// php error reporting
	
	// website details
	'website_name'	=> '',
	'website_email'	=> '',
	
	// SMTP details
	// To be used with PHPMailer, please see their documentation for more details https://github.com/PHPMailer/PHPMailer
	'smtp_host'		=> '',	// Specify main and backup SMTP servers
	'smtp_username'	=> '',	// SMTP username
	'smtp_password'	=> '',	// SMTP password
	'smtp_secure'	=> '',	// Enable TLS encryption, `ssl` also accepted
	'smtp_port'		=> ''	// TCP port to connect to
];