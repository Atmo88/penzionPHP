<?php

//prihlasime se k databazi
$db = mysqli_connect("localhost", "root","");

//nastavujeme kodovani, data budou v cestine
mysqli_set_charset($db, "utf8");

//vzbereme databazi s treou budeme pracovat
mysqli_select_db($db, "eshop");

if (array_key_exists("nazev", $_GET)) {
    
    $nazev = $_GET["nazev"];
    
    Echo "<h1>Hledam $nazev</h1>";
    
    //prida '\' k apostrofum atd jako ochrana pred special chars
    $nazev = mysqli_real_escape_string($db, $nazev);
    
    $sql = "SELECT * FROM produkt WHERE nazev = '$nazev'";
    
    $vysledek = mysqli_query($db, $sql);
    
    $radka = mysqli_fetch_assoc($vysledek);
    echo "ZDE: ";
    var_dump($vysledek);
    echo "TADy: ";
    var_dump($radka);
}
?>

<form>
    Nazev produktu: <input type="text" name="nazev">
    <input type="submit" value="Vyhledat">
</form>