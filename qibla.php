<?php
$pageTitle = "Qibla | Deen Companion";
include "partials/header.php";
?>
<div class="grid gap-6">
  <div class="card p-6">
    <h1 class="text-2xl font-bold mb-1" style="color:var(--accent);">Qibla Compass</h1>
    <p class="text-sm" style="color:var(--text-muted);">Point your device toward the Kaaba. Allow orientation &amp; location when prompted.</p>
  </div>

  <div id="qiblaPermission" class="card p-6 text-center hidden">
    <p class="mb-4" style="color:var(--text-muted);">Location or device orientation was denied. Using default direction from Hyderabad, India.</p>
    <p id="qiblaDegreesFallback" class="text-2xl font-bold" style="color:var(--accent);">—°</p>
  </div>

  <div id="qiblaCompassWrap" class="flex flex-col items-center py-6">
    <div class="relative w-64 h-64 sm:w-80 sm:h-80">
      <div class="absolute inset-0 rounded-full border-4 flex items-center justify-center" style="border-color:var(--border);background:var(--bg-card);">
        <span class="text-4xl" aria-hidden="true">🕋</span>
      </div>
      <div id="qiblaNeedle" class="absolute inset-0 flex items-start justify-center pt-4 transition-transform duration-100" style="transform: rotate(0deg);">
        <div class="w-2 h-24 rounded-full origin-bottom" style="background:var(--accent);"></div>
      </div>
      <div class="absolute bottom-2 left-1/2 -translate-x-1/2 text-sm font-mono" style="color:var(--text-muted);">N</div>
    </div>
    <p id="qiblaDegrees" class="mt-6 text-xl font-bold font-mono" style="color:var(--accent);">0°</p>
    <p id="qiblaHint" class="mt-1 text-sm" style="color:var(--text-muted);">Rotate device until needle points up</p>
  </div>
</div>
<script src="assets/js/qibla.js"></script>
<?php include "partials/footer.php"; ?>
