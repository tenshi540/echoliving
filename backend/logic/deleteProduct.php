<?php
session_start();
if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
    header('HTTP/1.1 403 Forbidden');
    exit;
}

require_once __DIR__ . '/../config/Database.php';
use Config\Database;

$db = Database::getConnection();

if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
    $id = (int) $_GET['id'];

    // 1) remove any order_items pointing to this product
    $stmt = $db->prepare("DELETE FROM order_items WHERE product_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // 2) delete the product itself
    $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

$db->close();
header('Location: /echoliving/frontend/res/pages/admin_products.php');
exit;
