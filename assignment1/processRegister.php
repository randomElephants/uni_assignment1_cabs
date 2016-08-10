<?php
if (registrationIsValid()) {
	header("location:booking.php");
} else {
	//redirect back to previous page
	header("location:register.php");
}

function registrationIsValid() {
	return true;
}