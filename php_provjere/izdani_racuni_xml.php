<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

if (isset($_COOKIE["ID"])) {
    $posiljateljID = $_COOKIE["ID"];
}

$veza = new Baza();
$veza->spojiDB();
$upit = "SELECT r.račun_id as racunID, r.primatelj_id as primatelj, k.ime as ime, k.prezime as prezime, r.datum_izdavanja as datum_izdavanja, r.jedinična_cijena as jedCijena, r.težina_kg as tezina, r.iznos_obrade as obrada, r.ukupna_cijena as ukupna_cijena, r.datum_plaćanja as datum_placanja, r.putanja_slike as putanja_slike, r.slika_javna as slika_javna, k.blokiran_do as blokiran from račun r join korisnik k on r.primatelj_id = k.korisnik_id WHERE r.izdao = $posiljateljID";
$rezultat = $veza->selectDB($upit);

$num_rows = mysqli_num_rows($rezultat);
$atributi = array("racunID", "primatelj", "ime", "prezime", "datum_izdavanja", "jedCijena", "tezina", "obrada", "ukupna_cijena", "datum_placanja", "putanja_slike", "slika_javna","blokiran");

$xmlDom = new DOMDocument();
header("Content-Type: text/xml");
$xmlDom->appendChild($xmlDom->createElement('racuni'));
$xmlRootNode = $xmlDom->documentElement;

if ($num_rows === 0) {
    $xmlRowElementNode = $xmlDom->createElement('racun');

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
        $racunID = $red['racunID'];
        $primatelj = $red['primatelj'];
        $ime = $red['ime'];      
        $prezime = $red['prezime'];
        $datum_izdavanja = $red['datum_izdavanja'];
        $jedCijena = $red['jedCijena'];
        $tezina = $red['tezina'];      
        $obrada = $red['obrada'];
        $ukupna_cijena = $red['ukupna_cijena'];
        $datum_placanja = $red['datum_placanja'];
        $putanja_slike = $red['putanja_slike'];
        $slika_javna = $red['slika_javna'];      
        $blokiran = $red['blokiran'];      

        $xmlRowElementNode = $xmlDom->createElement('racun');

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