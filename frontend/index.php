<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>EchoLiving</title>
  <link rel="stylesheet" href="./res/css/prisma.css">
</head>
<body>
  <?php include 'compass.php'; ?>

  <!-- Stacked hero panels -->
  <section class="stacked-hero">
    <div class="panel" style="background-image:url('res/img/landing1.jpg')">
      <div class="overlay"></div>
      <div class="text">
        <h1>Design Meets Comfort</h1>
        <p>Where form follows feeling.</p>
      </div>
    </div>
    <div class="panel" style="background-image:url('res/img/landing2.jpeg')">
      <div class="overlay"></div>
      <div class="text">
        <h1>Minimal. Modern. You.</h1>
        <p>The art of less is more.</p>
      </div>
    </div>
    <div class="panel" style="background-image:url('res/img/landing3.jpg')">
      <div class="overlay"></div>
      <div class="text">
        <h1>Elevate Your Space</h1>
        <p>Crafted for lasting elegance.</p>
      </div>
    </div>
  </section>

  <?php include 'omega.php'; ?>
</body>
</html>
