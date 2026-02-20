<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/../config/db.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name  = trim($_POST['full_name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $pass  = $_POST['password'] ?? '';

  if ($name === '' || $email === '' || $pass === '') {
    $msg = "Please fill all fields.";
  } elseif (strlen($pass) < 6) {
    $msg = "Password must be at least 6 characters.";
  } else {
    $hash = password_hash($pass, PASSWORD_DEFAULT);

    if (!$conn) {
      $msg = "Service temporarily unavailable.";
    } else {
      $stmt = mysqli_prepare($conn, "INSERT INTO users(full_name,email,password_hash) VALUES(?,?,?)");
      if (!$stmt) {
        $msg = "Registration error. Try again.";
      } else {
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hash);
        if (mysqli_stmt_execute($stmt)) {
          $_SESSION['user_id'] = mysqli_insert_id($conn);
          $_SESSION['user_name'] = $name;
          header("Location: ../dashboard.php");
          exit;
        } else {
          $msg = "Email already exists or error occurred.";
        }
      }
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
  <title>Register | Deen Companion</title>
</head>
<body class="bg-slate-900 text-white min-h-screen flex items-center justify-center p-6">
  <div class="w-full max-w-md bg-slate-800 rounded-2xl p-6 shadow">
    <h1 class="text-2xl font-bold text-yellow-400 mb-2">Create Account</h1>
    <p class="text-slate-300 mb-4">Start your daily Deen journey.</p>

    <?php if($msg): ?>
      <div class="bg-red-500/20 border border-red-500/30 rounded-xl p-3 text-sm mb-4">
        <?= htmlspecialchars($msg) ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="grid gap-3">
      <input name="full_name" type="text" required placeholder="Full name"
             class="bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">
      <input name="email" type="email" required placeholder="Email"
             class="bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">
      <input name="password" type="password" required placeholder="Password (min 6 chars)"
             class="bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">

      <button class="bg-yellow-400 text-black font-semibold py-3 rounded-xl hover:opacity-90 transition">
        Register
      </button>
    </form>

    <p class="text-sm text-slate-300 mt-4">
      Already have an account? <a class="underline" href="login.php">Login</a>
    </p>
  </div>
</body>
</html>
