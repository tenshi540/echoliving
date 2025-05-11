<?php
header('Content-Type: application/json');
session_start();

// 1) connect (same as registerUser)
$mysqli = new mysqli("localhost","root","","echo");
if($mysqli->connect_error){
  echo json_encode(["success"=>false,"message"=>"DB connection failed"]);
  exit;
}

// 2) pull & validate
$userOrEmail = $_POST['user']  ?? '';
$pass        = $_POST['password'] ?? '';
$remember    = isset($_POST['remember']);

if(!$userOrEmail || !$pass){
  echo json_encode(["success"=>false,"message"=>"Fill both fields"]);
  exit;
}

// 3) lookup by username OR email
$stmt = $mysqli->prepare(
  "SELECT id, password_hash, is_admin, active 
     FROM users 
     WHERE (username = ? OR email = ?) 
       AND active = 1
     LIMIT 1"
);
$stmt->bind_param("ss",$userOrEmail,$userOrEmail);
$stmt->execute();
$stmt->store_result();

if($stmt->num_rows===0){
  echo json_encode(["success"=>false,"message"=>"User not found"]);
  exit;
}

$stmt->bind_result($uid,$hash,$isAdmin,$active);
$stmt->fetch();

// 4) verify password
if(!password_verify($pass,$hash)){
  echo json_encode(["success"=>false,"message"=>"Wrong password"]);
  exit;
}

// 5) success → set session + (optionally) cookie
$_SESSION['user_id']   = $uid;
$_SESSION['is_admin']  = (bool)$isAdmin;

// remember-me for 30 days
if($remember){
  setcookie("remember_me",$uid,time()+60*60*24*30,"/echoliving",null,false,true);
}

echo json_encode(["success"=>true]);
$stmt->close();
$mysqli->close();
