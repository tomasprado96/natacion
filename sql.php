<?php
$host = "localhost"; // Your database host
$dbname = "natacion"; // Your database name
$user = "root"; // Your database username
$pass = ""; // Your database password

// Create connection
$sql = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($sql->connect_error) {
    die("Connection failed: " . $sql->connect_error);
}
?>
