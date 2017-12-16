<?php

require 'data.php';

session_start();

$spatneHeslo = false;

if (array_key_exists('prihlasit', $_POST)) {
    if ($_POST['pass'] == "heslo") {
        $_SESSION['loggedin']= TRUE;
    header('location:?');
    exit();        
    } else {
        $spatneHeslo = true;
    }
}

if (array_key_exists('odhlasit', $_POST)) {
    unset($_SESSION['loggedin']);
}

// zkontrolujeme zdali byla vybrana nejaka stranka

$aktualniStranka = null;
if (array_key_exists('stranka', $_GET)) { //ta stranka ktera je v url pres metodu GET
    $aktualniStranka=$seznamStranek[$_GET['stranka']];
}

if (array_key_exists("akce", $_GET)){
    
    $akce = $_GET["akce"];
    
    if ($akce == "odstranit"){
        $aktualniStranka->vymaznout();
        //presmeruje na zakladni stranku admin php, exit ukonci generovani php
        header("Location: ?");
        exit;
    }
    else if ($akce == "pridat"){
        $aktualniStranka = new Stranka("","","");
    }
    else if ($akce == "nastavPoradi"){
        $poradi = $_GET['poradi'];
        
        // zaktualizujeme poradi v databazi podle toho co mi poslal javascript
        Stranka::nastavPoradi($poradi);
        
        echo "OK";
        exit;
    }
}

if ($aktualniStranka !=null) {
    if (array_key_exists('obsah', $_POST)){
        
        $puvodniID = $aktualniStranka->getID();
        
        $aktualniStranka->setID($_POST['id']);
        $aktualniStranka->setTitulek($_POST['titulek']);
        $aktualniStranka->setMenu($_POST['menu']);
        $aktualniStranka->ulozit($puvodniID);
        
        $aktualniStranka->setObsah($_POST['obsah']);
        
        header("Location: ?stranka=".$aktualniStranka->getID());
    }

}


if (!array_key_exists('loggedin', $_SESSION)) {

//tady zacina vypis stranky
    
?>    

<form method="post">
    Zadejte heslo: <input type="password" name="pass">
    <?php if ($spatneHeslo) {
        echo "Spatne heslo";
    }
    ?>
    <input type="submit" name="prihlasit" value="Prihlasit">
</form>
<?php
} else {
?>   
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="admin.js"></script>
                
                
        <form method="post">
            <input type="submit" name="odhlasit" value="Odhlasit">
        </form>

        <div class="menu">
            <ul>
                <?php 
                    foreach ($seznamStranek as $idStranky => $stranka) {
                        echo "<li data-stranka-id='$idStranky'>
                            <a href='?stranka=$idStranky'>{$stranka->getID()}</a>
                            <a href='?stranka=$idStranky&akce=odstranit'>(odstranit)</a>
                            </li>";
                    }
                ?>
                <li><a href="?akce=pridat">Pridat</a></li>
            </ul>
        </div>

        <?php
        //zde bude formular pokud je vybrana stranka
        if ($aktualniStranka != null) {
        ?>
        <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
        <script>tinymce.init({ selector:'textarea' });</script>
        <form method="post">
            ID: <input type="text" name="id" value="<?php echo htmlspecialchars($aktualniStranka->getID()) ?>">
            <br>
            Titulek: <input type="text" name="titulek" value="<?php echo htmlspecialchars($aktualniStranka->getTitulek()) ?>">
            <br>
            Menu: <input type="text" name="menu" value="<?php echo htmlspecialchars($aktualniStranka->getMenu()) ?>">
            <br>
            
            <textarea name="obsah" cols="200" rows="35"><?php 
            echo htmlspecialchars($aktualniStranka->getObsah());
            ?></textarea><br>
            <input type="submit" value="Ulozit">
        </form>

<?php
    }
}