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
/*
$lang = ['en' => [    //kann man das so machen?
    'Gericht' => 'Meal',
    'Bewertungen' => 'Rating',
    'Insgesamt' => 'overall',
    'Filter' => 'filter',
    'Suchen' => 'search',
    'Gerichtinfo' => 'menuinfo',
    'einblenden' => 'show',
    'preis' => 'price',
    'intern' => 'intern',
    'extern' => 'extern'
],
    'de' => [
        'meal' => 'Gericht',
        'Rating' => 'Bewertung',
        'overall' => 'Ingesamt',
        'filter' => 'Filter',
        'search' => 'Suchen',
        'menuinfo' => 'Gerichtinfo',
        'show' => 'einblenden',
        'price' => 'preis',
        'intern' => 'intern',
        'extern' => 'extern'
    ]
];



if ($lang) {


    $newWert = 0;
    $lang = "deutsch";
    echo $lang['de'];


} else {


    $newWert = 1;
    $lang = "englisch";
    echo $_GET[$lang['en']];
}
*/
$translations =
    [
        'de' =>
            [
                'meal_h1' => "Gericht: ",
                'allergene_h1' => "Allergene",
                'tb_allergene_th_nr' => "Allergen-Nr.",
                'tb_allergene_th_desc' => "Beschreibung",
                'ranking_h1' => "Bewertungen (Insgesamt: ",
                'search_btn_text' => "Suchen",
                'tb_rankings_desc' => "Text",
                'tb_rankings_author' => "Autor",
                'tb_rankings_stars' => "Sterne",
            ],
        'en' =>
            [
                'meal_h1' => "Meal: ",
                'allergene_h1' => "Allergene",
                'tb_allergene_th_nr' => "Allergene-Nr.",
                'tb_allergene_th_desc' => "Description",
                'ranking_h1' => "Feedback/Raking (Overall: ",
                'search_btn_text' => "Serach",
                'tb_rankings_desc' =>"Feedback",
                'tb_rankings_author' =>"Author",
                'tb_rankings_stars' =>"Stars",
            ]
    ];

/*<?php echo $translations[$lang]['tb_allergene_th_nr']?>*/
$lang = 'de';

if (key_exists('lang', $_GET)){
if(key_exists($_GET['lang'],$translations)){
$lang =  $_GET['lang'];
}
}

echo "<form action='meal.php' method='get'>
  <label for='language'>Diese Seite in einer anderen Sprache:</label>
  <select id='language'>
    <option lang='en' name='lang' href='?lang=en' value='en'>english</option>
    <option lang='de' name='lang' href='?lang=de' value='de'>deutsch</option>
  </select>
  <button type='submit' name='sub_lang'>Ändern</button>
</form>";





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
    <?php echo $translations[$lang]['meal_h1']?>
    <title>Gericht: <?php echo $meal['name']; ?></title>
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
<h1>Gericht: <?php echo $meal['name']; ?></h1>

<table class="Preise">
    <thead>
    <tr>
        <td>Preis Inter</td>
        <td>Preis extern</td>
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

<?php
echo '<ul>';
foreach ($meal[allergens] as $allergenNr) {
    echo "<ol>" . $allergensList[$allergenNr] . "</ol>";
}
echo '</ul>';
?>

<!--3b Allergene-->

<h1>Bewertungen (Insgesamt: <?php echo calcMeanStars($ratings); ?>)</h1>

<form method="get">
    <label for="search_text">Filter:</label>
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
        <td>Text</td>
        <td>Author</td>    <!--3a Author der Bewertung-->
        <td>Sterne</td>
        <td>Preis</td>
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