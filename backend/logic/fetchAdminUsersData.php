<?php
// fetchAdminUsersData.php
header('Content-Type: application/json; charset=UTF-8');
session_start();
require_once __DIR__ . '/../config/Database.php';
use config\Database;

if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    http_response_code(403);
    echo json_encode(['error'=>'Forbidden']);
    exit;
}

$db = (new Database())->getConnection();
$stmt = $db->prepare("
  SELECT id, salutation, first_name, last_name,
         email, username, active
    FROM users
   ORDER BY created_at DESC
");
$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

echo json_encode(['users'=>$users]);
exit;
