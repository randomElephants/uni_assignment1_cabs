<?php
require_once 'Customer.php';

session_start();

	if (isset($_SESSION['customer'])) {
		$customer = $_SESSION['customer'];
	} else {
		die("customer not set");
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="author" content="Claire O'Donoghue"/>
<title>CabsOnline - Booking</title>
</head>
<body>
	<h1>Booking a cab</h1>
	
	<?php 
		if ($customer !== NULL) {
			$name = $customer->getName();
			$email =$customer->getEmail();
			$phone = $customer->getPhone();
			echo "<p>Welcome $name ($email)</p>";
		} else {
			die("<p>No customer!!</p>");
		}
	?>
	
	<p>Please fill out the fields below to book a taxi.</p>
	
	<form method="post" action="processBooking.php">
		<p>
			<label for="pName">Passenger Name:</label>
			<input type="text" name="pName" id="pName" value="<?php echo "$name";?>"/>
		</p>
		<p>
			<label for="pPhone">Passenger contact phone:</label>
			<input type="text" name="pPhone" id="pPhone" title="Numerical only" value="<?php echo "$phone";?>"/>
		</p>
		<fieldset>
			<legend>Pickup Address</legend>
			<p>
				<label for="unit">Unit number (optional)</label>
				<input type="text" id="unit" name="unit" size="6"/>
			</p>
			<p>
				<label for="street">Street address:</label>
				<input type="text" id="streetNo" name="streetNo" size="4"/>
				<input type="text" id="street" name="street"/>
			</p>
			<p>
			<label for="pickupSuburb">Pickup suburb:</label>
			<input type="text" name="pickupSuburb" id="pickupSuburb"/>
			</p>
		</fieldset>
		<p>
			<label for="destSuburb">Destination suburb:</label>
			<input type="text" id="destSuburb" name="destSuburb"/>
		</p>
		<p>
			<label for="date">Pickup date:</label>
			<input id="date" name="date" type="date"/>
		</p>
		<p>
			<label for="time">Pickup time:</label>
			<input type="time" name="time" id="time"/>
		</p>
		<p>
			<input type="submit" value="Book"/>
		</p>
	</form>
	
</body>
</html>