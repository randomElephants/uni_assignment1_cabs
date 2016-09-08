<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="Claire O'Donoghue"  />
		<title><?php echo $pageTitle ?></title>
	</head>
	<body>
		<h1><?php echo $heading ?></h1>
		<?php
		//Check if there is an error to display
		if (!empty($_SESSION['error'])) {
			$errorMessage = $_SESSION['error'];
			$_SESSION['error'] = false;
		} else {
			//Reset the error
			$errorMessage = "";
		}
		
		//Display the error message
		//I would not usually use in-line style, but there's no CSS for this assignment
 		if (!empty($errorMessage)) {
 			echo "<p style='color:red'>$errorMessage</p>";
 		}
 		
		if ($content !== null) {
			require $content;
		} else {
			echo "The requested page was not found.";
		}
		?>
		<hr/>
		<p>View the <a href="admin" title ="Admin page">admin page</a></p>
		<p>Go back to <a href="login" title ="Login page">login page</a></p>
		<p><a href='logout' title="Logout">Logout</a></p>
    </body>
</html>