<?php

$host = "sql202.infinityfree.com";   // <-- exact hostname from panel
$user = "if0_41152364";              // <-- your MySQL username
$pass = "Syed7207";        // <-- your MySQL password
$db   = "if0_41152364_deencompanion"; // <-- FULL database name

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
