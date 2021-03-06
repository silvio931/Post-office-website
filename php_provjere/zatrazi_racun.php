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

$upit = "INSERT INTO zahtjevi_izdavanje_računa (korisnik_id, pošiljka_id, datum_izvadanja, račun_izdan) VALUES ($posiljateljID, $posiljkaID, now(), 0)";

$rezultat = $veza->updateDB($upit);

$veza->zatvoriDB();
?>