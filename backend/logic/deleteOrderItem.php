<?php
// deleteOrderItem.php
header('Content-Type: application/json; charset=UTF-8');
session_start();
require_once __DIR__ . '/../config/Database.php';
use config\Database;

// 1) Admin check
if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    http_response_code(403);
    echo json_encode(['success'=>false,'message'=>'Forbidden']);
    exit;
}

// 2) Get & validate item_id
$itemId = $_POST['item_id'] ?? '';
if (!ctype_digit((string)$itemId)) {
    echo json_encode(['success'=>false,'message'=>'Invalid item ID']);
    exit;
}
$itemId = (int)$itemId;

// 3) Delete it
$db = (new Database())->getConnection();
$stmt = $db->prepare("DELETE FROM order_items WHERE id = ?");
$stmt->bind_param('i', $itemId);
$ok = $stmt->execute();
$stmt->close();

// 4) JSON only
echo json_encode(['success'=>(bool)$ok]);
exit;
