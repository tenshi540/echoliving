<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/Database.php';
use Config\Database;

$q = '%' . ($_GET['q'] ?? '') . '%';
$db = Database::getConnection();
$stmt = $db->prepare("
  SELECT id,name,description,price,rating,image_filename,category
    FROM products
   WHERE name LIKE ? OR description LIKE ?
   ORDER BY name
");
$stmt->bind_param("ss", $q, $q);
$stmt->execute();
echo json_encode($stmt->get_result()->fetch_all(MYSQLI_ASSOC));
