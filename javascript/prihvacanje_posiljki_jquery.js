$('document').ready(function () {
    $('#prihvatiPosiljku').hide();
    $("#submit").attr("disabled", true);
    spremiPocetni = false;
    spremiSljedeci = false;
    spremiZavrsni = false;

    $.ajax({
        url: '../php_provjere/prihvacanje_posiljki_xml.php',
        type: 'GET',
        dataType: 'xml',
        success: function (xml) {
            $(xml).find('posiljka').each(function () {
                var id = $(this).find('id').text();
                var posiljatelj_ime = $(this).find('posiljatelj_ime').text();
                var posiljatelj_prezime = $(this).find('posiljatelj_prezime').text();
                var primatelj_ime = $(this).find('primatelj_ime').text();
                var primatelj_prezime = $(this).find('primatelj_prezime').text();
                var datum_kreiranja = $(this).find('datum_kreiranja').text();
                var tezina = $(this).find('tezina').text();
                if (id != 0) {

                    $('#tablica1').append('<tr><td>' + id + '</td><td>' + posiljatelj_ime + ' ' + posiljatelj_prezime + '</td><td>' + primatelj_ime + ' ' + primatelj_prezime + '</td><td>' + datum_kreiranja + '</td><td>' + tezina + '</td><td>' + '<div id="odaberi" style="font-weight:bold;text-decoration: underline;color:blue">Odaberi</div>' + '</td></tr>');

                }
            });
            $("#tablica1").dataTable({
                "aaSorting": [[0, "asc"]],
                "bPaginate": true,
                "bLengthChange": true,
                "bFilter": true,
                "bSort": true,
                "bInfo": true,
                "bAutoWidth": true
            });
        }

    });


    $('#tablica1 tbody').on('click', '#odaberi', function () {
        id = ($(this).closest('tr')).find('td:eq(0)').text();

        $("#submit").attr("disabled", true);

        $('#prihvatiPosiljku').show();
        $('#posiljkaID').val(id);

        $('#pocetni').val("");
        $('#pocetniUredID').val("");
        $('#sljedeci').val("");
        $('#sljedeciUredID').val("");
        $('#zavrsni').val("");
        $('#zavrsniUredID').val("");

    });


    $('#pocetni').blur(function () {
        naziv = $('#pocetni').val();

        $.ajax({
            url: '../php_provjere/zaprimanje_posiljki_dohvati_id_xml.php?naziv=' + naziv,
            type: 'GET',
            dataType: 'xml',
            success: function (xml) {
                $(xml).find('ured').each(function () {
                    var id = $(this).find('id').text();
                    if (id === '0') {
                        $('#pocetniUredID').val("Ne postoji ovaj ured!");
                        spremiPocetni = false;
                        provjeri();
                    }
                    if (id > 0) {
                        $('#pocetniUredID').val(id);
                        spremiPocetni = true;
                        provjeri();
                    }
                });
            }
        });
    });

    $('#sljedeci').blur(function () {
        naziv = $('#sljedeci').val();

        $.ajax({
            url: '../php_provjere/zaprimanje_posiljki_dohvati_id_xml.php?naziv=' + naziv,
            type: 'GET',
            dataType: 'xml',
            success: function (xml) {
                $(xml).find('ured').each(function () {
                    var id = $(this).find('id').text();
                    if (id === '0') {
                        $('#sljedeciUredID').val("Ne postoji ovaj ured!");
                        spremiSljedeci = false;
                        provjeri();
                    }
                    if (id > 0) {
                        $('#sljedeciUredID').val(id);
                        spremiSljedeci = true;
                        provjeri();
                    }
                });
            }
        });
    });

    $('#zavrsni').blur(function () {
        naziv = $('#zavrsni').val();

        $.ajax({
            url: '../php_provjere/zaprimanje_posiljki_dohvati_id_xml.php?naziv=' + naziv,
            type: 'GET',
            dataType: 'xml',
            success: function (xml) {
                $(xml).find('ured').each(function () {
                    var id = $(this).find('id').text();
                    if (id === '0') {
                        $('#zavrsniUredID').val("Ne postoji ovaj ured!");
                        spremiZavrsni = false;
                        provjeri();
                    }
                    if (id > 0) {
                        $('#zavrsniUredID').val(id);
                        spremiZavrsni = true;
                        provjeri();
                    }
                });
            }
        });
    });

    //provjerava jesu li ispranvo uneseni svi uredi
    function provjeri() {
        if (spremiPocetni === true && spremiSljedeci === true && spremiZavrsni === true) {
            $("#submit").attr("disabled", false);
        } else {
            $("#submit").attr("disabled", true);
        }
    }

});