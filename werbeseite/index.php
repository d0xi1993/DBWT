<!DOCTYPE html>
<!--
- Praktikum DBWT Autoren:
- Nicolas Woitzyk 3187694
- Philip Schmidt 3236291
-->
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link href="test.css" rel="stylesheet">
    <title>Title</title>

</head>
<body>

<nav>


    <ul class="navbar">
        <li><a class="logo"><img src="logo-FH.png" alt="Das Bild ist leider momentan nicht Verfügbar" height="80"
                                 width="40"></a></li>
        <li><a href="#Ankündigung">Ankündigung</a></li>
        <li><a href="#Speisen">Speisen</a></li>
        <li><a href="wunschgericht.php" >Wunschgericht vorschlagen</a></li>
        <li><a href="#Zahlen">Zahlen</a></li>
        <li><a href="#Kontakt">Kontakt</a></li>
        <li><a href="#Wichtig">Wichtig für uns</a></li>
    </ul>
</nav>
<hr>
<div class="content-body">

    <!--------------------Ankündigungen---------------------------------------------------------->

    <br>
    <a id="Ankündigung"></a>
    <div class="ankuendigung">
        <h2>Ankündigungen</h2>
        <br>
        <p>Das Ungezieferproblem wurde gelöst</p>
    </div>
    <br><br>

    <!---------- Speisen ------------------------------------------------------------------------>

    <a id="Speisen"></a>
    <div class="speisen">
        <h2>Köstlichkeiten, die Sie erwarten</h2>
        <table id="menüliste">
            <thead>

            <tr>
                <th>Gericht</th>
                <th>Preis intern(Euro)</th>
                <th>Preis extern(Euro)</th>
                <th>Allergene</th>
            </tr>
            </thead>
            <tbody>


            <?php





            /**$count ist die Anzahl der vorhandenen Speisen unten im Bereich: Zahlen*/
            $count = 0;

            /** Abrufen der Datenbank */
            require_once ("connection.php");







            $sql = "select id,name,preis_intern,preis_extern from gericht order by name;";


            $table = $con->query($sql) or die($con->connect_error);
            /** $con wird in connection.php deklariert*/
            $all_Liste = [];

            for ($j = 0; $j < 5; $j++) {
                $row = $table->fetch_assoc();
                $count++;


                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['preis_intern'] . "</td>";
                echo "<td>" . $row['preis_extern'] . "</td>";

                $sql_all = "select code from gericht_hat_allergen where gericht_id =" . $row['id'] . ";";
                $allergen = $con->query($sql_all) or die($con->connect_error);

                echo "<td>";
                while ($all = $allergen->fetch_assoc()) {
                    foreach ($all as $a) {
                        echo htmlspecialchars($a) . "; "; //gegen sql inj und xss
                        if(!in_array($a,$all_Liste)){
                            $all_Liste[] = $a;
                        }
                    }
                }
                echo "</td>" . "</tr>";

            }


            echo "</tbody>
        </table>
    </div>
    <br><br>";

            foreach ($all_Liste as $al){
                $sql_all_liste="Select code,name From allergen WHERE code ='". $al."';";
                $ausgabe_liste = $con->query($sql_all_liste) or die($con->connect_error);
                foreach ($ausgabe_liste as $aus){
                    echo $aus['code']."= " .$aus['name']."; ";
                }

            }

            /**
             * Auslesen der Anzahl der bisherigen Besucher
             */

            $line = unserialize(file_get_contents('zaehler_besucher.txt'));

            if (empty($line)) {

                $num = 1;

            } else {
                $num = (int)$line; //$line;
                $num += 1;
            }
            /**
             * Speichern der neuen Anzahl der Besucher in Datei
             */

            $file = fopen('zaehler_besucher.txt', 'w');
            if (!$file) {//---------------------- Prüft ob file wirklich geöffnet ist
                die('Öffnen fehlgeschlagen');
            } else {

                fwrite($file, serialize($num));
                fclose($file);
            }
            /**
             *  Auslesen der Anzahl an Anmeldungen für den Newsletter
             */

            $file = fopen('newsname.txt', 'r');
            if (!$file) {
                die('Öffnen fehlgeschlagen');
            } else {
                $anzahlAnmeldungen = 0;

                while (fgets($file, 1024) !== false) {
                    $anzahlAnmeldungen++;
                }

                fclose($file);
            }


            ?>

            <!-- zahlen der E-Mensa---------------------------------------------------------------------------------------------------->


            <a id="Zahlen"></a>
            <div class="zahlen">
                <h2>E-Mensa in Zahlen</h2>

                <ul>
                    <li><?php echo $num ?> Besucher</li>
                    <li><?php echo $anzahlAnmeldungen; ?> Anmeldungen zum Newsletter</li>
                    <li><?php echo $count ?> Speisen</li> <!--- $count wird oben bei der ausgabe der Speisen definiert--->
                </ul>
            </div>
            <br><br>

            <!--------------Anmeldung zum Newsletter------------------------------------------------------------>

            <a id="Kontakt"></a>
            <h2>Interesse geweckt? wir informieren Sie !</h2>

            <form class="newsl" method="post">

                <fieldset>

                    <div class="n">
                        <label for="name">Ihr Name:</label> <br>
                        <input placeholder="Name" id="name" name="name" size="15">
                    </div>

                    <div class="n">
                        <label for="email">E-Mail:</label><br>
                        <input id="email" name="email" size="15">
                    </div>

                    <div class="n">
                        <select class="select" name="option" required>
                            <option value="">Newsletter bitte in:</option>
                            <option value="englisch">englisch</option>
                            <option value="deutsch">deutsch</option>
                        </select>
                    </div>
                    <br>

                    <div class="n">
                        <label class="switch">
                            <input type="checkbox" required>
                            <span class="slider round"></span>
                        </label>
                        Datenschutzhinweise gelesen
                    </div>

                    <button type="submit" id="getnews" class="button">Zum Newsletter anmelden</button>

                    <br>
                </fieldset>

            </form>
            <br>
            <?php

            /**
             * Prüfen undspeichern der Anmeldung
             *
             * @param $fehler hier werden die Fehlermeldungen gespeichert
             * @param $success wird bei erfolgreichem Speichern true
             */

            $fehler = [];
            $success = false;

            if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['option'])) {

                $name = $_POST['name'];
                $email = $_POST['email'];
                $sprache = $_POST['option'];

                if (trim($name) == "") {
                    /** ---Prüfen ob Namensfeld Leer ist--- */
                    $fehler[] = "Ungültiger name";
                }


                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    $domain = substr(strrchr($email, "@"), 1);
                    /**---$domain => doimain teil der Eingabe---*/

                    $disposable_list = ['rcpt.at', ', damnthespam.at', 'wegwerfmail.de',
                        'trashmail.de', 'trashmail.com'];
                    /**---Liste nicht zugelassener Domains---*/

                    if (in_array($domain, $disposable_list)) {
                        /**---abgleichen der Domain Eingabe und der Liste mit gesperrten domains---*/

                        $fehler[] = "invalide Email";
                    }

                    /**
                     * wenn keine Fehlermeldung in $fehler array ist wird die eingabe gespeichert
                     */

                    if (empty($fehler)) {
                        $safe = ['\'',';','<','>'];
                        $name = str_replace($safe,'',$name);  //gegen sql injection und XSS
                        $neuerEintrag = [$name, $email, $sprache];

                        $file = fopen('./newsname.txt', 'a');
                        if (!$file) {
                            die('Öffnen fehlgeschlagen');
                        } else {

                            $sstring = serialize($neuerEintrag);

                            fwrite($file, $sstring . "\r\n");
                            fclose();
                            $success = true;
                        }
                    }


                } else {
                    $fehler[] = "invalide Email";
                }


            }

            /**
             * Ausgabe bei erfolgreichem speichern
             */

            if ($success === true) {
                echo "<p>Eingabe Erfolgreich!</p>";
            }
            /**
             * Ausgabe der Fehlermeldungen
             */
            if (!empty($fehler)) {
                foreach ($fehler as $f) {

                    echo "<p class='warning'>$f</p>";
                }
            }

            ?>
            <br><br>


            <!--- Was uns wichtig ist---------------------------------------------------------------------------->

            <a id="Wichtig"></a>
            <div class="Wichtig">
                <h2>Das ist uns wichtig</h2>

                <ul>
                    <li>Beste frische saisonale Zutaten</li>
                    <li>Ausgewogene abwechslungsreiche Gerichte</li>
                    <li>Sauberkeit</li>
                </ul>
            </div>
            <br><br>


            <div class="container">
                <div class="abschluss" id="trans">
                    <h2>Wir freuen uns auf Ihren Besuch!</h2>
                </div>
            </div>


    </div>
    <footer>
        <ul>
            <li>(c) E-Mensa GmbH</li>
            <li>Phillip Schmidt, Nicolas Woitzyk</li>
            <li><a href="">Impressum</a></li>
        </ul>
    </footer>
</body>
</html>