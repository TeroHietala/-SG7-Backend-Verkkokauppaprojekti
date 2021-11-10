<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

$URL = parse_url(filter_input(INPUT_SERVER,'PATH_INFO'),PHP_URL_PATH);
$parameters = explode('/', $URL);
$category_id = $parameters[1];

try {
    $db = openDb();
    selectAsJson($db, "select * from tuotteet where category_id = $category_id");
} 
catch (PDOException $pdoex) {
    returnError($pdoex);
}