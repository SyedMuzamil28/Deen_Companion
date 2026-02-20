<?php
session_start();
session_destroy();
// Ramadan Lite: redirect to home (no login required)
header("Location: ../index.php");
exit;
