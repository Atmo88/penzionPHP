<?php

require "libDB.php";

DB::init("sqlchat");

session_start();


$prispevek = $_POST["prispevek"];
//    zapis do souboru po staru
//    $zaznam = date("H:i:s")." ".$_SESSION["prihlasenyUzivatel"].": ".$prispevek;
//    file_put_contents("chat.txt", $zaznam."\r\n<!!!>", FILE_APPEND); /* !!! libovolný znak podle kterýho pak rozdělíme explode text na */
DB::doSql("INSERT INTO zprava SET cas = NOW(), nick = ".DB::toSql($_SESSION["prihlasenyUzivatel"]).", zprava = ".DB::toSql($prispevek)); 
     
