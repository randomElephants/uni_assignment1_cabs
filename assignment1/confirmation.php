<?php 
	require_once 'Customer.php';
	session_start();
		
	if (isset($_SESSION['customer'])) {
		$customer = $_SESSION['customer'];
		$name = $customer->getName();
		$email = $customer->getEmail();
		
		if (isset($_SESSION['bookingID']) && isset($_SESSION['pickupTime']) && isset($_SESSION['pickupDate'])) {
			$bookingID= $_SESSION['bookingID'];
			$pickupTime = $_SESSION['pickupTime'];
			$pickupDate = $_SESSION['pickupDate'];
		} else {
			//TODO: ?Error?
			header("location:booking.php");
		}
	} else {
		//shouldn't be here
		header("location: login.php");
	}
?>
	<p>Thanks, <?php echo $name;?>.</p>
	<p>Your booking reference number is <?php echo $bookingID;?>. We will pick up the passengers in front of your provided address at <?php echo $pickupTime;?> on <?php echo $pickupDate;?>.</p>
	<p> A confirmation email will also be sent to you at <?php echo $email;?></p>