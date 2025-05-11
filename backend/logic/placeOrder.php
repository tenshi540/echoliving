<?php
header('Content-Type: application/json');
session_start();
require_once __DIR__ . "/../config/Database.php";
use config\Database;


// 1) auth check
if (empty($_SESSION['user_id'])) {
    echo json_encode(["success"=>false,"message"=>"Not logged in"]);
    exit;
}

// 2) read JSON body
$body = json_decode(file_get_contents('php://input'), true);
$cart = $body['cart'] ?? [];

if (!$cart || !is_array($cart)) {
    echo json_encode(["success"=>false,"message"=>"Cart empty"]);
    exit;
}

// 3) connect DB
$mysqli = Database::getConnection();
if ($mysqli->connect_error) {
    echo json_encode(["success"=>false,"message"=>"DB error"]);
    exit;
}

// 4) load products to verify prices
$ids = array_keys($cart);
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$stmt = $mysqli->prepare("SELECT id, price FROM products WHERE id IN ($placeholders)");
$stmt->bind_param(str_repeat('i', count($ids)), ...$ids);
$stmt->execute();
$res = $stmt->get_result();
$products = [];
while ($row = $res->fetch_assoc()) {
    $products[$row['id']] = $row['price'];
}
$stmt->close();

// 5) calculate total
$total = 0.0;
foreach ($cart as $pid => $qty) {
    if (!isset($products[$pid])) {
        echo json_encode(["success"=>false,"message"=>"Invalid product $pid"]);
        exit;
    }
    $total += $products[$pid] * $qty;
}

// 6) insert order
$user_id = $_SESSION['user_id'];
$stmt = $mysqli->prepare(
  "INSERT INTO orders (user_id, total_price, payment_method) VALUES (?, ?, ?)"
);
$pm = "N/A"; // no actual payment gateway
$stmt->bind_param("ids", $user_id, $total, $pm);
if (!$stmt->execute()) {
    echo json_encode(["success"=>false,"message"=>"Order insert failed"]);
    exit;
}
$order_id = $stmt->insert_id;
$stmt->close();

// 7) insert order items
$stmt = $mysqli->prepare(
  "INSERT INTO order_items (order_id, product_id, quantity, price_per_item)
   VALUES (?, ?, ?, ?)"
);
foreach ($cart as $pid => $qty) {
    $price = $products[$pid];
    $stmt->bind_param("iiid", $order_id, $pid, $qty, $price);
    $stmt->execute();
}
$stmt->close();
$mysqli->close();

// 8) done
echo json_encode(["success"=>true,"orderId"=>$order_id]);
