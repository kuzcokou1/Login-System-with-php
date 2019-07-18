<?php

$dbServername = "Localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "loginsystem";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbname);
if (!conn) {
	die("Connection failed".mysqli_connect_error());
}