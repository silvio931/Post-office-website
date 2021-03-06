$('document').ready(function () {

    function osvjezi(datumOd, datumDo) {
        var tbody = document.getElementById('tablica1').getElementsByTagName('tbody')[0];
        tbody.innerHTML = '';
        var tbody = document.getElementById('tablica2').getElementsByTagName('tbody')[0];
        tbody.innerHTML = '';
        $.ajax({
            url: '../php_provjere/statistika_placene_posiljke_xml.php?datumOd=' + datumOd + '&datumDo=' + datumDo,
            type: 'GET',
            dataType: 'xml',
            success: function (xml) {
                $(xml).find('drzava').each(function () {
                    var ime = $(this).find('ime').text();
                    var placene_posiljke = $(this).find('placene_posiljke').text();
                    if (ime !== "0") {
                        $('#tablica1').append('<tr><td>' + ime + '</td><td>' + placene_posiljke + '</td></tr>');
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

        $.ajax({
            url: '../php_provjere/statistika_neplacene_posiljke_xml.php?datumOd=' + datumOd + '&datumDo=' + datumDo,
            type: 'GET',
            dataType: 'xml',
            success: function (xml) {
                $(xml).find('drzava').each(function () {
                    var ime = $(this).find('ime').text();
                    var neplacene_posiljke = $(this).find('neplacene_posiljke').text();
                    if (ime !== "0") {
                        $('#tablica2').append('<tr><td>' + ime + '</td><td>' + neplacene_posiljke + '</td></tr>');
                    }
                });
                if ($.fn.dataTable.isDataTable('#tablica2')) {
                    table = $('#tablica2').DataTable();
                } else {
                    table = $('#tablica2').DataTable({
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

    var datumOdStart = "1970-01-01";
    var datumDoStart = "2070-01-01";
    osvjezi(datumOdStart, datumDoStart);

    $('#submitPrikaziSve').click(function () {
        var datumOdStart = "1970-01-01";
        var datumDoStart = "2070-01-01";
        osvjezi(datumOdStart, datumDoStart);
    });

    $('#submitFiltriraj').click(function () {
        var datum1 = $('#datumOd').val();
        var datumOd = datum1.slice(0, 10);

        var datum2 = $('#datumDo').val();
        var datumDo = datum2.slice(0, 10);

        osvjezi(datumOd, datumDo);
    });
});