<?php

// Dieses Array dient gleichzeitig zur Validierung gültiger Zustände
// wie auch zum Zuordnen des Gegenzustands
$states = array(
    'visible' => 'hidden' ,
    'hidden' => 'visible' ,
);

$display = 'visible'; // dies ist der Initialzustand

if (! empty ($_GET['display'])) {
    // wir nehmen nur 'visible' oder 'hidden an
    if(in_array ($_GET['display'] , $states)) {
        $display = $_GET['display'];
    }
}

$link = '?display=' . $states[$display]; // Gegenteil in den Link
?>
<style>
    .hidden {display:none;}
    .visible {display:block;}
</style>
...
<a href="<?php echo $link; ?>">Click me!</a>
<div class="<?php echo $display; ?>">
    Here ist some content for you!
</div>