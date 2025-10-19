<?php
require_once('config.inc.php');

function getAllUsers() {
    $pdo = getPDO();
    $sql = "SELECT firstname, lastname FROM users";
    $result = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $pdo = null;
    return $result;
}
?>
