<?php
$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

if (!isset($_SESSION["uloga"])) {
    header("Location: ../obrasci/prijava.php");
    exit();
} elseif (isset($_SESSION["uloga"]) && $_SESSION["uloga"] === "4") {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['submit'])) {
    $posiljateljID = "";

    if (isset($_COOKIE["ID"])) {
        $posiljateljID = $_COOKIE["ID"];
    }

    $veza = new Baza();
    $veza->spojiDB();

    $id = $_GET['primatelj'];

    $upit = "SELECT * FROM korisnik WHERE "
            . "korisnik_id={$id}";
    $rezultat = $veza->selectDB($upit);

    $num_rows = mysqli_num_rows($rezultat);



    if ($num_rows === 0) {
        header('location:posiljke.php?status=fail');
    } else {
        $veza2 = new Baza();
        $veza2->spojiDB();

        $primateljID = $_GET['primatelj'];
        $tezina = $_GET['tezina'];

        $upit2 = "INSERT INTO pošiljka (pošiljka_id, pošiljatelj, primatelj, datum_kreiranja, težina_kg) VALUES (DEFAULT, $posiljateljID, $primateljID, now(), $tezina)";
        $rezultat2 = $veza2->updateDB($upit2);
        $veza2->zatvoriDB();
        header('location:posiljke.php?status=success');
    }
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
        <meta name="keywords" content="FOI, WebDiP, pošiljke, pošta">
        <meta name="description" content="Stranica pošijlke, 28.5.2020.">
        <link rel="stylesheet" href="../css/smihalic.css" type="text/css"/>
        <link href="../css/smihalic_prilagodbe.css" rel="stylesheet" type="text/css"/>
        <link href="../css/smihalic_ispis.css" rel="stylesheet" type="text/css" media="print"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../javascript/posiljke_korisnici_jquery.js"></script>

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
        <div>   

            <a href = "posiljke_u_dolasku.php"><img src="../multimedija/dolaznePoruke.png" style="width:100px;"></a>
            <a href = "posiljke_u_dolasku.php" style="position:relative; right:110px;top:30px;font-family:Arial;text-decoration: none;color:black;">Pošiljke u dolasku</a>
            <a href = "poslane_posiljke.php"><img src="../multimedija/odlaznePoruke.png" style="width:100px;"></a>
            <a href = "poslane_posiljke.php" style="position:relative; right:110px;top:30px;font-family:Arial;text-decoration: none;color:black">Poslane pošiljke</a>
            <a href = "moji_racuni.php"><img src="../multimedija/racuni.jpg" style="width:100px;"></a>
            <a href = "moji_racuni.php" style="position:relative; right:90px;top:30px;font-family:Arial;text-decoration: none;color:black">Moji računi</a>

        </div>
        <br><br>
        <div style="margin-right: 920px; margin-top: 30px; font-family: arial">
            <h2>Kreiraj novu pošiljku</h2>
            <form method="get" name="form1" action="posiljke.php">
                <label for="tezina">Težina (kg): </label>
                <input type="number" id="tezina" name="tezina" placeholder="1.0" step="0.1" min="0" required="required"><br><br>
                <label for="primatelj">ID primatelja: </label>
                <input type="number" id="primatelj" name="primatelj" placeholder="id primatelja" required="required"><br><br>
                <input type="submit" name="submit" id="submit" value="Kreiraj pošiljku">
                <br><br>
                <?php
                if (isset($_GET['status']) && $_GET['status'] == 'success') {
                    echo '<span>Pošiljka kreirana!</span>';
                }
                if (isset($_GET['status']) && $_GET['status'] == 'fail') {
                    echo '<span>Ne postoji korisnik koji ima ovaj ID.</span>';
                }
                ?>
            </form>            
        </div>
        <div style="margin-right:-700px;margin-top: -300px">
            <form method="get" name="form2" action="posiljke.php">
                <div>
                    <input type="button" name="submitKorisnici" id="submitKorisnici" value="Prikaži korisnike">
                </div>
            </form>
        </div>
        <div style="font-size:15px;font-family: arial;margin-top:-200px;">
            <table class="display compact nowrap" id="tablica1" style="font-weight: bold;margin-top: -90px;">
                <caption style="font-size: 20px">Korisnici</caption>
                <thead>
                    <tr id="zaglavljetablice">
                        <th>ID korisnika</th>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>Korisničko ime</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal">

                </tbody>
            </table>

        </div>


    </body>
</html>
