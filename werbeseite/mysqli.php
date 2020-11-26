<?php

$link = mysqli_connect(
    "127.0.0.1",
    "root",
    "root",
    "db_emensawerbeseite",
    "3306"
);

if(!$link){
    echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
    exit();
}

$id = gericht.name; //wegen Datenbankinjektion
$sql = "SELECT name FROM gericht WHERE id = $id";

$result = mysqli_query($link, $sql);

if(!$result)
    echo "Fehler während der Abfrage: ", mysqli_error($link);

while ($row = mysqli_fetch_row($result)){
  echo '<li>', $row['id'], ':', $row['name'], '</li>';
}
mysqli_error($link);
mysqli_errno($link);

?>