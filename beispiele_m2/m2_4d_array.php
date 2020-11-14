<html lang="de">
<head>
    <link href="arraystyle.css" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Array</title>
</head>
<body>
<?php
$famousMeals = [
    1 => ['name' => 'Currywurst mit Pommes',
        'winner' => [2001, 2003, 2007, 2010, 2020]],
    2 => ['name' => 'Hähnchencrossies mit Paprikareis',
        'winner' => [2002, 2004, 2008]],
    3 => ['name' => 'Spaghetti Bolognese',
        'winner' => [2011, 2012, 2017]],
    4 => ['name' => 'Jägerschnitzel mit Pommes',
        'winner' => 2019]
];
echo "<ol>"; // Startet eine Geordnete Liste
foreach ($famousMeals as $index => $val) { //geht durch die die

    echo '<li>' . $val['name'] . '<br>'; // macht Listenelemente aus den Einträgen
    echo "  ";
    if (is_array($val['winner'])) { // frägt ab ob val ein array ist
        foreach ($val['winner'] as $i) { // gibt die einzelnen arrayeinträge aus
            echo "$i, ";
        }
    } else {
        echo $val['winner'];
    }
    echo '</li>';

    /* foreach ($val as $i ){
         echo $i . "\n".' ';
     }
     */
    /*$i = 1;
    echo $i . '.' . $val[0] . '\n' . ' ' . $val[1] . '\n\n';*/
}
echo '</ol><br>';

function nowin($fm)
{
    $array = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    foreach ($fm as $index => $val) {// Geht wie davor durch array durch
        if (is_array($val['winner'])) { // frägt wieder auf Array ab
            foreach ($val['winner'] as $i) {
                $res = $i - 2000;
                $array[$res] = 1; // Markiert die Jahre mit Gewinner im Array
            }
        } else {
            $res = $val['winner'] - 2000;// ziehe 2000 Jahre ab für array
            $array[$res] = 1;
        }

    }
    echo 'In den folgenden Jahren gab es kein Gewinner: ';
    for ($x = 0; $x < 21; $x++) {
        if ($array[$x] === 0) {
            echo $x + 2000 . ', '; // Gibt Jahre ohne Gewinner aus und addiert davor die 2000 wieder dazu
        }
    }


}

nowin($famousMeals);

?>
</body>