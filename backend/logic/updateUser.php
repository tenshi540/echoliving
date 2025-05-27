<?php
// backend/logic/updateUser.php

// 1) Always return JSON, suppress HTML errors
header('Content-Type: application/json; charset=UTF-8');
error_reporting(E_ALL);
ini_set('display_errors', '0');

session_start();
require_once __DIR__ . '/../config/Database.php';
use config\Database;

// 2) Must be logged in
if (empty($_SESSION['user_id'])) {
    echo json_encode(['success'=>false, 'message'=>'Not authenticated']);
    exit;
}

// 3) Decode JSON payload
$payload = json_decode(file_get_contents('php://input'), true);
if (!is_array($payload)) {
    echo json_encode(['success'=>false, 'message'=>'Invalid JSON']);
    exit;
}

// 4) Validate fields
$required = [
  'salutation','first_name','last_name','address',
  'postal_code','city','email','username','confirm_password'
];
foreach ($required as $f) {
    if (empty($payload[$f])) {
        echo json_encode(['success'=>false, 'message'=>"Missing {$f}"]);
        exit;
    }
}

// 5) Lookup user’s current password hash
$db   = (new Database())->getConnection(); // mysqli
$stmt = $db->prepare("SELECT password_hash FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($storedHash);
$stmt->fetch();
$stmt->close();

// 6) Verify password
if (!password_verify($payload['confirm_password'], $storedHash)) {
    echo json_encode(['success'=>false, 'message'=>'Password incorrect']);
    exit;
}

// 7) Perform the update
$upd = $db->prepare("
  UPDATE users
     SET salutation   = ?,
         first_name   = ?,
         last_name    = ?,
         address      = ?,
         postal_code  = ?,
         city         = ?,
         email        = ?,
         username     = ?
   WHERE id = ?
");
$upd->bind_param(
    "ssssssssi",
    $payload['salutation'],
    $payload['first_name'],
    $payload['last_name'],
    $payload['address'],
    $payload['postal_code'],
    $payload['city'],
    $payload['email'],
    $payload['username'],
    $_SESSION['user_id']
);
$success = $upd->execute();
$upd->close();

// 8) Return JSON result
echo json_encode(['success' => (bool)$success]);
exit;
