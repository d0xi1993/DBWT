<?php
echo "Hallo welt";

$var = 1;    // != $vAr = 1;  Groß und klein Schreibung
$a = $b = $c = 2;

echo 'mein Wert= $var <br>';

echo "mein Wert= $var <br>"; // bei doppelten wird die Variable gesetzt bei einfachen nicht

$var = 'String';
//$var = 1.5;    //variablen können sich verändern vom datentyp

//type joggling

$var += 10; // versucht auf ein String 10 zu addieren führt zu Problemen !!

//error reporting=e_all    einstellen auf ide Einstellungen

var_dump($var); //gibt die Variable und Typ zurück

function myvardump($v){
    echo '<pre>';
    var_dump($v);
    echo '</pre>';
}

$a = array('Apfel' => 1,
    2,
    3,
    42,
    'string');
myvardump($a);

echo $a[1]; //zugrüff über indexoperator

for($i = 0; $i < count($a); $i++) {

    echo $a[$i], '<br>';
}

foreach($a as $key => $value){

    echo $key, '=', $value, '<br>';

    if(§value == 1){                      // === dann passiert keine typ konvertierung
        echo 'er ist 1!', '<br>';
    }

}

$a2 = array('Apfel' => "1",
    'Banane' => [1,2,3],);

