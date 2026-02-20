<?php
if (session_status() === PHP_SESSION_NONE) session_start();
// Ramadan Lite: Admin protection disabled for public launch.
// if (empty($_SESSION['admin_logged_in'])) {
//   header("Location: login.php");
//   exit;
// }
