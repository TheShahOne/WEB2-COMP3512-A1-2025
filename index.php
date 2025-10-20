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
        $fullName = urlencode($u["firstname"] . " " . $u["lastname"]);
        echo "<li><a class='customer-btn' href='?selected=$fullName'>"
            . htmlspecialchars($u["firstname"] . " " . $u["lastname"])
            . "</a></li>";
      }
    ?>
  </ul>
</section>

<section class="customer-info">
  <h2>Selected Customer</h2>

  <?php
    if (isset($_GET['selected'])) {
        $name = $_GET['selected'];
        echo "<p><strong>" . htmlspecialchars($name) . "</strong></p>";

        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT id FROM users WHERE firstname || ' ' || lastname = ?");
        $stmt->execute([$name]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $pdo = null;

        if ($user) {
            $userId = $user['id'];
            $summary = getUserPortfolioSummary($userId);
            $details = getUserPortfolioDetails($userId);

            echo "<p>Companies (count of records): " . $summary['company_count'] . "</p>";
            echo "<p># shares (sum of portfolio amount field): " . $summary['total_shares'] . "</p>";
            echo "<p>Total Value: $" . number_format($summary['total_value'], 2) . "</p>";

            echo "<table border='1' cellpadding='6'>
                    <tr>
                      <th>Symbol</th>
                      <th>Name</th>
                      <th>Sector</th>
                      <th>Amount</th>
                      <th>Value</th>
                    </tr>";
           foreach ($details as $row) {
    $symbol = htmlspecialchars($row['symbol']);
    $name = htmlspecialchars($row['name']);
    echo "<tr>
            <td><a class='link-symbol' href='company.php?symbol=$symbol'>$symbol</a></td>
            <td><a class='link-name' href='company.php?symbol=$symbol'>$name</a></td>
            <td>{$row['sector']}</td>
            <td>{$row['amount']}</td>
            <td>$" . number_format($row['value'], 2) . "</td>
          </tr>";
}

            echo "</table>";
        } else {
            echo "<p>User not found.</p>";
        }
    } else {
        echo "<p>Click a customer to view details.</p>";
    }
  ?>
</section>


    
  </main>
</body>
</html>
