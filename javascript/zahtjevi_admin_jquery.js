$('document').ready(function () {
    $('#azurirajZahtjev').hide();

    function osvjezi() {
        var tbody = document.getElementById('tablica1').getElementsByTagName('tbody')[0];
        tbody.innerHTML = '';
        $.ajax({
            url: '../php_provjere/zahtjevi_admin_xml.php',
            type: 'GET',
            dataType: 'xml',
            success: function (xml) {
                $(xml).find('zahtjev').each(function () {
                    var ime = $(this).find('ime').text();
                    var prezime = $(this).find('prezime').text();
                    var id = $(this).find('id').text();
                    var datum_izdavanja = $(this).find('datum_izdavanja').text();
                    var izdan = $(this).find('izdan').text();
                    if (id != 0) {
                        if (izdan === '1') {
                            $('#tablica1').append('<tr><td>' + ime + ' ' + prezime + '</td><td>' + id + '</td><td>' + datum_izdavanja + '</td><td>' + 'Da' + '</td><td>' + '<div id="azuriraj" style="font-weight:bold;text-decoration: underline;color:blue">Ažuriraj</div>' + '</td><td>' + '<div id="obrisi" style="font-weight:bold;text-decoration: underline;color:blue">Obriši</div>' + '</td></tr>');
                        }
                        if (izdan === '0') {
                            $('#tablica1').append('<tr><td>' + ime + ' ' + prezime + '</td><td>' + id + '</td><td>' + datum_izdavanja + '</td><td>' + 'Ne' + '</td><td>' + '<div id="azuriraj" style="font-weight:bold;text-decoration: underline;color:blue">Ažuriraj</div>' + '</td><td>' + '<div id="obrisi" style="font-weight:bold;text-decoration: underline;color:blue">Obriši</div>' + '</td></tr>');
                        }
                    }
                });
                if ($.fn.dataTable.isDataTable('#tablica1')) {
                    table = $('#tablica1').DataTable();
                } else {
                    table = $('#tablica1').DataTable({
                        "aaSorting": [[1, "asc"]],
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

    $('#tablica1 tbody').on('click', '#obrisi', function () {
        id = ($(this).closest('tr')).find('td:eq(1)').text();

        $.ajax({
            url: '../php_provjere/obrisi_zahtjev_admin.php?posiljkaID=' + id,
            type: 'GET',
            datatype: 'xml',
            success: function (xml) {
                osvjezi();
            }
        });

    });



    $('#tablica1 tbody').on('click', '#azuriraj', function () {
        korisnik = ($(this).closest('tr')).find('td:eq(0)').text();
        posiljka = ($(this).closest('tr')).find('td:eq(1)').text();
        datum = ($(this).closest('tr')).find('td:eq(2)').text();
        izdan = ($(this).closest('tr')).find('td:eq(3)').text();


        $('#azurirajZahtjev').show();

        $('#korisnik').val(korisnik);
        $('#posiljkaID').val(posiljka);
        $('#datum').val(new Date(datum));
        $('#izdan').val(izdan);

    });



});