<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

$datumOd = $_GET['datumOd'];
$datumDo = $_GET['datumDo'];

$veza = new Baza();
$veza->spojiDB();
$upit = "SELECT DISTINCT d.ime as ime, COUNT(p.pošiljka_id) as placene_posiljke FROM država d left join poštanski_ured pu on d.država_id = pu.država_id left join pošiljka p on pu.poštanski_ured_id = p.završni_ured_id left join račun r on p.račun_id = r.račun_id WHERE p.račun_id IS NOT NULL AND r.datum_plaćanja IS NOT NULL AND r.datum_izdavanja >= '$datumOd' AND r.datum_izdavanja <= '$datumDo' GROUP BY d.ime";
$rezultat = $veza->selectDB($upit);

$num_rows = mysqli_num_rows($rezultat);
$atributi = array("ime", "placene_posiljke");

$xmlDom = new DOMDocument();
header("Content-Type: text/xml");
$xmlDom->appendChild($xmlDom->createElement('drzave'));
$xmlRootNode = $xmlDom->documentElement;

if ($num_rows === 0) {
    $xmlRowElementNode = $xmlDom->createElement('drzava');

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
        $ime = $red['ime'];
        $placene_posiljke = $red['placene_posiljke'];

        $xmlRowElementNode = $xmlDom->createElement('drzava');

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