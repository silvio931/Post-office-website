<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

$naziv = $_GET['naziv'];

$veza = new Baza();
$veza->spojiDB();
$upit = "SELECT poštanski_ured_id as id from poštanski_ured WHERE naziv = '$naziv'";
$rezultat = $veza->selectDB($upit);

$num_rows = mysqli_num_rows($rezultat);
$atributi = array("id");

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