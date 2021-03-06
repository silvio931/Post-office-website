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
?>

<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Moderator</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Silvio Mihalic">
        <meta name="keywords" content="FOI, WebDiP, pošiljke, moderator, pošta">
        <meta name="description" content="Stranica za admina, popis moderatorskih moćunosti, 7.6.2020.">
        <link rel="stylesheet" href="../css/smihalic.css" type="text/css"/>
        <link href="../css/smihalic_prilagodbe.css" rel="stylesheet" type="text/css"/>
        <link href="../css/smihalic_ispis.css" rel="stylesheet" type="text/css" media="print"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../javascript/posiljke_korisnici_jquery_1.js"></script>

    </head>
    <body>
        <header style="width: 100%;text-align: right;">
            <nav>
                <?php
                include '../meni.php';
                ?>
                <a href = "../index.php"><img class = "logo" style="width:45px;margin-left: 25px" id = "slikaf1" src = "../multimedija/logo.png" alt = "f1 pozadina" /></a>
                <h2 class="naslovStranice" style="margin-left: -5px">Moderator</h2>                

            </nav>
            <form method="post" name="form1" action="http://barka.foi.hr/WebDiP/2019/materijali/zadace/ispis_forme.php">
                <input type="text" id='trazilica' name='trazi' placeholder="Traži" class="trazilica">
                <input type="image" style="width:1.4%; padding-right: 10px" src="../multimedija/search.PNG" alt="Submit">
            </form>
        </header>
        <br><br>
        <div style="position: absolute;  z-index: 999; top:100px">   

            <a style="margin-left:10px;font-family:Arial;text-decoration: none;color:#aeaeae;font-size: 15px;letter-spacing: -0.5px;" class="bocniMeni" href = "izdani_racuni.php">IZDANI RAČUNI</a><br><br>
            <a style="margin-left:10px;font-family:Arial;text-decoration: none;color:#aeaeae;font-size: 15px;letter-spacing: -0.5px;" class="bocniMeni" href = "zahtjevi.php">ZAHTJEVI ZA IZDAVANJE RAČUNA</a><br><br>
            <a style="margin-left:10px;font-family:Arial;text-decoration: none;color:#aeaeae;font-size: 15px;letter-spacing: -0.5px;" class="bocniMeni" href = "zaprimanje_posiljki.php">ZAPRIMANJE I USMJERAVANJE POŠILJKI</a><br><br>
            <a style="margin-left:10px;font-family:Arial;text-decoration: none;color:#aeaeae;font-size: 15px;letter-spacing: -0.5px;" class="bocniMeni" href = "statistika.php">STATISTIKA</a><br><br>

        </div>
        <br><br>

        <div style="border-left: 300px solid black;height: 694px;position: absolute;"></div>
        <div style="height: 694px;position: absolute; margin-left: 300px;">
            <img src="../multimedija/moderator.png" style="height:694px;">
        </div>

    </body>
</html>
