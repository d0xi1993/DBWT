<?php
$a =$b =null;

if(isset($_GET['a'])){
    $a = $_GET['a'];
}
if(isset($_GET['b'])){
    $b = $_GET['b'];
}
$a = $_GET['a'];
$b = $_GET['b'];
$result = $a + $b;

?>
<form method="get" action="formular.php">
    <input type="text" name="a"> + <input type="text" name="b">
    <input type="submit">

</form>
