<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

$veza = new Baza();
$veza->spojiDB();

$upit = "SELECT p.pošiljka_id as id, u1.naziv as pocetni, u2.naziv as trenutni, u3.naziv as sljedeci, u4.naziv as zavrsni, k1.ime as imePosiljatelj, k1.prezime as prezimePosiljatelj, k2.ime as imePrimatelj, k2.prezime as prezimePrimatelj, p.datum_otpreme as datum_otpreme, p.cijena_kg as cijena, p.težina_kg as tezina, p.datum_pristizanja as datum_pristizanja, p.račun_id as racun_id FROM pošiljka p left join poštanski_ured u1 on p.početni_ured_id = u1.poštanski_ured_id left join poštanski_ured u2 on p.trenutni_ured_id = u2.poštanski_ured_id left join poštanski_ured u3 on p.sljedeći_ured_id = u3.poštanski_ured_id left join poštanski_ured u4 on p.završni_ured_id = u4.poštanski_ured_id left join korisnik k1 on p.pošiljatelj = k1.korisnik_id left join korisnik k2 on p.primatelj = k2.korisnik_id ORDER BY 1";

$rezultat = $veza->selectDB($upit);

$num_rows = mysqli_num_rows($rezultat);
$atributi = array("id", "pocetni", "trenutni", "sljedeci", "zavrsni", "imePosiljatelj", "prezimePosiljatelj", "imePrimatelj", "prezimePrimatelj", "datum_otpreme", "cijena", "tezina", "datum_pristizanja", "racun_id");

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
        $imePosiljatelj = $red['imePosiljatelj'];
        $prezimePosiljatelj = $red['prezimePosiljatelj'];
        $imePrimatelj = $red['imePrimatelj'];
        $prezimePrimatelj = $red['prezimePrimatelj'];
        $datum_otpreme = $red['datum_otpreme'];
        $cijena = $red['cijena'];
        $tezina = $red['tezina'];
        $datum_pristizanja = $red['datum_pristizanja'];
        $racun_id = $red['racun_id'];

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