<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

$input = json_decode(file_get_contents('php://input'));

$first_name = filter_var($input->first_name, FILTER_SANITIZE_STRING);
$last_name = filter_var($input->last_name, FILTER_SANITIZE_STRING);
$product_id = filter_var($input->product_id, FILTER_SANITIZE_NUMBER_INT);
$kpl = filter_var($input->kpl, FILTER_SANITIZE_NUMBER_INT);

try {
    $db = openDb();

    $query = $db->prepare('insert into orders(first_name, last_name, product_id, kpl) values (:first_name, :last_name, :product_id, :kpl)');
    $query->bindValue(':first_name', $first_name, PDO::PARAM_STR);
    $query->bindValue(':last_name', $last_name, PDO::PARAM_STR);
    $query->bindValue(':product_id', $product_id, PDO::PARAM_INT);
    $query->bindValue(':kpl', $kpl, PDO::PARAM_INT);
    $query->execute();

    header('HTTP/1.1 200 OK');
    $data = array('id' => $db->lastInsertId(), 'first_name' => $first_name, 'last_name' =>$last_name, 'product_id' =>$product_id, 'kpl' => $kpl);
    print json_encode($data);
} catch (PDOException $pdoex) {
    print json_encode($error);
}