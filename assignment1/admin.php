<?php 
	require_once 'MySQLDatabase.php';
	require_once 'MySQLResult.php';
	require_once 'settings.php';
	
	$db = new MySQLDatabase($databaseHost, $databaseUsername, $databasePassword, $databaseName);
	
	if (isset($_GET['bookingResultSet'])) {
		$bookingResultSet = $_SESSION['bookingResultSet'];
	} else {
		$bookingResultSet = $db->listAllBookings();
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="author" content="Claire O'Donoghue"/>
<title>CabsOnline - Admin</title>
</head>
<body>
	<h1>CabsOnline - Admin</h1>

	<h2>1.Click button below to search for all unassigned booking requests with a pick-up time within 2 hours</h2>
	
	<form method="get" action="">
		<input type="submit" value="List all"/>
	</form>
	
	<h2>Input a reference number below and click "update" button to assign a taxi to that request</h2>
	
	<form>
		<p>
			<label for="refNumber">Reference number:</label>
			<input type="text" id="refNumber" name="refNumber"/>
			<input type="submit"
		</p>
	</form>
</body>
</html>