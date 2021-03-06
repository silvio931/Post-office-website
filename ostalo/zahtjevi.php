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

if (isset($_GET['submit'])) {

    $izdao = $_COOKIE["ID"];
    $korisnik = $_GET['korisnikID'];
    $jedCijena = $_GET['jedCijena'];
    $tezina = $_GET['tezina'];
    $obrada = $_GET['obrada'];
    $ukupna_cijena = $jedCijena * $tezina + $obrada;
    $posiljkaID = $_GET['posiljkaID'];

    $veza = new Baza();
    $veza->spojiDB();

    $unesiRacun = "INSERT INTO račun (račun_id, izdao, primatelj_id, datum_izdavanja, jedinična_cijena, težina_kg, iznos_obrade, ukupna_cijena, datum_plaćanja, putanja_slike, slika_javna) VALUES (DEFAULT, $izdao, $korisnik, now(), $jedCijena, $tezina, $obrada, $ukupna_cijena, null, null, 0)";
    $rezultatUnesiRacun = $veza->updateDB($unesiRacun);
    
    $azurirajZahtjev = "UPDATE zahtjevi_izdavanje_računa SET račun_izdan = 1 WHERE pošiljka_id = $posiljkaID";
    $rezultatAzurirajZahtjev = $veza->updateDB($azurirajZahtjev);

    $dohvatiID = "SELECT račun_id as id from račun WHERE izdao = $izdao AND primatelj_id = $korisnik AND jedinična_cijena = $jedCijena AND težina_kg = $tezina AND iznos_obrade = $obrada AND ukupna_cijena = $ukupna_cijena";
    $rezultatDohvatiID = $veza->selectDB($dohvatiID);
    while ($red = mysqli_fetch_array($rezultatDohvatiID)) {
        $zadnjiID = $red['id'];
    }
    
    $azurirajPosiljku = "UPDATE pošiljka SET račun_id = $zadnjiID WHERE pošiljka_id = $posiljkaID";
    $rezultatAzurirajPosiljku = $veza->updateDB($azurirajPosiljku);
    
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
        <meta name="keywords" content="FOI, WebDiP, zahtjevi za izdavanjem računa, pošta">
        <meta name="description" content="Stranica zahtjevi za izdavanjem računa za moderatora, 5.6.2020.">
        <link rel="stylesheet" href="../css/smihalic.css" type="text/css"/>
        <link href="../css/smihalic_prilagodbe.css" rel="stylesheet" type="text/css"/>
        <link href="../css/smihalic_ispis.css" rel="stylesheet" type="text/css" media="print"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../javascript/zahtjevi_jquery.js"></script>

    </head>
    <body>
        <header style="width: 100%;text-align: right;">
            <nav>
                <?php
                include '../meni.php';
                ?>
                <a href = "../index.php"><img class = "logo" style="width:45px;margin-left: 25px" id = "slikaf1" src = "../multimedija/logo.png" alt = "f1 pozadina" /></a>
                <h2 class="naslovStranice" style="margin-left: -5px">Zahtjevi za izdavanje računa</h2>                

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
                        <th>Korisnik ID</th>
                        <th>Korisnik</th>
                        <th>Pošiljka ID</th>
                        <th>Ured</th>
                        <th>Datum izdavanja zahtjeva</th>
                        <th>Račun izdan</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal">

                </tbody>
            </table>

        </div>
        <br><br>

        <div id="izdajRacun" style="width: 55%;font-family: arial;margin-right:350px">
            <h2>Izdavanje računa</h2>
            <form method="get" name="form1" action="zahtjevi.php">
                <label for="korisnik">Korisnik ID: </label>
                <input type="text" id="korisnikID" name="korisnikID" required="required" readonly=""><br><br>
                <label for="posiljka">Pošiljka ID: </label>
                <input type="text" id="posiljkaID" name="posiljkaID" required="required" readonly=""><br><br>
                <label for="jedCijena">Jedinična cijena(kn): </label>
                <input type="number" id="jedCijena" name="jedCijena" placeholder="1.00" step="0.01" min="0" required="required" readonly=""><br><br>
                <label for="tezina">Težina(kg): </label>
                <input type="number" id="tezina" name="tezina" placeholder="1.0" step="0.1" min="0" required="required" readonly=""><br><br>
                <label for="obrada">Iznos obrade: </label>
                <input type="number" id="obrada" name="obrada" placeholder="1.00" step="0.01" min="0" required="required"><br><br>
                <input type="submit" name="submit" id="submit" value="Izdaj račun">
            </form> 
        </div>
        <br><br>


    </body>
</html>
