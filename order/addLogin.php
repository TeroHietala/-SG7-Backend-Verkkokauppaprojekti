<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

$input = json_decode(file_get_contents('php://input'));
$user = $input->user;
$cart = $input->cart;

// $db = null;

try {
    // Luo database yhteys
    $db = openDb();
    //oston database yhteys 
    $db->beginTransaction();
    //Ostajan lisäys

    //insert tilaus
 //$cust_nro = executeInsert($db, $sql);
    foreach ($user as $customers) {
        $sql = "insert into orders(customers_cust_nro) VALUES ("
        .
            $customers->cust_nro
           
        . ")";
       
    }
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
    $data = array('id' => $order_id);
    echo json_encode($data);
}
    catch (PDOException $pdoex) {
        $db->rollback();
        returnError($pdoex);
    }
