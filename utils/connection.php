<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'yourfit_journey';

$connection = mysqli_connect($server, $username, $password, $database) or die("Connection failed: " . mysqli_connect_error());

if ($connection) {
    $databaseStatus = 'Connected';
} else {
    $databaseStatus = 'Not Connected';
}   