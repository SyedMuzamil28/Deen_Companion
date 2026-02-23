<?php
$pageTitle = "Settings | Deen Companion";
include "partials/header.php";
?>
<div class="max-w-5xl mx-auto grid gap-6">
  <div class="card p-6">
    <h1 class="text-2xl font-bold mb-2" style="color:var(--accent);">Settings</h1>
    <p class="text-sm" style="color:var(--text-muted);">Prayer time calculation and app preferences. Data is saved on this device.</p>
  </div>

  <div class="card p-6">
    <h2 class="text-lg font-bold mb-2" style="color:var(--accent);">Prayer time accuracy</h2>
    <p class="text-sm mb-5" style="color:var(--text-muted);">Choose the same method as your local masjid.</p>
    <div class="grid md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm mb-2" style="color:var(--text-muted);">Calculation method</label>
        <select id="calcMethod" class="w-full px-4 py-3 rounded-xl border text-sm" style="background:var(--bg-input);border-color:var(--border);color:var(--text);">
          <option value="1">Karachi (1)</option>
          <option value="2">ISNA (2)</option>
          <option value="3">Muslim World League (3)</option>
          <option value="4">Umm Al-Qura (4)</option>
          <option value="5">Egyptian (5)</option>
          <option value="8">Gulf (8)</option>
          <option value="9">Kuwait (9)</option>
          <option value="10">Qatar (10)</option>
          <option value="11">Singapore (11)</option>
          <option value="12">France UOIF (12)</option>
          <option value="13">Turkey Diyanet (13)</option>
        </select>
      </div>
      <div>
        <label class="block text-sm mb-2" style="color:var(--text-muted);">Asr method</label>
        <select id="asrMethod" class="w-full px-4 py-3 rounded-xl border text-sm" style="background:var(--bg-input);border-color:var(--border);color:var(--text);">
          <option value="0">Shafi</option>
          <option value="1">Hanafi</option>
        </select>
      </div>
    </div>
    <div class="mt-5 flex flex-wrap gap-3 items-center">
      <button id="savePrayerSettings" class="px-5 py-2.5 rounded-xl font-semibold text-sm" style="background:var(--accent);color:#fff;">Save</button>
      <span id="settingsMsg" class="text-sm" style="color:var(--text-muted);"></span>
    </div>
  </div>
</div>
<script src="assets/js/prayerSettings.js"></script>
<?php include "partials/footer.php"; ?>
