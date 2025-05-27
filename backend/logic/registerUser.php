<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Only POST allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

// Update these fields as needed!
$required = ['salutation', 'first_name', 'last_name', 'address', 'postal_code', 'city', 'email', 'username', 'password', 'password_repeat'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        echo json_encode(['success' => false, 'message' => "Missing field: $field"]);
        exit;
    }
}
if ($data['password'] !== $data['password_repeat']) {
    echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
    exit;
}

require_once __DIR__ . '/../config/Database.php';
use config\Database;
$db = (new Database())->getConnection();

$hashed = password_hash($data['password'], PASSWORD_DEFAULT);

// Insert user
$stmt = $db->prepare("
    INSERT INTO users 
    (salutation, first_name, last_name, address, postal_code, city, email, username, password_hash)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->bind_param(
    'sssssssss',
    $data['salutation'],
    $data['first_name'],
    $data['last_name'],
    $data['address'],
    $data['postal_code'],
    $data['city'],
    $data['email'],
    $data['username'],
    $hashed
);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Registration failed: ' . $stmt->error]);
}
$stmt->close();
$db->close();
?>
