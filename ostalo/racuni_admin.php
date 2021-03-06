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
    $racunID = $_GET['racunID'];
    $izdao = $_GET['izdao'];
    $primatelj = $_GET['primatelj'];
    $datumIzdavanja = $_GET['datumIzdavanja'];
    $cijena_kg = $_GET['cijena_kg'];
    $tezina = $_GET['tezina'];
    $obrada = $_GET['obrada'];
    $datum = $_GET['datum'];
    $putanja_slike = $_GET['putanja'];
    $javna = $_GET['javna'];
    $ukupna_cijena = $cijena_kg * $tezina + $obrada;

    $veza = new Baza();
    $veza->spojiDB();

    if ($javna === 'Da') {
        $upit = "UPDATE račun SET izdao = $izdao, primatelj_id = $primatelj, datum_izdavanja = " . ($datumIzdavanja == NULL ? "NULL" : "'$datumIzdavanja'") . ", jedinična_cijena = $cijena_kg, težina_kg = $tezina, iznos_obrade = $obrada, ukupna_cijena = $ukupna_cijena, datum_plaćanja = " . ($datum == NULL ? "NULL" : "'$datum'") . ", putanja_slike = '$putanja_slike', slika_javna = 1 WHERE račun_id = $racunID";
        $rezultat = $veza->updateDB($upit);
    }
    if ($javna === 'Ne') {
        $upit = "UPDATE račun SET izdao = $izdao, primatelj_id = $primatelj, datum_izdavanja = " . ($datumIzdavanja == NULL ? "NULL" : "'$datumIzdavanja'") . ", jedinična_cijena = $cijena_kg, težina_kg = $tezina, iznos_obrade = $obrada, ukupna_cijena = $ukupna_cijena, datum_plaćanja = " . ($datum == NULL ? "NULL" : "'$datum'") . ", putanja_slike = '$putanja_slike', slika_javna = 0 WHERE račun_id = $racunID";
        $rezultat = $veza->updateDB($upit);
    }
    if ($javna !== 'Da' && $javna !== 'Ne') {
        echo 'Greška kod unosa - slika javna.';
    }

    $veza->zatvoriDB();
}
?>

<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Računi</title>
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
        <script type="text/javascript" src="../javascript/racuni_admin_jquery.js"></script>

    </head>
    <body>
        <header style="width: 100%;text-align: right;">
            <nav>
                <?php
                include '../meni.php';
                ?>
                <a href = "../index.php"><img class = "logo" style="width:45px;margin-left: 25px" id = "slikaf1" src = "../multimedija/logo.png" alt = "f1 pozadina" /></a>
                <h2 class="naslovStranice" style="margin-left: -5px">Računi</h2>                

            </nav>
            <form method="post" name="form1" action="http://barka.foi.hr/WebDiP/2019/materijali/zadace/ispis_forme.php">
                <input type="text" id='trazilica' name='trazi' placeholder="Traži" class="trazilica">
                <input type="image" style="width:1.4%; padding-right: 10px" src="../multimedija/search.PNG" alt="Submit">
            </form>
        </header>
        <br><br>

        <div style="font-size:15px;font-family: arial;">
            <table class="display compact " id="tablica1" style="font-weight: bold;">
                <caption style="font-size: 20px">Računi</caption>
                <thead>
                    <tr id="zaglavljetablice">
                        <th>ID</th>
                        <th>Izdao</th>
                        <th>Primatelj</th>   
                        <th>Datum izdavanja</th>
                        <th>Cijena</th>
                        <th>Težina</th>
                        <th>Obrada</th>
                        <th>Ukupna cijena</th>
                        <th>Datum plaćanja</th>
                        <th>Putanja slike</th>
                        <th>Slika</th>
                        <th>Slika javna</th>
                        <th>Ažuriraj</th>
                        <th>Obriši</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal">

                </tbody>
            </table>

        </div>
        <br><br>

        <div id="azurirajRacun" style="width: 55%;font-family: arial;margin-right:100px">
            <h2 id="naslovAzuriraj">Ažuriraj račun</h2>
            <form method="get" name="form1" action="racuni_admin.php">
                <label for="racunID">Račun ID: </label>
                <input type="text" id="racunID" name="racunID" required="required" readonly=""><br><br>

                <label for="izdao">Izdao: </label>
                <select name="izdao" id="izdao">

                </select><br><br>

                <label for="primatelj">Primatelj: </label>
                <select name="primatelj" id="primatelj">

                </select><br><br>

                <label for="datumIzdavanja">Datum izdavanja: </label>
                <input type="datetime-local" id="datumIzdavanja" name="datumIzdavanja"/><br><br>
                <label for="cijena_kg">Cijena(kg): </label>
                <input type="number" id="cijena_kg" placeholder="1.00" step="0.01" min="0" name="cijena_kg" required="required"><br><br>
                <label for="tezina">Težina: </label>
                <input type="number" id="tezina" placeholder="1.0" step="0.1" min="0" name="tezina" required="required"><br><br>
                <label for="obrada">Iznos obrade: </label>
                <input type="number" id="obrada" placeholder="1.00" step="0.01" min="0" name="obrada" required="required"><br><br>
                <label for="datum">Datum plaćanja: </label>
                <input type="datetime-local" id="datum" name="datum"/><br><br>
                <label for="putanja">Putanja slike: </label>
                <input type="text" id="putanja" name="putanja"><br><br>
                <label for="javna">Slika javna: </label>
                <input type="text" id="javna" name="javna"><br><br>
                <input type="submit" name="submitAzuriraj" id="submitAzuriraj" value="Spremi">

            </form> 
        </div>
        <br><br>

    </body>
</html>
