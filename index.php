<?php require_once('includes/data_functions.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Home</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <nav class="navbar">
    <div class="nav-left">
      <img src="css/logo.png" alt="Logo" class="logo">
      <span class="site-name">Portfolio Prowl</span>
    </div>
    <div class="nav-right">
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="api.php">APIs</a>
    </div>
  </nav>

  <main class="main-content">
    <section class="customer-list">
      <h2>Customers</h2>
      <ul>
        <?php
            $users = getAllUsers();
            foreach ($users as $u) {
            echo "<li>".$u["firstname"]." ".$u["lastname"];
            }
        ?>
      </ul>
    </section>

    <section class="customer-info">
      <h2>Selected Customer</h2>
      <p>Click a customer to view details.</p>
    </section>
    
  </main>
</body>
</html>
