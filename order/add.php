<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

$input = json_decode(file_get_contents('php://input'));

$first_name = filter_var($input->first_name, FILTER_SANITIZE_STRING);
$last_name = filter_var($input->last_name, FILTER_SANITIZE_STRING);
$address = filter_var($input->address, FILTER_SANITIZE_STRING);
$cart = $input->cart;

$db = null;

try {
    // Luo database yhteys
    $db = openDb();
    //oston database yhteys 
    $db->beginTransaction();
    //Ostajan lisäys
    $sql = "insert into customers(first_name, last_name, address) VALUES
    ('" .
        filter_var($first_name, FILTER_SANITIZE_STRING) . "','" .
        filter_var($last_name, FILTER_SANITIZE_STRING) . "','" .
        filter_var($address, FILTER_SANITIZE_STRING)
        . "')";

    $customers_cust_nro = executeInsert($db, $sql);

    //insert tilaus
    $sql = "insert into `order`(customers_cust_nro) VALUES ($customers_cust_nro)";
    $order_id = executeInsert($db, $sql);

    //Lisätään tilaus rivit loopin kautta ostoskoriin -> array
    foreach ($cart as $product) {
        $sql = "insert into order_row(order_id, product_id) VALUES ("
        .
            $order_id . "," . 
            $product->id 
        . ")";
        executeInsert($db, $sql);
    }

    $db->commit();
    header('HHTP/1.1 200 OK');
    $data = array('id' => $customers_cust_nro);
    echo json_encode($data);
}
    catch (PDOException $pdoex) {
        $db->rollback();
        returnError($pdoex);
    }
