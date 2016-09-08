<?php 
	if (isset($_SESSION['customer'])) {
		$customer = $_SESSION['customer'];
		$name = $customer['name'];
		$email = $customer['email'];
		$phone = $customer['phone'];
		
		echo "<p>Welcome, $name ($email)</p>";
	}
?>

<p>Please fill out the fields below to book a taxi.</p>

<form method="post" action="booking?process">
	<p>
		<label for="pName">Passenger Name:</label>
		<input type="text" name="pName" id="pName" value="<?php if(isset($name)) {echo "$name";}?>"/>
	</p>
	<p>
		<label for="pPhone">Passenger contact phone:</label>
		<input type="text" name="pPhone" id="pPhone" title="Numerical only" value="<?php if (isset($phone)) {echo "$phone";}?>"/>
	</p>
	<fieldset>
		<legend>Pickup Address</legend>
		<p>
			<label for="unit">Unit number (optional)</label>
			<input type="text" id="unit" name="unit" size="6" value="<?php if(isset($unit)) {echo "$unit";}?>"/>
		</p>
		<p>
			<label for="street">Street address:</label>
			<input type="text" id="streetNo" name="streetNo" size="4" value="<?php if(isset($streetNo)) {echo "$streetNo";}?>"/>
			<input type="text" id="street" name="street" value="<?php if(isset($street)) {echo "$street";}?>"/>
		</p>
		<p>
		<label for="pickupSuburb">Pickup suburb:</label>
		<input type="text" name="pickupSuburb" id="pickupSuburb" value="<?php if(isset($pickupSub)) {echo "$pickupSub";}?>"/>
		</p>
	</fieldset>
	<p>
		<label for="destSuburb">Destination suburb:</label>
		<input type="text" id="destSuburb" name="destSuburb" value="<?php if(isset($destSuburb)) {echo "$destSuburb";}?>"/>
	</p>
	<p>
		<label for="date">Pickup date:</label>
		<input id="date" name="date" type="date" value="<?php if(isset($pickupDate)) {echo "$pickupDate";}?>"/>
	</p>
	<p>
		<label for="time">Pickup time:</label>
		<input type="time" name="time" id="time" value="<?php if(isset($pickupTime)) {echo "$pickupTime";}?>"/>
	</p>
	<p>
		<input type="submit" value="Book"/>
	</p>
</form>