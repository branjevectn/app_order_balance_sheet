<?php
// gthfcrfgdsdfdd
$host = '0.0.0.0';
$username = 'root';
$password = 'root';
$database = 'my';

$limit = 4;
// Create connection
$conn = new mysqli($host, $username, $password, $database);



// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
