<?php
$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

//generiranje captcha koda

$slova = 'abcdefghijklmnoprstuvzxyqABCDEFGHIJKLMNOPRSTUVZXYQ0123456789';
$duljina = strlen($slova);
$captchaKod = '';
for ($i = 0; $i < 8; $i++) {
    $captchaKod .= $slova[rand(0, $duljina - 1)];
}

$_GET['capthca'] = $captchaKod;

//provjere na strani poslužitelja
//ukoliko postoji pogreška, zapisuje se u varijablu $pogreska
//ukoliko pogrešaka nema, $pogreska ostaje prazno i ono dozvoljava upis u bazu, inače upis nije dozvoljen
if (isset($_GET['submit'])) {

    $pogreska = "";

    $ime = $_GET['ime'];
    $prezime = $_GET['prezime'];
    $korime = $_GET['korime'];
    $email = $_GET['email'];
    $godina = $_GET['godina'];
    $lozinka = $_GET['lozinka'];
    $ponovljenaLozinka = $_GET['ponovljenaLozinka'];
    $captcha = $_GET['captcha'];
    $unosCaptche = $_GET['unosCaptche'];

    if ($ime === "") {
        $pogreska .= "Ime ne smije biti prazno.<br>";
    }

    if ($prezime === "") {
        $pogreska .= "Prezime ne smije biti prazno.<br>";
    }

    if ($korime === "") {
        $pogreska .= "Korisničko ime ne smije biti prazno.<br>";
    }

    if (!preg_match("/^[0-9a-zA-Z]{4,12}$/", $korime) && $korime !== "") {
        $pogreska .= "Korisničko ime nije ispravno, mora imati između <br>4 i 12 znakova i sadržavati slova i brojeve.";
    }

    if ($godina === "") {
        $pogreska .= "Godina rođenja ne smije biti prazna.<br>";
    }

    if ($godina < 1900 || $godina > 2020) {
        $pogreska .= "Godina rođenja ne smije biti manja od 1900 i veća od 2020.<br>";
    }

    if ($email === "") {
        $pogreska .= "Email ne smije biti prazan.<br>";
    }

    if (!preg_match("/^[a-zA-Z0-9.-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$/", $email) && $email !== "") {
        $pogreska .= "Email nije ispravan.<br>";
    }

    if ($lozinka === "") {
        $pogreska .= "Lozinka ne smije biti prazna.<br>";
    }

    if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,20}$/", $lozinka) && $lozinka !== "") {
        $pogreska .= "Lozinka nije ispravna.<br>";
    }

    if ($ponovljenaLozinka === "") {
        $pogreska .= "Ponovljena lozinka ne smije biti prazna.<br>";
    }

    if ($lozinka !== $ponovljenaLozinka) {
        $pogreska .= "Ponovljena lozinka nije ispravna.<br>";
    }

    if ($captcha !== $unosCaptche) {
        $pogreska .= "CAPTCHA kod nije ispravno unesen.<br>";
    }

    //echo $pogreska;

    if (empty($pogreska)) {

        $salt = sha1(time());
        $lozinkaSHA1 = sha1($salt . '--' . $lozinka);

        $veza = new Baza();
        $veza->spojiDB();

        $upit = "INSERT INTO korisnik (korisnik_id, uloga_id, vrsta_statusa_id, ime, prezime, korisnicko_ime, godina_rodenja, email, lozinka, lozinka_sha1, salt, datum_registracije, uvjeti_koristenja, blokiran_do) VALUES (DEFAULT, 3, 1, '$ime', '$prezime', '$korime', $godina, '$email', '$lozinka','$lozinkaSHA1', '$salt', now(), NULL, NULL)";

        $rezultat = $veza->updateDB($upit);

        $upit2 = "SELECT korisnik_id FROM korisnik WHERE korisnicko_ime = '$korime'";

        $rezultat2 = $veza->selectDB($upit2);

        $podaci = mysqli_fetch_assoc($rezultat2);

        $ID = $podaci['korisnik_id'];

        $poveznica = "http://{$_SERVER['HTTP_HOST']}/WebDiP/2019_projekti/WebDiP2019x083/php_provjere/aktivacija_racuna.php?id=" . $ID;
        $mail_to = $email;
        $mail_subject = "Aktivacija korisnickog racuna - Hrvatska posta";
        $mail_body = "Za aktivaciju korisnickog racuna kliknite na poveznicu: " . $poveznica;
        $mail_from = "From: support@hrvatskaposta.hr";

        mail($mail_to, $mail_subject, $mail_body, $mail_from);

        $veza->zatvoriDB();
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Registracija</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Silvio Mihalic">
        <meta name="keywords" content="FOI, WebDiP, registracija, F1">
        <meta name="description" content="Stranica za registraciju za zadacu 1, 10.3.2020.">
        <link rel="stylesheet" href="../css/smihalic.css" type="text/css"/>
        <link href="../css/smihalic_prilagodbe.css" rel="stylesheet" type="text/css"/>
        <link href="../css/smihalic_ispis.css" rel="stylesheet" type="text/css" media="print"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../javascript/registracija_jquery.js"></script>

    </head>
    <body>
        <header style="width: 100%;text-align: right;">
            <nav>
                <?php
                include '../meni.php';
                ?>
                <a href = "../index.php"><img class = "logo" style="width:45px;margin-left: 25px" id = "slikaf1" src = "../multimedija/logo.png" alt = "f1 pozadina" /></a>
                <h2 class="naslovStranice" style="margin-left:-5px">Registracija</h2>       

            </nav>
            <form method="post" name="form1" action="http://barka.foi.hr/WebDiP/2019/materijali/zadace/ispis_forme.php">
                <input type="text" id='trazilica' name='trazi' placeholder="Traži" class="trazilica">
                <input type="image" style="width:1.4%; padding-right: 10px" src="../multimedija/search.PNG" alt="Submit">
            </form>
        </header>

        <main id="pozadina">
            <h1>Registriraj se</h1>
            <form novalidate method="get" name="form1" action="registracija.php">
                <p class="prijava">
                    <label for="ime">Ime: </label>
                    <input type="text" id="ime" name="ime" placeholder="ime" autofocus="autofocus" required="required"><br>
                    <label for="prezime">Prezime: </label>
                    <input type="text" id="prezime" name="prezime" placeholder="prezime" required="required"><br>
                    <label for="korime">Korisničko ime: </label>
                    <input type="text" id="korime" name="korime" size="15" maxlength="15" placeholder="korisničko ime" required="required"><br>
                    <span id="dostupnost"></span>
                    <label for="godina">Godina rođenja: </label>
                    <input type="number" id="godina" name="godina" required="required"><br>
                    <label for="email">Email adresa: </label>
                    <input type="email" id="email" name="email" size="35" maxlength="35" placeholder="ime.prezime@posluzitelj.xxx" required="required"><br>
                    <span id="dostupnostEmail"></span>
                    <label for="lozinka">Lozinka: </label>
                    <input type="password" id="lozinka" name="lozinka" placeholder="lozinka" required="required"><br>
                    <label for="ponovljenaLozinka">Ponovite lozinku: </label>
                    <input type="password" id="ponovljenaLozinka" name="ponovljenaLozinka" placeholder="ponovite lozinku" required="required"><br>
                    <label for="captcha">CAPTCHA: </label>
                    <input type="text" id="captcha" name="captcha" required="required" readonly="" value="<?php echo $captchaKod ?>"><br>
                    <label for="unosCaptche">Unesite kod: </label>
                    <input type="text" id="unosCaptche" name="unosCaptche" placeholder="unesite kod" required="required"><br>
                    <input id="submit" name="submit" type="submit" value=" Registriraj se "><br>
                    <?php
                    if (isset($pogreska)) {
                        echo $pogreska;
                    }
                    ?>
            </form>

        </main>

    </body>
</html>
