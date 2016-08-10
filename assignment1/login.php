<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="author" content="Claire O'Donoghue"/>
<title>CabsOnline  - Login</title>
</head>
<body>
	<h1>Login to CabsOnline</h1>
	<form method="post" action="processLogin.php">
		<p>
			<label for="email">Email:</label>
			<input type="email" id="email" name="email" required="required" placeholder="e.g. joe@example.com"/>
		</p>
		<p>
			<label for="password">Password:</label>
			<input type="password" id="password" name="password" required="required"/>
		</p>
		<p>
			<input type="submit" value="Log in"/>
		</p>
	</form>
	<p>New to CabsOnline? <a href="register.php" title="Register at CabsOnline">Register Now!</a></p>
</body>
</html>