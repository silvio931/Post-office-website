<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

$korisnikID = $_GET['korisnikID'];

$veza = new Baza();
$veza->spojiDB();
$upit = "DELETE FROM korisnik WHERE korisnik_id = $korisnikID";
$rezultat = $veza->updateDB($upit);

$veza->zatvoriDB();
?>