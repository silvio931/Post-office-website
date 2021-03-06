<?php

if (!isset($_SESSION["uloga"])) {
    echo "   <a  style = \"float:left;   
    text-decoration: none; 
    font-family: Arial;
    position: relative;
    top: 23px;
    padding-left:10px;
    font-size: 15px;
    letter-spacing: -0.5px; 
    color:grey  \" 
    id = \"prijava\" href = \"$putanja/obrasci/prijava.php\">Prijava</a>";
}
if (isset($_SESSION["uloga"])) {
    echo "<form action=\"\" method=\"post\">
          <input style=\"background-color: black;
          border: none;
          color: grey;
          font-size: 15px;
          font-family: Arial;
          position: relative;
          top: 23px;
          padding-left:10px;
          float:left;
          letter-spacing: -0.5px;\" 
          type=\"submit\" name=\"odjava\" value=\"Odjava\">
          </form>";
}

if (isset($_POST['odjava'])) {
    Sesija::obrisiSesiju();
    session_unset();
    session_destroy();
    header("Location: $putanja/index.php");
    exit();
}

echo
"
    <a id = \"meni\" class = \"veza\" href = \"$putanja/index.php\">POČETNA STRANICA</a>
    <a id = \"meni3\" class = \"veza\" href = \"$putanja/obrasci/registracija.php\">REGISTRACIJA</a>
    <a id = \"meni3\" class = \"veza\" href = \"$putanja/ostalo/uredi.php\">POŠTANSKI UREDI</a>
        ";
if (isset($_SESSION["uloga"]) && $_SESSION["uloga"] < 4) {
    echo "<a id = \"meni6\" class = \"veza\" href = \"$putanja/ostalo/posiljke.php\">POŠILJKE</a>";
}

if (isset($_SESSION["uloga"]) && $_SESSION["uloga"] < 3) {
    echo "    <a id = \"meni5\" class = \"veza\" href = \"$putanja/ostalo/moderator.php\">MODERATOR</a>";
}
if (isset($_SESSION["uloga"]) && $_SESSION["uloga"] === "1") {
    echo "<a id = \"meni4\" class = \"veza\" href = \"$putanja/ostalo/admin.php\">ADMIN</a>";
}
?>