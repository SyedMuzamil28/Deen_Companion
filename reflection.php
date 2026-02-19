<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reflections | Ramadan Companion</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-900 text-white min-h-screen p-6">

<div class="max-w-3xl mx-auto">

  <!-- Header -->
  <div class="mb-6 flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-bold text-yellow-400">📝 Daily Reflection</h1>
      <p class="text-slate-400">Be honest with Allah and yourself</p>
    </div>

    <a href="dashboard.php" class="text-sm underline text-slate-300 hover:text-white">
      Back to Dashboard
    </a>
  </div>

  <!-- Reflection Card -->
  <div class="bg-slate-800 rounded-2xl p-6 shadow">

    <label class="block text-sm text-slate-300 mb-2">
      How was your day spiritually?
    </label>

    <textarea id="reflectionText"
      rows="6"
      class="w-full bg-slate-900 text-white rounded-xl p-4 focus:outline-none focus:ring-2 focus:ring-yellow-400"
      placeholder="Write freely… no one else will see this."></textarea>

    <!-- Rating -->
    <div class="mt-6">
      <p class="text-sm text-slate-300 mb-2">Rate your day</p>
      <div id="stars" class="flex gap-2 text-2xl cursor-pointer">
        <span data-star="1">☆</span>
        <span data-star="2">☆</span>
        <span data-star="3">☆</span>
        <span data-star="4">☆</span>
        <span data-star="5">☆</span>
      </div>
    </div>

    <!-- Actions -->
    <div class="mt-6 flex items-center gap-4">
      <button id="saveReflection"
        class="bg-yellow-400 text-black font-semibold py-3 px-6 rounded-xl hover:opacity-90 transition">
        Save Reflection
      </button>

      <span id="msg" class="text-sm text-slate-300"></span>
    </div>
  </div>
</div>
<!-- Reflection History -->
<div class="bg-slate-800 rounded-2xl p-6 shadow mt-6">
  <h2 class="text-lg font-semibold mb-4">📅 Reflection History</h2>
  <div id="historyList" class="space-y-3 text-sm text-slate-300">
    <p class="text-slate-400">No reflections yet.</p>
  </div>
</div>


<script src="assets/js/reflection.js"></script>
</body>
</html>
