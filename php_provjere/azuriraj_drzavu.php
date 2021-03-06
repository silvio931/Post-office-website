<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

$drzavaID = $_GET['drzavaID'];
$naziv = $_GET['naziv'];

$veza = new Baza();
$veza->spojiDB();
$upit = "UPDATE država SET ime = '$naziv' WHERE država_id = $drzavaID";
$rezultat = $veza->updateDB($upit);

$veza->zatvoriDB();
?>