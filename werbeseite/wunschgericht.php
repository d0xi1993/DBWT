<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Wunschgericht</title>
    <style type="text/css">
        *{
            font-family: Comic Sans MS;
            border: 4px solid bisque;

            background: white;
            border-collapse: collapse;

        }
        fieldset{
            text-align: center;

        }
    </style>
</head>
<body>
<fieldset>
    <legend>Wunschgericht</legend>
    <form method="post" >


        <label for="name">Name des Wunschgerichtes</label>
        <br>
        <input type="text" id="name" name="name" placeholder="Titel Ihres Wunschgerichtes" required>
        <br>
        <?php
        $search = ['\'',';','<','"']; //gegen sql inj und xss
        !isset($_POST['name']);
        ?>

        <br>
        <label for="beschreibung">Beschreibung</label>
        <br>
        <input type="text" id="beschreibung" name="beschreibung" placeholder="optional"  >
        <br>
        <?php
        !isset($_POST['beschreibung']);
        ?>

        <br>
        <label for="vorname" >Vorname</label>
        <br>
        <input type="text" id="vorname" name="vorname" placeholder="anonym" >
        <br>
        <?php

        if(isset($_POST['vorname'])){
            if(!empty($_POST['vorname'])){
                $vorname = $_POST['vorname'];
                $vorname = str_replace($search, " ", $vorname); //gegen sql inj und xss
            }else{

                $vorname = "unbekannt";

            }


        }

        ?>

        <br>
        <label for="nachname">Nachname</label>
        <br>
        <input type="text" id="nachname"  name="nachname"placeholder="anonym" >
        <br>
        <?php
        if(isset($_POST['nachname'])){
            if(!empty($_POST['nachname'])){
                $nachname = $_POST['nachname'];
                $nachname = str_replace($search, " ", $nachname); //gegen sql inj und xss
            }else{
                $nachname = "unbekannt";
            }
        }
        ?>

        <br>
        <label for="mail">E-Mail</label>
        <br>
        <input type="text" id="email" name="email"  placeholder="Bitte geben Sie Ihre E-Mail ein"  required>
        <br>
        <?php
        $mailbool = true;
        if (isset($_POST['email'])) { //leerzeichen rausfiltern
            $h = trim($_POST['email']);

            if ($h == "" || strpos($_POST['email'], 'rcpt.at') || strpos($_POST['email'], 'damnthespam.at') //überprüft auf Falschemails
                || strpos($_POST['email'], 'egwerfmail.de') || strpos($_POST['email'], 'trashmail.')
                || !strpos($_POST['email'], '@')) {
                echo "Dias Email-Adressen Format ist inkorrekt sollte: name@example.com formatiert sein", '<br>',
                "Das Email-Format ist nicht gültig", '<br>';
                $mailbool = false;
            }
            $email = $_POST['email'];
        }
        ?>
        <br>



        <input type="submit" value="Wunsch Abschicken" >
        <br>
        <br>
        <a href="index.php"><input type="button" value="Zurück zur Hauptseite"></a>

    </form>
</fieldset>

</body>
</html>
<?php
if(isset($_POST['name'])){
    $mysqli = new mysqli("localhost",
        "root",
        "",
        "db_emensawerbeseite",
        "3306"
    );

    if (!$mysqli) {
        echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
        exit();
    }

//sql Abfragebefehl als string
    $beschreibung = $_POST['beschreibung'];
    $beschreibung = str_replace('\'', " ", $beschreibung); //gegen sql inj und xss

    $name = $_POST['name'];
    $name =  str_replace($search, " ", $name); //gegen sql inj und xss
    $email = $_POST['email'];

    $anf = "INSERT INTO wunschgericht (datum, beschreibung , name) VALUES ( CURRENT_TIMESTAMP , '$beschreibung', '$name')"; //zuordnen der Datenbank also eingaben der Datenbank zuweisen

    $result = mysqli_query($mysqli, $anf);

    if (!$result) {
        echo "Fehler während der Abfrage:  ", mysqli_error($mysqli);
        exit();
    }
    $anf2 = "INSERT INTO ersteller (vorname, nachname, mail) VALUES ('$vorname', '$nachname', '$email')";

    $result = mysqli_query($mysqli, $anf2);
    if (!$result) {
        echo "Fehler während der Abfrage:  ", mysqli_error($mysqli);
        exit();
    }

/*
    $anf = "SELECT * FROM wunschgericht ORDER BY id DESC LIMIT 5;"; //zuordnen der Datenbank also eingaben der Datenbank zuweisen


    $result_safe = mysqli_query($mysqli, $anf);
    if(isset($result_safe)){

        foreach ($result_safe as $rs)
        {
            echo htmlspecialchars($rs['name']);
        }
    }
*/

}
