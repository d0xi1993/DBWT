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
    <!--
    <link rel="stylesheet" href="https/maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https/ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https/cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https/maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    -->
</head>
<body>

<nav>


    <ul class="navbar">
        <li><a class="logo"><img src="logo-FH.png" alt="Das Bild ist leider momentan nicht Verfügbar" height="80" width="40" ></a></li>
        <li><a href="#Ankündigung">Ankündigung</a></li>
        <li><a href="#Speisen">Speisen</a></li>
        <li><a href="#Zahlen">Zahlen</a></li>
        <li><a href="#Kontakt">Kontakt</a></li>
        <li><a href="#Wichtig">Wichtig für uns</a></li>
    </ul>
</nav>
<hr>
<div class="content-body">


    <br>
    <a id="Ankündigung"></a>    <!--id statt name, name wirft ein fehler raus (vermutlich veraltet)-->
    <div class="ankuendigung">
        <h2>Ankündigungen</h2>
        <br>
        <p>Das Ungezieferproblem wurde gelöst</p>
    </div>
    <br><br>

    <a id="Speisen"></a>        <!--id statt name, name wirft ein fehler raus (vermutlich veraltet)-->
    <div class="speisen">
        <h2>Köstlichkeiten, die Sie erwarten</h2>
        <table id="menüliste">
            <thead>

            <tr>
                <th></th> <!--Oben links leer in Essenstabelle -->
                <th>Preis intern</th>
                <th>Preis extern</th>
            </tr>
            </thead>
            <tbody>
            <?php



            $file= fopen('./Speisen.txt','r');

            while(($line = fgets($file,1024))!==false){ // liest die Zeilen der Datei ein bis ende

                $val = explode(';',$line);  // trennt die attriebute der Zeil und packt sie in Array

                echo "<tr>";
                foreach($val as $i){ // gibt die Atribute in Tabellenform aus
                    echo "<td>".$i."</td>";
                }
                echo "</tr>";
                switch ($val[0]){             //Gibt zum jeweiligen Essen das passende Bild aus
                    case "Schnitzel":
                        echo "<tr><td colspan='3'><img src='./img/Schnitzel.jpg'></td></tr>";
                        break;
                    case "Pommes rot weiß":
                        echo "<tr><td colspan='3'><img src='./img/pommes.jpg'></td></tr>";
                        break;
                    case "Gyros komplett":
                        echo "<tr><td colspan='3'><img src='./img/gyros.jpg'></td></tr>";
                        break;

                    case "Spätzle mit Soße":
                        echo "<tr><td colspan='3'><img src='./img/spätzle.jpg'></td></tr>";
                        break;

                    case "Spagetti":
                        echo "<tr><td colspan='3'><img src='./img/spagetti.jpg'></td></tr>";
                        break;
                }
            }

            ?>
            </tbody>
        </table>
    </div>
    <br><br>


    <!-- zahlen der E-Mensa-->
    <a id="Zahlen"></a>       <!--id statt name, name wirft ein fehler raus (vermutlich veraltet)-->
    <div class="zahlen">
        <h2>E-Mensa in Zahlen</h2>

        <ul>
            <li>x Besuche</li>
            <li>y Anmeldungen zum Newsletter</li>
            <li>z Speisen</li>
        </ul>
    </div>
    <br><br>


    <a id="Kontakt"></a>            <!--id statt name, name wirft ein fehler raus (vermutlich veraltet)-->
    <h2>Interesse geweckt? wir informieren Sie !</h2>

    <form action='newsl_anzeigen.php' class="newsl" method="post">

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
                    <option value="" >Newsletter bitte in:</option>
                    <option value="1">englisch</option>
                    <option value="2">deutsch</option>
                </select>
            </div>
            <br>

            <div class="n">
                <label class="switch">
                    <input name='dataCheck' type="checkbox" required>
                    <span class="slider round"></span>
                </label>
                Datenschutzhinweise gelesen
            </div>

            <button type="submit" id="getnews" class="button" >Zum Newsletter anmelden</button>

            <br>
        </fieldset>

    </form>
    <br>
    <?php
    $fehler = [];
    $success=false;

    if(isset($_POST['name'])&&isset($_POST['email'])&&isset($_POST['option'])){

        $name=$_POST['name'];
        $email=$_POST['email'];
        $sprache=$_POST['option'];

        if (trim($name)== ""){ // Prüfen ob Namensfeld Leer ist
            $fehler[] = "Ungültiger name";
        }


        if( filter_var($email, FILTER_VALIDATE_EMAIL) ){ /// Testen auf valide Email

            $domain = substr(strrchr($email, "@"), 1);// doimain teil der Eingabe
            $disposable_list = ['rcpt.at',', damnthespam.at','wegwerfmail.de',
                'trashmail.de','trashmail.com']; // Liste nicht zugelassener Domains

            if(in_array($domain, $disposable_list)){ // abgleiche der Domain Eingabe und der Liste mit gesperrten domains

                $fehler[]="invalide Email";
            }

            if(empty($fehler)) { // wenn keine Fehlermeldung in $fehler array ist wird die eingabe gespeichert

                $neuerEintrag= [$name,$email,$sprache];

                $file = fopen('./newsname.txt', 'a'); // öffnet newsname.txt
                if (!$file) {//---------------------- Prüft ob file wirklichgeöffnet ist
                    die('Öffnen fehlgeschlagen');
                } else {

                    $sstring = serialize($neuerEintrag);

                    fwrite($file,$sstring. "\r\n");
                    fclose();
                    $success= true;
                }
            }


        }
        else{
            $fehler[]="invalide Email";
        }



    }

    if($success===true){
        echo"<p>Eingabe Erfolgreich!</p>";
    }

    if(!empty($fehler)){
        foreach($fehler as $f){

            echo"<p class='warning'>$f</p>";
        }
    }

    ?>
    <br><br>
    <!--- Was uns wichtig ist-->

    <a id="Wichtig"></a>                <!--id statt name, name wirft ein fehler raus (vermutlich veraltet)-->
    <div class="Wichtig">
        <h2>Das ist uns wichtig</h2>

        <ul>
            <li>Beste frische saisonale Zutaten</li>
            <li>Ausgewogene abwechslungsreiche Gerichte</li>
            <li>Sauberkeit</li>
        </ul>
    </div>
    <br><br>


    <div class="container"><!---->
        <div class="abschluss" id="trans">
            <h2>Wir freuen uns auf Ihren Besuch!</h2>
        </div>
    </div><!---->


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