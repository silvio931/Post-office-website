<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

if (isset($_COOKIE["ID"])) {
    $posiljateljID = $_COOKIE["ID"];
}

$veza = new Baza();
$veza->spojiDB();
$upit = "SELECT z.korisnik_id as korisnik, k.ime as ime, k.prezime as prezime, p.pošiljka_id as posiljka, pu.naziv as ured, z.datum_izvadanja as datum_izdavanja, z.račun_izdan as racun_izdan from zahtjevi_izdavanje_računa z join korisnik k on z.korisnik_id = k.korisnik_id join pošiljka p on z.pošiljka_id = p.pošiljka_id join poštanski_ured pu on p.završni_ured_id = pu.poštanski_ured_id WHERE pu.moderator_id = $posiljateljID";
$rezultat = $veza->selectDB($upit);

$num_rows = mysqli_num_rows($rezultat);
$atributi = array("korisnik", "ime", "prezime", "posiljka", "ured", "datum_izdavanja", "racun_izdan");

$xmlDom = new DOMDocument();
header("Content-Type: text/xml");
$xmlDom->appendChild($xmlDom->createElement('zahtjevi'));
$xmlRootNode = $xmlDom->documentElement;

if ($num_rows === 0) {
    $xmlRowElementNode = $xmlDom->createElement('zahtjev');

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
        $korisnik = $red['korisnik'];
        $ime = $red['ime'];      
        $prezime = $red['prezime'];
        $posiljka = $red['posiljka'];
        $ured = $red['ured'];
        $datum_izdavanja = $red['datum_izdavanja'];  
        $racun_izdan = $red['racun_izdan'];   

        $xmlRowElementNode = $xmlDom->createElement('zahtjev');

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