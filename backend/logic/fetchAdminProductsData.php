<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/Database.php';
use config\Database;
$db = (new Database())->getConnection();

$sql = "SELECT * FROM products";
$result = $db->query($sql);

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode(['products' => $products]);

$result->close();
$db->close();
?>
