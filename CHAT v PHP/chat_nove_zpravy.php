<?php

require "libDB.php";

DB::init("sqlchat");

session_start();

$posledniID = $_GET['id'];

$zpravy = DB::doSql("SELECT * FROM zprava WHERE id > ".DB::toSql($posledniID));

header("Content-Type: application/json");

echo json_encode($zpravy);