<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// JSON ONLY: accept POST with JSON body (no query params)
$data = json_decode(file_get_contents('php://input'), true);
$orderId = isset($data['orderId']) ? intval($data['orderId']) : 0;

if ($orderId <= 0) {
    echo json_encode(['error' => 'Invalid order ID']);
    exit;
}

// (Assuming you have something like this)
require_once __DIR__ . '/../config/Database.php';
use config\Database;
$db = (new Database())->getConnection();

// Fetch order
$stmt = $db->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$orderRes = $stmt->get_result();
$order = $orderRes->fetch_assoc();
$stmt->close();

if (!$order) {
    echo json_encode(['error' => 'Order not found']);
    $db->close();
    exit;
}

// Fetch user
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $order['user_id']);
$stmt->execute();
$userRes = $stmt->get_result();
$user = $userRes->fetch_assoc();
$stmt->close();

if (!$user) {
    echo json_encode(['error' => 'User not found']);
    $db->close();
    exit;
}

// Fetch items
$stmt = $db->prepare("
    SELECT oi.*, p.name, oi.price_per_item AS price_per_item
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$itemsRes = $stmt->get_result();
$items = [];
while ($row = $itemsRes->fetch_assoc()) {
    $items[] = $row;
}
$stmt->close();
$db->close();

// Return all as JSON
echo json_encode([
    'order' => [
        'id' => $order['id'],
        'date' => $order['created_at'],
        'total' => $order['total_price']
    ],
    'user' => [
        'salutation' => $user['salutation'],
        'first_name' => $user['first_name'],
        'last_name' => $user['last_name'],
        'address' => $user['address'],
        'postal_code' => $user['postal_code'],
        'city' => $user['city']
    ],
    'items' => $items
]);
?>
