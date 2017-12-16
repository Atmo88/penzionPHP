<?php

class DB {
    //promena pro vytvorene spojeni
    protected static $db;
    
    //fce pro vytvoreni spojeni s databazi
    static function  init($nazevDatabaze) {
        self::$db = mysqli_connect("localhost", "root", "");
        
        mysqli_set_charset(self::$db, "utf8");
        
        mysqli_select_db(self::$db, $nazevDatabaze);
    }
    
    // funkce provede SQL dotaz a zkontroluje zdali dopadl ok
    // pokud je SQL nevalidni tak vyhodi vyjimku
    // pokud je OK a jde o SELECT tak vrati vysledek jako pole radek
    
    static function  doSql($sql) {
        $vysledek = mysqli_query(self::$db, $sql);
        
        if ($vysledek === false) {
            // pokud jhe sq nevalidni
            $chyba = mysqli_error(self::$db);
            throw new Exception("Spatny SQL ($sql). Chyba: $chyba");
        } else if ($vysledek === true) {
            // byl provede validni SQL dotaz ktery ale nic nevraci
            // napr INSERT, UPDATE
            // vse je OK a ani my nic nevracime
        } else {
            // byl proveden dotaz
            // vratime tedy vysledek jako pole radku
            $radky = array();
            while ($radka = mysqli_fetch_assoc($vysledek)){
                $radky[] = $radka;
            }
            return $radky;
        }
    }
    
    // funkce pro prevod libovolne hodnoty na SQL reprezentaci
    // NULL prevede na NULL
    // cislo prevede na text
    // text oescapuje a obali apostrofy
    static function toSql($hodnota) {
        if (is_null($hodnota)){
            return "NULL";
        } else if (is_numeric($hodnota)){
            //cislo nechame tak jak je a prevedeme na text
            return "$hodnota";
        } else if (is_string($hodnota)) {
            //text vratime obaleny a oescapovany
            $escaped = mysqli_real_escape_string(self::$db, $hodnota);
            return "'$escaped'";
        } else {
            throw new Exception("Neznamy datovy typ pro SQL");
        }
    }
    
}
