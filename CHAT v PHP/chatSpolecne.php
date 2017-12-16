<?php

require "libDB.php";

DB::init("sqlchat");

session_start();

if (array_key_exists('nick', $_POST))
{
    $nick= $_POST['nick'];
    $_SESSION ["prihlasenyUzivatel"]=$nick;
    header('location:?');
    exit();
}

if (array_key_exists('odhlasit', $_POST))
{
    unset ($_SESSION["prihlasenyUzivatel"]);
    header('location:?');
    exit();
}

?>

<meta charset="utf-8"/>

<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
></script>
<script src="chat.js"></script>
  


<?php

if (!array_key_exists("prihlasenyUzivatel", $_SESSION))
{      
?>
    <form method="post">
        Nick: <input type="text" name="nick"/>
        <input type="submit" value="Přihlásit"/>
    </form>
<?php
}
else 
{
    echo "Přihlášen jako {$_SESSION ['prihlasenyUzivatel']} ";

?>

    <form method="POST">
        <input type="submit" name="odhlasit" value="Odhlásit"/>
    </form>

    <form id="chatform" method="POST">
        <textarea name="prispevek" cols="100" rows="5" ></textarea>
        <br/><input type="submit" value="Odeslat zprávu"/>
    </form>

<div id="zpravy">    
    <?php
//    $obsah= file_get_contents('chat.txt');
//    $radky= explode("<!!!>", $obsah);
//    $pocet= count($radky);
//    for ($i=$pocet-1; $i>$pocet-11 && $i>=0 ; $i--)
//    {
//        echo "<div>$radky[$i]</div>";
//    }
    
    $zpravy = DB::doSql("SELECT * FROM zprava ORDER BY cas DESC LIMIT 10");
    foreach ($zpravy as $zprava) {
        $zprava['cas'] = date("H:i:s", strtotime($zprava['cas']));
        echo "<div>{$zprava['nick']} {$zprava['cas']} {$zprava['zprava']}</div>";
    }
    ?>
    
</div>
<?php
    // potrebuji vytvorit Kontrolora a predat mu posledni id
    $radky = DB::doSql("SELECT id FROM zprava ORDER BY id DESC LIMIT 1");
    $posledniID = $radky[0]['id'];
    ?>
<script>
    new Kontrolor (<?php echo $posledniID ?>);
</script>
    <?php
}
