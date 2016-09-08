<form method="post" action="login?process">
	<p>
		<label for="email">Email:</label>
		<input type="text" id="email" name="email" placeholder="e.g. joe@example.com" <?php if (isset($email)) {echo "value='$email'";}?>/>
	</p>
	<p>
		<label for="password">Password:</label>
		<input type="password" id="password" name="password"/>
	</p>
	<p>
		<input type="submit" value="Log in"/>
	</p>
</form>
<p>New to CabsOnline? <a href="register" title="Register at CabsOnline">Register Now!</a></p>
