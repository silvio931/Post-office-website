$('document').ready(function () {
    $('#blokirajRacun').hide();
    $('#azurirajKorisnika').hide();

    function osvjezi() {
        var tbody = document.getElementById('tablica1').getElementsByTagName('tbody')[0];
        tbody.innerHTML = '';
        $.ajax({
            url: '../php_provjere/blokiranje_otkljucavanje_racuna_xml.php',
            type: 'GET',
            dataType: 'xml',
            success: function (xml) {
                $(xml).find('korisnik').each(function () {
                    var id = $(this).find('id').text();
                    var uloga = $(this).find('uloga').text();
                    var status = $(this).find('status').text();
                    var ime = $(this).find('ime').text();
                    var prezime = $(this).find('prezime').text();
                    var korime = $(this).find('korime').text();
                    var lozinka = $(this).find('lozinka').text();
                    var email = $(this).find('email').text();
                    var blokiran_do = $(this).find('blokiran_do').text();
                    if (id != 0) {

                        if (status === "Blokiran") {
                            $('#tablica1').append('<tr><td>' + id + '</td><td>' + uloga + '</td><td>' + status + '</td><td>' + ime + '</td><td>' + prezime + '</td><td>' + korime + '</td><td>' + lozinka + '</td><td>' + email + '</td><td>' + blokiran_do + '</td><td>' + '<div id="otkljucaj" style="font-weight:bold;text-decoration: underline;color:blue">Otključaj</div>' + '</td><td>' + '<div id="azuriraj" style="font-weight:bold;text-decoration: underline;color:blue">Ažuriraj</div>' + '</td><td>' + '<div id="obrisi" style="font-weight:bold;text-decoration: underline;color:blue">Obriši</div>' + '</td></tr>');
                        } else {
                            $('#tablica1').append('<tr><td>' + id + '</td><td>' + uloga + '</td><td>' + status + '</td><td>' + ime + '</td><td>' + prezime + '</td><td>' + korime + '</td><td>' + lozinka + '</td><td>' + email + '</td><td>' + blokiran_do + '</td><td>' + '<div id="blokiraj" style="font-weight:bold;text-decoration: underline;color:blue">Blokiraj</div>' + '</td><td>' + '<div id="azuriraj" style="font-weight:bold;text-decoration: underline;color:blue">Ažuriraj</div>' + '</td><td>' + '<div id="obrisi" style="font-weight:bold;text-decoration: underline;color:blue">Obriši</div>' + '</td></tr>');
                        }

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

    //popunjava dropdown meni za ulogu
    $.ajax({
        url: '../php_provjere/uloga_xml.php',
        type: 'GET',
        dataType: 'xml',
        success: function (xml) {
            $(xml).find('uloga').each(function () {
                var id = $(this).find('id').text();
                var naziv = $(this).find('naziv').text();
                $('#uloga').append('<option value="' + id + '">' + naziv + '</option>');
            });
        }

    });

    //popunjava dropdown meni za status
    $.ajax({
        url: '../php_provjere/status_xml.php',
        type: 'GET',
        dataType: 'xml',
        success: function (xml) {
            $(xml).find('status').each(function () {
                var id = $(this).find('id').text();
                var naziv = $(this).find('naziv').text();
                $('#status').append('<option value="' + id + '">' + naziv + '</option>');
            });
        }

    });

    $('#tablica1 tbody').on('click', '#otkljucaj', function () {
        id = ($(this).closest('tr')).find('td:eq(0)').text();

        $.ajax({
            url: '../php_provjere/otkljucaj_racun.php?korisnikID=' + id,
            type: 'GET',
            datatype: 'xml',
            success: function (xml) {
                osvjezi();
            }
        });

    });

    $('#tablica1 tbody').on('click', '#blokiraj', function () {
        id = ($(this).closest('tr')).find('td:eq(0)').text();
        korisnik = ($(this).closest('tr')).find('td:eq(3)').text();

        $('#azurirajKorisnika').hide();
        $('#blokirajRacun').show();
        $('#korisnikID').val(id);
        $('#imePrezime').val(korisnik);

    });

    $('#tablica1 tbody').on('click', '#obrisi', function () {
        id = ($(this).closest('tr')).find('td:eq(0)').text();

        $.ajax({
            url: '../php_provjere/obrisi_korisnika.php?korisnikID=' + id,
            type: 'GET',
            datatype: 'xml',
            success: function (xml) {
                osvjezi();
            }
        });

    });

    $('#tablica1 tbody').on('click', '#azuriraj', function () {
        id = ($(this).closest('tr')).find('td:eq(0)').text();
        uloga = ($(this).closest('tr')).find('td:eq(1)').text();
        status = ($(this).closest('tr')).find('td:eq(2)').text();
        ime = ($(this).closest('tr')).find('td:eq(3)').text();
        prezime = ($(this).closest('tr')).find('td:eq(4)').text();
        korime = ($(this).closest('tr')).find('td:eq(5)').text();
        lozinka = ($(this).closest('tr')).find('td:eq(6)').text();
        email = ($(this).closest('tr')).find('td:eq(7)').text();

        $('#blokirajRacun').hide();
        $('#azurirajKorisnika').show();

        $('#korisnikID2').val(id);
        $("#uloga option:contains(" + uloga + ")").attr('selected', 'selected');
        $("#status option:contains(" + status + ")").attr('selected', 'selected');
        $('#ime').val(ime);
        $('#prezime').val(prezime);
        $('#korime').val(korime);
        $('#lozinka').val(lozinka);
        $('#email').val(email);
    });


});