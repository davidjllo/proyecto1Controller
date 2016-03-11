<?php
header("Access-Control-Allow-Origin: *");


$DBServer = 'localhost'; // e.g 'localhost' or '192.168.1.100'
$DBUser   = 'grupo1';
$DBPass   = 'grupo1db';
$DBName   = 'proyecto1';

$conn = new mysqli($DBServer, $DBUser, $DBPass, $DBName);
 
// check connection
if ($conn->connect_error) {
  trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
}
?>
