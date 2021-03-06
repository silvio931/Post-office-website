<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

$racunID = $_GET['racunID'];

$veza = new Baza();
$veza->spojiDB();
$upit = "DELETE FROM račun WHERE račun_id = $racunID";
$rezultat = $veza->updateDB($upit);

$veza->zatvoriDB();
?>