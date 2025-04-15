
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    echo "Vielen Dank, $name! Deine Check-in E-Mail ($email) wurde registriert.";
}
?>
