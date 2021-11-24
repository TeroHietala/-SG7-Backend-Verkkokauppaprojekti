<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

//Ottaa vastaan input input tiedot json muodossa
$json = json_decode(file_get_contents('php://input'));
$fname = filter_var($json->fname, FILTER_SANITIZE_STRING);
$lname = filter_var($json->lname, FILTER_SANITIZE_STRING);
$mail = filter_var($json->mail, FILTER_SANITIZE_EMAIL);
$passwd = filter_var($json->passwd, FILTER_SANITIZE_STRING);
$addr = filter_var($json->addr, FILTER_SANITIZE_STRING);
$zip = filter_var($json->zip, FILTER_SANITIZE_NUMBER_INT);
$city = filter_var($json->city, FILTER_SANITIZE_STRING);
$phone = filter_var($json->phone, FILTER_SANITIZE_NUMBER_INT);
//salasanan salaus
$passwd_hash = password_hash($passwd, PASSWORD_DEFAULT);

try {

    $db = openDb();
    $sql = $db->prepare('INSERT INTO customers(first_name, last_name, mail_username, password, address, zip, city, phone) VALUES(:fname, :lname, :mail, :passwd, :addr, :zip, :city, :phone)');
    $sql->bindValue(':fname',$fname);
    $sql->bindValue(':lname',$lname);
    $sql->bindValue(':mail',$mail);
    $sql->bindValue(':passwd',$passwd_hash);
    $sql->bindValue(':addr',$addr);
    $sql->bindValue(':zip',$zip);
    $sql->bindValue(':city',$city);
    $sql->bindValue(':phone',$phone);
    $sql->execute();

    header('HTTP/1.1 200 OK');
    $data = array('id' => $db->lastInsertId(),'first_name' => $fname, 'last_name' => $lname,'mail_username' => $mail, 'password' => $passwd_hash, 'address' => $addr, 'zip' => $zip,'city' => $city, 'phone' => $phone);
    print json_encode($data);
} 
catch (PDOException $pdoex) {
    returnError($pdoex);
}