<?php
/*
 * Praktikum DBWT Autoren:
 * Nico Woitzyk 3187694
 * Philip Schmidt 3236291
*/

/**
 * sortieren() sortiert das array
 *
 * @param $array als referenz übergeben beinhaltet ein array
 * @param $spalten gibt an ob nach Name oder Email sortiert wird
 * @param $aufab gibt an ob auf- oder absteigend sortiert wird
 */

function sortieren(&$array, $spalten, $aufab)
{

    if ($spalten === "name") {
        $sp = 0;
    } else {
        $sp = 1;
    }

    for ($i = 0; $i < sizeof($array) - 1; $i++) {
        for ($j = $i + 1; $j < sizeof($array); $j++) {

            $tmp = strcasecmp($array[$i][$sp], $array[$j][$sp]);

            // wenn strcasecmp(nicht empfindlichauf groß/kleinschreibng) ein Wert < 0 liefert; kommt
            // string 1 zuerst im Alphabet

            // tauschen der array pläzte
            if ($aufab === "auf") {
                if ($tmp > 0) {
                    $tmp2 = $array[$i];
                    $array[$i] = $array[$j];
                    $array[$j] = $tmp2;
                }
            } else {
                if ($tmp < 0) {
                    $tmp2 = $array[$i];
                    $array[$i] = $array[$j];
                    $array[$j] = $tmp2;
                }
            }

        }
    }

}

?>


<!----- Header mit Styleeinbindung und Anfang des Bodys mit Form zum sortieren der Einträge --->


<!DOCTYPE html>

<html lang="de">
<head>
    <meta charset="UTF-8">
    <link href="test.css" rel="stylesheet">
    <title>Title</title>

</head>
<body>

<fieldset>
    <form action="nl_admin.php" method="get">
        <select name="spaltenauswahl" class="cat">
            <option value="email">email</option>
            <option value="name">name</option>
        </select>
        <select name="aufab" class="cat">
            <option value="auf">Aufwärts</option>
            <option value="ab">Abwärts</option>
        </select>
        <button type="submit">Sortieren</button>
    </form>
</fieldset>
<fieldset>
    <form action="nl_admin.php" method="get">
        <input type="search" name="filter">
        <button type="submit">Filtern</button>
    </form>
</fieldset>


<?php
/**
 * Einlesen der Datei in $file_nl
 *
 * übergabe der Daten in Array $anmeldungen
 */


$anmeldungen = [];

$file_nl = fopen('newsname.txt', 'r');
if (!$file_nl) {
    die("Öffnen von zaehler_besucher ist fehlgeschlagen");
} else {

    while ($tmp_array = unserialize(fgets($file_nl, 1024))) {

        $anmeldung[] = $tmp_array;
    }


    fclose($file_nl);
}
// Aufruf funktion sortieren()
$ausgaeb = [];

if (isset($_GET['spaltenauswahl']) && isset($_GET['aufab'])) {
    $ausgabe = $anmeldung;
    sortieren($ausgabe, $_GET['spaltenauswahl'], $_GET['aufab']);
}
elseif (isset($_GET['filter'])) {
    foreach ($anmeldung as $arr => $a){
        if(stripos($a['0'],$_GET['filter'])!==false){
            $ausgabe[] = $a;
        }
    }
    if(empty($ausgabe)){
        $ausgabe = $anmeldung;
    }

}else{
    $ausgabe = $anmeldung;
}

?>

<!---------------------Ausgabe-------------------------------------------->


<div class="adminnews">
    <table id="newsliste">
        <thead>

        <tr>
            <th>Name</th> <!--Oben links leer in Essenstabelle -->
            <th>Email</th>
            <th>Newsletter Sprache</th>
            <th>Datenschutz zugestimmt</th>
        </tr>
        </thead>
        <tbody>


        <?php
        /**
         *  ausgabe der sortierten Anmeldungen
         */

        foreach ($ausgabe as $arr => $item) {

            echo "<tr>";
            echo "<td>" . $item[0] . "</td>";
            echo "<td>" . $item[1] . "</td>";
            echo "<td>" . $item[2] . "</td>";
            echo "<td> Ja </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<br><br>
</body>