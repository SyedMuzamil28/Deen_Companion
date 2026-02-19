<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// ✅ Always use absolute include
require_once __DIR__ . '/../config/db.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $pass  = $_POST['password'] ?? '';

  if ($email === '' || $pass === '') {
    $msg = "Please fill all fields.";
  } else {
    // ✅ Match your existing table name: admin_users OR users
    // We'll try "users" first; if table doesn't exist, you'll see the error clearly.
    $sql = "SELECT id, full_name, password_hash FROM users WHERE email=? LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
      die("SQL prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if (!$res) {
      die("SQL execute failed: " . mysqli_error($conn));
    }

    $user = mysqli_fetch_assoc($res);

    if ($user && password_verify($pass, $user['password_hash'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_name'] = $user['full_name'];
      header("Location: /dashboard.php");
      exit;
    } else {
      $msg = "Invalid email or password.";
    }
  }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Login | Deen Companion</title>
</head>
<body class="bg-slate-900 text-white min-h-screen flex items-center justify-center p-6">
  <div class="w-full max-w-md bg-slate-800 rounded-2xl p-6 shadow">
    <h1 class="text-2xl font-bold text-yellow-400 mb-2">Login</h1>
    <p class="text-slate-300 mb-4">Welcome back to Deen Companion.</p>

    <?php if($msg): ?>
      <div class="bg-red-500/20 border border-red-500/30 rounded-xl p-3 text-sm mb-4">
        <?= htmlspecialchars($msg) ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="grid gap-3">
      <input name="email" type="email" required placeholder="Email"
             class="bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">
      <input name="password" type="password" required placeholder="Password"
             class="bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">

      <button class="bg-yellow-400 text-black font-semibold py-3 rounded-xl hover:opacity-90 transition">
        Login
      </button>
    </form>

    <p class="text-sm text-slate-300 mt-4">
      New here? <a class="underline" href="/auth/register.php">Create an account</a>
    </p>
  </div>
</body>
</html>
