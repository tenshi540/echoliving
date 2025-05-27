<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['name'], $data['description'], $data['price'], $data['rating'], $data['category'])) {
    echo json_encode(['success' => false, 'message' => 'Missing fields']);
    exit;
}

require_once __DIR__ . '/../config/Database.php';
use config\Database;
$db = (new Database())->getConnection();

$stmt = $db->prepare(
    "INSERT INTO products (name, description, price, rating, category) VALUES (?, ?, ?, ?, ?)"
);
$stmt->bind_param(
    'ssdss',
    $data['name'],
    $data['description'],
    $data['price'],
    $data['rating'],
    $data['category']
);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to create product']);
}
$stmt->close();
$db->close();
?>
