<?php
require_once '../includes/config.inc.php';
require_once '../includes/data_functions.php'; 
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");

function isCorrectQueryStringInfo($param) {
    if (isset($_GET[$param]) && !empty($_GET[$param])) {
        return true;
    } else {
        return false;
    }
}

try {
    if (isset($_GET['ref']) && !empty($_GET['ref'])) {
        $data = getCompanyBySymbol($_GET['ref']);
    } else {
        $data = getAllCompanies();
    }
    echo json_encode($data, JSON_NUMERIC_CHECK);
} catch (Exception $e) {
    die($e->getMessage());
}
?>
