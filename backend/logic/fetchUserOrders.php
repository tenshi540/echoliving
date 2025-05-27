<?php
// fetchUserOrders.php
header('Content-Type: application/json; charset=UTF-8');
session_start();
require_once __DIR__ . '/../config/Database.php';
use config\Database;

// 1) Only admins allowed
if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    http_response_code(403);
    echo json_encode(['error'=>'Forbidden']);
    exit;
}

// 2) Get userId from query
$userId = $_GET['userId'] ?? '';
if (!ctype_digit((string)$userId)) {
    echo json_encode(['items'=>[]]);
    exit;
}

// 3) Query order_items for that user
$db = (new Database())->getConnection();
$stmt = $db->prepare("
  SELECT 
    oi.id            AS item_id,
    oi.order_id      AS order_id,
    p.name           AS product_name,
    oi.quantity      AS quantity,
    (oi.quantity * p.price) AS total_price,
    o.created_at     AS created_at
  FROM order_items oi
  JOIN orders o  ON oi.order_id = o.id
  JOIN products p ON oi.product_id = p.id
  WHERE o.user_id = ?
  ORDER BY oi.id DESC
");
$stmt->bind_param('i', $userId);
$stmt->execute();
$items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// 4) Return JSON
echo json_encode(['items'=>$items]);
exit;
