<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'yourfitjourney';

$conn = mysqli_connect($server, $username, $password, $database) or die("Connection failed: " . mysqli_connect_error());

if ($conn) {
    $databaseStatus = 'Connected';
} else {
    $databaseStatus = 'Not Connected';
}   