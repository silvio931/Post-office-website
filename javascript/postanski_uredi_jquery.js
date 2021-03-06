$('document').ready(function () {
    $('#naslovAzuriraj').hide();
    $('#submitAzuriraj').hide();
    $('#ured').hide();
    $('#uredID').hide();

    function osvjezi() {
        var tbody = document.getElementById('tablica1').getElementsByTagName('tbody')[0];
        tbody.innerHTML = '';
        $.ajax({
            url: '../php_provjere/postanski_uredi_xml.php',
            type: 'GET',
            dataType: 'xml',
            success: function (xml) {
                $(xml).find('ured').each(function () {
                    var id = $(this).find('id').text();
                    var drzava = $(this).find('drzava').text();
                    var ime = $(this).find('ime').text();
                    var prezime = $(this).find('prezime').text();
                    var naziv = $(this).find('naziv').text();
                    var adresa = $(this).find('adresa').text();
                    var broj_zaposlenih = $(this).find('broj_zaposlenih').text();
                    if (id !== '0') {
                        $('#tablica1').append('<tr><td>' + id + '</td><td>' + drzava + '</td><td>' + ime + ' ' + prezime + '</td><td>' + naziv + '</td><td>' + adresa + '</td><td>' + broj_zaposlenih + '</td><td>' + '<div id="azuriraj" style="font-weight:bold;text-decoration: underline;color:blue">Ažuriraj</div>' + '</td><td>' + '<div id="obrisi" style="font-weight:bold;text-decoration: underline;color:blue">Obriši</div>' + '</td></tr>');
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



    //popunjava dropdown meni za države
    $.ajax({
        url: '../php_provjere/drzave_xml.php',
        type: 'GET',
        dataType: 'xml',
        success: function (xml) {
            $(xml).find('drzava').each(function () {
                var id = $(this).find('id').text();
                var naziv = $(this).find('naziv').text();
                $('#drzave').append('<option value="' + id + '">' + naziv + '</option>');
            });
        }

    });

    //popunjava dropdown meni za moderatore
    $.ajax({
        url: '../php_provjere/moderatori_xml.php',
        type: 'GET',
        dataType: 'xml',
        success: function (xml) {
            $(xml).find('moderator').each(function () {
                var id = $(this).find('id').text();
                var ime = $(this).find('ime').text();
                var prezime = $(this).find('prezime').text();
                $('#moderator').append('<option value="' + id + '">' + ime + ' ' + prezime + '</option>');
            });
        }

    });


    $('#tablica1 tbody').on('click', '#azuriraj', function () {
        id = ($(this).closest('tr')).find('td:eq(0)').text();
        drzava = ($(this).closest('tr')).find('td:eq(1)').text();
        moderator = ($(this).closest('tr')).find('td:eq(2)').text();
        naziv = ($(this).closest('tr')).find('td:eq(3)').text();
        adresa = ($(this).closest('tr')).find('td:eq(4)').text();
        brojZaposlenih = ($(this).closest('tr')).find('td:eq(5)').text();


        $('#naslovAzuriraj').show();
        $('#naslovDodaj').hide();
        $('#ured').show();
        $('#uredID').show();
        $('#submitAzuriraj').show();
        $('#submitDodaj').hide();

        $('#uredID').val(id);
        $("#drzave option:contains(" + drzava + ")").attr('selected', 'selected');
        $("#moderator option:contains(" + moderator + ")").attr('selected', 'selected');
        $('#naziv').val(naziv);
        $('#adresa').val(adresa);
        $('#brojZaposlenih').val(brojZaposlenih);

    });

    $('#tablica1 tbody').on('click', '#obrisi', function () {
        id = ($(this).closest('tr')).find('td:eq(0)').text();
        $.ajax({
            url: '../php_provjere/obrisi_postanski_ured.php?uredID=' + id,
            type: 'GET',
            datatype: 'xml',
            success: function (xml) {
                osvjezi();
            }
        });
    });

});