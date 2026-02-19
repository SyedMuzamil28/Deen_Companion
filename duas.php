<?php
$pageTitle = "Duas | Ramadan Companion";
include "partials/header.php";
?>

<div class="grid gap-6">

  <!-- Header -->
  <div class="bg-slate-800 rounded-2xl p-6 shadow">
    <h1 class="text-2xl font-bold text-yellow-400 mb-2">📿 Daily Duas</h1>
    <p class="text-slate-300">Small duas, big impact — read with presence.</p>
  </div>

  <!-- Filter -->
  <div class="flex gap-3 text-sm">
    <button data-filter="all" class="filterBtn bg-yellow-400 text-black px-4 py-2 rounded-xl font-semibold">All</button>
    <button data-filter="sehri" class="filterBtn bg-slate-800 px-4 py-2 rounded-xl">Sehri</button>
    <button data-filter="iftar" class="filterBtn bg-slate-800 px-4 py-2 rounded-xl">Iftar</button>
    <button data-filter="general" class="filterBtn bg-slate-800 px-4 py-2 rounded-xl">General</button>
  </div>

  <!-- Duas List -->
  <div id="duaList" class="grid md:grid-cols-2 gap-4"></div>

</div>

<script src="assets/js/duas.js"></script>

<?php include "partials/footer.php"; ?>
