<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

//Ottaa vastaan input input tiedot json muodossa
$json = json_decode(file_get_contents('php://input'));
$name = filter_var($json->name, FILTER_SANITIZE_STRING);
$price = filter_var($json->price, FILTER_SANITIZE_STRING);
$image = filter_var($json->image, FILTER_SANITIZE_STRING);
$category_id = filter_var($json->category_id, FILTER_SANITIZE_STRING);
$description = filter_var($json->description, FILTER_SANITIZE_STRING);



try {

    $db = openDb();
    $sql = $db->prepare('INSERT INTO product(name, price, image, category_id, description) VALUES(:name, :price,  :image, :category_id, :description)');
    $sql->bindValue(':name',$name);
    $sql->bindValue(':price',$price);
    $sql->bindValue(':image',$image);
    $sql->bindValue(':category_id',$category_id);
    $sql->bindValue(':description',$description);

    $sql->execute();

    header('HTTP/1.1 200 OK');
    $data = array('id' => $db->lastInsertId(),'name' => $name, 'price' => $price,'image' => $image,'category_id' => $category_id,'description' => $description);
    print json_encode($data);
} 
catch (PDOException $pdoex) {
    returnError($pdoex);
}