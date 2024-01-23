<?php
session_start();

$_SESSION = array();

session_destroy();

header("Location: index.php"); // Adjust the path as needed
exit;