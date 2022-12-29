<?php
session_start();

define('SITEURL', 'http://localhost:8080/NaijaBowl/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'naijabowl');

$conn = mysqli_connect('localhost', 'root', '')  or die(mysqli_error());
$db_select = mysqli_select_db($conn, 'naijabowl') or die(mysqli_error());

?>