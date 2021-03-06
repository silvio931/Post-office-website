<?php

require "$direktorij/baza.class.php";
require "$direktorij/sesija.class.php";

Sesija::kreirajSesiju();

/*
function dodaj_zapis(){
    global $direktorij;
    $sada= date('d.m.Y H:i:s');
    $fp = fopen("$direktorij/izvorne_datoteke/dnevnik.log", "a+");
    fwrite($fp, $sada);
    fwrite($fp, ", ");
    fwrite($fp, $_SERVER["HTTP_REFERER"]);
    fwrite($fp, "\n");
    fclose($fp);
}

dodaj_zapis();
 */

function vrati_ascPolje($naziv){
    return 0;
}

?>