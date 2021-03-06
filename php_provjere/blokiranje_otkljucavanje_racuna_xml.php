<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

$veza = new Baza();
$veza->spojiDB();
$upit = "SELECT k.korisnik_id as id, u.naziv as uloga, s.naziv as status, k.ime as ime, k.prezime as prezime, k.korisnicko_ime as korime, k.lozinka as lozinka, k.email as email, k.blokiran_do as blokiran_do FROM korisnik k join uloga u on k.uloga_id = u.uloga_id join vrsta_statusa s on k.vrsta_statusa_id = s.vrsta_statusa_id ORDER BY 1";
$rezultat = $veza->selectDB($upit);

$num_rows = mysqli_num_rows($rezultat);
$atributi = array("id", "uloga", "status", "ime", "prezime", "korime", "lozinka", "email", "blokiran_do");

$xmlDom = new DOMDocument();
header("Content-Type: text/xml");
$xmlDom->appendChild($xmlDom->createElement('korisnici'));
$xmlRootNode = $xmlDom->documentElement;

if ($num_rows === 0) {
    $xmlRowElementNode = $xmlDom->createElement('korisnik');

    for ($k = 0; $k < count($atributi); $k++) {
        $xmlRowElement = $xmlDom->createElement($atributi[$k]);
        $xmlText = $xmlDom->createTextNode(0);
        $xmlRowElement->appendChild($xmlText);

        $xmlRowElementNode->appendChild($xmlRowElement);
    }
    $xmlRootNode->appendChild($xmlRowElementNode);
}

if ($num_rows > 0) {
    while ($red = mysqli_fetch_array($rezultat)) {
        $id = $red['id'];
        $uloga = $red['uloga'];
        $status = $red['status'];
        $ime = $red['ime'];
        $prezime = $red['prezime'];
        $korime = $red['korime'];
        $lozinka = $red['lozinka'];
        $email = $red['email'];
        $blokiran_do = $red['blokiran_do'];

        $xmlRowElementNode = $xmlDom->createElement('korisnik');

        for ($j = 0; $j < count($atributi); $j++) {
            $xmlRowElement = $xmlDom->createElement($atributi[$j]);
            $xmlText = $xmlDom->createTextNode($red[$j]);
            $xmlRowElement->appendChild($xmlText);

            $xmlRowElementNode->appendChild($xmlRowElement);
        }

        $xmlRootNode->appendChild($xmlRowElementNode);
    }
}

$veza->zatvoriDB();
echo $xmlDom->saveXML();
?>