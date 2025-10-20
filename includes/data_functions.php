<?php
require_once('config.inc.php');

function getAllUsers() {
    $pdo = getPDO();
    $sql = "SELECT firstname, lastname FROM users";
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
?>
