<?php
$conn = new mysqli("localhost", "root", "abamalayko", "elections");

if ($conn->connect_error) {
    die("Connection failed");
}
?>
