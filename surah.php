<?php
$pageTitle = "Surah | Ramadan Companion";
include "partials/header.php";

$no = isset($_GET["no"]) ? intval($_GET["no"]) : 1;
if ($no < 1 || $no > 114) $no = 1;
?>

<div class="grid gap-6">

  <div class="bg-slate-800 rounded-2xl p-6 shadow">
    <a href="quran.php" class="text-sm underline text-slate-300 hover:text-white">← Back to Surah List</a>
    <h1 id="surahTitle" class="text-2xl font-bold text-yellow-400 mt-2">Loading...</h1>
    <p id="surahMeta" class="text-slate-300 text-sm"></p>
  </div>
  <div class="mt-4 flex flex-col sm:flex-row gap-3">
  <select id="qariSelect" class="bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">
    <option value="ar.alafasy">Mishary Alafasy (calm)</option>
    <option value="ar.husary">Mahmoud Khalil Al-Husary (very clear)</option>
    <option value="ar.abdulbasitmurattal">Abdul Basit (murattal)</option>
  </select>

  <div class="flex gap-3">
    <button id="playAllBtn" class="bg-yellow-400 text-black font-semibold px-5 py-3 rounded-xl hover:opacity-90 transition">
      ▶ Play All
    </button>
    <button id="stopBtn" class="bg-slate-700 text-white font-semibold px-5 py-3 rounded-xl hover:opacity-90 transition">
      ⏹ Stop
    </button>
  </div>
  <div class="mt-3 grid sm:grid-cols-3 gap-3">
  <select id="repeatMode" class="bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">
    <option value="off">Repeat: Off</option>
    <option value="ayah">Repeat: Current Ayah</option>
    <option value="surah">Repeat: Whole Surah</option>
  </select>

  <select id="playbackRate" class="bg-slate-900 border border-slate-700 rounded-xl p-3 text-white">
    <option value="0.75">Speed: 0.75×</option>
    <option value="1" selected>Speed: 1×</option>
    <option value="1.25">Speed: 1.25×</option>
  </select>

  <button id="resumeBtn" class="bg-slate-700 text-white font-semibold px-5 py-3 rounded-xl hover:opacity-90 transition">
    ⏩ Continue where I left
  </button>
</div>

</div>

<p class="text-slate-500 text-xs mt-3">
  Tip: Tap any ayah to play/pause. “Play All” will continue automatically.
</p>

<button id="toggleTranslation" class="bg-slate-700 text-white font-semibold px-5 py-3 rounded-xl hover:opacity-90 transition">
  🌐 Show Translation
</button>



  <div id="ayahList" class="grid gap-3"></div>

</div>

<script>
  window.SURAH_NO = <?= $no ?>;
</script>
<script src="assets/js/surah.js"></script>

<?php include "partials/footer.php"; ?>
