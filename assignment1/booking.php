<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="author" content="Claire O'Donoghue"/>
<title>CabsOnline - Booking</title>
</head>
<body>
	<h1>Booking a cab</h1>
	<p>Please fill out the fields below to book a taxi.</p>
	
	<form method="post" action="processBooking.php">
		<p>
			<label for="pName">Passenger Name:</label>
			<input type="text" name="pName" id="pName" required="required"/>
		</p>
		<p>
			<label for="pPhone">Passenger contact phone:</label>
			<input type="tel" name="pPhone" id="pPhone" required="required" pattern="[0-9]*" title="Numerical only"/>
		</p>
		<fieldset>
			<legend>Pickup Address</legend>
			<p>
				<label for="unit">Unit number (optional)</label>
				<input type="text" id="unit" name="unit" size="6" pattern="[0-9]{1,5}"/>
			</p>
			<p>
				<label for="street">Street address:</label>
				<input type="text" id="streetNo" name="streetNo" required="required" pattern="[0-9]{1,6}" size="6"/>
				<input type="text" id="street" name="street" required="required" pattern="[a-zA-Z]*"/>
			</p>
			<p>
			<label for="pickupSuburb">Pickup suburb:</label>
			<select name="pickupSuburb" id="pickupSuburb" required="required">
				<option value="">Please select</option>
				<option value="Box Hill">Box Hill</option>
			</select>
			</p>
		</fieldset>
		<p>
			<label for="destSuburb">Destination suburb:</label>
			<select name="destSuburb" id="destSuburb" required="required">
				<option value="">Please select</option>
				<option value="Box Hill">Box Hill</option>
			</select>
		</p>
		<p>
			<label for="date">Pickup date:</label>
			<input id="date" name="date" type="date" required="required"/>
		</p>
		<p>
			<label for="time">Pickup time:</label>
			<input type="time" name="time" id="time" required="required"/>
		</p>
		<p>
			<input type="submit" value="Book"/>
		</p>
	</form>
	
</body>
</html>