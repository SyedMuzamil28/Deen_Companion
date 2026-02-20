<?php
$pageTitle = "Dashboard | Deen Companion";
include "partials/header.php";
?>

<main class="px-4">

<!-- Premium Header Card -->
<div class="max-w-5xl mx-auto mb-6">
  <div class="bg-gradient-to-r from-slate-800 to-slate-900 rounded-2xl p-6 shadow border border-slate-700/50">
    <div class="flex items-center justify-between">
      <div>
        <div class="text-yellow-400 font-extrabold text-2xl tracking-tight">
          Deen Companion
        </div>
        <div class="text-slate-300 text-sm mt-1">
          Daily Deen. Simple habits. Strong Iman.
        </div>
      </div>
      <div class="text-right">
        <div class="text-slate-400 text-xs">Today</div>
        <div class="text-slate-200 font-semibold" id="todayDate"></div>
      </div>
    </div>
  </div>
</div>

<!-- Top Section -->
<div class="max-w-5xl mx-auto mb-6 flex items-start justify-between gap-6">
  <div>
    <h1 class="text-2xl font-bold text-yellow-400">🌙 Ramadan Dashboard</h1>
    <p class="text-slate-400">May Allah accept our efforts</p>
  </div>
  <a href="index.php" class="text-sm text-slate-300 hover:text-white underline">Back Home</a>
</div>

<!-- Ramadan Daily Timetable -->
<h2 class="text-lg font-semibold text-slate-200 mb-3">📅 Today’s Timetable</h2>
<div class="max-w-5xl mx-auto grid md:grid-cols-3 gap-4 mb-8">

  <!-- Iftar (Maghrib) -->
  <div class="bg-slate-800 rounded-2xl p-6 shadow">
    <div class="text-slate-300 text-sm mb-1">🍽️ Iftar (Maghrib)</div>
    <div id="iftarCountdown" class="text-3xl font-bold text-yellow-400">--:--:--</div>
    <div id="iftarTime" class="text-slate-400 text-sm mt-2">--</div>
  </div>

  <!-- Sehri end (Imsak/Fajr) -->
  <div class="bg-slate-800 rounded-2xl p-6 shadow">
    <div class="text-slate-300 text-sm mb-1">🌙 Sehri Ends (Imsak)</div>
    <div id="sehriCountdown" class="text-3xl font-bold text-yellow-400">--:--:--</div>
    <div id="sehriTime" class="text-slate-400 text-sm mt-2">--</div>
    <div id="imsakTime" class="text-slate-500 text-xs mt-1">--</div>
  </div>

  <!-- Next Prayer -->
  <div class="bg-slate-800 rounded-2xl p-6 shadow">
    <div class="text-slate-300 text-sm mb-1">🕌 Next Prayer</div>
    <div id="nextPrayerName" class="text-xl font-semibold text-white">--</div>
    <div id="nextPrayerTime" class="text-2xl font-bold text-yellow-400 mt-1">--</div>
    <div id="nextPrayerCountdown" class="text-slate-400 text-sm mt-2">--:--:--</div>
  </div>

</div>

</main>

<script>
  (function () {
    var el = document.getElementById("todayDate");
    if (el) el.textContent = new Date().toLocaleDateString("en-GB", { weekday: "short", day: "numeric", month: "short" });
  })();
</script>
<script src="assets/js/timer.js"></script>

<?php include "partials/footer.php"; ?>
