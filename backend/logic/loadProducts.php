<?php
header('Content-Type: application/json');

$mysqli = new mysqli("localhost", "root", "", "echo");

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
