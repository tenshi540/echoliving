<?php
// registerUser.php
header('Content-Type: application/json; charset=UTF-8');
session_start();

require_once __DIR__ . '/../config/Database.php';
use config\Database;

// 1) Collect & basic validate
$fields = [
  'salutation','first_name','last_name','address',
  'postal_code','city','email','username',
  'password','password_repeat','payment_info'
];
foreach ($fields as $f) {
  if (empty($_POST[$f])) {
    echo json_encode(['success'=>false,'message'=>"Field {$f} is required."]);
    exit;
  }
}

// 2) Password match
if ($_POST['password'] !== $_POST['password_repeat']) {
    echo json_encode(['success'=>false,'message'=>'Passwords do not match.']);
    exit;
}

// 3) Unique check
$db = (new Database())->getConnection();
$stmt = $db->prepare("
  SELECT id FROM users
   WHERE username = ? OR email = ?
");
$stmt->bind_param("ss", $_POST['username'], $_POST['email']);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo json_encode(['success'=>false,'message'=>'Username or email already in use.']);
    exit;
}
$stmt->close();

// 4) Hash password & insert
$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
$stmt = $db->prepare("
  INSERT INTO users
    (salutation, first_name, last_name,
     address, postal_code, city,
     email, username, password_hash,
     payment_info, active, is_admin, created_at)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 0, NOW())
");
$stmt->bind_param(
  "ssssssssss",
  $_POST['salutation'],
  $_POST['first_name'],
  $_POST['last_name'],
  $_POST['address'],
  $_POST['postal_code'],
  $_POST['city'],
  $_POST['email'],
  $_POST['username'],
  $hash,
  $_POST['payment_info']
);
$ok = $stmt->execute();
$stmt->close();

echo json_encode(['success'=>(bool)$ok]);
exit;
