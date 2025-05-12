<?php
session_start();
if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    header('HTTP/1.1 403 Forbidden');
    exit;
}

require_once __DIR__ . '/../config/Database.php';
use Config\Database;
$db = Database::getConnection();

$itemId = isset($_GET['item_id']) && ctype_digit($_GET['item_id'])
        ? (int)$_GET['item_id']
        : null;
$userId = isset($_GET['user_id']) && ctype_digit($_GET['user_id'])
        ? (int)$_GET['user_id']
        : null;

if ($itemId) {
    // 1) find its order
    $stmt = $db->prepare("
      SELECT order_id 
        FROM order_items 
       WHERE id = ?
    ");
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    $stmt->bind_result($orderId);
    $stmt->fetch();
    $stmt->close();

    // 2) delete the item
    $stmt = $db->prepare("
      DELETE FROM order_items 
       WHERE id = ?
    ");
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    $stmt->close();

    // 3) recalc new total
    $stmt = $db->prepare("
      SELECT COALESCE(SUM(quantity * price_per_item), 0) 
        FROM order_items 
       WHERE order_id = ?
    ");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $stmt->bind_result($newTotal);
    $stmt->fetch();
    $stmt->close();

    // 4) update orders table
    $stmt = $db->prepare("
      UPDATE orders 
         SET total_price = ?
       WHERE id = ?
    ");
    $stmt->bind_param("di", $newTotal, $orderId);
    $stmt->execute();
    $stmt->close();
}

$db->close();

// go back to this user’s order overview
header(
  'Location: /echoliving/frontend/res/pages/admin_user_orders.php'
  . '?user_id=' . $userId
);
exit;
