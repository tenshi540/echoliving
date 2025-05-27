<?php
// fetchNavData.php
header('Content-Type: application/json; charset=UTF-8');

if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../config/Database.php';
use config\Database;

$resp = [
  'logged_in' => false,
  'username'  => null,
  'is_admin'  => false
];

if (!empty($_SESSION['user_id'])) {
    $uid = (int)$_SESSION['user_id'];
    $db  = (new Database())->getConnection();

    $stmt = $db->prepare("
      SELECT username, active, is_admin
        FROM users
       WHERE id = ?
    ");
    $stmt->bind_param('i', $uid);
    $stmt->execute();
    $stmt->bind_result($username, $active, $isAdmin);
    if ($stmt->fetch() && (int)$active === 1) {
        $resp['logged_in'] = true;
        $resp['username']  = $username;
        $resp['is_admin']  = (bool)$isAdmin;
    }
    $stmt->close();
}

echo json_encode($resp);
exit;
