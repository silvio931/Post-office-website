<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

if (isset($_COOKIE["ID"])) {
    $posiljateljID = $_COOKIE["ID"];
}

$veza = new Baza();
$veza->spojiDB();

$upit = "SELECT p.pošiljka_id as id, u.naziv as ured, p.primatelj as primateljID, k.ime as ime, k.prezime as prezime, p.težina_kg as tezina, p.datum_otpreme as datum_otpreme,p. datum_pristizanja as datum_pristizanja, p.račun_id as racun FROM `pošiljka` p join korisnik k on p.primatelj = k.korisnik_id left join poštanski_ured u on p.trenutni_ured_id = u.poštanski_ured_id WHERE p.pošiljatelj = $posiljateljID";

$rezultat = $veza->selectDB($upit);

$num_rows = mysqli_num_rows($rezultat);
$atributi = array("id", "ured", "primateljID", "ime", "prezime", "tezina", "datum_otpreme", "datum_pristizanja", "racun");

$xmlDom = new DOMDocument();
header("Content-Type: text/xml");
$xmlDom->appendChild($xmlDom->createElement('posiljke'));
$xmlRootNode = $xmlDom->documentElement;

if ($num_rows === 0) {
    $xmlRowElementNode = $xmlDom->createElement('posiljka');

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
        $ured = $red['ured'];
        $primateljID = $red['primateljID'];
        $ime = $red['ime'];
        $prezime = $red['prezime'];
        $tezina = $red['tezina'];
        $datum_otpreme = $red['datum_otpreme'];
        $datum_pristizanja = $red['datum_pristizanja'];
        $racun = $red['racun'];

        $xmlRowElementNode = $xmlDom->createElement('posiljka');

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