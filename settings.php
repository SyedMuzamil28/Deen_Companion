<?php
$pageTitle = "Settings | Deen Companion";
include "partials/header.php";

if (session_status() === PHP_SESSION_NONE) session_start();
?>

<div class="max-w-5xl mx-auto grid gap-6">

  <!-- Settings Header -->
  <div class="bg-slate-800 rounded-2xl p-6 shadow border border-slate-700/40">
    <h1 class="text-2xl font-bold text-yellow-400 mb-2">⚙️ Settings</h1>

    <?php if (isset($_SESSION["user_id"])): ?>
      <p class="text-slate-300">
        Assalaamu Alaikum,
        <span class="text-yellow-400 font-semibold"><?= htmlspecialchars($_SESSION["user_name"]) ?></span> 👋
      </p>
      <p class="text-slate-400 text-sm mt-1">You’re logged in. Your progress can be saved.</p>

      <a href="/auth/logout.php"
         class="inline-block mt-4 text-sm underline text-slate-300 hover:text-white">
        Logout →
      </a>

    <?php else: ?>
      <p class="text-slate-300">Use as guest, or login to save your progress.</p>

      <div class="grid grid-cols-2 gap-3 mt-4">
        <a href="/auth/login.php"
           class="bg-yellow-400 text-black font-semibold py-3 rounded-xl text-center hover:opacity-90 transition">
          Login
        </a>

        <a href="/index.php"
           class="bg-slate-900 border border-slate-700 text-white font-semibold py-3 rounded-xl text-center hover:opacity-90 transition">
          Continue as Guest
        </a>
      </div>

      <p class="text-xs text-slate-400 mt-3">
        Guest mode saves data on this device only.
      </p>
    <?php endif; ?>
  </div>


  <!-- Prayer Time Settings -->
  <div class="bg-slate-800 rounded-2xl p-6 shadow border border-slate-700/40">
    <h2 class="text-xl font-bold text-yellow-400 mb-2">🕌 Prayer Time Accuracy</h2>
    <p class="text-slate-300 text-sm mb-5">
      Choose the same method as your local masjid timetable so times match exactly.
    </p>

    <div class="grid md:grid-cols-2 gap-4">

      <div>
        <label class="block text-sm text-slate-300 mb-2">Calculation Method</label>
        <select id="calcMethod" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">
          <option value="1">Karachi (India/Pakistan/Bangladesh common) - Method 1</option>
          <option value="2">ISNA (North America) - Method 2</option>
          <option value="3">Muslim World League - Method 3</option>
          <option value="4">Umm Al-Qura, Makkah - Method 4</option>
          <option value="5">Egyptian General Authority - Method 5</option>
          <option value="8">Gulf Region - Method 8</option>
          <option value="9">Kuwait - Method 9</option>
          <option value="10">Qatar - Method 10</option>
          <option value="11">Singapore - Method 11</option>
          <option value="12">France (UOIF) - Method 12</option>
          <option value="13">Turkey (Diyanet) - Method 13</option>
        </select>
        <p class="text-xs text-slate-400 mt-2">
          🇮🇳 India → usually Karachi (Method 1). Confirm with your masjid card.
        </p>
      </div>

      <div>
        <label class="block text-sm text-slate-300 mb-2">Asr Method</label>
        <select id="asrMethod" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">
          <option value="0">Shafi (Standard)</option>
          <option value="1">Hanafi</option>
        </select>
        <p class="text-xs text-slate-400 mt-2">
          Choose what your masjid follows.
        </p>
      </div>

    </div>

    <div class="mt-5 flex flex-col sm:flex-row gap-3 items-center">
      <button id="savePrayerSettings"
              class="w-full sm:w-auto bg-yellow-400 text-black font-semibold py-3 px-6 rounded-xl hover:opacity-90 transition">
        Save Settings
      </button>
      <p id="settingsMsg" class="text-sm text-slate-300"></p>
    </div>
  </div>

</div>

<script src="assets/js/prayerSettings.js"></script>

<?php include "partials/footer.php"; ?>
