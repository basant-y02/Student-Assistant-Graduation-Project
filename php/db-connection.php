<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$db = "student_assistance_db";
$conn = new mysqli($dbhost, $dbuser, $dbpass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>