<?php
// loginUser.php
header('Content-Type: application/json; charset=UTF-8');
session_start();

require_once __DIR__ . '/../config/Database.php';
use config\Database;

// 1) Read & validate inputs
$usernameOrEmail = trim($_POST['username'] ?? '');
$password        = $_POST['password'] ?? '';

if ($usernameOrEmail === '' || $password === '') {
    echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
    exit;
}

// 2) Lookup user (now selecting active too)
$db = (new Database())->getConnection();
$stmt = $db->prepare("
  SELECT id, password_hash, active, is_admin
    FROM users
   WHERE username = ? OR email = ?
   LIMIT 1
");
$stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
$stmt->execute();
$stmt->bind_result($id, $hash, $active, $isAdmin);

// 3) If no such user
if (!$stmt->fetch()) {
    echo json_encode(['success' => false, 'message' => 'Invalid credentials.']);
    $stmt->close();
    exit;
}
$stmt->close();

// 4) Prevent login if deactivated
if ((int)$active !== 1) {
    echo json_encode(['success' => false, 'message' => 'This account has been deactivated.']);
    exit;
}

// 5) Verify password
if (!password_verify($password, $hash)) {
    echo json_encode(['success' => false, 'message' => 'Invalid credentials.']);
    exit;
}

// 6) Successful login
$_SESSION['user_id']  = $id;
$_SESSION['is_admin'] = $isAdmin ? 1 : 0;

echo json_encode(['success' => true]);
exit;
