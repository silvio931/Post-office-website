<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

if (isset($_COOKIE["ID"])) {
    $posiljateljID = $_COOKIE["ID"];
}

$veza = new Baza();
$veza->spojiDB();
$upit = "SELECT p.pošiljka_id as id, pu.naziv as pocetni, pu2.naziv as trenutni, pu3.naziv as sljedeci, pu4.naziv as zavrsni from pošiljka p join poštanski_ured pu on p.početni_ured_id = pu.poštanski_ured_id join poštanski_ured pu2 on p.trenutni_ured_id = pu2.poštanski_ured_id join poštanski_ured pu3 on p.sljedeći_ured_id = pu3.poštanski_ured_id join poštanski_ured pu4 on p.završni_ured_id = pu4.poštanski_ured_id WHERE pu3.moderator_id = $posiljateljID AND p.datum_pristizanja IS NULL";
$rezultat = $veza->selectDB($upit);

$num_rows = mysqli_num_rows($rezultat);
$atributi = array("id", "pocetni", "trenutni", "sljedeci", "zavrsni");

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
        $pocetni = $red['pocetni'];
        $trenutni = $red['trenutni'];      
        $sljedeci = $red['sljedeci'];
        $zavrsni = $red['zavrsni'];
      

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