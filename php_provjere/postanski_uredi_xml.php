<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

$veza = new Baza();
$veza->spojiDB();
$upit = "SELECT p.poštanski_ured_id as id, d.ime as drzava, k.ime as ime, k.prezime as prezime, p.naziv as naziv, p.adresa as adresa, p.broj_zaposlenih as broj_zaposlenih from poštanski_ured p join država d on p.država_id = d.država_id join korisnik k on p.moderator_id = k.korisnik_id";
$rezultat = $veza->selectDB($upit);

$num_rows = mysqli_num_rows($rezultat);
$atributi = array("id", "drzava", "ime", "prezime", "naziv", "adresa", "broj_zaposlenih");

$xmlDom = new DOMDocument();
header("Content-Type: text/xml");
$xmlDom->appendChild($xmlDom->createElement('uredi'));
$xmlRootNode = $xmlDom->documentElement;

if ($num_rows === 0) {
    $xmlRowElementNode = $xmlDom->createElement('ured');

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
        $drzava = $red['drzava'];
        $ime = $red['ime'];
        $prezime = $red['prezime'];
        $naziv = $red['naziv'];
        $adresa = $red['adresa'];
        $broj_zaposlenih = $red['broj_zaposlenih'];

        $xmlRowElementNode = $xmlDom->createElement('ured');

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