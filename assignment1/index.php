<?php
//Index for ease of testing

require_once 'MySQLDatabase.php';
require_once 'MySQLResult.php';
require_once 'settings.php';
require_once 'CustomerFactory.php';
require_once 'Customer.php';

echo "<p>Top of page</p>";
$db = new MySQLDatabase($databaseHost, $databaseUsername, $databasePassword, $databaseName);
echo "<p>DB created</p>";
$factory = new CustomerFactory($db);
echo "<p>Factory created</p>";
$email = "email";
$customer = $factory->getCustomer($email);
if ($customer) {
	echo "<p>Found customer!<p>";
	$string = "Email: " . $customer->getEmail() . " Name: " . $customer->getName();
	echo "<p>$string</p>";
} else {
	echo "<p>Couldn't get customer!<p>";
}


echo "<p>Bottom of page</p>";