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

// 2) Parse JSON input
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

// 3) Determine ID (JSON body or fallback to form-data)
if (isset($data['id']) && ctype_digit((string)$data['id'])) {
    $uid = (int)$data['id'];
} elseif (isset($_POST['id']) && ctype_digit((string)$_POST['id'])) {
    $uid = (int)$_POST['id'];
} else {
    echo json_encode(['success'=>false,'message'=>'Invalid user ID']);
    exit;
}

// 4) DB setup
require_once __DIR__ . '/../config/Database.php';
use config\Database;
$db = (new Database())->getConnection();

// 5) Fetch current “active” flag
$stmt = $db->prepare("SELECT active FROM users WHERE id = ?");
$stmt->bind_param("i", $uid);
$stmt->execute();
$stmt->bind_result($current);
if (!$stmt->fetch()) {
    $stmt->close();
    echo json_encode(['success'=>false,'message'=>'User not found']);
    exit;
}
$stmt->close();

// 6) Toggle & update
$new = $current ? 0 : 1;
$stmt = $db->prepare("UPDATE users SET active = ? WHERE id = ?");
$stmt->bind_param("ii", $new, $uid);
$ok = $stmt->execute();
$stmt->close();

// 7) Return JSON
echo json_encode([
  'success' => (bool)$ok,
  'active'  => $new
]);
exit;
