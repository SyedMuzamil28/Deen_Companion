<?php
include "_guard.php";
include "../config/db.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $slug = trim($_POST["slug"] ?? "");
  $title = trim($_POST["title"] ?? "");
  $age_group = $_POST["age_group"] ?? "all";
  $category = $_POST["category"] ?? "faith";
  $story_date = $_POST["story_date"] ?: null;

  $short_summary = trim($_POST["short_summary"] ?? "");
  $kids_text = trim($_POST["kids_text"] ?? "");
  $adult_text = trim($_POST["adult_text"] ?? "");
  $moral = trim($_POST["moral"] ?? "");
  $action_tip = trim($_POST["action_tip"] ?? "");

  $audio_url = trim($_POST["audio_url"] ?? "");
  $video_url = trim($_POST["video_url"] ?? "");
  $thumbnail_url = trim($_POST["thumbnail_url"] ?? "");

  $is_published = isset($_POST["is_published"]) ? 1 : 0;

  if ($slug === "" || $title === "" || $kids_text === "" || $adult_text === "") {
    $msg = "⚠️ Slug, Title, Kids text and Adult text are required.";
  } else {

    $stmt = mysqli_prepare($conn, "
      INSERT INTO stories
      (slug, title, age_group, category, story_date, short_summary,
       kids_text, adult_text,
       moral, action_tip,
       audio_url, video_url, thumbnail_url,
       is_published)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if ($stmt) {
      mysqli_stmt_bind_param(
        $stmt,
        "sssssssssssssi",
        $slug, $title, $age_group, $category, $story_date,
        $short_summary,
        $kids_text, $adult_text,
        $moral, $action_tip,
        $audio_url, $video_url, $thumbnail_url,
        $is_published
      );

      if (mysqli_stmt_execute($stmt)) {
        $msg = "✅ Story saved successfully!";
      } else {
        $msg = "❌ DB execute error: " . mysqli_error($conn);
      }

    } else {
      $msg = "❌ DB prepare error: " . mysqli_error($conn);
    }
  }
}

// Fetch recent stories
$res = mysqli_query(
  $conn,
  "SELECT id, title, age_group, category, is_published, story_date
   FROM stories
   ORDER BY id DESC
   LIMIT 10"
);

$recent = [];
if ($res) {
  while ($r = mysqli_fetch_assoc($res)) {
    $recent[] = $r;
  }
}
?>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin | Add Story</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white min-h-screen p-6">

<div class="max-w-5xl mx-auto">
  <div class="flex items-center justify-between mb-6">
    <div>
      <h1 class="text-2xl font-bold text-yellow-400">🛠 Admin: Add Story</h1>
      <p class="text-slate-300 text-sm">Logged in as <?= htmlspecialchars($_SESSION["admin_username"] ?? "admin") ?></p>
    </div>
    <div class="flex gap-3">
      <a href="../stories.php" class="px-4 py-2 rounded-xl bg-slate-800 hover:opacity-90">View Stories Page</a>
      <a href="logout.php" class="px-4 py-2 rounded-xl bg-red-500/30 hover:opacity-90">Logout</a>
    </div>
  </div>

  <?php if ($msg): ?>
    <div class="bg-slate-800 border border-slate-700 rounded-2xl p-4 mb-6">
      <?= htmlspecialchars($msg) ?>
    </div>
  <?php endif; ?>

  <form method="POST" class="bg-slate-800 rounded-2xl p-6 shadow grid gap-4">

    <div class="grid md:grid-cols-2 gap-4">
      <input name="slug" placeholder="slug (unique) e.g. musa-sea-kids-001" class="bg-slate-900 rounded-xl p-3" required>
      <input name="title" placeholder="Title" class="bg-slate-900 rounded-xl p-3" required>
    </div>

    <div class="grid md:grid-cols-3 gap-4">
      <select name="age_group" class="bg-slate-900 rounded-xl p-3">
        <option value="kids">Kids</option>
        <option value="adult">Adults</option>
        <option value="all">All</option>
      </select>

      <select name="category" class="bg-slate-900 rounded-xl p-3">
        <option value="prophets">Prophets</option>
        <option value="sahaba">Sahaba</option>
        <option value="heroes">Heroes</option>
        <option value="manners">Manners</option>
        <option value="faith">Faith</option>
        <option value="ramadan">Ramadan</option>
      </select>

      <input type="date" name="story_date" class="bg-slate-900 rounded-xl p-3" />
    </div>

    <textarea name="short_summary" rows="2" placeholder="Short summary (optional)"
      class="bg-slate-900 rounded-xl p-3"></textarea>

    <textarea name="kids_text" rows="6"
  placeholder="Kids version (simple language)"
  class="bg-slate-900 rounded-xl p-3" required></textarea>

<textarea name="adult_text" rows="8"
  placeholder="Adult version (detailed explanation)"
  class="bg-slate-900 rounded-xl p-3" required></textarea>


    <div class="grid md:grid-cols-2 gap-4">
      <textarea name="moral" rows="3" placeholder="Moral (optional)" class="bg-slate-900 rounded-xl p-3"></textarea>
      <textarea name="action_tip" rows="3" placeholder="Action for today (optional)" class="bg-slate-900 rounded-xl p-3"></textarea>
    </div>

    <div class="grid md:grid-cols-3 gap-4">
      <input name="audio_url" placeholder="Audio URL (mp3 link)" class="bg-slate-900 rounded-xl p-3">
      <input name="video_url" placeholder="Video URL (mp4 link)" class="bg-slate-900 rounded-xl p-3">
      <input name="thumbnail_url" placeholder="Thumbnail URL (optional)" class="bg-slate-900 rounded-xl p-3">
    </div>

    <label class="flex items-center gap-2 text-sm text-slate-300">
      <input type="checkbox" name="is_published" class="w-4 h-4">
      Publish now
    </label>

    <button class="bg-yellow-400 text-black font-semibold py-3 rounded-xl hover:opacity-90 transition">
      Save Story
    </button>
  </form>

  <div class="mt-8 bg-slate-800 rounded-2xl p-6 shadow">
    <h2 class="text-lg font-semibold mb-4">Recent Stories</h2>
    <div class="space-y-2 text-sm text-slate-300">
      <?php foreach ($recent as $s): ?>
        <div class="flex items-center justify-between bg-slate-900 rounded-xl p-3">
          <div>
            <div class="font-semibold"><?= htmlspecialchars($s["title"]) ?></div>
            <div class="text-xs text-slate-400">
              <?= htmlspecialchars($s["age_group"]) ?> • <?= htmlspecialchars($s["category"]) ?> •
              <?= $s["story_date"] ? htmlspecialchars($s["story_date"]) : "no date" ?>
            </div>
          </div>
          <div class="<?= $s["is_published"] ? "text-green-400" : "text-slate-500" ?>">
            <?= $s["is_published"] ? "Published" : "Draft" ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

</div>

</body>
</html>
