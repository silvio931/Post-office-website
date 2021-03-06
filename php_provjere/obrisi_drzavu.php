<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

$drzavaID = $_GET['drzavaID'];

$veza = new Baza();
$veza->spojiDB();
$upit = "DELETE FROM država WHERE država_id = $drzavaID";
$rezultat = $veza->updateDB($upit);

$veza->zatvoriDB();
?>