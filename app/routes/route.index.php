<?php
$route = function($handler) {
	$handler::$vars['title'] = 'Backslash UMS';
	$handler::$vars['blurb'] = 'Backslash UMS is a User Management System built with the <a href="http://gbackslash.com/" target="_blank">G\ micro-framework</a> and <a href="http://getbootstrap.com/" target="_blank">Twitter Bootstrap</a>. This User Management System has all the features necessary to quickly deploy web applications where users need to be able to login, register and manage their account.';
};