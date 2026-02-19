<?php
$pageTitle = "Quran | Ramadan Companion";
include "partials/header.php";
?>

<div class="grid gap-6">

  <div class="bg-slate-800 rounded-2xl p-6 shadow">
    <h1 class="text-2xl font-bold text-yellow-400 mb-2">📖 Quran</h1>
    <p class="text-slate-300">Read the Quran with clarity and focus.</p>
  </div>

  <div id="surahList" class="grid md:grid-cols-2 gap-4"></div>

</div>

<script src="assets/js/quran.js"></script>

<?php include "partials/footer.php"; ?>
