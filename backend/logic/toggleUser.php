<?php
session_start();
if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    header('HTTP/1.1 403 Forbidden');
    exit;
}

require_once __DIR__ . '/../config/Database.php';
use Config\Database;

$db = Database::getConnection();

if (!empty($_GET['id']) && ctype_digit($_GET['id']) && isset($_GET['action'])) {
    $id     = (int) $_GET['id'];
    $active = ($_GET['action'] === 'activate') ? 1 : 0;

    $stmt = $db->prepare("UPDATE users SET active = ? WHERE id = ?");
    $stmt->bind_param("ii", $active, $id);
    $stmt->execute();
    $stmt->close();
}

$db->close();
header('Location: /echoliving/frontend/res/pages/admin_users.php');
exit;
