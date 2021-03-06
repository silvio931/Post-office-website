<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

$id = $_GET['id'];

$veza = new Baza();
$veza->spojiDB();
$upit = "SELECT * FROM korisnik WHERE korisnik_id = $id";
$rezultat = $veza->selectDB($upit);

$red = mysqli_fetch_assoc($rezultat);

$status = $red['vrsta_statusa_id'];
$datum_registracije = $red['datum_registracije'];

$sada = date('Y-m-d H:i:s');

$datetime_registracija = strtotime($datum_registracije);
$datetime_sada = strtotime($sada);

$sati = ($datetime_sada - $datetime_registracija) / 60 / 60;

if ($status !== "1") {
    echo "Korisnički račun je već aktiviran.<br>Preusmjeravanje na stranicu prijave...";
    echo"<script>setTimeout(function(){ window.location.href=\"../obrasci/prijava.php\" }, 5000);</script>";
} else {
    if ($sati > 7) {
        echo "Aktivacijski link je istekao.<br>Preusmjeravanje na stranicu registracije...";
        echo"<script>setTimeout(function(){ window.location.href=\"../obrasci/registracija.php\" }, 5000);</script>";
    } else {
        $upit2 = "UPDATE korisnik SET vrsta_statusa_id = 2 WHERE korisnik_id = $id";

        $rezultat2 = $veza->updateDB($upit2);

        if ($rezultat2 === true) {
            echo "Uspješno ste aktivirali korisnički račun.<br>Preusmjeravanje na stranicu prijave...";
            echo"<script>setTimeout(function(){ window.location.href=\"../obrasci/prijava.php\" }, 5000);</script>";
        }
    }
}

$veza->zatvoriDB();
?>