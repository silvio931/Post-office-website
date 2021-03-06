<?php

$putanja = dirname($_SERVER["REQUEST_URI"], 2);
$direktorij = dirname(getcwd());
include '../zaglavlje.php';

if (isset($_COOKIE["ID"])) {
    $posiljateljID = $_COOKIE["ID"];
}

$posiljkaID = $_GET['posiljkaID'];

$veza = new Baza();
$veza->spojiDB();
$upit = "SELECT p.pošiljka_id as id, u.naziv as ured, k.ime as ime, k.prezime as prezime, p.datum_otpreme as datum_otpreme,p. datum_pristizanja as datum_pristizanja, p.cijena_kg as cijena, p.težina_kg as tezina, p.račun_id as racun, z.račun_izdan as zahtjev FROM `pošiljka` p join korisnik k on p.pošiljatelj = k.korisnik_id join poštanski_ured u on p.početni_ured_id = u.poštanski_ured_id left join zahtjevi_izdavanje_računa z on p.pošiljka_id = z.pošiljka_id WHERE p.primatelj = $posiljateljID AND p.pošiljka_id = $posiljkaID";
$rezultat = $veza->selectDB($upit);

$num_rows = mysqli_num_rows($rezultat);
$atributi = array("id", "ured", "ime", "prezime", "datum_otpreme", "datum_pristizanja", "cijena", "tezina", "racun", "zahtjev");

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
        $ured = $red['ured'];
        $ime = $red['ime'];
        $prezime = $red['prezime'];
        $datum_otpreme = $red['datum_otpreme'];
        $datum_pristizanja = $red['datum_pristizanja'];
        $cijena = $red['cijena'];
        $tezina = $red['tezina'];
        $racun = $red['racun'];
        $zahtjev = $red['zahtjev'];

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