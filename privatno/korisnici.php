<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';
?>

<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Korisnici</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Silvio Mihalic">
        <meta name="keywords" content="FOI, WebDiP, korisnici, htaccess, korisnički računi, pošta">
        <meta name="description" content="Stranica za korisnike i htaccess, 10.6.2020.">
        <link rel="stylesheet" href="../css/smihalic.css" type="text/css"/>
        <link href="../css/smihalic_prilagodbe.css" rel="stylesheet" type="text/css"/>
        <link href="../css/smihalic_ispis.css" rel="stylesheet" type="text/css" media="print"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../javascript/korisnici_jquery.js"></script>

    </head>
    <body>
        <header style="width: 100%;text-align: right;">
            <nav>
                <?php
                include '../meni.php';
                ?>
                <a href = "../index.php"><img class = "logo" style="width:45px;margin-left: 25px" id = "slikaf1" src = "../multimedija/logo.png" alt = "f1 pozadina" /></a>
                <h2 class="naslovStranice" style="margin-left: -5px">Korisnici</h2>                

            </nav>
            <form method="post" name="form1" action="http://barka.foi.hr/WebDiP/2019/materijali/zadace/ispis_forme.php">
                <input type="text" id='trazilica' name='trazi' placeholder="Traži" class="trazilica">
                <input type="image" style="width:1.4%; padding-right: 10px" src="../multimedija/search.PNG" alt="Submit">
            </form>
        </header>
        <br><br>

        <div style="font-size:15px;font-family: arial;">
            <table class="tablica1" id="tablica1" style="font-weight: bold;">
                <caption style="font-size: 20px">Korisnici</caption>
                <thead>
                    <tr id="zaglavljetablice">
                        <th>Korisničko ime</th>
                        <th>Prezime</th>
                        <th>Ime</th>                       
                        <th>Email</th>
                        <th>Lozinka</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal">

                </tbody>
            </table>

        </div>
        <br><br>

        <footer style="position: absolute;">
            <a href="https://validator.w3.org/nu/?doc=http%3A%2F%2Fbarka.foi.hr%2FWebDiP%2F2019%2Fzadaca_04%2Fsmihalic%2Fostalo%2Fpopis.php"><img class="slikafooter" id="slikap" src="../multimedija/HTML5.png" alt="html" /></a>
            <a href = "http://jigsaw.w3.org/css-validator/validator?uri=http%3A%2F%2Fbarka.foi.hr%2FWebDiP%2F2019%2Fzadaca_04%2Fsmihalic%2Fostalo%2Fpopis.php&profile=css3svg&usermedium=all&warning=1&vextwarning=&lang=en"><img class = "slikafooter" id = "slikap2" src = "../multimedija/CSS3.png" alt = "css"/></a>
            <address style = "padding-left:150px">Kontakt: <a style = "color:#3366ff" href = "mailto:smihalic@foi.hr">Silvio Mihalic</a></address>
            <p style = "padding-left:150px"><small>&copy;
                    2020 S. Mihalic</small></p>
        </footer>
    </body>
</html>
