<?php
// fetchAdminProductsData.php
header('Content-Type: application/json; charset=UTF-8');

session_start();
require_once __DIR__ . '/../config/Database.php';
use config\Database;

// 1) Auth & admin check
if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    http_response_code(403);
    echo json_encode(['error'=>'Forbidden']);
    exit;
}

// 2) Connect & fetch all products
$db = (new Database())->getConnection();
$stmt = $db->prepare("
  SELECT id, name, description, rating, price, image_filename, category, created_at
    FROM products
   ORDER BY created_at DESC
");
$stmt->execute();
$products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// 3) Return JSON
echo json_encode(['products'=>$products]);
exit;
