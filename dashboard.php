<?php
$pageTitle = "Dashboard | Deen Companion";
include "partials/header.php";
?>
<main class="px-4">
  <div class="card p-5 mb-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
      <div>
        <h1 class="text-xl font-bold" style="color:var(--accent);">Ramadan Dashboard</h1>
        <p class="text-sm mt-0.5" style="color:var(--text-muted);">May Allah accept our efforts</p>
      </div>
      <div class="text-right">
        <span class="text-xs" style="color:var(--text-muted);">Today</span>
        <div id="todayDate" class="font-semibold text-sm"></div>
      </div>
    </div>
  </div>

  <!-- Ramadan progress: Day 1–30 -->
  <div class="card p-5 mb-6">
    <h2 class="text-lg font-bold mb-3" style="color:var(--accent);">Ramadan progress</h2>
    <div class="flex items-center gap-3 mb-2">
      <div class="flex-1 h-3 rounded-full overflow-hidden" style="background:var(--bg-input);">
        <div id="ramadanProgressBar" class="h-full rounded-full transition-all duration-300" style="width:0%;background:var(--accent);"></div>
      </div>
      <span id="ramadanProgressText" class="text-sm font-medium whitespace-nowrap" style="color:var(--text-muted);">0/30</span>
    </div>
    <p id="ramadanDayLabel" class="text-xs" style="color:var(--text-muted);">Day 1 of 30</p>
  </div>

  <h2 class="text-lg font-semibold mb-3" style="color:var(--text);">Today’s timetable</h2>
  <div class="grid md:grid-cols-3 gap-4 mb-8">
    <div class="card p-5">
      <div class="text-sm mb-1" style="color:var(--text-muted);">Iftar (Maghrib)</div>
      <div id="iftarCountdown" class="text-2xl font-bold" style="color:var(--accent);">--:--:--</div>
      <div id="iftarTime" class="text-sm mt-1" style="color:var(--text-muted);">--</div>
    </div>
    <div class="card p-5">
      <div class="text-sm mb-1" style="color:var(--text-muted);">Sehri ends (Imsak)</div>
      <div id="sehriCountdown" class="text-2xl font-bold" style="color:var(--accent);">--:--:--</div>
      <div id="sehriTime" class="text-sm mt-1" style="color:var(--text-muted);">--</div>
      <div id="imsakTime" class="text-xs mt-0.5" style="color:var(--text-muted);">--</div>
    </div>
    <div class="card p-5">
      <div class="text-sm mb-1" style="color:var(--text-muted);">Next prayer</div>
      <div id="nextPrayerName" class="text-lg font-semibold">--</div>
      <div id="nextPrayerTime" class="text-xl font-bold mt-0.5" style="color:var(--accent);">--</div>
      <div id="nextPrayerCountdown" class="text-sm mt-1" style="color:var(--text-muted);">--:--:--</div>
    </div>
  </div>

  <!-- Daily Quran tracker -->
  <div class="card p-5 mb-8">
    <h2 class="text-lg font-bold mb-3" style="color:var(--accent);">Daily Quran</h2>
    <p class="text-sm mb-4" style="color:var(--text-muted);">Mark when you’ve read or listened today.</p>
    <label class="flex items-center gap-3 cursor-pointer p-3 rounded-xl border" style="border-color:var(--border);">
      <input type="checkbox" id="quranDoneToday" class="w-5 h-5 rounded" style="accent-color:var(--accent);" />
      <span>I read/listened to Quran today</span>
    </label>
  </div>
</main>
<script>
(function(){
  var d = new Date();
  var el = document.getElementById("todayDate");
  if (el) el.textContent = d.toLocaleDateString("en-GB", { weekday: "short", day: "numeric", month: "short" });
})();
</script>
<script src="assets/js/ramadan.js"></script>
<script src="assets/js/timer.js"></script>
<?php include "partials/footer.php"; ?>
