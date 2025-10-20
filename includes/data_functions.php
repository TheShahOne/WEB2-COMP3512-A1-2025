<?php
require_once('config.inc.php');

function getAllUsers() {
    $pdo = getPDO();
    $sql = "SELECT firstname, lastname FROM users ORDER BY lastname ASC";
    $result = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $pdo = null;
    return $result;
}


function getAllCompanies() {
    $pdo = getPDO();
    $sql = "SELECT * FROM companies";
    $result = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $pdo = null;
    return $result;
}

function getCompanyBySymbol($symbol) {
    $pdo = getPDO();
    $sql = "SELECT * FROM companies WHERE UPPER(symbol)=UPPER(?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$symbol]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $pdo = null;
    return $result;
}

function getPortfolioByUserId($userId) {
    $pdo = getPDO();
    $sql = "SELECT * FROM portfolio WHERE userId = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $pdo = null;
    return $result;
}

function getHistoryBySymbol($symbol) {
    $pdo = getPDO();
    $sql = "SELECT * FROM history WHERE UPPER(symbol)=UPPER(?) ORDER BY date ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$symbol]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $pdo = null;
    return $result;
}

function getUserPortfolioDetails($userId) {
    $pdo = getPDO();
    $sql = "
        SELECT 
            p.symbol,
            c.name,
            c.sector,
            p.amount,
            h.close AS latest_close,
            (p.amount * h.close) AS value
        FROM portfolio p
        JOIN companies c ON p.symbol = c.symbol
        JOIN (
            SELECT symbol, MAX(date) AS max_date
            FROM history
            GROUP BY symbol
        ) latest ON p.symbol = latest.symbol
        JOIN history h 
            ON h.symbol = latest.symbol 
            AND h.date = latest.max_date
        WHERE p.userId = ?
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $pdo = null;
    return $result;
}

function getUserPortfolioSummary($userId) {
    $pdo = getPDO();
    $sql = "
        SELECT 
            COUNT(DISTINCT p.symbol) AS company_count,
            SUM(p.amount) AS total_shares,
            SUM(p.amount * h.close) AS total_value
        FROM portfolio p
        JOIN (
            SELECT symbol, MAX(date) AS max_date
            FROM history
            GROUP BY symbol
        ) latest ON p.symbol = latest.symbol
        JOIN history h 
            ON h.symbol = latest.symbol 
            AND h.date = latest.max_date
        WHERE p.userId = ?
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $pdo = null;
    return $result;
}

function getCompanyBySymbolFull($symbol) {
    $pdo = getPDO();
    $sql = "SELECT symbol, name, sector, subindustry, address, exchange, website, description, financials
            FROM companies
            WHERE UPPER(symbol) = UPPER(?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$symbol]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $pdo = null;
    return $result;
}

function getCompanyHistory($symbol) {
    $pdo = getPDO();
    $sql = "SELECT date, volume, open, close, high, low
            FROM history
            WHERE UPPER(symbol) = UPPER(?)
            ORDER BY date DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$symbol]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $pdo = null;
    return $result;
}

function getCompanyHistorySummary($symbol) {
    $pdo = getPDO();
    $sql = "SELECT 
                MAX(high) AS history_high,
                MIN(low) AS history_low,
                SUM(volume) AS total_volume,
                AVG(volume) AS avg_volume
            FROM history
            WHERE UPPER(symbol) = UPPER(?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$symbol]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $pdo = null;
    return $result;
}

?>
