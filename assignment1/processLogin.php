<?php 
require_once 'settings.php';
require_once 'MySQLDatabase.php';

$db = new MySQLDatabase($username, $password, $database, $host);

if (loginIsValid($db)) {
	header("location:booking.php");
} else {
	header("location:login.php");
}

function loginIsValid() {
	
	if (loginFormIsValid() && userPasswordCorrect($db)) {
		return true;
	}
	else {
		return false;
	}
	
}

function loginFormIsValid() {
	return true;
}

function userPasswordCorrect($db) {
	$db = $db;
	if (true) {
		return true;
	}
}

