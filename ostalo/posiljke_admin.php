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

if (isset($_GET['submitAzuriraj'])) {
    $posiljkaID = $_GET['posiljkaID'];

    if (($_GET['pocetniUredID']) == "" || ($_GET['pocetniUredID']) == "Ne postoji ovaj ured!") {
        $pocetniUredID = 'NULL';
    } else {
        $pocetniUredID = $_GET['pocetniUredID'];
    }

    if (($_GET['trenutniUredID']) == "" || ($_GET['trenutniUredID']) == "Ne postoji ovaj ured!") {
        $trenutniUredID = 'NULL';
    } else {
        $trenutniUredID = $_GET['trenutniUredID'];
    }

    if (($_GET['sljedeciUredID']) == "" || ($_GET['sljedeciUredID']) == "Ne postoji ovaj ured!") {
        $sljedeciUredID = 'NULL';
    } else {
        $sljedeciUredID = $_GET['sljedeciUredID'];
    }

    if (($_GET['zavrsniUredID']) == "" || ($_GET['zavrsniUredID']) == "Ne postoji ovaj ured!") {
        $zavrsniUredID = 'NULL';
    } else {
        $zavrsniUredID = $_GET['zavrsniUredID'];
    }

    $posiljatelj = $_GET['posiljatelj'];
    $primatelj = $_GET['primatelj'];

    $datumOtpreme = $_GET['datumOtpreme'];


    if (($_GET['cijena']) == "") {
        $cijena = 'NULL';
    } else {
        $cijena = $_GET['cijena'];
    }

    $tezina = $_GET['tezina'];

    $datumPristizanja = $_GET['datumPristizanja'];

    if (($_GET['racun']) == "") {
        $racun = 'NULL';
    } else {
        $racun = $_GET['racun'];
    }

    $veza = new Baza();
    $veza->spojiDB();

    $upit = "UPDATE pošiljka SET početni_ured_id = $pocetniUredID, trenutni_ured_id = $trenutniUredID, sljedeći_ured_id = $sljedeciUredID, završni_ured_id = $zavrsniUredID, pošiljatelj = $posiljatelj, primatelj = $primatelj, datum_otpreme = " . ($datumOtpreme==NULL ? "NULL" : "'$datumOtpreme'") . ", cijena_kg = $cijena, težina_kg = $tezina, datum_pristizanja = " . ($datumPristizanja==NULL ? "NULL" : "'$datumPristizanja'") . ", račun_id = $racun WHERE pošiljka_id = $posiljkaID";

    $rezultat = $veza->updateDB($upit);

    $veza->zatvoriDB();
}
?>

<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Pošiljke</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Silvio Mihalic">
        <meta name="keywords" content="FOI, WebDiP, blokiranje, otključavanje, korisnički računi, pošta">
        <meta name="description" content="Stranica za blokiranje i otključavanje računa za admina, 10.6.2020.">
        <link rel="stylesheet" href="../css/smihalic.css" type="text/css"/>
        <link href="../css/smihalic_prilagodbe.css" rel="stylesheet" type="text/css"/>
        <link href="../css/smihalic_ispis.css" rel="stylesheet" type="text/css" media="print"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../javascript/posiljke_admin_jquery.js"></script>

    </head>
    <body>
        <header style="width: 100%;text-align: right;">
            <nav>
                <?php
                include '../meni.php';
                ?>
                <a href = "../index.php"><img class = "logo" style="width:45px;margin-left: 25px" id = "slikaf1" src = "../multimedija/logo.png" alt = "f1 pozadina" /></a>
                <h2 class="naslovStranice" style="margin-left: -5px">Pošiljke</h2>                

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
                        <th>ID</th>
                        <th>Početni ured</th>
                        <th>Trenutni</th>                       
                        <th>Sljedeći</th>
                        <th>Završni</th>
                        <th>Pošiljatelj</th>
                        <th>Primatelj</th>
                        <th>Datum otpreme</th>
                        <th>Cijena</th>
                        <th>Težina</th>
                        <th>Datum pristizanja</th>
                        <th>Račun ID</th>
                        <th>Ažuriraj</th>
                        <th>Obriši</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal">

                </tbody>
            </table>

        </div>
        <br><br>

        <div id="azurirajPosiljku" style="width: 55%;font-family: arial;margin-right:100px">
            <h2 id="naslovAzuriraj">Ažuriraj pošiljku</h2>
            <form method="get" name="form1" action="posiljke_admin.php">
                <label for="posiljkaID">Pošiljka ID: </label>
                <input type="text" id="posiljkaID" name="posiljkaID" required="required" readonly=""><br><br>

                <label for="pocetni">Početni ured:  </label>
                <input type="text" id="pocetni" name="pocetni" >
                <label for="pocetniUred">ID: </label>
                <input type="text" id="pocetniUredID" name="pocetniUredID" readonly=""><br><br>
                <label for="sljedeci">Sljedeći ured: </label>
                <input type="text" id="sljedeci" name="sljedeci">
                <label for="sljedeciUred">ID: </label>
                <input type="text" id="sljedeciUredID" name="sljedeciUredID" readonly=""><br><br>
                <label for="trenutni">Trenutni ured: </label>
                <input type="text" id="trenutni" name="trenutni">
                <label for="trenutniUred">ID: </label>
                <input type="text" id="trenutniUredID" name="trenutniUredID" readonly=""><br><br>
                <label for="zavrsni">Završni ured:  </label>
                <input type="text" id="zavrsni" name="zavrsni">
                <label for="sljedeciUred">ID: </label>
                <input type="text" id="zavrsniUredID" name="zavrsniUredID" readonly=""><br><br>

                <label for="posiljatelj">Pošiljatej: </label>
                <select name="posiljatelj" id="posiljatelj">

                </select><br><br>

                <label for="primatelj">Primatelj: </label>
                <select name="primatelj" id="primatelj">

                </select><br><br>

                <label for="datumOtpreme">Datum otpreme: </label>
                <input type="datetime-local" id="datumOtpreme" name="datumOtpreme"/><br><br>

                <label for="cijena">Cijena(kg): </label>
                <input type="number" id="cijena" placeholder="1.00" step="0.01" min="0" name="cijena"><br><br>
                <label for="tezina">Težina(kg): </label>
                <input type="number" id="tezina" placeholder="1.0" step="0.1" min="0" name="tezina"><br><br>

                <label for="datumPristizanja">Datum pristizanja: </label>
                <input type="datetime-local" id="datumPristizanja" name="datumPristizanja"/><br><br>

                <label for="racun">Račun ID: </label>
                <input type="number" id="racun" name="racun"><br><br>

                <input type="submit" name="submitAzuriraj" id="submitAzuriraj" value="Spremi">

            </form> 
        </div>
        <br><br>


    </body>
</html>
