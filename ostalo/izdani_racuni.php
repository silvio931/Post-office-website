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
    $primatelj = $_GET['primateljID'];
    $datum = $_GET['datum'];
    $noviDatum = date("Y-m-d H:i:s", strtotime($datum));  
    
    $veza = new Baza();
    $veza->spojiDB();

    $upit = "UPDATE korisnik SET vrsta_statusa_id = 3, blokiran_do = '$noviDatum' WHERE korisnik_id = $primatelj";

    $rezultat = $veza->updateDB($upit);

    $veza->zatvoriDB();
}
?>

<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Izdani računi</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Silvio Mihalic">
        <meta name="keywords" content="FOI, WebDiP, izdani računi, pošta">
        <meta name="description" content="Stranica izdani računi za moderatora, 4.6.2020.">
        <link rel="stylesheet" href="../css/smihalic.css" type="text/css"/>
        <link href="../css/smihalic_prilagodbe.css" rel="stylesheet" type="text/css"/>
        <link href="../css/smihalic_ispis.css" rel="stylesheet" type="text/css" media="print"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../javascript/izdani_racuni_jquery.js"></script>

    </head>
    <body>
        <header style="width: 100%;text-align: right;">
            <nav>
                <?php
                include '../meni.php';
                ?>
                <a href = "../index.php"><img class = "logo" style="width:45px;margin-left: 25px" id = "slikaf1" src = "../multimedija/logo.png" alt = "f1 pozadina" /></a>
                <h2 class="naslovStranice" style="margin-left: -5px">Izdani računi</h2>                

            </nav>
            <form method="post" name="form1" action="http://barka.foi.hr/WebDiP/2019/materijali/zadace/ispis_forme.php">
                <input type="text" id='trazilica' name='trazi' placeholder="Traži" class="trazilica">
                <input type="image" style="width:1.4%; padding-right: 10px" src="../multimedija/search.PNG" alt="Submit">
            </form>
        </header>
        <br><br>

        <div style="font-size:15px;font-family: arial;">
            <table class="tablica1" id="tablica1" style="font-weight: bold;">
                <caption style="font-size: 20px">Izdani računi</caption>
                <thead>
                    <tr id="zaglavljetablice">
                        <th>Račun ID</th>
                        <th>Primatelj ID</th>
                        <th>Primatelj</th>
                        <th>Datum izdavanja</th>
                        <th>Jedinična cijena(kn)</th>
                        <th>Težina(kg)</th>
                        <th>Iznos obrade(kn)</th>
                        <th>Ukupna cijena(kn)</th>
                        <th>Datum plaćanja</th>
                        <th>Slika</th>
                        <th>Slika javna</th>
                        <th>Detalji</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal">

                </tbody>
            </table>

        </div>
        <br><br>

        <div id="blokiranjeKorisnika" style="width: 55%;font-family: arial;margin-right:350px">
            <h2>Detalji</h2>
            <form method="get" name="form1" action="izdani_racuni.php">
                <label for="racun">ID računa: </label>
                <input type="text" id="racunID" name="racunID" required="required" readonly=""><br><br>
                <label for="primateljID">ID primatelja: </label>
                <input type="text" id="primateljID" name="primateljID" required="required" readonly=""><br><br>
                <label for="primatelj">Primatelj: </label>
                <input type="text" id="primatelj" name="primatelj"  placeholder="primatelj" required="required" readonly=""><br><br>
                <label for="dani">Račun nije plaćen: </label>
                <input type="text" id="dani" name="dani" required="required" readonly="">
                <label for="dani">dana</label><br><br>
                <label for="datum">Blokiraj do: </label>
                <input type="datetime-local" id="datum" name="datum" required="required" /><br><br>
                <input type="submit" name="submit" id="submit" value="Blokiraj korisnika">
            </form> 
        </div>
        <br><br>

    </body>
</html>
