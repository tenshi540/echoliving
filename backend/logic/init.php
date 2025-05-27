<?php
// backend/config/init.php

session_start();

require_once __DIR__ . "/Database.php";
use config\Database;

// If user not in session but has a remember_me cookie, restore it
if (empty($_SESSION['user_id']) && !empty($_COOKIE['remember_me'])) {
    $uid = (int)$_COOKIE['remember_me'];

    // Optionally, verify that ID still exists & is active
    $db   = (new Database())->getConnection();
    $stmt = $db->prepare("SELECT id, is_admin FROM users WHERE id = :id AND is_active = 1");
    $stmt->execute([':id' => $uid]);
    $u = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($u) {
        // restore session
        $_SESSION['user_id']  = (int)$u['id'];
        $_SESSION['is_admin'] = (bool)$u['is_admin'];
    } else {
        // invalid or deactivated → clear cookie
        setcookie('remember_me', '', time() - 3600, '/');
    }
}
