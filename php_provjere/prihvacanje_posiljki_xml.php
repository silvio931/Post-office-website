<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

if (isset($_COOKIE["ID"])) {
    $posiljateljID = $_COOKIE["ID"];
}

$veza = new Baza();
$veza->spojiDB();
$upit = "SELECT p.pošiljka_id as id, k1.ime as posiljatelj_ime, k1.prezime as posiljatelj_prezime, k2.ime as primatelj_ime, k2.prezime as primatelj_prezime, p.datum_kreiranja as datum_kreiranja, p.težina_kg as tezina from pošiljka p join korisnik k1 on p.pošiljatelj = k1.korisnik_id join korisnik k2 on p.primatelj = k2.korisnik_id WHERE p.početni_ured_id IS NULL";
$rezultat = $veza->selectDB($upit);

$num_rows = mysqli_num_rows($rezultat);
$atributi = array("id", "posiljatelj_ime", "posiljatelj_prezime", "primatelj_ime", "primatelj_prezime", "datum_kreiranja", "tezina");

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
        $posiljatelj_ime = $red['posiljatelj_ime'];
        $posiljatelj_prezime = $red['posiljatelj_prezime'];
        $primatelj_ime = $red['primatelj_ime'];
        $primatelj_prezime = $red['primatelj_prezime'];
        $datum_kreiranja = $red['datum_kreiranja'];
        $tezina = $red['tezina'];

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