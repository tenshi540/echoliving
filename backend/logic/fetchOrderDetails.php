<?php
header('Content-Type: application/json; charset=UTF-8');
session_start();
require_once __DIR__ . '/../config/Database.php';
use config\Database;

// 1) Auth & parameter check
if (empty($_SESSION['user_id']) ||
    !isset($_GET['orderId']) ||
    !ctype_digit($_GET['orderId'])
) {
    http_response_code(401);
    echo json_encode(['error'=>'Not authenticated or invalid order']);
    exit;
}
$uid     = (int)$_SESSION['user_id'];
$orderId = (int)$_GET['orderId'];

$db = (new Database())->getConnection();

// 2) Fetch order summary
$stmt = $db->prepare("
  SELECT total_price, created_at
    FROM orders
   WHERE id = ? AND user_id = ?
");
$stmt->bind_param('ii', $orderId, $uid);
$stmt->execute();
$stmt->bind_result($total, $date);
if (!$stmt->fetch()) {
    $stmt->close();
    echo json_encode(['error'=>'Order not found']);
    exit;
}
$stmt->close();

// 3) Fetch line items
$stmt = $db->prepare("
  SELECT p.name, oi.quantity, oi.price_per_item
    FROM order_items oi
    JOIN products p ON p.id = oi.product_id
   WHERE oi.order_id = ?
");
$stmt->bind_param('i', $orderId);
$stmt->execute();
$items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// 4) Fetch user billing info
$stmt = $db->prepare("
  SELECT salutation, first_name, last_name,
         address, postal_code, city
    FROM users
   WHERE id = ?
");
$stmt->bind_param('i', $uid);
$stmt->execute();
$stmt->bind_result($sal, $fn, $ln, $addr, $pc, $city);
$stmt->fetch();
$stmt->close();

// 5) Return JSON
echo json_encode([
  'order' => [
    'id'    => $orderId,
    'total' => $total,
    'date'  => $date
  ],
  'user' => [
    'salutation'  => $sal,
    'first_name'  => $fn,
    'last_name'   => $ln,
    'address'     => $addr,
    'postal_code' => $pc,
    'city'        => $city
  ],
  'items' => $items
]);
exit;
