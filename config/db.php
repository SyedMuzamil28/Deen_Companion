<?php
// Ramadan Lite: Do not die on DB failure so site works without database.
$host = "sql202.infinityfree.com";
$user = "if0_41152364";
$pass = "Syed7207";
$db   = "if0_41152364_deencompanion";

$conn = @mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    $conn = null;
}
