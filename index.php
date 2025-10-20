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
      <ul class="customer-ul">
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
      <?php
        if (isset($_GET['selected'])) {
            $name = $_GET['selected'];
            echo "<h2>" . htmlspecialchars($name) . "</h2>";

            $pdo = getPDO();
            $stmt = $pdo->prepare("SELECT id FROM users WHERE firstname || ' ' || lastname = ?");
            $stmt->execute([$name]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $pdo = null;

            if ($user) {
                $userId = $user['id'];
                $summary = getUserPortfolioSummary($userId);
                $details = getUserPortfolioDetails($userId);

                echo "<div class='summary-grid customer-summary'>
                        <div class='summary-box'><strong>Companies:</strong> <span>" . htmlspecialchars($summary['company_count']) . "</span></div>
                        <div class='summary-box'><strong>Total Shares:</strong> <span>" . htmlspecialchars($summary['total_shares']) . "</span></div>
                        <div class='summary-box'><strong>Total Value:</strong> <span>$" . number_format($summary['total_value'], 2) . "</span></div>
                      </div>";

                echo "<h3>Portfolio Details</h3>";
                echo "<div class='history-scroll'>
                        <table class='data-table'>
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
                echo "</table></div>";
            } else {
                echo "<p>User not found.</p>";
            }
        } else {
            echo "<p class='no-selection'>Click a customer to view details.</p>";
        }
      ?>
    </section>
  </main>
</body>
</html>
