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
    $posiljka = $_GET['posiljkaID'];
    $datum = $_GET['datum'];
    $izdan = $_GET['izdan'];

    $veza = new Baza();
    $veza->spojiDB();

    if ($izdan === 'Da') {
        $upit = "UPDATE zahtjevi_izdavanje_računa SET datum_izvadanja = '$datum', račun_izdan = 1 WHERE pošiljka_id = $posiljka";
    }
    if ($izdan === 'Ne') {
        $upit = "UPDATE zahtjevi_izdavanje_računa SET datum_izvadanja = '$datum', račun_izdan = 0 WHERE pošiljka_id = $posiljka";
    }
    $rezultat = $veza->updateDB($upit);
    $veza->zatvoriDB();
}
?>

<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Zahtjevi</title>
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
        <script type="text/javascript" src="../javascript/zahtjevi_admin_jquery.js"></script>

    </head>
    <body>
        <header style="width: 100%;text-align: right;">
            <nav>
                <?php
                include '../meni.php';
                ?>
                <a href = "../index.php"><img class = "logo" style="width:45px;margin-left: 25px" id = "slikaf1" src = "../multimedija/logo.png" alt = "f1 pozadina" /></a>
                <h2 class="naslovStranice" style="margin-left: -5px">Zahtjevi</h2>                

            </nav>
            <form method="post" name="form1" action="http://barka.foi.hr/WebDiP/2019/materijali/zadace/ispis_forme.php">
                <input type="text" id='trazilica' name='trazi' placeholder="Traži" class="trazilica">
                <input type="image" style="width:1.4%; padding-right: 10px" src="../multimedija/search.PNG" alt="Submit">
            </form>
        </header>
        <br><br>

        <div style="font-size:15px;font-family: arial;">
            <table class="display compact nowrap" id="tablica1" style="font-weight: bold;">
                <caption style="font-size: 20px">Zahtjevi za izdavanje računa</caption>
                <thead>
                    <tr id="zaglavljetablice">
                        <th>Korisnik</th>
                        <th>Pošiljka ID</th>
                        <th>Datum izdavanja</th>                       
                        <th>Račun izdan</th>
                        <th>Ažuriraj</th>
                        <th>Obriši</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal">

                </tbody>
            </table>

        </div>
        <br><br>

        <div id="azurirajZahtjev" style="font-family: arial;">
            <h2 id="naslovAzuriraj">Ažuriraj zahtjev</h2>
            <form method="get" name="form1" action="zahtjevi_admin.php">
                <label for="korisnik">Korisnik: </label>
                <input type="text" id="korisnik" name="korisnik" readonly=""><br><br>
                <label for="posiljkaID">Pošiljka ID: </label>
                <input type="text" id="posiljkaID" name="posiljkaID" readonly=""><br><br>
                <label for="datum">Datum izdavanja: </label>
                <input type="datetime-local" id="datum" name="datum"/><br><br>
                <label for="izdan">Račun izdan (Da/Ne): </label>
                <input type="text" id="izdan" name="izdan"><br><br>
                <input type="submit" name="submitAzuriraj" id="submitAzuriraj" value="Spremi">

            </form> 
        </div>
        <br><br>


    </body>
</html>
