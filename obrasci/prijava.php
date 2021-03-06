<?php
if (!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on") {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit;
}

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

if (isset($_GET['submit'])) {
    $poruka = "";
    foreach ($_GET as $k => $v) {
        if (empty($v)) {
            $poruka = "Neuspješna prijava, pokušajte ponovo!";
        }
    }
    if (empty($poruka)) {
        $veza = new Baza();
        $veza->spojiDB();

        $korime = $_GET['korime'];
        $lozinka = $_GET['lozinka'];

        $upit = "SELECT * FROM korisnik WHERE "
                . "korisnicko_ime='{$korime}' "
                . "AND lozinka='{$lozinka}'"
                . "AND vrsta_statusa_id = 2 || (vrsta_statusa_id = 3 AND (blokiran_do IS NOT NULL AND blokiran_do < now()));";
        $rezultat = $veza->selectDB($upit);

        $autenticiran = false;
        while ($red = mysqli_fetch_array($rezultat)) {
            if ($red) {
                if (sha1($red["salt"] . '--' . $lozinka) === $red["lozinka_sha1"]) {
                    $autenticiran = true;
                    setcookie("ID", $red['korisnik_id'], false, '/', false);
                    $email = $red["email"];
                    $tip = $red["uloga_id"];
                }
            }
        }
        if ($autenticiran) {
            if (isset($_GET['zapamti'])) {
                setcookie("korisnickoIme", $korime, false, '/', false);
            }

            $upit2 = "SELECT * FROM korisnik WHERE korisnicko_ime = '$korime'";
            $rezultat2 = $veza->selectDB($upit2);
            $podaci = mysqli_fetch_assoc($rezultat2);
            $broj_neuspjela_prijava = $podaci['broj_neuspjela_prijava'];
            if ($broj_neuspjela_prijava === '1' || $broj_neuspjela_prijava === '2') {
                $upit3 = "UPDATE korisnik SET broj_neuspjela_prijava = 0 WHERE korisnicko_ime = '$korime'";
                $rezultat3 = $veza->updateDB($upit3);
            }

            Sesija::kreirajKorisnika($korime, $tip);
            header("Location: $putanja/index.php");
            exit();
        } else {
            $poruka = "Neuspješna prijava, pokušajte ponovo!";

            $upit2 = "SELECT * FROM korisnik WHERE korisnicko_ime = '$korime'";
            $rezultat2 = $veza->selectDB($upit2);
            $podaci = mysqli_fetch_assoc($rezultat2);
            $broj_neuspjela_prijava = $podaci['broj_neuspjela_prijava'];

            if ($broj_neuspjela_prijava >= 2) {
                $upit3 = "UPDATE korisnik SET vrsta_statusa_id = 3, broj_neuspjela_prijava = 0 WHERE korisnicko_ime = '$korime'";
                $rezultat3 = $veza->updateDB($upit3);
            }

            if ($broj_neuspjela_prijava < 2) {
                $broj_neuspjela_prijava = $broj_neuspjela_prijava + 1;
                $upit3 = "UPDATE korisnik SET broj_neuspjela_prijava = $broj_neuspjela_prijava WHERE korisnicko_ime = '$korime'";
                $rezultat3 = $veza->updateDB($upit3);
            }
        }
    }
    //$veza->zatvoriDB();
}
?>

<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Prijava</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Silvio Mihalic">
        <meta name="keywords" content="FOI, WebDiP, prijava, F1">
        <meta name="description" content="Stranica za prijavu za zadacu 1, 10.3.2020.">
        <link rel="stylesheet" href="../css/smihalic.css" type="text/css"/>
        <link href="../css/smihalic_prilagodbe.css" rel="stylesheet" type="text/css"/>
        <link href="../css/smihalic_ispis.css" rel="stylesheet" type="text/css" media="print"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../javascript/prijava_jquery.js"></script>

    </head>
    <body>
        <header style="width: 100%;text-align: right;">
            <nav>
                <?php
                include '../meni.php';
                ?>
                <a href = "../index.php"><img class = "logo" style="width:45px;margin-left: 25px" id = "slikaf1" src = "../multimedija/logo.png" alt = "f1 pozadina" /></a>
                <h2 class="naslovStranice" style="margin-left: -5px">Prijavi se</h2>        


            </nav>
            <form method="post" name="form1" action="http://barka.foi.hr/WebDiP/2019/materijali/zadace/ispis_forme.php">
                <input type="text" id='trazilica' name='trazi' placeholder="Traži" class="trazilica">
                <input type="image" style="width:1.4%; padding-right: 10px" src="../multimedija/search.PNG" alt="Submit">
            </form>
        </header>

        <main id="pozadina">
            <h1>Prijavi se</h1>
            <form novalidate method="get" name="form1" action="prijava.php">

                <p class="prijava" id="prijavaForma">
                    <label for="korime">Korisničko ime: </label>
                    <input type="text" id="korime" name="korime" placeholder="korisničko ime" autofocus="autofocus" required="required"><br>
                    <label for="lozinka">Lozinka: </label>
                    <input type="password" id="lozinka" name="lozinka" placeholder="lozinka" required="required"><br>
                    <a href = "zaboravljena_lozinka.php" style="font-family:Arial;text-decoration: none;color:black;">Zaboravljena lozinka?</a><br>
                    <input type="checkbox" name="zapamti" id="zapamti" value="1"> Upamti korisničko ime<br>
                    <input type="submit" name="submit" id="submit" value=" Prijavi se ">
                    <input type="reset" name="reset" id="reset" value=" Inicijaliziraj "> 
                </p>



                <div id="poruka" style="font-family: arial;color:red">
                    <?php
                    if (isset($poruka)) {
                        echo $poruka;
                    }
                    ?>
                </div>
            </form>

        </main>


    </body>
</html>
