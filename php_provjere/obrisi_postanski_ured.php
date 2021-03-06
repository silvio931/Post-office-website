<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

$uredID = $_GET['uredID'];

$veza = new Baza();
$veza->spojiDB();
$upit = "DELETE FROM poštanski_ured WHERE poštanski_ured_id = $uredID";
$rezultat = $veza->updateDB($upit);

$veza->zatvoriDB();
?>