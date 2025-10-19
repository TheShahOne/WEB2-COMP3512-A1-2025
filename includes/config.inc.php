<?php
define('DBCONNSTRING', 'sqlite:' . __DIR__ . '/../data/stocks.db');

function getPDO() {
    try {
        $pdo = new PDO(DBCONNSTRING);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
?>
