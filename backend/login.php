
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["username"];
    $pass = $_POST["password"];
    if ($user == "admin" && $pass == "1234") {
        echo "Login successful. Welcome, " . htmlspecialchars($user) . "!";
    } else {
        echo "Invalid login.";
    }
} else {
?>
<form method="post" action="">
    <label>Username:</label><br>
    <input type="text" name="username"><br><br>
    <label>Password:</label><br>
    <input type="password" name="password"><br><br>
    <input type="submit" value="Login">
</form>
<?php
}
?>
