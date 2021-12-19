<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

$input = json_decode(file_get_contents('php://input'));

$first_name = filter_var($input->first_name, FILTER_SANITIZE_STRING);
$last_name = filter_var($input->last_name, FILTER_SANITIZE_STRING);
$address = filter_var($input->address, FILTER_SANITIZE_STRING);
$mail = filter_var($input->mail, FILTER_SANITIZE_STRING);
$zip = filter_var($input->zip, FILTER_SANITIZE_STRING);
$city = filter_var($input->city, FILTER_SANITIZE_STRING);
$phone = filter_var($input->phone, FILTER_SANITIZE_STRING);
$cart = $input->cart;

$db = null;

try {
    // Luo database yhteys
    $db = openDb();
    //oston database yhteys 
    $db->beginTransaction();
    //Ostajan lisäys
    $sql = "insert into customers(first_name, last_name,mail_username, address, zip, city, phone) VALUES
    ('" .
        filter_var($first_name, FILTER_SANITIZE_STRING) . "','" .
        filter_var($last_name, FILTER_SANITIZE_STRING) . "','" .
        filter_var($mail, FILTER_SANITIZE_STRING) . "','" .
        filter_var($address, FILTER_SANITIZE_STRING) . "','" .
        filter_var($zip, FILTER_SANITIZE_STRING) . "','" .
        filter_var($city, FILTER_SANITIZE_STRING) . "','" .
        filter_var($phone, FILTER_SANITIZE_STRING)
        . "')";

    $customers_cust_nro = executeInsert($db, $sql);

    //insert tilaus
    $sql = "insert into orders(customers_cust_nro) VALUES ($customers_cust_nro)";
    $order_id = executeInsert($db, $sql);

    //Lisätään tilaus rivit loopin kautta ostoskoriin -> array
    foreach ($cart as $product) {
        $sql = "insert into order_row(order_id, product_id, amount) VALUES ("
        .
            $order_id . "," . 
            $product->id . "," . 
            $product->amount
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
