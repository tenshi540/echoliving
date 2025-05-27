<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Only accept JSON POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Only POST with JSON allowed.']);
    exit;
}

// Decode JSON input
$data = json_decode(file_get_contents('php://input'), true);
$q = isset($data['q']) ? trim($data['q']) : '';

// Basic validation (optional)
if ($q === '') {
    echo json_encode([]);
    exit;
}

require_once __DIR__ . '/../config/Database.php';
use config\Database;
$db = (new Database())->getConnection();

// Prepare and execute the search query
$stmt = $db->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ? OR category LIKE ? ORDER BY name ASC");
$searchTerm = '%' . $q . '%';
$stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$res = $stmt->get_result();

$products = [];
while ($row = $res->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);

$stmt->close();
$db->close();
?>
