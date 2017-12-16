<?php
//prihlasime se k databazi
$db = mysqli_connect("localhost", "root","");

//nastavujeme kodovani, data budou v cestine
mysqli_set_charset($db, "utf8");

//vzbereme databazi s treou budeme pracovat
mysqli_select_db($db, "eshop");

//polozime SQL dotaz

$vysledek = mysqli_query($db, "SELECT * FROM kategorie");

var_dump($vysledek);

//ziskame data z $vysledku

while ($radka = mysqli_fetch_assoc($vysledek)) {
    var_dump($radka);
}

