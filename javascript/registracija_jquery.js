$('document').ready(function () {

    //provjerava dostupnost i strukturu korisničkog imena
    $('#korime').keyup(function () {
        var kor_ime = $(this).val();
        $.ajax({
            url: '../php_provjere/provjera_korime.php?korime=' + kor_ime,
            type: 'GET',
            dataType: 'xml',
            success: function (xml)
            {
                $(xml).find('korisnik').each(function () {
                    var ime = $(this).find('ime').text();
                    if (ime === "0") {
                        $('#dostupnost').html("");
                        var rePattern = new RegExp(/^[0-9a-zA-Z]{4,12}$/);
                        var ok = rePattern.test(kor_ime);
                        if (!ok) {
                            korime = false;
                        } else {
                            korime = true;
                        }
                        provjera();
                    } else {
                        $('#dostupnost').html("Korisničko ime je zauzeto!<br>");
                        korime = false;
                        provjera();
                    }
                });
            }
        });
    });



    //provjerava zauzetosti i strukturu email-a
    $('#email').keyup(function () {
        var e_mail = $(this).val();

        $.ajax({
            url: '../php_provjere/provjera_email.php?email=' + e_mail,
            type: 'GET',
            dataType: 'xml',
            success: function (xml)
            {
                $(xml).find('korisnik').each(function () {
                    var ime = $(this).find('ime').text();
                    if (ime === "0") {
                        $('#dostupnostEmail').html("");
                        var rePattern = new RegExp(/^[a-zA-Z0-9.-]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$/);
                        var ok = rePattern.test(e_mail);
                        if (!ok) {
                            email = false;
                            $("#email").attr("style", "border-color: red;");
                        } else
                        {
                            email = true;
                            $("#email").attr("style", "border-color: default;");
                        }
                        provjera();
                    } else {
                        $('#dostupnostEmail').html("Već postoji račun s ovim email-om.<br>");
                        email = false;
                        provjera();
                    }
                });
            }
        });
    });

    $("#submit").prop('disabled', true);

    //provjerava je li uneseno ime
    $('#ime').keyup(function () {
        if (!$("#ime").val()) {
            ime = false;
            $("#ime").attr("style", "border-color: red;");
        } else {
            ime = true;
            $("#ime").attr("style", "border-color: default;");
        }
        provjera();
    });

    //provjerava je li uneseno prezime
    $('#prezime').keyup(function () {
        if (!$("#prezime").val()) {
            prezime = false;
            $("#prezime").attr("style", "border-color: red;");
        } else {
            prezime = true;
            $("#prezime").attr("style", "border-color: default;");
        }
        provjera();
    });

    //provjerava je li godina rođenja između 1900 i 2020
    $('#godina').blur(function () {
        if ($("#godina").val() < 1900 || $("#godina").val() > 2020) {
            godina = false;
            $("#godina").attr("style", "border-color: red;");
        } else {
            godina = true;
            $("#godina").attr("style", "border-color: default;");
        }
        provjera();
    });

//provjerava strukturu lozinke
    $('#lozinka').keyup(function () {
        var password = $("#lozinka").val();
        var rePattern = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,20}$/);
        var ok = rePattern.test(password);
        if (ok) {
            lozinka = true;
            $("#lozinka").attr("style", "border-color: default;");
        } else {
            lozinka = false;
            $("#lozinka").attr("style", "border-color: red;");
        }
        provjera();
    });

    //provjerava je li ponovljena lozinka jednaka prethodno upisanoj lozinki
    $('#ponovljenaLozinka').keyup(function () {
        if ($("#ponovljenaLozinka").val() === $("#lozinka").val()) {
            ponovljenaLozinka = true;
            $("#ponovljenaLozinka").attr("style", "border-color: default;");
        } else {
            ponovljenaLozinka = false;
            $("#ponovljenaLozinka").attr("style", "border-color: red;");
        }
        provjera();
    });

    //provjerava je li ispravno unese CAPTCHA kod
    $('#unosCaptche').keyup(function () {
        if ($("#unosCaptche").val() === $("#captcha").val()) {
            captcha = true;
            $("#unosCaptche").attr("style", "border-color: default;");
        } else {
            captcha = false;
            $("#unosCaptche").attr("style", "border-color: red;");
        }
        provjera();
    });

    function provjera() {
        if (ime == true && prezime == true && godina == true && korime == true && email == true && lozinka == true && ponovljenaLozinka == true && captcha == true) {
            $("#submit").prop('disabled', false);
        } else {
            $("#submit").prop('disabled', true);
        }
    }

});