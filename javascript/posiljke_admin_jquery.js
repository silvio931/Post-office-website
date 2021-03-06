$('document').ready(function () {
    $('#azurirajPosiljku').hide();

    function osvjezi() {
        var tbody = document.getElementById('tablica1').getElementsByTagName('tbody')[0];
        tbody.innerHTML = '';
        $.ajax({
            url: '../php_provjere/posiljke_admin_xml.php',
            type: 'GET',
            dataType: 'xml',
            success: function (xml) {
                $(xml).find('posiljka').each(function () {
                    var id = $(this).find('id').text();
                    var pocetni = $(this).find('pocetni').text();
                    var trenutni = $(this).find('trenutni').text();
                    var sljedeci = $(this).find('sljedeci').text();
                    var zavrsni = $(this).find('zavrsni').text();
                    var imePosiljatelj = $(this).find('imePosiljatelj').text();
                    var prezimePosiljatelj = $(this).find('prezimePosiljatelj').text();
                    var imePrimatelj = $(this).find('imePrimatelj').text();
                    var prezimePrimatelj = $(this).find('prezimePrimatelj').text();
                    var datum_otpreme = $(this).find('datum_otpreme').text();
                    var cijena = $(this).find('cijena').text();
                    var tezina = $(this).find('tezina').text();
                    var datum_pristizanja = $(this).find('datum_pristizanja').text();
                    var racun_id = $(this).find('racun_id').text();
                    if (id != 0) {


                        $('#tablica1').append('<tr><td>' + id + '</td><td>' + pocetni + '</td><td>' + trenutni + '</td><td>' + sljedeci + '</td><td>' + zavrsni + '</td><td>' + imePosiljatelj + ' ' + prezimePosiljatelj + '</td><td>' + imePrimatelj + ' ' + prezimePrimatelj + '</td><td>' + datum_otpreme + '</td><td>' + cijena + '</td><td>' + tezina + '</td><td>' + datum_pristizanja + '</td><td>' + racun_id + '</td><td>' + '<div id="azuriraj" style="font-weight:bold;text-decoration: underline;color:blue">Ažuriraj</div>' + '</td><td>' + '<div id="obrisi" style="font-weight:bold;text-decoration: underline;color:blue">Obriši</div>' + '</td></tr>');


                    }
                });
                if ($.fn.dataTable.isDataTable('#tablica1')) {
                    table = $('#tablica1').DataTable();
                } else {
                    table = $('#tablica1').DataTable({
                        "aaSorting": [[0, "asc"]],
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": true,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": true
                    });
                }
            }

        });
    }

    osvjezi();

    //popunjava dropdown meni za posiljatelja
    $.ajax({
        url: '../php_provjere/svi_korisnici_xml.php',
        type: 'GET',
        dataType: 'xml',
        success: function (xml) {
            $(xml).find('korisnik').each(function () {
                var id = $(this).find('id').text();
                var ime = $(this).find('ime').text();
                var prezime = $(this).find('prezime').text();
                $('#posiljatelj').append('<option value="' + id + '">' + ime + ' ' + prezime + '</option>');
            });
        }

    });



    //popunjava dropdown meni za primatelja
    $.ajax({
        url: '../php_provjere/svi_korisnici_xml.php',
        type: 'GET',
        dataType: 'xml',
        success: function (xml) {
            $(xml).find('korisnik').each(function () {
                var id = $(this).find('id').text();
                var ime = $(this).find('ime').text();
                var prezime = $(this).find('prezime').text();
                $('#primatelj').append('<option value="' + id + '">' + ime + ' ' + prezime + '</option>');
            });
        }

    });


    $('#tablica1 tbody').on('click', '#obrisi', function () {
        id = ($(this).closest('tr')).find('td:eq(0)').text();

        $.ajax({
            url: '../php_provjere/obrisi_posiljku.php?posiljkaID=' + id,
            type: 'GET',
            datatype: 'xml',
            success: function (xml) {
                osvjezi();
            }
        });

    });



    $('#tablica1 tbody').on('click', '#azuriraj', function () {
        $('#pocetniUredID').val("");
        $('#trenutniUredID').val("");
        $('#sljedeciUredID').val("");
        $('#zavrsniUredID').val("");

        id = ($(this).closest('tr')).find('td:eq(0)').text();
        pocetni = ($(this).closest('tr')).find('td:eq(1)').text();
        trenutni = ($(this).closest('tr')).find('td:eq(2)').text();
        sljedeci = ($(this).closest('tr')).find('td:eq(3)').text();
        zavrsni = ($(this).closest('tr')).find('td:eq(4)').text();
        posiljatelj = ($(this).closest('tr')).find('td:eq(5)').text();
        primatelj = ($(this).closest('tr')).find('td:eq(6)').text();
        cijena = ($(this).closest('tr')).find('td:eq(8)').text();
        tezina = ($(this).closest('tr')).find('td:eq(9)').text();
        racun = ($(this).closest('tr')).find('td:eq(11)').text();


        $('#azurirajPosiljku').show();

        $('#posiljkaID').val(id);
        $('#pocetni').val(pocetni);
        $('#trenutni').val(trenutni);
        $('#sljedeci').val(sljedeci);
        $('#zavrsni').val(zavrsni);
        $("#posiljatelj option:contains(" + posiljatelj + ")").attr('selected', 'selected');
        $("#primatelj option:contains(" + primatelj + ")").attr('selected', 'selected');
        $('#cijena').val(cijena);
        $('#tezina').val(tezina);
        $('#racun').val(racun);
    });


    // provjerava unesene nazive za urede, postoji li uneseni ured ili ne

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
                    }
                    if (id > 0) {
                        $('#pocetniUredID').val(id);
                    }
                });
            }
        });
    });

    $('#trenutni').blur(function () {
        naziv = $('#trenutni').val();

        $.ajax({
            url: '../php_provjere/zaprimanje_posiljki_dohvati_id_xml.php?naziv=' + naziv,
            type: 'GET',
            dataType: 'xml',
            success: function (xml) {
                $(xml).find('ured').each(function () {
                    var id = $(this).find('id').text();
                    if (id === '0') {
                        $('#trenutniUredID').val("Ne postoji ovaj ured!");
                    }
                    if (id > 0) {
                        $('#trenutniUredID').val(id);
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
                    }
                    if (id > 0) {
                        $('#sljedeciUredID').val(id);
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
                    }
                    if (id > 0) {
                        $('#zavrsniUredID').val(id);
                    }
                });
            }
        });
    });

});