<?php
function openDb(): object {
    $ini= parse_ini_file("../config.ini", true);

    $host = $ini['host'];
    $database = $ini['database'];
    $user = $ini['user'];
    $password = $ini['password'];
    $db = new PDO("mysql:host=$host;dbname=$database;charset=utf8",$user,$password);
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    return $db;
}

// Functio joka tarkastaa onko kirjautuja validi
function checkUser($db, $mail_username, $password, $first_name){

    $db = openDb();
    $json = json_decode(file_get_contents('php://input'), true);
    //Sanitointi
    $mail_username = filter_var($json['mail_username'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($json['password'], FILTER_SANITIZE_STRING);
    $first_name = filter_var($first_name, FILTER_SANITIZE_STRING);
    try{
        $sql = "SELECT password FROM customers 
        WHERE mail_username=?";
        $prepare = $db->prepare($sql);
        $prepare->execute(array($mail_username));
        //Haetaan tulokser fetch functiolla.
        $rows = $prepare->fetchAll();
        //$data = array('first_name' => $first_name);
        //Etsitään salasanarivi ja jos palautetaan true arvo jos kaikki ok.
        foreach($rows as $row){
            $pw = $row["password"];
            //purkaa salasanan HASHin
            if(password_verify($password, $pw) ){ 
                //print json_encode($data);
                return true;
            }
        }
        //Jos tiedot eivät tästää. palautetaan false
        
        return false;

    }catch(PDOException $e){
        echo '<br>'.$e->getMessage();
    }
}

function selectAsJson(object $db,string $sql): void {
    $query = $db->query($sql);
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    header('HTTP/1.1 200 OK');
    echo json_encode($result);
}

function executeInsert(object $db,string $sql): int {
    $query = $db->query($sql);
    return $db->lastInsertId();
}

function returnError(PDOException $pdoex): void {
    header('HTTP/1.1 500 Internal Server Error');
    $error = array('error' => $pdoex->getMessage());
    echo json_encode($error);
    exit;
}