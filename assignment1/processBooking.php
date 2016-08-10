<?php
if (bookingIsValid()) {
	header("location:confirmation.php");
} else {
	//redirect back to previous page
	header("location:booking.php");
}

function bookingIsValid() {
	return true;
}