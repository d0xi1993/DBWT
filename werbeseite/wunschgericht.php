
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Wunschgericht</title>
    <style type="text/css">
        *{
            font-family: Comic Sans MS;
        }
    </style>
</head>
<body>
<fieldset>
    <legend>Wunschgericht</legend>
    <form method="post" >


        <label for="name">Name des Wunschgerichtes</label>
        <br>
        <input type="text" id="name" name="name" placeholder="Bitte geben Sie den Titel Ihres Wunschgerichtes an"  size="28" required>
        <br>
        <?php
        $_POST['name'];
        ?>

        <br>
        <label for="beschreibung">Beschreibung</label>
        <br>
        <input type="text" id="beschreibung" name="beschreibung" placeholder="optional" size="28" >
        <br>
        <?php
         echo $_POST['beschreibung'];
        ?>

        <br>
        <label for="vorname" >Vorname</label>
        <br>
        <input type="text" id="vorname" name="vorname" placeholder="Anonym" size="28" >
        <br>
        <?php
        if($_POST['vorname'] == ""){

            $_POST['vorname'] = "anonym";
        }

        ?>

        <br>
        <label for="nachname">Nachname</label>
        <br>
        <input type="text" id="nachname"  name="nachname"placeholder="Anonym" size="28" >
        <br>
        <?php
        if($_POST['nachname'] == ""){

            $_POST['nachname'] = "anonym";
        }
        ?>

        <br>
        <label for="mail">E-Mail</label>
        <br>
        <input type="text" id="email" name="email"  placeholder="Bitte geben Sie Ihre E-Mail ein" size="28" required>
        <br>
        <?php
        $mailbool = true;
        if (isset($_POST['email'])) { //leerzeichen rausfiltern
            $h = trim($_POST['email']);
            // überprüft ob spam mails benutzt wurden
            if ($h == "" || strpos($_POST['email'], 'rcpt.at') || strpos($_POST['email'], 'damnthespam.at')
                || strpos($_POST['email'], 'egwerfmail.de') || strpos($_POST['email'], 'trashmail.')
                || !strpos($_POST['email'], '@')) {
                echo "Die Email-Adresse muss korrekt nach dem Format name@example.com formatiert sein", '<br>',
                "Das Email-Format ist nicht gültig", '<br>';
                $mailbool = false;
            }
            $email = $_POST['email'];
        }
        ?>
        <br>



        <input type="submit" value="Wunsch Abschicken">
        <br>
        <br>

    </form>
</fieldset>

</body>
</html>
<?php
if(isset($_POST['name'])){
//if(isset($_POST['submit'])) {
    $link = mysqli_connect("localhost", // Host der Datenbank
        "root",                        // Benutzername zur Anmeldung
        "root",                    // Passwort
        "db_emensawerbeseite",        // Auswahl der Datenbanken (bzw. des Schemas)
        "3306"                        // optional port der Datenbank
    );

    if (!$link) {
        echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
        exit();
    }

//sql Abfragebefehl als string
    $beschreibung = $_POST['beschreibung'];
    $name = $_POST['name'];
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $email = $_POST['email'];

    $sql = "INSERT INTO wunschgericht (datum, beschreibung, name) VALUES ( NOW(), '$beschreibung', '$name')";


    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }
    $sql2 = "INSERT INTO ersteller (eid, vorname, nachname, mail) VALUES (LAST_INSERT_ID(), '$vorname', '$nachname', '$email')";

    $result = mysqli_query($link, $sql2);
    if (!$result) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }

    // Aufgabe 1.6
    // SELECT * FROM wunschgericht ORDER BY wid DESC LIMIT 5;
}


-- Aufgabe 1 M4 Datenbank Wunschgericht

create table if not EXISTS 'wunschgericht' (
'id' BIGINT auto_increment,            -- automtisch berechnete Nummer
    'datum' DATE not null,                 -- Erstellungsdatum
    'beschreibung' VARCHAR(800) NOT NULL,  -- Beschreibung
    'name' VARCHAR(300) not null           -- Namen des Wunschgerichts

);

create table if not exists 'ersteller' (
'eid' bigint auto_increment,
    'vorname' varchar(300)not null,
    'nachname' varchar(300) not null,
    'mail' varchar(300) not null
);
