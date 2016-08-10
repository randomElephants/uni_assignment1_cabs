<?php
if (registrationIsValid()) {
	header("booking.php");
} else {
	//redirect back to previous page
	header("register.php");
}

function registrationIsValid() {
	
}