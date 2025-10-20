<?php
require_once '../includes/config.inc.php';
require_once '../includes/data_functions.php';
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");

function isCorrectQueryStringInfo($param) {
    return (isset($_GET[$param]) && !empty($_GET[$param]));
}

try {
    if (isCorrectQueryStringInfo("ref")) {
        $data = getPortfolioByUserId($_GET["ref"]);
    } else {
        $data = ["error" => "Missing ref parameter"];
    }

    echo json_encode($data, JSON_NUMERIC_CHECK);
} catch (Exception $e) {
    die($e->getMessage());
}
?>
