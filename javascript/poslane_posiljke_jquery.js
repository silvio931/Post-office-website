$('document').ready(function () {
    $('#azuriranjePosiljke').hide();
    $.ajax({
        url: '../php_provjere/poslane_posiljke_xml.php',
        type: 'GET',
        dataType: 'xml',
        success: function (xml) {
            $(xml).find('posiljka').each(function () {
                var id = $(this).find('id').text();
                var ured = $(this).find('ured').text();
                var primateljID = $(this).find('primateljID').text();
                var ime = $(this).find('ime').text();
                var prezime = $(this).find('prezime').text();
                var tezina = $(this).find('tezina').text();
                var datum_otpreme = $(this).find('datum_otpreme').text();
                var datum_pristizanja = $(this).find('datum_pristizanja').text();
                var racun = $(this).find('racun').text();
                if (id != 0) {
                    if (ured === "") {
                        $('#tablica1').append('<tr><td>' + id + '</td><td>' + '<div style="color:red">Pošiljka još nije poslana.</div>' + '</td><td>' + primateljID + '</td><td>' + ime + ' ' + prezime + '</td><td>' + tezina + '</td><td>' + '-' + '</td><td>' + '<div style="color:red">Pošiljka nije pristigla na odredište.</div>' + '</td><td>' + '<div style="color:red">Račun nije izdan.</div>' + '</td><td>' + '<div id="azuriraj" style="font-weight:bold;text-decoration: underline;color:blue">Ažuriraj</div>' + '</td><td>' + '<div id="obrisi" style="font-weight:bold;text-decoration: underline;color:blue">Obriši</div>' + '</td></tr>');
                    }
                    if (ured !== "" && datum_pristizanja === "") {
                        $('#tablica1').append('<tr><td>' + id + '</td><td>' + ured + '</td><td>' + primateljID + '</td><td>' + ime + ' ' + prezime + '</td><td>' + tezina + '</td><td>' + datum_otpreme + '</td><td>' + '<div style="color:red">Pošiljka nije pristigla na odredište.</div>' + '</td><td>' + '<div style="color:red">Račun nije izdan.</div>' + '</td><td>' + '-' + '</td><td>' + '-' + '</td></tr>');
                    }
                    if (ured !== "" && datum_pristizanja !== "" && racun === "") {
                        $('#tablica1').append('<tr><td>' + id + '</td><td>' + ured + '</td><td>' + primateljID + '</td><td>' + ime + ' ' + prezime + '</td><td>' + tezina + '</td><td>' + datum_otpreme + '</td><td>' + datum_pristizanja + '<div style="color:green">Pošiljka spremna za isporuku!</div>' + '</td><td>' + '<div style="color:red">Račun nije izdan.</div>' + '</td><td>' + '-' + '</td><td>' + '-' + '</td></tr>');
                    }
                    if (ured !== "" && datum_pristizanja !== "" && racun !== "") {
                        $('#tablica1').append('<tr><td>' + id + '</td><td>' + ured + '</td><td>' + primateljID + '</td><td>' + ime + ' ' + prezime + '</td><td>' + tezina + '</td><td>' + datum_otpreme + '</td><td>' + datum_pristizanja + '<br>' + '<div style="color:green">Pošiljka isporučena!</div>' + '</td><td>' + racun + '</td><td>' + '-' + '</td><td>' + '-' + '</td></tr>');
                    }
                }
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


    $('#tablica1 tbody').on('click', '#obrisi', function () {
        id = ($(this).closest('tr')).find('td:eq(0)').text();
        $.ajax({
            url: '../php_provjere/obrisi_posiljku.php?posiljkaID=' + id,
            type: 'GET',
            datatype: 'xml',
            success: function (xml) {
                //ponovno učitava stranicu kako bi se ažurirala tablica
                location.reload();
            }
        });
    });

    $('#tablica1 tbody').on('click', '#azuriraj', function () {
        id = ($(this).closest('tr')).find('td:eq(0)').text();
        primateljID = ($(this).closest('tr')).find('td:eq(2)').text();
        tezina = ($(this).closest('tr')).find('td:eq(4)').text();

        $('#azuriranjePosiljke').show();
        $('#posiljkaID').val(id);
        $('#primatelj').val(primateljID);
        $('#tezina').val(tezina);

        var tbody = document.getElementById('tablica2').getElementsByTagName('tbody')[0];
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
                    $('#tablica2').append('<tr><td>' + id + '</td><td>' + ime + '</td><td>' + prezime + '</td><td>' + korime + '</td></tr>');
                });

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


    });

});