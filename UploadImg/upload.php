<?php
$target_dir = "../images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Tehdään tarkistus, yrittääkö käyttäjä ladata kuvaa vai jotain muuta tiedostoa. 
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "Ladataan kuvaa - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "Valitsemasi tiedosto ei ole kuva.";
    $uploadOk = 0;
  }
}

// Tarkistetaan, onko sama tiedosto jo olemassa
if (file_exists($target_file)) {
  echo "Tiedostoista löytyy jo saman niminen kuva.";
  $uploadOk = 0;
}


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Tiedoston lataaminen ei onnistu.";
// Yritetään ladata tiedosto kansioon
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "<p>Tiedosto ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " ladattiin onnistuneesti.";
  } else {
    echo "Ongelmia kuvan lataamisessa, ole hyvä ja yritä uudelleen.";
  }
}
?>
