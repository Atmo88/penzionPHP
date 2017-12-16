<?php

require "libDB.php";

DB::init("penzion");

class Stranka {
    protected $id;
    protected $titulek;
    protected $menu;
    
    function __construct($id, $titulek, $menu) {
        $this->id = $id;
        $this->titulek= $titulek;
        $this->menu = $menu;
    }
    
    function getID() {
        return $this->id;
    }
    function setID($id) {
        $this->id = $id;
    }
    function getTitulek() {
        return $this->titulek;
    }
    function setTitulek($titulek) {
        $this->titulek = $titulek;
    }
    function getMenu() {
        return $this->menu;
    }
    function setMenu($menu) {
        $this->menu = $menu;
    }
    function getObsah() {
        if ($this->id == ""){
            return "";
        }
//      return file_get_contents("$this->id.html");
        // nacte z databaze sloupec obsah pro radek id
        $radky = DB::doSql("SELECT obsah FROM stranka WHERE id = ".DB::toSql($this->id));
        // doSql nam vraci pole kde kazdy clen je jeden radek
        // a v tomto clenu je dalsi pole kde cleny reprezentuji sloupce
        // zde mame 1 radek (kvuli $this->id) a v tomto mame jeden sloupec s indexem 'obsah'
        return $radky[0]['obsah'];
    }
    function setObsah($obsah) {
//      return file_put_contents("$this->id.html", $string);
        //udelame sql prikaz pro ulozeni html obsahu do databaze
        DB::doSql("UPDATE stranka SET obsah = ".DB::toSql($obsah)." WHERE id = ".DB::toSql($this->id));
    }
    function ulozit($puvodniID){
        if ($puvodniID == "") {
            DB::doSql("INSERT INTO stranka SET id = ".DB::toSql($this->id)
                        .", titulek = ".DB::toSql($this->titulek)
                        .", menu = ".DB::toSql($this->menu));
            
        } else{ 
            DB::doSql("UPDATE stranka SET id = ".DB::toSql($this->id)
                                    .", titulek = ".DB::toSql($this->titulek)
                                    .", menu = ".DB::toSql($this->menu)
                                    ." WHERE id = ".DB::toSql($puvodniID));
        }
    }
    function vymaznout(){
        DB::doSql("DELETE FROM stranka WHERE id= ".DB::toSql($this->id));
    }
    static function nastavPoradi($poradi){
        // vezme pole idecek a zaktualizuje podle nej databazi
        foreach($poradi as $index => $id){
            DB::doSql("UPDATE stranka SET poradi=".DB::toSql($index)." WHERE id = ".DB::toSql($id));
        }
    }
           
}

$seznamStranek = array ();
//    "uvod" => new Stranka("uvod", "Prima Penzion", "Domů"),
//    "kontakt" => new Stranka("kontakt", "Kontaktujte nás", "Kontakty"),
//    "cenik" => new Stranka("cenik", "Naše ceny", "Ceník"),
//    "fotogalerie" => new Stranka("fotogalerie", "Jak to u nás vypadá", "Fotky"),
//    "404" => new Stranka("404", "Chyba 404 - stránka nenalezena", ""),

$radky = DB::doSql("SELECT * FROM stranka ORDER BY poradi");
// v $radkach mam ulozene radky databaze v poli, kde kazdy radek je vnorene pole s hodnotami sloupcu
foreach ($radky as $radka){
    //pridam do seznamu stranek novy objekt, ktery ma index jako id stranky a a vygeneruju promene objektu jako id, titulek, menu
    $seznamStranek[$radka['id']]= new Stranka($radka['id'], $radka['titulek'], $radka['menu']);
}
