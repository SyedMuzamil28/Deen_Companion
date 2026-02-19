<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include "../config/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = trim($_POST["username"] ?? "");
  $password = $_POST["password"] ?? "";

  $stmt = mysqli_prepare($conn, "SELECT password_hash FROM admin_users WHERE username = ? LIMIT 1");
  mysqli_stmt_bind_param($stmt, "s", $username);
  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($res);

  if ($row && password_verify($password, $row["password_hash"])) {
    $_SESSION["admin_logged_in"] = true;
    $_SESSION["admin_username"] = $username;
    header("Location: add-story.php");
    exit;
  } else {
    $error = "Invalid username or password.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white min-h-screen flex items-center justify-center p-6">

<div class="max-w-md w-full bg-slate-800 rounded-2xl shadow p-6">
  <h1 class="text-2xl font-bold text-yellow-400 mb-2">🔐 Admin Login</h1>
  <p class="text-slate-300 mb-6">Login to manage stories.</p>

  <?php if ($error): ?>
    <div class="bg-red-500/20 border border-red-500/40 text-red-200 p-3 rounded-xl mb-4">
      <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>

  <form method="POST" class="space-y-4">
    <input name="username" placeholder="Username"
           class="w-full bg-slate-900 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
    <input name="password" type="password" placeholder="Password"
           class="w-full bg-slate-900 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-yellow-400" required>

    <button class="w-full bg-yellow-400 text-black font-semibold py-3 rounded-xl hover:opacity-90 transition">
      Login
    </button>
  </form>
</div>

</body>
</html>
