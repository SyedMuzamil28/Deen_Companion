<?php
$pageTitle = "Surah | Deen Companion";
include "partials/header.php";
$no = isset($_GET["no"]) ? intval($_GET["no"]) : 1;
if ($no < 1 || $no > 114) $no = 1;
?>
<div class="grid gap-5">
  <div class="card p-5">
    <a href="quran.php" class="text-sm inline-block mb-2" style="color:var(--text-muted);">← Back to Quran</a>
    <h1 id="surahTitle" class="text-xl font-bold mt-1" style="color:var(--accent);">Loading…</h1>
    <p id="surahMeta" class="text-sm mt-1" style="color:var(--text-muted);"></p>
  </div>

  <div class="flex flex-wrap gap-2">
    <select id="qariSelect" class="px-4 py-2.5 rounded-xl border text-sm" style="background:var(--bg-input);border-color:var(--border);color:var(--text);">
      <option value="ar.alafasy">Mishary Alafasy</option>
      <option value="ar.husary">Al-Husary</option>
      <option value="ar.abdulbasitmurattal">Abdul Basit</option>
    </select>
    <button id="playAllBtn" class="px-4 py-2.5 rounded-xl font-semibold text-sm" style="background:var(--accent);color:#fff;">▶ Play all</button>
    <button id="stopBtn" class="px-4 py-2.5 rounded-xl border text-sm" style="background:var(--bg-card);border-color:var(--border);">⏹ Stop</button>
    <select id="repeatMode" class="px-4 py-2.5 rounded-xl border text-sm" style="background:var(--bg-input);border-color:var(--border);color:var(--text);">
      <option value="off">Repeat: Off</option>
      <option value="ayah">Repeat ayah</option>
      <option value="surah">Repeat surah</option>
    </select>
    <select id="playbackRate" class="px-4 py-2.5 rounded-xl border text-sm" style="background:var(--bg-input);border-color:var(--border);color:var(--text);">
      <option value="0.75">0.75×</option>
      <option value="1" selected>1×</option>
      <option value="1.25">1.25×</option>
    </select>
    <button id="toggleTranslation" class="px-4 py-2.5 rounded-xl border text-sm" style="background:var(--bg-card);border-color:var(--border);">🌐 Translation</button>
  </div>

  <div id="surahLoading" class="flex justify-center py-12">
    <div class="w-10 h-10 border-4 rounded-full animate-spin" style="border-color:var(--border);border-top-color:var(--accent);"></div>
  </div>
  <div id="ayahList" class="grid gap-4 hidden"></div>
</div>
<script>window.SURAH_NO = <?= (int)$no ?>;</script>
<script src="assets/js/surah.js"></script>
<?php include "partials/footer.php"; ?>
