<?php 
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="author" content="Claire O'Donoghue"/>
<title>CabsOnline - Register</title>
</head>
<body>
	<h1>Register at CabsOnline</h1>
	<p>Please fill out the fields below to complete your registration</p>
	<form method="post" action="processRegister.php">
		<p>
			<label for="name">Name:</label>
			<input type="text" id="name" name="name" placeholder="e.g. John Doe"/>
		</p>
		<p>
			<label for="password">Password:</label>
			<input type="password" id="password" name="password"/>
		</p>
		<p>
			<label for="confirmPassword">Confirm Password:</label>
			<input type="password" id="confirmPassword" name="confirmPassword"/>
		</p>
		<p>
			<label for="email">Email:</label>
			<input type="text" id="email" name="email" placeholder="e.g. John@example.com"/>
		</p>
		<p>
			<label for="phone">Contact phone:</label>
			<input type="text" id="phone" name="phone"/>
		</p>
		<p>
			<input type="submit" value="Register Now"/>
		</p>
	</form>
	<p>Already a member? <a href="login.php" title="CabsOnline Login">Login here</a></p>
</body>
</html>