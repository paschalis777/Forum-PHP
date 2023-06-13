<?php
$server = 'localhost';
$username   = 'root';
$password   = '';
$database   = 'db_forum';


$conn = new mysqli($server, $username, $password);


if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}
if(!mysqli_select_db($conn, $database))
{
    exit('Error: could not select the database');
}


if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}


?>