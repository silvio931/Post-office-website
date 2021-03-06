<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

$id = $_GET['IDureda'];

$veza2 = new Baza();
$veza2->spojiDB();
$upit2 = "SELECT p.pošiljka_id as posiljkaID, r.račun_id as racunID, r.putanja_slike as slika, r.slika_javna as javna from pošiljka p join račun r on p.račun_id = r.račun_id WHERE p.početni_ured_id = $id AND r.putanja_slike is NOT NULL";
$rezultat2 = $veza2->selectDB($upit2);

$num_rows = mysqli_num_rows($rezultat2);
$atributi = array("posiljkaID", "racunID", "putanja_slike", "slika_javna");

$xmlDom = new DOMDocument();
header("Content-Type: text/xml");
$xmlDom->appendChild($xmlDom->createElement('galerije'));
$xmlRootNode = $xmlDom->documentElement;

if ($num_rows === 0) {
    $xmlRowElementNode = $xmlDom->createElement('galerija');

    for ($k = 0; $k < count($atributi); $k++) {
        $xmlRowElement = $xmlDom->createElement($atributi[$k]);
        $xmlText = $xmlDom->createTextNode(0);
        $xmlRowElement->appendChild($xmlText);

        $xmlRowElementNode->appendChild($xmlRowElement);
    }
    $xmlRootNode->appendChild($xmlRowElementNode);
}

if ($num_rows > 0) {
    while ($red2 = mysqli_fetch_array($rezultat2)) {
        $posiljkaid = $red2['posiljkaID'];
        $racunid = $red2['racunID'];
        $putanja = $red2['slika'];
        $slikajavna = $red2['javna'];

        $xmlRowElementNode = $xmlDom->createElement('galerija');

        for ($j = 0; $j < count($atributi); $j++) {
            $xmlRowElement = $xmlDom->createElement($atributi[$j]);
            $xmlText = $xmlDom->createTextNode($red2[$j]);
            $xmlRowElement->appendChild($xmlText);

            $xmlRowElementNode->appendChild($xmlRowElement);
        }

        $xmlRootNode->appendChild($xmlRowElementNode);
    }
}

$veza2->zatvoriDB();
echo $xmlDom->saveXML();

?>