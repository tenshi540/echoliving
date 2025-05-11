<?php

require_once __DIR__ . "/../config/Database.php";
use config\Database;

header('Content-Type: application/json');

$mysqli = Database::getConnection();


if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

$result = $mysqli->query("SELECT * FROM products");

$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);
?>
