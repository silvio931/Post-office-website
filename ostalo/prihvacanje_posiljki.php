<?php
$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

if (!isset($_SESSION["uloga"])) {
    header("Location: ../obrasci/prijava.php");
    exit();
} elseif (isset($_SESSION["uloga"]) && $_SESSION["uloga"] > 1) {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['submit'])) {

    $posiljkaID = $_GET['posiljkaID'];
    $cijena = $_GET['cijena'];
    $pocetniUredID = $_GET['pocetniUredID'];
    $sljedeciUredID = $_GET['sljedeciUredID'];
    $zavrsniUredID = $_GET['zavrsniUredID'];

    $veza = new Baza();
    $veza->spojiDB();

    $upit = "UPDATE pošiljka SET početni_ured_id = $pocetniUredID, trenutni_ured_id = $pocetniUredID, sljedeći_ured_id = $sljedeciUredID, završni_ured_id = $zavrsniUredID, datum_otpreme = now(), cijena_kg = $cijena WHERE pošiljka_id = $posiljkaID";

    $rezultat = $veza->updateDB($upit);

    $veza->zatvoriDB();
}

?>

<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Prihvaćanje pošiljki</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Silvio Mihalic">
        <meta name="keywords" content="FOI, WebDiP, prihvacanje pošiljki, pošta">
        <meta name="description" content="Stranica za prihvacanje pošiljki za admina, 7.6.2020.">
        <link rel="stylesheet" href="../css/smihalic.css" type="text/css"/>
        <link href="../css/smihalic_prilagodbe.css" rel="stylesheet" type="text/css"/>
        <link href="../css/smihalic_ispis.css" rel="stylesheet" type="text/css" media="print"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../javascript/prihvacanje_posiljki_jquery.js"></script>

    </head>
    <body>
        <header style="width: 100%;text-align: right;">
            <nav>
                <?php
                include '../meni.php';
                ?>
                <a href = "../index.php"><img class = "logo" style="width:45px;margin-left: 25px" id = "slikaf1" src = "../multimedija/logo.png" alt = "f1 pozadina" /></a>
                <h2 class="naslovStranice" style="margin-left: -5px">Prihvaćanje pošiljki</h2>                

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
                        <th>Pošiljatelj</th>
                        <th>Primatelj</th>
                        <th>Datum kreitanja</th>
                        <th>Težina</th>
                        <th>Prihvati pošiljku</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal">

                </tbody>
            </table>

        </div>
        <br><br>

        <div id="prihvatiPosiljku" style="width: 55%;font-family: arial;margin-left:200px">
            <h2>Postavi sljedeći ured</h2>
            <form method="get" name="form1" action="prihvacanje_posiljki.php">
                <label for="posiljka">Pošiljka ID: </label>
                <input type="text" id="posiljkaID" name="posiljkaID" required="required" readonly=""><br><br>
                <label for="cijena">Cijena po kilogramu: </label>
                <input type="number" id="cijena" name="cijena" placeholder="1.00" step="0.01" min="0" required="required" ><br><br>
                <label for="pocetni">Početni ured: </label>
                <input type="text" id="pocetni" name="pocetni" required="required" >
                <label for="pocetniUred">ID: </label>
                <input type="text" id="pocetniUredID" name="pocetniUredID" required="required" readonly=""><br><br>
                <label for="sljedeci">Sljedeći ured: </label>
                <input type="text" id="sljedeci" name="sljedeci" required="required" >
                <label for="sljedeciUred">ID: </label>
                <input type="text" id="sljedeciUredID" name="sljedeciUredID" required="required" readonly=""><br><br>
                <label for="zavrsni">Završni ured: </label>
                <input type="text" id="zavrsni" name="zavrsni" required="required" >
                <label for="sljedeciUred">ID: </label>
                <input type="text" id="zavrsniUredID" name="zavrsniUredID" required="required" readonly=""><br><br>
                <input type="submit" name="submit" id="submit" value="Spremi">

            </form> 
        </div>
        <br><br>


    </body>
</html>
