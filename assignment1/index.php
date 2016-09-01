<?php
//Index for ease of testing

require_once 'MySQLDatabase.php';
require_once 'MySQLResult.php';
require_once 'settings.php';
require_once 'CustomerFactory.php';
require_once 'Customer.php';
require_once 'BookingFactory.php';
require_once 'Validator.php';

echo "<p>Top of page</p>";
$db = new MySQLDatabase($databaseHost, $databaseUsername, $databasePassword, $databaseName);
echo "<p>DB created</p>";
$results = $db->listAllBookings();

print_result_table($results);

echo "<p>Bottom of page</p>";

function print_result_table(MySQLResult $result) {
	echo "<table border='1'>";
	echo "<thead><tr>";
	foreach ($result->getFieldNames() as $field) {
		echo "<th>$field</th>";
	}
	echo "</tr></thead>";
	echo "<tbody>";
	foreach ($result->getRows() as $row) {
		echo "<tr>";
		foreach ($row as $field) {
			echo "<td>$field</td>";
		}
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";
}