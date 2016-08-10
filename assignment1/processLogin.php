<?php 
if (loginIsValid()) {
	header("booking.php");
} else {
	header("login.php");
}

function loginIsValid() {
	return true;
}