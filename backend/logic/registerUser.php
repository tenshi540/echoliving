<?php
header('Content-Type: application/json');

// ——————————————————————————————
// 1) Connect
// ——————————————————————————————
$mysqli = new mysqli("localhost", "root", "", "echo");
if ($mysqli->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "DB connection failed: " . $mysqli->connect_error
    ]);
    exit;
}

// ——————————————————————————————
// 2) Validate inputs
// ——————————————————————————————
$required = [
    "salutation","first_name","last_name",
    "address","postal_code","city",
    "email","username","password",
    "password_repeat","payment_info"
];
foreach ($required as $f) {
    if (empty($_POST[$f])) {
        echo json_encode([
            "success" => false,
            "message" => "Missing field: $f"
        ]);
        exit;
    }
}
if ($_POST["password"] !== $_POST["password_repeat"]) {
    echo json_encode([
        "success" => false,
        "message" => "Passwords do not match"
    ]);
    exit;
}

// ——————————————————————————————
// 3) Insert into users
// ——————————————————————————————
$hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
$stmt = $mysqli->prepare(
    "INSERT INTO users
     (salutation, first_name, last_name, address,
      postal_code, city, email, username,
      password_hash, payment_info)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param(
    "ssssssssss",
    $_POST["salutation"],
    $_POST["first_name"],
    $_POST["last_name"],
    $_POST["address"],
    $_POST["postal_code"],
    $_POST["city"],
    $_POST["email"],
    $_POST["username"],
    $hash,
    $_POST["payment_info"]
);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Insert failed: " . $stmt->error
    ]);
}

$stmt->close();
$mysqli->close();
