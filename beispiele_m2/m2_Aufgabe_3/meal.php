<?php
const GET_PARAM_MIN_STARS = 'search_min_stars';
const GET_PARAM_SEARCH_TEXT = 'search_text';

/**
 * Liste aller möglichen Allergene.
 */
$allergensList = [
    11 => 'Gluten',
    12 => 'Krebstiere',
    13 => 'Eier',
    14 => 'Fisch',
    17 => 'Milch'
]    //hier muss das array geschlossen werden
;
//--3e show_descr--> //

$isDescHidden = 0;
//--3e show_descr--> //

$meal = [ // Kurzschreibweise für ein Array (entspricht = array())
    'name' => 'Süßkartoffeltaschen mit Frischkäse und Kräutern gefüllt',
    'description' => 'Die Süßkartoffeln werden vorsichtig aufgeschnitten und der Frischkäse eingefüllt.',
    'price_intern' => 2.90,
    'price_extern' => 3.90,
    'allergens' => [11, 13],
    'amount' => 42   // Anzahl der verfügbaren Gerichte.
];


$translations =
    [
        'de' =>
            [
                'preis_'=>'Preis',
                'change_' =>'Ändern',
                'sprache' =>'Sprache ändern:' ,
                'meal_' => "Gericht: ",
                'allergene_' => "Allergene",
                'ranking_' => "Bewertungen (Insgesamt: ",
                'search_' => "Suchen",
                'r_text' => "Text",
                'r_author' => "Author",
                'r_stars' => "Sterne",
            ],
        'en' =>
            [
                'preis_'=>'price',
                'change_' =>'Change',
                'sprache' =>'Change language:' ,
                'meal_' => "Meal: ",
                'allergens_' => "Allergens",
                'ranking_' => "Feedback/Raking (Overall: ",
                'search_' => "Search",
                'r_text' =>"Feedback",
                'r_author' =>"Author",
                'r_stars' =>"Stars",
            ]
    ];

$lang = 'de';

if (isset($_GET['lang'])){
    if($_GET['lang'] == 'en'){
        $lang='en';
    }
    if($_GET['lang'] == 'de'){
        $lang='de';
    }

}
?>

<form action="meal.php" method="get">
    <label for="language"><?php echo $translations[$lang]['sprache'];?></label>
    <select id="language" name="lang">
        <option value="en">en</option>
        <option value="de">de</option>
    </select>
    <button type="submit"  ><?php echo $translations[$lang]['change_'];?></button>
</form>


<?php


$ratings = [
    ['text' => 'Die Kartoffel ist einfach klasse. Nur die Fischstäbchen schmecken nach Käse. ',
        'author' => 'Ute U.',
        'stars' => 2],
    ['text' => 'Sehr gut. Immer wieder gerne',
        'author' => 'Gustav G.',
        'stars' => 4],
    ['text' => 'Der Klassiker für den Wochenstart. Frisch wie immer',
        'author' => 'Renate R.',
        'stars' => 4],
    ['text' => 'Kartoffel ist gut. Das Grüne ist mir suspekt.',
        'author' => 'Marta M.',
        'stars' => 3]
];

$showRatings = [];      //erzeugt ein leeres Array
if (!empty($_GET[GET_PARAM_SEARCH_TEXT])) {     //wenn Parameter übergeben wurden
    $searchTerm = $_GET[GET_PARAM_SEARCH_TEXT];     //Suche den Parameter
    foreach ($ratings as $rating) {     //

        if (stripos($rating['text'], $searchTerm) !== false) {  // Aufgabe 3c
            $showRatings[] = $rating;
        }

    }
} else if (!empty($_GET[GET_PARAM_MIN_STARS])) { //nicht elif sonder else if
    $minStars = $_GET[GET_PARAM_MIN_STARS];
    foreach ($ratings as $rating) {
        if ($rating['stars'] >= $minStars) {
            $showRatings[] = $rating;
        }
    }
} else {
    $showRatings = $ratings;
}


//--3b Berechnungsfehler--> //
function calcMeanStars($ratings): float
{ // : float gibt an, dass der Rückgabewert vom Typ "float" ist
    $sum = 0;
    $i = 0;
    foreach ($ratings as $rating) {        //for eacH nicht foreah
        $i++;                              //muss das nicht vorher passieren ?! damit ich auch für jedes Rating die Zahl habe sonst fehlt zum Schluss eine Bewertung
        $sum += $rating['stars'];

    }
    return $sum / $i;  // vorher wurde der Mittelwert vom Mittelwert berechnet jetzt richtig
}

//--3d Berechnungsfehler--> //
?>


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8"/>
    <title><?php echo $translations[$lang]['meal_'].$meal['name']; ?></title>
    <style type="text/css">
        * {
            font-family: Arial, serif;
        }

        .rating {
            color: darkgray;
        }
    </style>
</head>
<body>
<h1><?php echo $translations[$lang]['meal_'].$meal['name']; ?></h1>

<table class="Preise">
    <thead>
    <tr>
        <td><?php echo $translations[$lang]['preis_'];?> inter</td>
        <td><?php echo $translations[$lang]['preis_'];?> extern</td>
    </tr>
    </thead>
    <tbody>
    <tr> <!--Aufgabe 3h-->
        <td><?php echo number_format($meal['price_intern'], 2, ",", ".") . '€' ?></td>
        <td><?php echo number_format($meal['price_extern'], 2, ",", ".") . '€' ?></td>
    </tr> <!--Aufgabe 3h-->
    </tbody>
</table>
<?php
// Aufgabe 3e//
if (!empty($_GET['show_descr'])) {


    $newValue = 0;
    $buttonText = "Gerichtinfo Ausblenden";
    echo $meal['description'];

} else {
    $newValue = 1;
    $buttonText = "Gerichtinfo Einblenden";
    $newValue = 1;
}
//Aufgabe 3e


echo "<form method='get' action='meal.php'>
                <input name='show_descr' value='{$newValue}'  hidden>
                <input type='submit' value='{$buttonText}'>
            </form>";


?>


<!--3b Allergene-->
<h2><?php echo $translations[$lang]['allergene_'];?></h2>
<?php

foreach ($meal['allergens'] as $allergenNr) {
    echo "<ul>" . $allergensList[$allergenNr] . "</ul>";
}

?>

<!--3b Allergene-->

<h1><?php echo $translations[$lang]['ranking_'] .calcMeanStars($ratings); ?>)</h1>

<form method="get">
    <label for="search_text">Filter: </label>
    <?php
    //Aufgabe 3f
    if (!empty($_GET['search_text'])) {

        $search_eingabe = '';
        $search_eingabe = $_GET['search_text'];

    }

    echo "<input id='search_text' value='{$search_eingabe}' type='text' name='search_text'>"
    //Aufgabe 3f
    ?>
    <input type="submit" value="Suchen">

</form>
<table class="rating">
    <thead>
    <tr>
        <td><?php echo $translations[$lang]['r_text'] ?></td>
        <td><?php echo $translations[$lang]['r_author'] ?></td>    <!--3a Author der Bewertung-->
        <td><?php echo $translations[$lang]['r_stars'] ?></td>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($showRatings as $rating) {
        echo "<tr> <td class='rating_text'>{$rating['text']}</td>
                   <td class='rating_text'>{$rating['author']}</td>   <!--3a Author der Bewertung-->
                   <td class='rating_stars'>{$rating['stars']}</td>
              </tr>";
    }
    ?>
    </tbody>
</table>
</body>
</html>