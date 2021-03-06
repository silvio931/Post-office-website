$('document').ready(function () {
    $('#naslovAzuriraj').hide();
    $('#submitAzuriraj').hide();

    $.ajax({
        url: '../php_provjere/drzave_xml.php',
        type: 'GET',
        dataType: 'xml',
        success: function (xml) {
            $(xml).find('drzava').each(function () {
                var id = $(this).find('id').text();
                var naziv = $(this).find('naziv').text();
                $('#tablica1').append('<tr><td>' + id + '</td><td>' + naziv + '</td><td>' + '<div id="azuriraj" style="font-weight:bold;text-decoration: underline;color:blue">Ažuriraj</div>' + '</td><td>' + '<div id="obrisi" style="font-weight:bold;text-decoration: underline;color:blue">Obriši</div>' + '</td></tr>');
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

    $('#tablica1 tbody').on('click', '#azuriraj', function () {
        id = ($(this).closest('tr')).find('td:eq(0)').text();
        naziv = ($(this).closest('tr')).find('td:eq(1)').text();
        $('#drzava').val(naziv);
        $('#naslovAzuriraj').show();
        $('#submitAzuriraj').show();
        $('#naslovDodaj').hide();
        $('#submitDodaj').hide();

        $("#submitAzuriraj").click(function () {
            noviNaziv = $('#drzava').val();
            $.ajax({
                url: '../php_provjere/azuriraj_drzavu.php?drzavaID=' + id + '&naziv=' + noviNaziv,
                type: 'GET',
                datatype: 'xml',
                success: function (xml) {
                    //ponovno učitava stranicu kako bi se ažurirala tablica
                    location.reload();
                }
            });
        });

    });

    $('#tablica1 tbody').on('click', '#obrisi', function () {
        id = ($(this).closest('tr')).find('td:eq(0)').text();
        $.ajax({
            url: '../php_provjere/obrisi_drzavu.php?drzavaID=' + id,
            type: 'GET',
            datatype: 'xml',
            success: function (xml) {
                //ponovno učitava stranicu kako bi se ažurirala tablica
                location.reload();
            }
        });
    });

});