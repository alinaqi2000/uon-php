<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "store_db";

global $conn;
// $conn = new mysqli($servername, $username, $password, $dbname);
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
