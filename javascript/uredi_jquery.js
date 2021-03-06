$('document').ready(function () {
    $('#tablica2').hide();
    $.ajax({
        url: '../php_provjere/uredi_xml.php',
        type: 'GET',
        dataType: 'xml',
        success: function (xml) {
            $(xml).find('ured').each(function () {
                var id = $(this).find('id').text();
                var ime = $(this).find('ime').text();
                var korime = $(this).find('korime').text();
                var naziv = $(this).find('naziv').text();
                var adresa = $(this).find('adresa').text();
                var broj = $(this).find('broj').text();
                var brojposiljki = $(this).find('brojposiljki').text();
                $('#tablica1').append('<tr><td>' + id + '</td><td>' + ime + '</td><td>' + korime + '</td><td>' + naziv + '</td><td>' + adresa + '</td><td>' + broj + '</td><td>' + brojposiljki + '</td><td>' + '<div id="galerija" style="font-weight:bold;text-decoration: underline;color:blue">Prikaži</div>' + '</td></tr>');
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

    $('#tablica1 tbody').on('click', '#galerija', function () {
        $('#tablica2').show();
        id = ($(this).closest('tr')).find('td:eq(0)').text();

        //očisti tablicu od prethodnog zapisa
        var tbody = document.getElementById('tablica2').getElementsByTagName('tbody')[0];
        tbody.innerHTML = '';
        $.ajax({
            url: '../php_provjere/galerija_xml.php?IDureda=' + id,
            type: 'GET',
            dataType: 'xml',
            success: function (xml) {
                $(xml).find('galerija').each(function () {
                    var posiljkaid = $(this).find('posiljkaID').text();
                    var racunid = $(this).find('racunID').text();
                    var putanjaslike = $(this).find('putanja_slike').text();
                    var slikajavna = $(this).find('slika_javna').text();
                    if (posiljkaid != 0 && slikajavna == 1) {
                        $('#tablica2').append('<tr><td>' + posiljkaid + '</td><td>' + racunid + '</td><td>' + '<img src="../slike_racuna/' + putanjaslike + '" style="width:200px;">' + '</td></tr>');
                    }
                    if (posiljkaid != 0 && slikajavna == 0) {
                        $('#tablica2').append('<tr><td>' + posiljkaid + '</td><td>' + racunid + '</td><td>' + 'Slika nije javna.' + '</td></tr>');
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
    });

});