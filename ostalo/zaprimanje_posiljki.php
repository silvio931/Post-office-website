<?php
$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

if (!isset($_SESSION["uloga"])) {
    header("Location: ../obrasci/prijava.php");
    exit();
} elseif (isset($_SESSION["uloga"]) && $_SESSION["uloga"] > 2) {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['submitSpremi'])) {

    $posiljkaID = $_GET['posiljkaID'];
    $trenutniUredId = $_GET['trenutniUredID'];
    $sljedeciUredID = $_GET['sljedeciUredID'];

    $veza = new Baza();
    $veza->spojiDB();

    $upit = "UPDATE pošiljka SET trenutni_ured_id = $trenutniUredId, sljedeći_ured_id = $sljedeciUredID WHERE pošiljka_id = $posiljkaID";

    $rezultat = $veza->updateDB($upit);

    $veza->zatvoriDB();
}

if (isset($_GET['submitIsporuka'])) {

    $posiljkaID = $_GET['posiljkaID'];
    $trenutniUredId = $_GET['trenutniUredID'];

    $veza = new Baza();
    $veza->spojiDB();

    $upit = "UPDATE pošiljka SET trenutni_ured_id = $trenutniUredId, datum_pristizanja = now() WHERE pošiljka_id = $posiljkaID";

    $rezultat = $veza->updateDB($upit);

    $veza->zatvoriDB();
}
?>

<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Zaprimanje pošiljki</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Silvio Mihalic">
        <meta name="keywords" content="FOI, WebDiP, zaprimanje pošiljki, pošta">
        <meta name="description" content="Stranica za zaprimanje pošiljki za moderatora, 6.6.2020.">
        <link rel="stylesheet" href="../css/smihalic.css" type="text/css"/>
        <link href="../css/smihalic_prilagodbe.css" rel="stylesheet" type="text/css"/>
        <link href="../css/smihalic_ispis.css" rel="stylesheet" type="text/css" media="print"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../javascript/zaprimanje_posiljki_jquery.js"></script>

    </head>
    <body>
        <header style="width: 100%;text-align: right;">
            <nav>
                <?php
                include '../meni.php';
                ?>
                <a href = "../index.php"><img class = "logo" style="width:45px;margin-left: 25px" id = "slikaf1" src = "../multimedija/logo.png" alt = "f1 pozadina" /></a>
                <h2 class="naslovStranice" style="margin-left: -5px">Zaprimanje pošiljki</h2>                

            </nav>
            <form method="post" name="form1" action="http://barka.foi.hr/WebDiP/2019/materijali/zadace/ispis_forme.php">
                <input type="text" id='trazilica' name='trazi' placeholder="Traži" class="trazilica">
                <input type="image" style="width:1.4%; padding-right: 10px" src="../multimedija/search.PNG" alt="Submit">
            </form>
        </header>
        <br><br>

        <div style="font-size:15px;font-family: arial;">
            <table class="display compact nowrap" id="tablica1" style="font-weight: bold;">
                <caption style="font-size: 20px">Pošiljke</caption>
                <thead>
                    <tr id="zaglavljetablice">
                        <th>Pošiljka ID</th>
                        <th>Početni ured</th>
                        <th>Trenutni ured</th>
                        <th>Sljedeći ured</th>
                        <th>Završni ured</th>
                        <th>Ažuriraj</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal">

                </tbody>
            </table>

        </div>
        <br><br>

        <div id="dodajSljedeciUred" style="width: 55%;font-family: arial;margin-left:200px">
            <h2>Postavi sljedeći ured</h2>
            <form method="get" name="form1" action="zaprimanje_posiljki.php">
                <label for="posiljka">Pošiljka ID: </label>
                <input type="text" id="posiljkaID" name="posiljkaID" required="required" readonly=""><br><br>
                <label for="trenutni">Trenutni ured: </label>
                <input type="text" id="trenutni" name="trenutni" required="required" readonly="">
                <label for="trenutniUred">ID: </label>
                <input type="text" id="trenutniUredID" name="trenutniUredID" required="required" readonly=""><br><br>
                <input type="submit" name="submitIsporuka" id="submitIsporuka" value="Spremna za isporuku">
                <label for="sljedeci" id="sljedecilbl">Sljedeći ured: </label>
                <input type="text" id="sljedeci" name="sljedeci" style="border-color: black">
                <label for="sljedeciUred" id="sljedeciUredlbl">ID: </label>
                <input type="text" id="sljedeciUredID" name="sljedeciUredID" required="required" readonly=""><br><br>
                <input type="submit" name="submitSpremi" id="submitSpremi" value="Spremi">

            </form> 
        </div>
        <br><br>


    </body>
</html>
