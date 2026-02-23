<?php
$pageTitle = "Quran | Deen Companion";
include "partials/header.php";
?>
<div class="grid gap-5">
  <div class="card p-6">
    <h1 class="text-2xl font-bold mb-1" style="color:var(--accent);">Quran</h1>
    <p class="text-sm mb-4" style="color:var(--text-muted);">Read and listen. Search by name or number.</p>
    <input type="text" id="surahSearch" placeholder="Search Surah (e.g. Baqarah or 2)" class="w-full px-4 py-3 rounded-xl text-lg border outline-none focus:ring-2" style="background:var(--bg-input);border-color:var(--border);color:var(--text);" />
  </div>

  <div id="surahLoading" class="flex justify-center py-12">
    <div class="w-10 h-10 border-4 rounded-full animate-spin" style="border-color:var(--border);border-top-color:var(--accent);"></div>
  </div>
  <div id="surahList" class="grid md:grid-cols-2 gap-4 hidden"></div>
  <div id="surahError" class="hidden text-center py-8" style="color:var(--text-muted);">Failed to load. Check connection.</div>
</div>
<script src="assets/js/quran.js"></script>
<?php include "partials/footer.php"; ?>
