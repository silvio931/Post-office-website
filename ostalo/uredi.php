<?php
$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';
?>

<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Poštanski uredi</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Silvio Mihalic">
        <meta name="keywords" content="FOI, WebDiP, poštanski uredi, pošta">
        <meta name="description" content="Popis ureda za projekt, 23.5.2020.">
        <link rel="stylesheet" href="../css/smihalic.css" type="text/css"/>
        <link href="../css/smihalic_prilagodbe.css" rel="stylesheet" type="text/css"/>
        <link href="../css/smihalic_ispis.css" rel="stylesheet" type="text/css" media="print"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../javascript/uredi_jquery.js"></script>

    </head>
    <body>
        <header style="width: 100%;text-align: right;">
            <nav>
                <?php
                include '../meni.php';
                ?>
                <a href = "../index.php"><img class = "logo" style="width:45px;margin-left: 25px" id = "slikaf1" src = "../multimedija/logo.png" alt = "" /></a>
                <h2 class="naslovStranice" style="margin-left: -5px">Poštanski uredi</h2>                

            </nav>
            <form method="post" name="form1" action="http://barka.foi.hr/WebDiP/2019/materijali/zadace/ispis_forme.php">
                <input type="text" id='trazilica' name='trazi' placeholder="Traži" class="trazilica">
                <input type="image" style="width:1.4%; padding-right: 10px" src="../multimedija/search.PNG" alt="Submit">
            </form>
        </header>

        <br><br>
        <table class="display compact nowrap" id="tablica1" style="font-family: Arial; font-weight: bold">
            <caption style="font-size: 20px">Poštanski uredi</caption>
            <thead>
                <tr id="zaglavljetablice">
                    <th>ID poštanskog ureda</th>
                    <th>Država</th>
                    <th>Moderator</th>
                    <th>Naziv ureda</th>
                    <th>Adresa</th>
                    <th>Broj zaposlenih</th>
                    <th>Broj poslanih pošiljki</th>
                    <th>Galerija pošiljki</th>
                </tr>
            </thead>
            <tbody style="font-weight: normal">

            </tbody>
        </table>

        <br><br>

        <table class="display compact nowrap" id="tablica2" style="font-family: Arial; font-weight: bold">
            <caption style="font-size: 20px">Galerija slika</caption>
            <thead>
                <tr id="zaglavljetablice">
                    <th>ID pošiljke</th>
                    <th>ID računa</th>
                    <th>Slika</th>

                </tr>
            </thead>
            <tbody style="font-weight: normal">



            </tbody>
        </table>


    </body>
</html>
