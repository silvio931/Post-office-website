$('document').ready(function () {

    $('#submitKorisnici').click(function () {

        //očisti tablicu od prethodnog zapisa
        var tbody = document.getElementById('tablica1').getElementsByTagName('tbody')[0];
        tbody.innerHTML = '';
        $.ajax({
            url: '../php_provjere/posiljke_korisnici_xml.php',
            type: 'GET',
            dataType: 'xml',
            success: function (xml) {
                $(xml).find('korisnik').each(function () {
                    var id = $(this).find('id').text();
                    var ime = $(this).find('ime').text();
                    var prezime = $(this).find('prezime').text();
                    var korime = $(this).find('korime').text();
                    $('#tablica1').append('<tr><td>' + id + '</td><td>' + ime + '</td><td>' + prezime + '</td><td>' + korime + '</td></tr>');
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
    });

});