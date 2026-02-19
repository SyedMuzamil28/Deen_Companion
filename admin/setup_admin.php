<?php
include "../config/db.php";

$username = "Syed";          // change if you want
$password = "Syed@123";       // change this RIGHT NOW

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = mysqli_prepare($conn, "INSERT IGNORE INTO admin_users (username, password_hash) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt, "ss", $username, $hash);
mysqli_stmt_execute($stmt);

echo "✅ Admin user ready. Username: $username | Password: $password";
