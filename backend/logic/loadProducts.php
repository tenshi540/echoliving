<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Enforce GET method
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Only GET allowed.']);
    exit;
}

require_once __DIR__ . '/../config/Database.php';
use config\Database;
$db = (new Database())->getConnection();

$res = $db->query("SELECT * FROM products ORDER BY name ASC");
$products = [];
while ($row = $res->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);

$db->close();
?>
