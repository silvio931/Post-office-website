<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

if (isset($_COOKIE["ID"])) {
    $posiljateljID = $_COOKIE["ID"];
}

$posiljkaID = $_GET['posiljkaID'];

$veza = new Baza();
$veza->spojiDB();
$upit = "DELETE FROM pošiljka WHERE pošiljka_id = $posiljkaID";
$rezultat = $veza->updateDB($upit);

$veza->zatvoriDB();

?>