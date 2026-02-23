<?php
$current = basename($_SERVER['PHP_SELF']);
function navActive($page, $current) {
  return $page === $current ? ' text-emerald-400 font-semibold' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
  <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Deen Companion' ?></title>

  <link rel="manifest" href="manifest.json" />
  <meta name="theme-color" content="#166534" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-title" content="Deen" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
  <link rel="apple-touch-icon" href="assets/icons/icon-192.png" />
  <link rel="icon" type="image/png" sizes="192x192" href="assets/icons/icon-192.png" />
  <link rel="icon" type="image/png" sizes="512x512" href="assets/icons/icon-512.png" />

  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/app.css" />
  <script src="assets/js/theme.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: { extend: {
        colors: {
          deen: { bg: 'var(--bg)', card: 'var(--bg-card)', accent: 'var(--accent)' }
        }
      }}
    };
  </script>
</head>
<body class="min-h-screen" style="background:var(--bg);color:var(--text);">

<script>
  if ('serviceWorker' in navigator) navigator.serviceWorker.register('service-worker.js').catch(function(){});
</script>

<header class="sticky top-0 z-50 border-b backdrop-blur-md" style="background:var(--bg);border-color:var(--border);">
  <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between gap-3">
    <a href="index.php" class="flex items-center gap-3 min-w-0">
      <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:var(--bg-card);">
        <span aria-hidden="true">🌙</span>
      </div>
      <div class="min-w-0">
        <div class="font-bold truncate" style="color:var(--accent);">Deen Companion</div>
        <div class="text-xs truncate" style="color:var(--text-muted);">Ramadan</div>
      </div>
    </a>
    <div class="flex items-center gap-2">
      <button type="button" id="themeToggle" class="theme-toggle" aria-label="Toggle light/dark mode">
        <svg id="iconSun" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        <svg id="iconMoon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
      </button>
    </div>
  </div>
  <nav class="hidden sm:flex items-center gap-1 px-4 pb-2 overflow-x-auto">
    <a href="dashboard.php" class="px-3 py-2 rounded-lg text-sm whitespace-nowrap<?= navActive('dashboard.php', $current) ?>" style="color:var(--text);">Dashboard</a>
    <a href="prayer.php" class="px-3 py-2 rounded-lg text-sm whitespace-nowrap<?= navActive('prayer.php', $current) ?>" style="color:var(--text);">Prayer</a>
    <a href="qibla.php" class="px-3 py-2 rounded-lg text-sm whitespace-nowrap<?= navActive('qibla.php', $current) ?>" style="color:var(--text);">Qibla</a>
    <a href="quran.php" class="px-3 py-2 rounded-lg text-sm whitespace-nowrap<?= navActive('quran.php', $current) ?>" style="color:var(--text);">Quran</a>
    <a href="duas.php" class="px-3 py-2 rounded-lg text-sm whitespace-nowrap<?= navActive('duas.php', $current) ?>" style="color:var(--text);">Duas</a>
    <a href="settings.php" class="px-3 py-2 rounded-lg text-sm whitespace-nowrap<?= navActive('settings.php', $current) ?>" style="color:var(--text);">Settings</a>
  </nav>
</header>

<main class="max-w-5xl mx-auto px-4 py-5">
