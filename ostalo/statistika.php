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
        <title>Statistika</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Silvio Mihalic">
        <meta name="keywords" content="FOI, WebDiP, statistika, pošta">
        <meta name="description" content="Stranica statistike za moderatora, 8.6.2020.">
        <link rel="stylesheet" href="../css/smihalic.css" type="text/css"/>
        <link href="../css/smihalic_prilagodbe.css" rel="stylesheet" type="text/css"/>
        <link href="../css/smihalic_ispis.css" rel="stylesheet" type="text/css" media="print"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../javascript/statistika_jquery.js"></script>

    </head>
    <body>
        <header style="width: 100%;text-align: right;">
            <nav>
                <?php
                include '../meni.php';
                ?>
                <a href = "../index.php"><img class = "logo" style="width:45px;margin-left: 25px" id = "slikaf1" src = "../multimedija/logo.png" alt = "f1 pozadina" /></a>
                <h2 class="naslovStranice" style="margin-left: -5px">Statistika</h2>                

            </nav>
            <form method="post" name="form1" action="http://barka.foi.hr/WebDiP/2019/materijali/zadace/ispis_forme.php">
                <input type="text" id='trazilica' name='trazi' placeholder="Traži" class="trazilica">
                <input type="image" style="width:1.4%; padding-right: 10px" src="../multimedija/search.PNG" alt="Submit">
            </form>
        </header>
        <br>

        <div style="width: 55%;font-family: arial;margin-left:-200px">
            <h2>Filter</h2>
            <form method="get" name="form1" action="statistika.php">
                <label for="datumOd">Od: </label>
                <input type="datetime-local" id="datumOd" name="datumOd" required="required" /><br><br>
                <label for="datumDo">Do: </label>
                <input type="datetime-local" id="datumDo" name="datumDo" required="required" /><br><br>
                <input type="button" name="submitFiltriraj" id="submitFiltriraj" value="Filtriraj">
                <input type="button" name="submitPrikaziSve" id="submitPrikaziSve" value="Prikaži sve">
            </form> 
        </div>

        <br>

        <div style="font-size:15px;font-family: arial;margin-top:-180px">
            <table class="display compact nowrap" id="tablica1" style="font-weight: bold;">
                <caption style="font-size: 20px">Broj plaćenih pošiljki</caption>
                <thead>
                    <tr id="zaglavljetablice">
                        <th>Država</th>
                        <th>Broj plaćenih pošiljki</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal">

                </tbody>
            </table>

        </div>
        <br><br>
        <div style="font-size:15px;font-family: arial;">
            <table class="display compact nowrap" id="tablica2" style="font-weight: bold;">
                <caption style="font-size: 20px">Broj neplaćenih pošiljki</caption>
                <thead>
                    <tr id="zaglavljetablice">
                        <th>Država</th>
                        <th>Broj neplaćenih pošiljki</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal">

                </tbody>
            </table>

        </div>



        <br><br>


    </body>
</html>
