<?php
$pageTitle = "Stories | Daily Deen Companion";
include "partials/header.php";
?>

<div class="grid gap-6">

  <div class="bg-slate-800 rounded-2xl p-6 shadow">
    <h1 class="text-2xl font-bold text-yellow-400 mb-2">🌟 Daily Waqiya</h1>
    <p class="text-slate-300">Read • Listen • Watch — and take one action today.</p>

    <div class="mt-4 flex gap-2">
      <button id="kidsBtn" class="px-4 py-2 rounded-xl bg-yellow-400 text-black font-semibold">Kids</button>
      <button id="adultBtn" class="px-4 py-2 rounded-xl bg-slate-900 text-white">Adults</button>
    </div>
  </div>

  <div id="storyBox" class="bg-slate-800 rounded-2xl p-6 shadow">
    <p class="text-slate-300">Loading story...</p>
  </div>

</div>

<script src="assets/js/stories.js"></script>

<?php include "partials/footer.php"; ?>
