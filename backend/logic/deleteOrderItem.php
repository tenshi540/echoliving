<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use config\Database;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['item_id']) || !is_numeric($data['item_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing or invalid item_id']);
    exit;
}

$item_id = intval($data['item_id']);
require_once __DIR__ . '/../config/Database.php';
$db = (new Database())->getConnection();

$stmt = $db->prepare("DELETE FROM order_items WHERE id = ?");
$stmt->bind_param('i', $item_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to delete item']);
}

$stmt->close();
$db->close();
?>
