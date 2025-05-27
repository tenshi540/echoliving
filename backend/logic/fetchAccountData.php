<?php
// fetchAccountData.php
header('Content-Type: application/json; charset=UTF-8');

session_start();

require_once __DIR__ . '/../config/Database.php';
use config\Database;

// 1) Authentication check
if (empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}
$uid = (int)$_SESSION['user_id'];

// 2) Connect
$db = (new Database())->getConnection();

// 3) Fetch user profile
$stmt = $db->prepare("
  SELECT salutation, first_name, last_name,
         address, postal_code, city,
         email, username
    FROM users
   WHERE id = ?
");
$stmt->bind_param('i', $uid);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

// 4) Fetch orders
$stmt = $db->prepare("
  SELECT id, created_at, total_price
    FROM orders
   WHERE user_id = ?
ORDER BY created_at DESC
");
$stmt->bind_param('i', $uid);
$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// 5) Return JSON
echo json_encode([
  'user'   => $user,
  'orders' => $orders
]);
exit;
