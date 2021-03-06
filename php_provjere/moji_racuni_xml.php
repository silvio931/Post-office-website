<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

if (isset($_COOKIE["ID"])) {
    $posiljateljID = $_COOKIE["ID"];
}

$veza = new Baza();
$veza->spojiDB();
$upit = "SELECT r.račun_id as racun, p.pošiljka_id as posiljka, k.ime as ime, k.prezime as prezime, r.datum_izdavanja as datum_izdavanja, r.jedinična_cijena as jedCijena, r.težina_kg as tezina, r.iznos_obrade as obrada, r.ukupna_cijena as cijena, r.datum_plaćanja as datum_placanja, r.putanja_slike as putanjaSlike, r.slika_javna as javna FROM račun r left join korisnik k on r.izdao = k.korisnik_id join pošiljka p on r.račun_id = p.račun_id WHERE r.primatelj_id = $posiljateljID";
$rezultat = $veza->selectDB($upit);

$num_rows = mysqli_num_rows($rezultat);
$atributi = array("racun", "posiljka", "ime", "prezime", "datum_izdavanja", "jedCijena", "tezina", "obrada", "cijena", "datum_placanja", "putanjaSlike", "javna");

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
        $racun = $red['racun'];
        $posiljka = $red['posiljka'];
        $ime = $red['ime'];
        $prezime = $red['prezime'];
        $datum_izdavanja = $red['datum_izdavanja'];
        $jedCijena = $red['jedCijena'];
        $tezina = $red['tezina'];
        $obrada = $red['obrada'];
        $cijena = $red['cijena'];
        $datum_placanja = $red['datum_placanja'];
        $putanjaSlike = $red['putanjaSlike'];
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