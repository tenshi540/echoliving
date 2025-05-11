<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - EchoLiving</title>
  <link rel="stylesheet" href="../css/prisma.css">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;600&display=swap" rel="stylesheet">
  <script src="/echoliving/frontend/res/js/users.js" defer></script>
</head>
<body>
  <?php include('../../compass.php'); ?>

  <main>
    <section class="hero">
      <h2>Create Your Account</h2>
      <form 
        class="login-form" 
        id="register-form"
        action="#" 
        method="post" 
        style="display: flex; flex-direction: column; gap: 1rem; max-width: 300px; margin: auto;"
      >
        <select 
          name="salutation" 
          required 
          style="padding: 0.5rem; border-radius: 8px; border: 1px solid #ccc;"
        >
          <option value="">– Salutation –</option>
          <option value="Mr">Mr</option>
          <option value="Ms">Ms</option>
          <option value="Mx">Mx</option>
        </select>

        <input 
          type="text" 
          name="first_name" 
          placeholder="First Name" 
          required 
          style="padding: 0.5rem; border-radius: 8px; border: 1px solid #ccc;"
        >

        <input 
          type="text" 
          name="last_name" 
          placeholder="Last Name" 
          required 
          style="padding: 0.5rem; border-radius: 8px; border: 1px solid #ccc;"
        >

        <input 
          type="text" 
          name="address" 
          placeholder="Address" 
          required 
          style="padding: 0.5rem; border-radius: 8px; border: 1px solid #ccc;"
        >

        <input 
          type="text" 
          name="postal_code" 
          placeholder="Postal Code" 
          required 
          style="padding: 0.5rem; border-radius: 8px; border: 1px solid #ccc;"
        >

        <input 
          type="text" 
          name="city" 
          placeholder="City" 
          required 
          style="padding: 0.5rem; border-radius: 8px; border: 1px solid #ccc;"
        >

        <input 
          type="email" 
          name="email" 
          placeholder="Email Address" 
          required 
          style="padding: 0.5rem; border-radius: 8px; border: 1px solid #ccc;"
        >

        <input 
          type="text" 
          name="username" 
          placeholder="Username" 
          required 
          style="padding: 0.5rem; border-radius: 8px; border: 1px solid #ccc;"
        >

        <input 
          type="password" 
          name="password" 
          placeholder="Password" 
          required 
          style="padding: 0.5rem; border-radius: 8px; border: 1px solid #ccc;"
        >

        <input 
          type="password" 
          name="password_repeat" 
          placeholder="Confirm Password" 
          required 
          style="padding: 0.5rem; border-radius: 8px; border: 1px solid #ccc;"
        >

        <input 
          type="text" 
          name="payment_info" 
          placeholder="Payment Info" 
          required 
          style="padding: 0.5rem; border-radius: 8px; border: 1px solid #ccc;"
        >

        <button type="submit">Register</button>

        <p style="font-size: 0.9rem; text-align: center;">
          Already have an account? <a href="login.php">Login</a>
        </p>
      </form>
    </section>
  </main>

  <?php include('../../omega.php'); ?>
</body>
</html>
