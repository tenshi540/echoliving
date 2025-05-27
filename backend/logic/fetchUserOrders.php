<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use config\Database;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['items' => [], 'error' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['user_id']) || !is_numeric($data['user_id'])) {
    echo json_encode(['items' => [], 'error' => 'Missing or invalid user_id']);
    exit;
}

$user_id = intval($data['user_id']);
require_once __DIR__ . '/../config/Database.php';
$db = (new Database())->getConnection();

$stmt = $db->prepare("
    SELECT oi.id AS item_id, oi.order_id, p.name AS product_name, oi.quantity,
           (oi.quantity * oi.price_per_item) AS total_price, o.created_at
    FROM order_items oi
    JOIN orders o ON oi.order_id = o.id
    JOIN products p ON oi.product_id = p.id
    WHERE o.user_id = ?
    ORDER BY o.created_at DESC
");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$res = $stmt->get_result();

$items = [];
while ($row = $res->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode(['items' => $items]);
$stmt->close();
$db->close();
?>
