<?php
header("Content-Type: application/json");
include "../config/db.php";

$age = isset($_GET['age']) ? $_GET['age'] : 'kids';
$age = ($age === 'adult') ? 'adult' : 'kids';

$sql = "
  SELECT id, title, full_text, moral, action_tip, audio_url, video_url, thumbnail_url
  FROM stories
  WHERE is_published = 1
    AND (age_group = '$age' OR age_group = 'all')
  ORDER BY story_date DESC, id DESC
  LIMIT 1
";

$res = mysqli_query($conn, $sql);
if (!$res) { echo json_encode(["error" => "DB error"]); exit; }

$row = mysqli_fetch_assoc($res);
echo json_encode($row ? $row : null);
