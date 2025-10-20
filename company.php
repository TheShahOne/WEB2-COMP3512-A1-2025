<?php
require_once 'includes/config.inc.php';
require_once 'includes/data_functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Company Details</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <nav class="navbar">
    <div class="nav-left">
      <img src="css/logo.PNG" alt="Logo" class="logo">
      <span class="site-name">Portfolio Prowl</span>
    </div>
    <div class="nav-right">
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="api.php">APIs</a>
    </div>
  </nav>

  <main class="company-page">
    <?php
      if (isset($_GET['symbol'])) {
          $symbol = $_GET['symbol'];
          $company = getCompanyBySymbolFull($symbol);
          $history = getCompanyHistory($symbol);
          $summary = getCompanyHistorySummary($symbol);

          if ($company) {
              $financials = json_decode($company['financials'], true);

              function fmt($num, $dec = 2) {
                  if ($num === null || $num === '') return '-';
                  return number_format((float)$num, $dec);
              }

              echo "<div class='top-section'>";

              echo "<section class='company-info'>";
              echo "<h2>{$company['name']} <span class='symbol'>({$company['symbol']})</span></h2>";
              echo "<p class='desc'>{$company['description']}</p>";
              echo "<p><strong>Sector:</strong> {$company['sector']}</p>";
              echo "<p><strong>Subindustry:</strong> {$company['subindustry']}</p>";
              echo "<p><strong>Address:</strong> {$company['address']}</p>";
              echo "<p><strong>Exchange:</strong> {$company['exchange']}</p>";
              echo "<p><strong>Website:</strong> <a href='{$company['website']}' target='_blank'>{$company['website']}</a></p>";
              echo "</section>";

              echo "<section class='summary'>";
              echo "<div class='summary-grid'>
                      <div class='summary-box'><strong>Highest Price:</strong> <span>" . fmt($summary['history_high']) . "</span></div>
                      <div class='summary-box'><strong>Lowest Price:</strong> <span>" . fmt($summary['history_low']) . "</span></div>
                      <div class='summary-box'><strong>Total Volume:</strong> <span>" . number_format((float)$summary['total_volume'], 2) . "</span></div>
                      <div class='summary-box'><strong>Average Volume:</strong> <span>" . number_format((float)$summary['avg_volume'], 2) . "</span></div>
                    </div>";
              echo "</section>";

              echo "</div>";

              echo "<div class='bottom-section'>";

              if ($financials && isset($financials['years'])) {
                  echo "<section class='financials'>";
                  echo "<h3>Financials</h3>";
                  echo "<table class='data-table'>
                          <tr><th>Year</th><th>Earnings</th><th>Assets</th><th>Liabilities</th></tr>";
                  for ($i = 0; $i < count($financials['years']); $i++) {
                      echo "<tr>
                              <td>{$financials['years'][$i]}</td>
                              <td>" . number_format((float)$financials['earnings'][$i], 2) . "</td>
                              <td>" . number_format((float)$financials['assets'][$i], 2) . "</td>
                              <td>" . number_format((float)$financials['liabilities'][$i], 2) . "</td>
                            </tr>";
                  }
                  echo "</table>";
                  echo "</section>";
              }

              echo "<section class='history'>";
              echo "<h3>Price History</h3>";
              echo "<div class='history-scroll'>
                      <table class='data-table'>
                        <tr>
                          <th>Date</th><th>Volume</th><th>Open</th><th>Close</th><th>High</th><th>Low</th>
                        </tr>";
              foreach ($history as $row) {
                  echo "<tr>
                          <td>{$row['date']}</td>
                          <td>" . number_format((float)$row['volume'], 2) . "</td>
                          <td>" . fmt($row['open']) . "</td>
                          <td>" . fmt($row['close']) . "</td>
                          <td>" . fmt($row['high']) . "</td>
                          <td>" . fmt($row['low']) . "</td>
                        </tr>";
              }
              echo "</table></div>";
              echo "</section>";

              echo "</div>";
          } else {
              echo "<p class='no-data'>Company not found.</p>";
          }
      } else {
          echo "<p class='no-data'>No company symbol provided.</p>";
      }
    ?>
  </main>
</body>
</html>
