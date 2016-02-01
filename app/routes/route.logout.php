<?php
$route = function($handler) {
	try 
	{
		C\User::logout();
		G\redirect('login');
	}
	catch(Exception $e) 
	{
		G\exception_to_error($e);
	}
};