	<p>Please fill out the fields below to complete your registration</p>
	<form method="post" action="register?process">
		<p>
			<label for="name">Name:</label>
			<input type="text" id="name" name="name" placeholder="e.g. John Doe" <?php if (isset($custName)) {echo "value='$custName'";}?>/>
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
			<input type="text" id="email" name="email" placeholder="e.g. John@example.com" <?php if (isset($custEmail)) {echo "value='$custEmail'";}?>/>
		</p>
		<p>
			<label for="phone">Contact phone:</label>
			<input type="text" id="phone" name="phone" <?php if (isset($custPhone)) {echo "value='$custPhone'";}?>/>
		</p>
		<p>
			<input type="submit" value="Register Now"/>
		</p>
	</form>
	<p>Already a member? <a href="login" title="CabsOnline Login">Login here</a></p>
