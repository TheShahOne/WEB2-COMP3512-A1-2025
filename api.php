<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>APIs</title>
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

  <h1>APIs Tester</h1>
  <ul>
    <li><a href="api/companies.php">Returns all companies (/api/companies.php)</a></li>
    <li><a href="api/companies.php?ref=ads">Returns just the specified company (/api/companies.php?ref=ads)</a></li>
    <li><a href="api/portfolio.php?ref=8">Returns the portfolio info for the specified user (/api/portfolio.php?ref=8)</a></li>
    <li><a href="api/history.php?ref=ADS">Returns the history information for the specified company, sorted by ascending date (/api/history?ref=ads)</a></li>
  </ul>
</body>
</html>
