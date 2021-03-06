<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

$korisnikID = $_GET['korisnikID'];

$veza = new Baza();
$veza->spojiDB();
$upit = "UPDATE korisnik SET vrsta_statusa_id = 2, blokiran_do = NULL, broj_neuspjela_prijava = 0 WHERE korisnik_id = $korisnikID";
$rezultat = $veza->updateDB($upit);

$veza->zatvoriDB();
?>