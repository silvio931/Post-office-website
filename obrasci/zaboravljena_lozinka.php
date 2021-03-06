<?php
if (!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on") {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit;
}

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

if (isset($_GET['submit'])) {
    $email = $_GET['email'];

    $slova = 'abcdefghijklmnoprstuvzxyqABCDEFGHIJKLMNOPRSTUVZXYQ0123456789';
    $duljina = strlen($slova);
    $randomString = '';
    for ($i = 0; $i < 8; $i++) {
        $randomString .= $slova[rand(0, $duljina - 1)];
    }

    $mail_to = $email;
    $mail_subject = "Zaboravljena lozinka - Hrvatska posta";
    $mail_body = "Vaša nova lozinka je: " . $randomString;
    $mail_from = "From: support@hrvatskaposta.hr";

    mail($mail_to, $mail_subject, $mail_body, $mail_from);

    $salt = sha1(time());
    $lozinkaSHA1 = sha1($salt . '--' . $randomString);

    $veza = new Baza();
    $veza->spojiDB();
    $upit = "UPDATE korisnik SET lozinka = '$randomString', lozinka_sha1 = '$lozinkaSHA1', salt = '$salt' WHERE email = '$email'";
    $rezultat = $veza->updateDB($upit);

    $veza->zatvoriDB();

    $poruka = "Lozinka poslana.";
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
            <h1>Zaboravljena lozinka</h1>
            <form novalidate method="get" name="form1" action="zaboravljena_lozinka.php">

                <p class="prijava">
                    <label for="email">Email: </label>
                    <input type="text" id="email" name="email" placeholder="email" autofocus="autofocus" required="required"><br>
                    <input type="submit" name="submit" id="submit" value="Pošalji novu lozinku">
                </p>
                <?php
                if (isset($poruka)) {
                    echo $poruka;
                }
                ?>
            </form>

        </main>

    </body>
</html>
