<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

$url = parse_url(filter_input(INPUT_SERVER,'PATH_INFO'),PHP_URL_PATH);
$parameters = explode('/',$url);
$category_id = $parameters[1];

try {
    $db = openDb();
    selectAsJson($db, "select * from product where category_id = $category_id");
} 
catch (PDOException $pdoex) {
    returnError($pdoex);
}