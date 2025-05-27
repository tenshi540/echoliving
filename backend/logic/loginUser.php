<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Only POST allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data || empty($data['username']) || empty($data['password'])) {
    echo json_encode(['success' => false, 'message' => 'Missing username or password']);
    exit;
}

require_once __DIR__ . '/../config/Database.php';
use config\Database;
$db = (new Database())->getConnection();

$stmt = $db->prepare("SELECT id, password_hash, active, is_admin FROM users WHERE username = ?");
$stmt->bind_param('s', $data['username']);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();

if ($user && $user['active'] && password_verify($data['password'], $user['password_hash'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['is_admin'] = isset($user['is_admin']) ? (int)$user['is_admin'] : 0;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid login or inactive account']);
}
$stmt->close();
$db->close();
?>
