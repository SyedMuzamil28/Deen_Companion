<?php
if (session_status() === PHP_SESSION_NONE) session_start();
// Ramadan Lite: No login required. Auth disabled for public launch.
// <?php if(!isset($_SESSION["user_id"])): ?>
//   <a href="auth/login.php" ...>Login / Create Account</a>
// <?php endif; ?>



<?php
// Simple app title + nav (no login yet)
$current = basename($_SERVER['PHP_SELF']);
function navActive($page, $current) {
  return $page === $current ? "text-yellow-400" : "text-slate-300 hover:text-white";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

<link rel="manifest" href="/manifest.json">

<link rel="apple-touch-icon" sizes="180x180" href="/assets/icons/icon-192.png">
<link rel="icon" type="image/png" sizes="192x192" href="/assets/icons/icon-192.png">
<link rel="icon" type="image/png" sizes="512x512" href="/assets/icons/icon-512.png">

<meta name="apple-mobile-web-app-title" content="Deen Companion">
<meta name="theme-color" content="#facc15">


<style>
  :root { --safe-bottom: env(safe-area-inset-bottom, 0px); }
  html, body { background: #0f172a; overflow-x: hidden; }
  main { padding-bottom: calc(96px + var(--safe-bottom)); }
  * { -webkit-tap-highlight-color: transparent; }
  @media (max-height: 700px) { .footer-credit { display: none; } }
</style>

    <!-- Duplicate .app-tabs CSS removed for Ramadan Lite -->
    <style type="text/template"><!-- .app-tabs{
    position: fixed;
    left: 0; right: 0;
    bottom: 0;
    padding-bottom: calc(10px + var(--safe-bottom));
    background: rgba(2, 6, 23, 0.92); /* slate-950-ish */
    backdrop-filter: blur(10px);
    border-top: 1px solid rgba(148, 163, 184, 0.15);
    z-index: 50;
  }

  /* Tabs grid */
  .app-tabs .tabs-grid{
    max-width: 980px;
    margin: 0 auto;
    padding: 10px 12px 6px;
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr)); /* 5 per row */
    gap: 8px;
  }

  /* Each tab */
  .app-tabs a{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 10px 6px;
    border-radius: 14px;
    color: rgba(226, 232, 240, 0.8);
    font-size: 11px;
    line-height: 1;
    text-decoration: none;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
  }

  .app-tabs a .tab-ico{
    font-size: 18px; /* icon size */
    line-height: 1;
  }

  .app-tabs a.active{
    background: rgba(250, 204, 21, 0.12);
    color: #facc15;
    outline: 1px solid rgba(250, 204, 21, 0.25);
  }

  /* IMPORTANT: give page content space so it doesn't hide behind tabs */
  .page-wrap{
    padding-bottom: calc(96px + var(--safe-bottom));
  }

  /* Optional: hide the “Crafted…” text on very small heights so it doesn't clash */
  @media (max-height: 700px){
    .footer-credit { display:none; }
  }
</style>

  <link href="https://fonts.googleapis.com/css2?family=Amiri&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : "Deen Companion
" ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<script>
  if ("serviceWorker" in navigator) {
    navigator.serviceWorker.register("service-worker.js");
  }
</script>


<body class="bg-slate-900 text-white min-h-screen">

<!-- Top Bar -->
<header class="sticky top-0 z-50 border-b border-slate-800 bg-slate-900/90 backdrop-blur">
 <div class="max-w-5xl mx-auto flex items-center justify-between">
  
  <div>
    <h1 class="text-xl font-bold text-yellow-400">Deen Companion</h1>

    <?php if(isset($_SESSION["user_name"])): ?>
      <p class="text-sm text-slate-300 mt-1">
        Assalaamu Alaikum,
        <span class="text-yellow-400 font-semibold">
          <?= htmlspecialchars($_SESSION["user_name"]) ?>
        </span> 👋
      </p>
    <?php endif; ?>
  </div>

</div>

    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-2xl bg-slate-800 grid place-items-center shadow">
        🌙
      </div>
      <div>
        <div class="font-bold leading-tight">Deen Companion
</div>
        <div class="text-xs text-slate-400 leading-tight">Simple • Beautiful • Personal</div>
      </div>
    </div>

    <!-- Ramadan Lite: Dashboard, Prayer, Quran, Duas, Settings only -->
    <nav class="hidden sm:flex items-center gap-6 text-sm">
      <a class="<?= navActive('dashboard.php', $current) ?>" href="dashboard.php">Dashboard</a>
      <a class="<?= navActive('prayer.php', $current) ?>" href="prayer.php">Prayer</a>
      <a class="<?= navActive('quran.php', $current) ?>" href="quran.php">Quran</a>
      <a class="<?= navActive('duas.php', $current) ?>" href="duas.php">Duas</a>
      <a class="<?= navActive('settings.php', $current) ?>" href="settings.php">Settings</a>
    </nav>
  </div>
</header>

<main class="max-w-5xl mx-auto px-4 py-6 pb-28">
