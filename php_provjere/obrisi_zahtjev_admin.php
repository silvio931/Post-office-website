<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

$posiljkaID = $_GET['posiljkaID'];

$veza = new Baza();
$veza->spojiDB();
$upit = "DELETE FROM zahtjevi_izdavanje_računa WHERE pošiljka_id = $posiljkaID";
$rezultat = $veza->updateDB($upit);

$veza->zatvoriDB();
?>