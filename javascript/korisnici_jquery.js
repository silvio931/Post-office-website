$('document').ready(function () {

    $.ajax({
        url: '../php_provjere/korisnici_xml.php',
        type: 'GET',
        dataType: 'xml',
        success: function (xml) {
            $(xml).find('korisnik').each(function () {
                var korime = $(this).find('korime').text();
                var prezime = $(this).find('prezime').text();
                var ime = $(this).find('ime').text();
                var email = $(this).find('email').text();
                var lozinka = $(this).find('lozinka').text();

                $('#tablica1').append('<tr><td>' + korime + '</td><td>' + prezime + '</td><td>' + ime + '</td><td>' + email + '</td><td>' + lozinka + '</td></tr>');

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

});