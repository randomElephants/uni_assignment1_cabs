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
$validator = new Validator();
echo "<p>Validator created</p>";
$date = "12 Feb 2017";
$time = "1ghiokj";
$validator->isValidPickupDatetime($date, $time);

echo "<p>Bottom of page</p>";