<?php
header("Content-Type: application/json");
include "../config/db.php";

if (!isset($conn) || !$conn) {
  echo json_encode(null);
  exit;
}

$age = isset($_GET['age']) ? $_GET['age'] : 'kids';
$age = ($age === 'adult') ? 'adult' : 'kids';

// Use kids_text / adult_text (DB schema); expose as full_text for frontend
$sql = "
  SELECT id, title, kids_text, adult_text, moral, action_tip, audio_url, video_url, thumbnail_url
  FROM stories
  WHERE is_published = 1
    AND (age_group = ? OR age_group = 'all')
  ORDER BY story_date DESC, id DESC
  LIMIT 1
";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) { echo json_encode(null); exit; }
mysqli_stmt_bind_param($stmt, "s", $age);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = $res ? mysqli_fetch_assoc($res) : null;

if ($row) {
  $row['full_text'] = ($age === 'adult') ? ($row['adult_text'] ?? '') : ($row['kids_text'] ?? '');
  unset($row['kids_text'], $row['adult_text']);
}
echo json_encode($row ? $row : null);
