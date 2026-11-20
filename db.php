<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = mysqli_connect("localhost", "root", "", "nti_r_5");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>