<?php
$pageTitle = "Dashboard | Deen Companion";
include "partials/header.php";
?>

<main class="px-4">

<a href="reflections.php"
   class="inline-block mb-6 text-sm underline text-slate-300 hover:text-white">
   Write Today’s Reflection →
</a>

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
<div class="max-w-5xl mx-auto mb-8 flex items-start justify-between gap-6">
  <div>
    <h1 class="text-2xl font-bold text-yellow-400">🌙 Dashboard</h1>
    <p class="text-slate-400">May Allah accept our efforts</p>
  </div>

  <div class="text-right">
    <p class="text-slate-300 text-sm">
      Active: 
      <span id="activeMemberName" class="text-yellow-400 font-semibold">...</span>
    </p>
    <a href="index.php" class="text-sm text-slate-300 hover:text-white underline">
      Back Home
    </a>
  </div>
</div>

<!-- Timers -->
<div class="max-w-5xl mx-auto grid md:grid-cols-3 gap-4 mb-6">

  <!-- Iftar -->
  <div class="bg-slate-800 rounded-2xl p-6 shadow">
    <div class="text-slate-300 text-sm mb-1">🍽️ Iftar Time</div>
    <div id="iftarCountdown" class="text-3xl font-bold text-yellow-400">--:--:--</div>
    <div id="iftarTime" class="text-slate-400 text-sm mt-2">--</div>
  </div>

  <!-- Sehri -->
  <div class="bg-slate-800 rounded-2xl p-6 shadow">
    <div class="text-slate-300 text-sm mb-1">🌙 Sehri Cutoff</div>
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

<!-- Tracker -->
<div class="max-w-5xl mx-auto bg-slate-800 rounded-2xl p-6 shadow mb-12">
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-bold">✅ Daily Tracker</h2>
    <span id="trackerDate" class="text-sm text-slate-300"></span>
  </div>

  <div class="mb-6">
    <div class="flex items-center justify-between mb-2">
      <p class="text-slate-300 text-sm">Today’s Progress</p>
      <p id="progressText" class="text-slate-300 text-sm">0%</p>
    </div>
    <div class="w-full bg-slate-700 rounded-full h-3 overflow-hidden">
      <div id="progressBar" class="bg-yellow-400 h-3 rounded-full" style="width:0%"></div>
    </div>
  </div>

  <!-- Checklist same as yours -->

  <!-- Actions -->
  <div class="mt-6 flex flex-col sm:flex-row gap-3">
    <button id="saveBtn" class="bg-yellow-400 text-black font-semibold py-3 px-6 rounded-xl hover:opacity-90 transition">
      Save Today
    </button>

    <button id="resetBtn" class="bg-slate-700 text-white font-semibold py-3 px-6 rounded-xl hover:opacity-90 transition">
      Reset Today
    </button>

    <p id="msg" class="text-sm text-slate-300 sm:ml-auto self-center"></p>
  </div>
</div>

</main>

<script src="assets/js/timer.js"></script>
<script src="assets/js/tracker.js"></script>
<script src="assets/js/activeMember.js"></script>

<?php include "partials/footer.php"; ?>
