<?php
session_start();
require('../inc/headers.php');
require('../inc/functions.php');

$db = openDb();
$json = json_decode(file_get_contents('php://input'), true);
$username = filter_var($json['username'], FILTER_SANITIZE_EMAIL);
$password = filter_var($json['password'], FILTER_SANITIZE_STRING);
try{
    $sql = "SELECT password FROM admin
    WHERE username=?";
    $prepare = $db->prepare($sql);
    $prepare->execute(array($username));
    //Haetaan tulokser fetch functiolla.
    $rows = $prepare->fetchAll();
    //Etsitään salasanarivi ja jos palautetaan true arvo jos kaikki ok.
    foreach($rows as $row){
        $pw = $row["password"];
        //purkaa salasanan HASHin
        if(password_verify($password, $pw) ){ 
            selectAsJson($db, "SELECT first_name,last_name FROM admin WHERE username = '$username'");
            
        }
    }
    //Jos tiedot eivät tästää. palautetaan false
    
    return false;

}catch(PDOException $e){
    echo '<br>'.$e->getMessage();
}

//$fname = $_SESSION["first_name"];
// //Tarkistetaan tuleeko palvelimelle basic login tiedot (authorization: Basic asfkjsafdjsajflkasj)
// if(isset($_SERVER['PHP_AUTH_USER']) ){
//     //Tarkistetaan käyttäjä tietokannasta
//     if(openDb($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW'],$_SESSION['first_name'])){
//         $_SESSION['user'] = $_SERVER['PHP_AUTH_USER'];
//         //$_SESSION["token"] = bin2hex(openssl_random_pseudo_bytes(16));
//         //print json_encode(array("Tervetuloa", $_SESSION['first_name']));
//         selectAsJson($db, "SELECT first_name FROM customers WHERE mail_username = '$mail_username'");
//         //header('Content-Type: application/json');
//         exit;
//     }
// }

//Väärät tunnukset antaa ilmoituksen
echo '{"info":"Väärä käyttäjätunnus tai salasana"}';
header('Content-Type: application/json');
header('HTTP/1.1 401');
exit;

?>