<?php
require_once '../inc/functions.php';
require_once '../inc/headers.php';

//Ottaa vastaan input input tiedot json muodossa
$json = json_decode(file_get_contents('php://input'));
$fname = filter_var($json->fname, FILTER_SANITIZE_STRING);
$rmail = filter_var($json->responsemail, FILTER_SANITIZE_EMAIL);
$feedback = filter_var($json->feedback, FILTER_SANITIZE_STRING);

try {

    $db = openDb();
    $sql = $db->prepare('INSERT INTO Contacts(fname, responsemail, feedback) VALUES(:fname, :responsemail, :feedback)');
    $sql->bindValue(':fname',$fname);
    $sql->bindValue(':responsemail',$rmail);
    $sql->bindValue(':feedback',$feedback);

    $sql->execute();

    header('HTTP/1.1 200 OK');
    $data = array('id' => $db->lastInsertId(),'fname' => $fname, 'responsemail' => $rmail,'feedback' => $feedback);
    print json_encode($data);
} 
catch (PDOException $pdoex) {
    returnError($pdoex);
}