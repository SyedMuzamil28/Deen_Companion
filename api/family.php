<?php
header("Content-Type: application/json");
include "../config/db.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method === "GET") {
  $res = mysqli_query($conn, "SELECT member_uid, name, emoji FROM family_members ORDER BY id ASC");
  $rows = [];
  while ($r = mysqli_fetch_assoc($res)) $rows[] = $r;
  echo json_encode($rows);
  exit;
}

if ($method === "POST") {
  $data = json_decode(file_get_contents("php://input"), true);
  if (!$data || empty($data['member_uid']) || empty($data['name'])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid data"]);
    exit;
  }

  $uid = mysqli_real_escape_string($conn, $data['member_uid']);
  $name = mysqli_real_escape_string($conn, $data['name']);
  $emoji = mysqli_real_escape_string($conn, $data['emoji'] ?? "");

  mysqli_query($conn, "
    INSERT IGNORE INTO family_members (member_uid, name, emoji)
    VALUES ('$uid', '$name', '$emoji')
  ");

  echo json_encode(["ok" => true]);
  exit;
}

http_response_code(405);
echo json_encode(["error" => "Method not allowed"]);
