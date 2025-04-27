<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - EchoLiving</title>
    <link rel="stylesheet" href="../css/prisma.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <?php include('../../compass.php'); ?>

    <main>
        <section class="hero">
            <h2>Create Your Account</h2>
            <form class="login-form" action="#" method="post" style="display: flex; flex-direction: column; gap: 1rem; max-width: 300px; margin: auto;">
                <input type="text" placeholder="Username" required style="padding: 0.5rem; border-radius: 8px; border: 1px solid #ccc;">
                <input type="email" placeholder="Email" required style="padding: 0.5rem; border-radius: 8px; border: 1px solid #ccc;">
                <input type="password" placeholder="Password" required style="padding: 0.5rem; border-radius: 8px; border: 1px solid #ccc;">
                <input type="password" placeholder="Confirm Password" required style="padding: 0.5rem; border-radius: 8px; border: 1px solid #ccc;">
                <button type="submit">Register</button>
                <p style="font-size: 0.9rem;">Already have an account? <a href="login.php">Login</a></p>
            </form>
        </section>
    </main>

    <?php include('../../omega.php'); ?>
</body>
</html>
