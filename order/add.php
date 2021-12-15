<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

$input = json_decode(file_get_contents('php://input'));

$first_name = filter_var($input->first_name, FILTER_SANITIZE_STRING);
$last_name = filter_var($input->last_name, FILTER_SANITIZE_STRING);
$product_id = filter_var($input->product_id, FILTER_SANITIZE_NUMBER_INT);
$kpl = filter_var($input->kpl, FILTER_SANITIZE_NUMBER_INT);

$db = null;

try {
    // Luo database yhteys
    $db = openDb();
    //oston database yhteys 
    $db->beginTransaction();
    //Ostajan lisäys
    $sql = "insert into customers(first_name, last_name) VALUES
    ('" .
        filter_var($first_name, FILTER_SANITIZE_STRING) . "','" .
        filter_var($last_name, FILTER_SANITIZE_STRING)
        . "')";

    $cust_nro = executeInsert($db, $sql);

    //insert tilaus
    $sql = "insert into orders(cust_nro) VALUES ($cust_nro)";
    
    $ordernro = executeInsert($db, $sql);

    //Lisätään tilaus rivit loopin kautta ostoskoriin -> array

        $sql = "insert into orderline(ordernro, product_id, kpl) VALUES ($ordernro,
        '" .
        filter_var($product_id, FILTER_SANITIZE_STRING) . "','" .
        filter_var($kpl, FILTER_SANITIZE_STRING)
    .   "')";

        executeInsert($db, $sql);



    $db->commit();
    header('HHTP/1.1 200 OK');
    $data = array('id' => $cust_nro);
    echo json_encode($data);
}
    catch (PDOException $pdoex) {
        $db->rollback();
        returnError($pdoex);
    }
