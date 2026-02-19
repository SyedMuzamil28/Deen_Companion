<?php
$pageTitle = "Prayer Times | Ramadan Companion";
include "partials/header.php";
?>

<div class="grid gap-6">

  <div class="bg-slate-800 rounded-2xl p-6 shadow">
    <h1 class="text-2xl font-bold text-yellow-400 mb-2">🕌 Prayer Times</h1>
    <p class="text-slate-300">Accurate prayer times based on your location.</p>
  </div>

  <div id="locationStatus" class="text-slate-400 text-sm">
    <div id="countdownBox" class="bg-slate-800 rounded-2xl p-6 shadow text-center text-xl font-semibold text-yellow-400"></div>

    Detecting location...
  </div>

  <div id="prayerCards" class="grid md:grid-cols-3 gap-4"></div>

</div>

<script src="assets/js/prayer.js"></script>

<?php include "partials/footer.php"; ?>
