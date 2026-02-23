<?php
$pageTitle = "Prayer Times | Deen Companion";
include "partials/header.php";
?>
<div class="grid gap-5">
  <div class="card p-6">
    <h1 class="text-2xl font-bold mb-1" style="color:var(--accent);">Prayer times</h1>
    <p class="text-sm" style="color:var(--text-muted);">Based on your location. Allow location for accurate times.</p>
  </div>
  <div id="locationStatus" class="text-sm" style="color:var(--text-muted);">Detecting location…</div>
  <div id="countdownBox" class="card p-5 text-center text-xl font-semibold hidden" style="color:var(--accent);"></div>
  <div id="prayerCards" class="grid md:grid-cols-2 lg:grid-cols-3 gap-4"></div>
</div>
<script src="assets/js/prayer.js"></script>
<?php include "partials/footer.php"; ?>
