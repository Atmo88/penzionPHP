<?php
//$seznamStranek = array (
//    "uvod" => array (
//        "titulek" => "Prima Penzion",
//        "menu" => "Domů",
//    ),
//    "kontakt" => array (
//        "titulek" => "Kontaktujte nás",
//        "menu" => "Kontakty",
//    ),
//    "cenik" => array (
//        "titulek" => "Naše ceny",
//        "menu" => "Ceník",
//    ),
//    "fotogalerie" => array (
//        "titulek" => "Jak to u nás vypadá",
//        "menu" => "Fotky",
//    ),
//    "404" => array (
//        "titulek" => "Chyba 404 - stránka nenalezena",
//        "menu" => "",
//    ),
//);

require 'data.php';


if (array_key_exists('stranka', $_GET)) { // (1) rozhodne kterou stranku zobrazit, budto kliknutim (zobrazi se v URL) nebo nova navsteva na strance
    $stranka = $_GET['stranka'];
    
    //kontrola zdali existuje
    
    if (!array_key_exists($stranka, $seznamStranek)) {
        $stranka = '404';
        http_response_code(404);
    }
} else {
    $stranka = 'uvod';
}

?>
<!DOCTYPE html>

<html>
    <head>
        <title><?php 
        echo $seznamStranek[$stranka]->getTitulek();
        ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Merriweather:300,400,900&amp;subset=latin-ext" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <header>
                <div class="clearfix">
                    <img class="obr" src="obrazky/PrimaPenzion.jpg" alt="hgf">
                    <div class="penzion">Prima Penzion</div>   
                </div>
                <div class="menu">
                    <ul>
                        <?php 
                        foreach ($seznamStranek as $idstranky => $vlastnosti) {
                            if (!empty($vlastnosti->getMenu())) {
                                echo "<li><a href='$idstranky'>{$vlastnosti->getMenu()}</a></li>";
                            }
                        }
                        ?>
                    </ul>
                </div>
            </header>
            <section class="obsah">
                
            <?php
            
//          echo file_get_contents("$stranka.html"); // (1) dle vyberu vygeneruje obsah
            echo $seznamStranek[$stranka]->getObsah();
            
            ?>
         
                
            </section>
            
            <footer>
                <div class="paticka clearfix">
                    <div class="prvek1">
                        <ul>
                        <?php 
                            foreach ($seznamStranek as $idstranky => $vlastnosti) {
                                if (!empty($vlastnosti->getMenu())) {
                                    echo "<li><a href='?stranka=$idstranky'>{$vlastnosti->getMenu()}</a></li>";
                                }
                            }
                        ?>
                        </ul>
                    </div>
                    <div class="prvek2">
                        <ul>
                            <li><a href="https://goo.gl/maps/WKjuoA3DAxF2" target="blank">Adresa 1111/20 Praha 3 160 00</a></li>
                            <li><i class="fa fa-phone-square" aria-hidden="true"></i><span>608 966 988</span></li>
                            <li><a href="#">cenik</a></li>
                        </ul>    
                    </div>
                </div>
            </footer>    
        </div>
    </body>
</html>
                