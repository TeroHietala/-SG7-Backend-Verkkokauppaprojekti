<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

//Ottaa vastaan input input tiedot json muodossa
$json = json_decode(file_get_contents('php://input'));
$first_name = filter_var($json->first_name, FILTER_SANITIZE_STRING);
$last_name = filter_var($json->last_name, FILTER_SANITIZE_STRING);
$username = filter_var($json->username, FILTER_SANITIZE_EMAIL);
$password = filter_var($json->password, FILTER_SANITIZE_STRING);
//salasanan salaus
$passwd_hash = password_hash($password, PASSWORD_DEFAULT);

try {

    $db = openDb();
    $sql = $db->prepare('INSERT INTO admin(first_name, last_name, username, password) VALUES(:f_name, :l_name, :u_name, :passwd)');
    $sql->bindValue(':f_name',$first_name);
    $sql->bindValue(':l_name',$last_name);
    $sql->bindValue(':u_name',$username);
    $sql->bindValue(':passwd',$passwd_hash);
    $sql->execute();

    header('HTTP/1.1 200 OK');
    $data = array('id' => $db->lastInsertId(),'first_name' => $first_name, 'last_name' => $last_name,'username' => $username, 'password' => $passwd_hash);
    print json_encode($data);
} 
catch (PDOException $pdoex) {
    returnError($pdoex);
}