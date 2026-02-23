<?php
$pageTitle = "Duas | Deen Companion";
include "partials/header.php";
?>
<div class="grid gap-5">
  <div class="card p-6">
    <h1 class="text-2xl font-bold mb-1" style="color:var(--accent);">Duas</h1>
    <p class="text-sm mb-4" style="color:var(--text-muted);">Sehri, Iftar and daily duas. Tap a filter to focus.</p>
    <div class="flex flex-wrap gap-2">
      <button type="button" data-filter="all" class="filterBtn px-4 py-2 rounded-xl text-sm font-medium transition">All</button>
      <button type="button" data-filter="sehri" class="filterBtn px-4 py-2 rounded-xl text-sm font-medium transition">Sehri</button>
      <button type="button" data-filter="iftar" class="filterBtn px-4 py-2 rounded-xl text-sm font-medium transition">Iftar</button>
      <button type="button" data-filter="general" class="filterBtn px-4 py-2 rounded-xl text-sm font-medium transition">General</button>
    </div>
  </div>

  <div id="duaList" class="grid gap-4"></div>
</div>
<script src="assets/js/duas.js"></script>
<?php include "partials/footer.php"; ?>
