<?php
$pageTitle = "Quran Plan | Ramadan Companion";
include "partials/header.php";
?>

<div class="grid gap-6">

  <div class="bg-slate-800 rounded-2xl p-6 shadow">
    <h1 class="text-2xl font-bold text-yellow-400 mb-2">📅 Quran Plan</h1>
    <p class="text-slate-300">One Juz a day during Ramadan. Simple and consistent.</p>
  </div>

  <div id="planCard" class="bg-slate-800 rounded-2xl p-6 shadow"></div>

  <div class="bg-slate-800 rounded-2xl p-6 shadow">
    <h2 class="text-xl font-bold mb-3">✅ Progress</h2>
    <div id="progressBarWrap" class="w-full bg-slate-700 rounded-full h-3 overflow-hidden">
      <div id="progressBar" class="bg-yellow-400 h-3 rounded-full" style="width:0%"></div>
    </div>
    <p id="progressText" class="text-slate-300 text-sm mt-2">0/30 days completed</p>
  </div>

</div>

<script src="assets/js/quranPlan.js"></script>

<?php include "partials/footer.php"; ?>
