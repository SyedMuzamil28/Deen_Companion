<?php
$pageTitle = "Family | Muslim Life Companion";
include "partials/header.php";
?>

<div class="bg-slate-800 rounded-2xl p-6 shadow mb-6">
  <h1 class="text-2xl font-bold text-yellow-400 mb-2">👪 Family</h1>
  <p class="text-slate-300">
    Ramadan Lite: Family feature is minimal. Add members below if needed.
  </p>
</div>

<div id="membersList" class="grid gap-4 mb-6"></div>

<div class="bg-slate-800 rounded-2xl p-6 shadow">
  <h2 class="text-lg font-semibold text-yellow-400 mb-3">Add member</h2>
  <div class="flex flex-wrap gap-3 mb-3">
    <input type="text" id="memberName" placeholder="Name" class="bg-slate-900 border border-slate-700 rounded-xl p-3 text-white flex-1 min-w-0">
    <input type="text" id="memberEmoji" placeholder="Emoji (optional)" class="bg-slate-900 border border-slate-700 rounded-xl p-3 text-white w-24">
  </div>
  <button type="button" id="addMemberBtn" class="bg-yellow-400 text-black font-semibold py-2 px-4 rounded-xl hover:opacity-90">Add</button>
  <p id="addMsg" class="text-sm text-slate-400 mt-2"></p>
</div>

<script src="assets/js/family.js"></script>

<?php include "partials/footer.php"; ?>
