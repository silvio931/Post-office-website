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
    $korisnikID = $_GET['korisnikID'];
    $datum = $_GET['datum'];
    $noviDatum = date("Y-m-d H:i:s", strtotime($datum));

    $veza = new Baza();
    $veza->spojiDB();

    $upit = "UPDATE korisnik SET vrsta_statusa_id = 3, blokiran_do = '$noviDatum' WHERE korisnik_id = $korisnikID";

    $rezultat = $veza->updateDB($upit);

    $veza->zatvoriDB();
}

if (isset($_GET['submitAzuriraj'])) {
    $korisnikID = $_GET['korisnikID2'];
    $uloga = $_GET['uloga'];
    $status = $_GET['status'];
    $ime = $_GET['ime'];
    $prezime = $_GET['prezime'];
    $korime = $_GET['korime'];
    $lozinka = $_GET['lozinka'];
    $email = $_GET['email'];

    $salt = sha1(time());
    $lozinkaSHA1 = sha1($salt . '--' . $lozinka);

    $veza = new Baza();
    $veza->spojiDB();

    $upit = "UPDATE korisnik SET uloga_id = $uloga, vrsta_statusa_id = $status, ime = '$ime', prezime = '$prezime', korisnicko_ime = '$korime', email = '$email', lozinka = '$lozinka', lozinka_sha1 = '$lozinkaSHA1', salt = '$salt' WHERE korisnik_id = $korisnikID";

    $rezultat = $veza->updateDB($upit);

    $veza->zatvoriDB();
}
?>

<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Korisnici</title>
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
        <script type="text/javascript" src="../javascript/blokiranje_otkljucavanje_racuna_jquery.js"></script>

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
            <table class="display compact nowrap" id="tablica1" style="font-weight: bold;">
                <caption style="font-size: 20px">Korisnici</caption>
                <thead>
                    <tr id="zaglavljetablice">
                        <th>Korisnik ID</th>
                        <th>Uoga</th>
                        <th>Status</th>                       
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>Korisničko ime</th>
                        <th>Lozinka</th>
                        <th>Email</th>
                        <th>Blokiran do</th>
                        <th>Blokiraj/otključaj</th>
                        <th>Ažuriraj</th>
                        <th>Obriši</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal">

                </tbody>
            </table>

        </div>
        <br><br>

        <div id="blokirajRacun" style="width: 55%;font-family: arial;margin-left:-140px">
            <h2 id="naslovBlokiraj">Blokiraj račun</h2>
            <form method="get" name="form1" action="blokiranje_otkljucavanje_racuna.php">
                <label for="korisnikID">Korisnik ID: </label>
                <input type="text" id="korisnikID" name="korisnikID" required="required" readonly=""><br><br>
                <label for="imePrezime">Ime i prezime: </label>
                <input type="text" id="imePrezime" name="imePrezime" required="required" readonly=""><br><br>
                <label for="datum">Blokiraj do: </label>
                <input type="datetime-local" id="datum" name="datum" required="required" /><br><br>
                <input type="submit" name="submit" id="submit" value="Blokiraj">
            </form> 
        </div>

        <div id="azurirajKorisnika" style="width: 55%;font-family: arial;margin-right:100px">
            <h2 id="naslovAzuriraj">Ažuriraj korisnika</h2>
            <form method="get" name="form1" action="blokiranje_otkljucavanje_racuna.php">
                <label for="korisnikID2">Korisnik ID: </label>
                <input type="text" id="korisnikID2" name="korisnikID2" required="required" readonly=""><br><br>

                <label for="uloga">Uloga: </label>
                <select name="uloga" id="uloga">

                </select><br><br>
                <label for="status">Status: </label>
                <select name="status" id="status">

                </select><br><br>

                <label for="ime">Ime: </label>
                <input type="text" id="ime" name="ime" required="required"><br><br>
                <label for="prezime">Prezime: </label>
                <input type="text" id="prezime" name="prezime" required="required"><br><br>
                <label for="korime">Korisničko ime: </label>
                <input type="text" id="korime" name="korime" required="required"><br><br>
                <label for="lozinka">Lozinka: </label>
                <input type="text" id="lozinka" name="lozinka" required="required"><br><br>
                <label for="email">Email: </label>
                <input type="text" id="email" name="email" required="required"><br><br>

                <input type="submit" name="submitAzuriraj" id="submitAzuriraj" value="Spremi">

            </form> 
        </div>
        <br><br>

    </body>
</html>
