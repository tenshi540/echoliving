<?php
// createProduct.php
session_start();
require_once __DIR__ . '/../config/Database.php';
use config\Database;

// 1) Optional: restrict to admin users
// if (empty($_SESSION['is_admin'])) {
//   header('HTTP/1.1 403 Forbidden');
//   exit;
// }

// 2) Read & validate POST
$name        = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$price       = (float) ($_POST['price'] ?? 0);
$rating      = (float) ($_POST['rating'] ?? 0);

// Basic validation
if ($name === '' || $description === '' || $price <= 0 || $rating < 0 || $rating > 5) {
    die('Invalid input');
}

// 3) Handle file upload
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    die('Image upload failed');
}

$tmpPath   = $_FILES['image']['tmp_name'];
$origName  = basename($_FILES['image']['name']);
$ext       = pathinfo($origName, PATHINFO_EXTENSION);
$filename  = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;

// Destination folder: frontend/res/img/picturefile
$destDir = __DIR__ . '/../../frontend/res/img/picturefile/';
if (!is_dir($destDir)) {
    mkdir($destDir, 0755, true);
}

$destPath = $destDir . $filename;
if (!move_uploaded_file($tmpPath, $destPath)) {
    die('Failed to move uploaded file');
}

// 4) Insert into database
$db = (new Database())->getConnection();
$stmt = $db->prepare("
  INSERT INTO products 
    (name, description, rating, price, image_filename, category)
  VALUES (?, ?, ?, ?, ?, ?)
");
$category = 'chair';  // default
// types: s = string, d = double, s = string, so "ssddss"
$stmt->bind_param(
  'ssddss',
  $name,
  $description,
  $rating,
  $price,
  $filename,
  $category
);
$stmt->execute();
$stmt->close();

// 5) Redirect back to admin page
header('Location: /echoliving/frontend/res/pages/admin_products.php');
exit;
