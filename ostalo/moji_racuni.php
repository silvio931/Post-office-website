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

if (isset($_POST['submit'])) {
    
    $racun = $_POST['racunID'];
    
    $slikaJavna = 0;
    if(isset($_POST['javna'])){
        $slikaJavna = 1;
    }
    
    $greska = "";

    $userfile = $_FILES['dokument']['tmp_name'];
    $userfile_name = $_FILES['dokument']['name'];
    $userfile_size = $_FILES['dokument']['size'];
    $userfile_type = $_FILES['dokument']['type'];
    $userfile_error = $_FILES['dokument']['error'];
    if ($userfile_error > 0) {
        echo 'Problem: ';
        switch ($userfile_error) {
            case 1: $greska .= 'Veličina veća od ' . ini_get('upload_max_filesize');
                break;
            case 2: $greska .= 'Veličina veća od ' . $_POST["MAX_FILE_SIZE"] . 'B';
                break;
            case 3: $greska .= 'Datoteka djelomično prenesena';
                break;
            case 4: $greska .= 'Datoteka nije prenesena';
                break;
        }
        exit;
    }

    $upfile = '../slike_racuna/' . $userfile_name;

    if (is_uploaded_file($userfile)) {
        if (!move_uploaded_file($userfile, $upfile)) {
            $greska .= "Problem: nije moguće prenijeti datoteku na odredište";
            exit;
        }
    } else {
        $greska .= "Problem: mogući napad prijenosom. Datoteka: " . $userfile_name;
        exit;
    }

    if (empty($greska)) {

        $veza = new Baza();
        $veza->spojiDB();

        $upit = "UPDATE račun SET datum_plaćanja = now(), putanja_slike = '$userfile_name', slika_javna = $slikaJavna WHERE račun_id = $racun";

        $rezultat = $veza->updateDB($upit);
        
        $veza->zatvoriDB();
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Računi</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Silvio Mihalic">
        <meta name="keywords" content="FOI, WebDiP, moji računi, pošta">
        <meta name="description" content="Stranica moji računi, 3.6.2020.">
        <link rel="stylesheet" href="../css/smihalic.css" type="text/css"/>
        <link href="../css/smihalic_prilagodbe.css" rel="stylesheet" type="text/css"/>
        <link href="../css/smihalic_ispis.css" rel="stylesheet" type="text/css" media="print"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="//code.jquery.com/jquery-1.12.4.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../javascript/moji_racuni.js"></script>

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
                        <th>Pošiljka ID</th>
                        <th>Izdao</th>
                        <th>Datum izdavanja</th>
                        <th>Jedinična cijena</th>
                        <th>Težina</th>
                        <th>Iznos obrade</th>
                        <th>Ukupna cijena</th>
                        <th>Datum plaćanja</th>
                        <th>Slika</th>
                        <th>Slika javna</th>
                        <th>Plati račun</th>
                    </tr>
                </thead>
                <tbody style="font-weight: normal">

                </tbody>
            </table>

        </div>
        <br>
        <form method="POST" id="placanjeRacuna" style="font-family: arial; margin-right: 800px" action="moji_racuni.php" enctype="multipart/form-data">
            <h2>Plaćanje računa</h2>
            <label for="racun">Broj računa: </label>
            <input type="text" id="racunID" name="racunID" required="racunID" readonly=""><br><br>
            <label for="dokument">Slika paketa: </label><br>
            <input type="file" id="dokument" name="dokument" />
            <input type="hidden" name="MAX_FILE_SIZE" value="30000"/><br><br>           
            <label>Dozvoliti da se slika prikazuje javno?</label>
            <input type="checkbox" id="javna" name="javna" value="Slika javna"><br><br>
            <input type="submit" name="submit" id="submit" value="Plati račun"/>
        </form>

    </body>
</html>
