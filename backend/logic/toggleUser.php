<?php
// toggleUser.php
header('Content-Type: application/json; charset=UTF-8');
session_start();

// 1) Admin check
if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    http_response_code(403);
    echo json_encode(['success'=>false,'message'=>'Forbidden']);
    exit;
}

// 2) Validate incoming ID
if (empty($_POST['id']) || !ctype_digit((string)$_POST['id'])) {
    echo json_encode(['success'=>false,'message'=>'Invalid user ID']);
    exit;
}
$uid = (int)$_POST['id'];

// 3) Database setup
require_once __DIR__ . '/../config/Database.php';
use config\Database;
$db = (new Database())->getConnection();

// 4) Fetch current “active” flag
$stmt = $db->prepare("SELECT active FROM users WHERE id = ?");
$stmt->bind_param("i", $uid);
$stmt->execute();
$stmt->bind_result($current);
if (!$stmt->fetch()) {
    // no such user
    $stmt->close();
    echo json_encode(['success'=>false,'message'=>'User not found']);
    exit;
}
$stmt->close();

// 5) Toggle and update
$new = $current ? 0 : 1;
$stmt = $db->prepare("UPDATE users SET active = ? WHERE id = ?");
$stmt->bind_param("ii", $new, $uid);
$ok = $stmt->execute();
$stmt->close();

// 6) Return the result
echo json_encode([
  'success' => (bool)$ok,
  'active'  => $new
]);
exit;
