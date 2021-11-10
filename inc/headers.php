<?php
header('Access-Control-Allow-Origin:' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Accept, Content-Type, Acces-Control-Allow-Header');
header('Content-Type: application/json');
header('Access-Control-Allow-Max-Age: 3600');

if ($_SERVER['REQUEST_METHOD']=== 'OPTIONS') {
    if (isset($SERVER['HTTP_ACCES_CONTROL_REQUEST_METHOD']))
        header("Acces-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCES_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCES_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}
