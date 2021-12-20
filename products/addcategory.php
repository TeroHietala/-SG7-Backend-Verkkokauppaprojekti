<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

//Ottaa vastaan input input tiedot json muodossa
$json = json_decode(file_get_contents('php://input'));
$name = filter_var($json->name, FILTER_SANITIZE_STRING);
$image = filter_var($json->image, FILTER_SANITIZE_STRING);



try {

    $db = openDb();
    $sql = $db->prepare('INSERT INTO category(name, image) VALUES(:name, :image)');
    $sql->bindValue(':name',$name);
    $sql->bindValue(':image',$image);

    $sql->execute();

    header('HTTP/1.1 200 OK');
    $data = array('id' => $db->lastInsertId(),'name' => $name, 'image' => $image);
    print json_encode($data);
} 
catch (PDOException $pdoex) {
    returnError($pdoex);
}