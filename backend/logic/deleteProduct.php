<?php
// deleteProduct.php
header('Content-Type: application/json; charset=UTF-8');
// no HTML or whitespace before this

session_start();
// 1) Check auth + admin
if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    http_response_code(403);
    echo json_encode(['success'=>false,'message'=>'Forbidden']);
    exit;
}

// 2) Get & validate payload
if (empty($_POST['id']) || !ctype_digit((string)$_POST['id'])) {
    echo json_encode(['success'=>false,'message'=>'Invalid ID']);
    exit;
}
$id = (int)$_POST['id'];

require_once __DIR__ . '/../config/Database.php';
use config\Database;

$db = (new Database())->getConnection();

// 3) Delete any dependent rows (order_items)
$stmt = $db->prepare("DELETE FROM order_items WHERE product_id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->close();

// 4) Delete the product
$stmt = $db->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param('i', $id);
$ok = $stmt->execute();
$stmt->close();

// 5) Return JSON only
echo json_encode(['success' => (bool)$ok]);
exit;
