$('document').ready(function () {
    $('#izdajRacun').hide();
    $.ajax({
        url: '../php_provjere/zahtjevi_xml.php',
        type: 'GET',
        dataType: 'xml',
        success: function (xml) {
            $(xml).find('zahtjev').each(function () {
                var korisnik = $(this).find('korisnik').text();
                var ime = $(this).find('ime').text();
                var prezime = $(this).find('prezime').text();
                var posiljka = $(this).find('posiljka').text();
                var ured = $(this).find('ured').text();
                var datum_izdavanja = $(this).find('datum_izdavanja').text();
                var racun_izdan = $(this).find('racun_izdan').text();
                if (korisnik !== '0') {
                    if (racun_izdan === '0') {
                        $('#tablica1').append('<tr><td>' + korisnik + '</td><td>' + ime + ' ' + prezime + '</td><td>' + posiljka + '</td><td>' + ured + '</td><td>' + datum_izdavanja + '</td><td>' + '<div id="izdaj" style="font-weight:bold;text-decoration: underline;color:blue">Izdaj račun</div>' + '</td></tr>');
                    }
                    if (racun_izdan === '1') {
                        $('#tablica1').append('<tr><td>' + korisnik + '</td><td>' + ime + ' ' + prezime + '</td><td>' + posiljka + '</td><td>' + ured + '</td><td>' + datum_izdavanja + '</td><td>' + 'Račun izdan.' + '</td></tr>');
                    }
                }


            });
            $("#tablica1").dataTable({
                "aaSorting": [[2, "asc"]],
                "bPaginate": true,
                "bLengthChange": true,
                "bFilter": true,
                "bSort": true,
                "bInfo": true,
                "bAutoWidth": true
            });
        }

    });


    $('#tablica1 tbody').on('click', '#izdaj', function () {
        id = ($(this).closest('tr')).find('td:eq(2)').text();
        korisnikID = ($(this).closest('tr')).find('td:eq(0)').text();

        $('#izdajRacun').show();
        $('#korisnikID').val(korisnikID);
        $('#posiljkaID').val(id);

        $.ajax({
            url: '../php_provjere/iznos_racuna_xml.php?posiljkaID=' + id,
            type: 'GET',
            dataType: 'xml',
            success: function (xml) {
                $(xml).find('posiljka').each(function () {
                    var cijena = $(this).find('cijena').text();
                    var tezina = $(this).find('tezina').text();

                    $('#jedCijena').val(cijena);
                    $('#tezina').val(tezina);


                });
            }

        });


    });

});