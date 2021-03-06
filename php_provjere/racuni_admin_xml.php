<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

$veza = new Baza();
$veza->spojiDB();

$upit = "SELECT r.račun_id as id, k1.ime as imeIzdao, k1.prezime as prezimeIzdao, k2.ime as imePrimatelj, k2.prezime as prezimePrimatelj, r.datum_izdavanja as datum_izdavanja, r.jedinična_cijena as cijena_kg, r.težina_kg as tezina, r.iznos_obrade as obrada, r.ukupna_cijena as cijena, r.datum_plaćanja as datum_placanja, r.putanja_slike as putanja_slike, r.slika_javna as javna FROM račun r left join korisnik k1 on r.izdao = k1.korisnik_id left join korisnik k2 on r.primatelj_id = k2.korisnik_id ORDER BY 1";

$rezultat = $veza->selectDB($upit);

$num_rows = mysqli_num_rows($rezultat);
$atributi = array("id", "imeIzdao", "prezimeIzdao", "imePrimatelj", "prezimePrimatelj", "datum_izdavanja", "cijena_kg", "tezina", "obrada", "cijena", "datum_placanja", "putanja_slike", "javna");

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
        $id = $red['id'];
        $imeIzdao = $red['imeIzdao'];
        $prezimeIzdao = $red['prezimeIzdao'];
        $imePrimatelj = $red['imePrimatelj'];
        $prezimePrimatelj = $red['prezimePrimatelj'];
        $datum_izdavanja = $red['datum_izdavanja'];
        $cijena_kg = $red['cijena_kg'];
        $tezina = $red['tezina'];
        $obrada = $red['obrada'];
        $cijena = $red['cijena'];
        $datum_placanja = $red['datum_placanja'];
        $putanja_slike = $red['putanja_slike'];
        $javna = $red['javna'];

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