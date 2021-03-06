<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

$veza2 = new Baza();
$veza2->spojiDB();
$upit2 = "SELECT pu.poštanski_ured_id as id, d.ime as ime, k.korisnicko_ime as korime, pu.naziv as naziv, pu.adresa as adresa, pu.broj_zaposlenih as broj, count(p.početni_ured_id) as brojposiljki FROM `poštanski_ured` pu join `država` d on pu.država_id = d.država_id join korisnik k on pu.moderator_id = k.korisnik_id left join pošiljka p on pu.poštanski_ured_id = p.početni_ured_id group by pu.poštanski_ured_id";
$rezultat2 = $veza2->selectDB($upit2);

$num_rows = mysqli_num_rows($rezultat2);
$atributi = array("id", "ime", "korime", "naziv", "adresa", "broj", "brojposiljki");

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
    while ($red2 = mysqli_fetch_array($rezultat2)) {
        $id = $red2['id'];
        $ime = $red2['ime'];
        $korime = $red2['korime'];
        $naziv = $red2['naziv'];
        $adresa = $red2['adresa'];
        $broj = $red2['broj'];
        $brojposiljki = $red2['brojposiljki'];
        
        $xmlRowElementNode = $xmlDom->createElement('ured');

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