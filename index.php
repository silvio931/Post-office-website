<?php
$putanja = dirname($_SERVER['REQUEST_URI']);
$direktorij = getcwd();
include './zaglavlje.php';
?>

<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Početna stranica</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Silvio Mihalic">
        <meta name="keywords" content="FOI, WebDiP, pocetna stranica, posta">
        <meta name="description" content="Pocetna stranica za projekt, 10.5.2020.">
        <link rel="stylesheet" href="css/smihalic_index.css" type="text/css"/>
        <link href="css/smihalic_ispis.css" rel="stylesheet" type="text/css" media="print"/>

    </head>

    <body class="resetka">
        <header class="spojiZaglavlje" style="width:100%;">   
            <nav>
                <?php
                include './meni.php';
                ?>
                <a href = "index.php"><img class = "logo" style="width:45px;margin-left: 25px;" id = "slikaf1" src = "multimedija/logo.png" alt = "f1 pozadina" /></a>

                <h2 id="naslovStranice" style="margin-left: -5px">Početna stranica</h2>

                <form style="" method="post" name="form1" action="http://barka.foi.hr/WebDiP/2019/materijali/zadace/ispis_forme.php">
                    <input type="text" id='trazilica' name='trazi' placeholder="Traži" class="trazilica">
                    <input type="image" class="slikaTrazi1" src="multimedija/search.PNG" alt="Submit">
                </form>
            </nav>
        </header>

        <div class="zaSliku" id="slika">
            <img id="slikaNaslovna" src="multimedija/naslovnica.png" alt="f1 pozadina" style="width:100%;"/>
            <img id="slikaPrilagodba" src="multimedija/pozadinaNaslovna.jpg" alt="f1 pozadina" style="width: 100%;"/>

            <div class="naslov" style="color:white;font-family: fantasy; margin-left:40px;font-size:70px">Hrvatska pošta</div>
            
            <p id="ispodnaslova" style="color:white;font-family: sans-serif; margin-left:40px;font-size:40px">Uz nas ostvarite <br> sve svoje obaveze</p>
        </div>


        <div class="autorNaslov" id="clanak" style="font-size: 22px;">
            <a href = "dokumentacija/o_autoru.html"><img src="multimedija/o_autoru.png" style="width:100px;position:relative;right:-160px;"></a>
            <a href = "dokumentacija/o_autoru.html" style="position:relative;right:-70px;top:30px;font-family:Arial;text-decoration: none;color:black;"><br><br><br>O autoru</a>
        </div>
        <div class="autorTekst" style="font-size: 22px;">
            <a href = "privatno/korisnici.php"><img src="multimedija/korisnici.png" style="width:100px;position:relative;right:-62px;bottom:-50px"></a>
            <a href = "privatno/korisnici.php" style="position:relative;right:-70px; top:10px;font-family:Arial;text-decoration: none;color:black;"><br><br><br>Korisnici</a>     
        </div>
        <div class="autorSlika" style="font-size: 22px;">
            <a href = "dokumentacija/dokumentacija.html"><img src="multimedija/dokumentacija.png" style="width:100px;"></a>
            <a href = "dokumentacija/dokumentacija.html" style="position:relative;right:115px; top:30px;font-family:Arial;text-decoration: none;color:black;"><br><br><br>Dokumentacija</a>
        </div>


        <div class="clanak1Naslov" id="clanak1" style="margin-left:100px;font-size: 22px;">
            <a href = "ostalo/posiljke.php"><img src="multimedija/odlaznePoruke.png" style="width:100px;position:relative;right:-60px;"></a>
            <a href = "ostalo/posiljke.php" style="position:relative;right:55px;top:30px;font-family:Arial;text-decoration: none;color:black;"><br><br><br>Kreiraj pošiljku</a>
        </div>
        <div class="clanak1Tekst" style="margin-left:50px;font-size: 22px;">
            <a href = "ostalo/posiljke_u_dolasku.php"><img src="multimedija/dolaznePoruke.png" style="width:100px;position:relative;right:-15px;"></a>
            <a href = "ostalo/posiljke_u_dolasku.php" style="position:relative; right:120px;top:30px;font-family:Arial;text-decoration: none;color:black;"><br><br><br>Pošiljke u dolasku</a>
        </div>
        <div class="clanak1Slika" style="font-size: 22px;">
            <a href = "ostalo/uredi.php"><img src="multimedija/popis_ureda.png" style="width:100px;"></a>
            <a href = "ostalo/uredi.php" style="position:relative; right:120px;top:30px;font-family:Arial;text-decoration: none;color:black;"><br><br><br>Poštanski uredi</a>
        </div>


        <footer class="spojiPodnozje">
            <address>Kontakt: <a style="color:#3366ff" href="mailto:smihalic@foi.hr">Silvio Mihalic</a></address>
            <p><small>&copy; 2020 S. Mihalic</small></p>
        </footer>
    </body>
</html>
