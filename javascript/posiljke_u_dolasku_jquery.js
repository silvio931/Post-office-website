$('document').ready(function () {
$('#tablicaDetalji').hide();
    $.ajax({
        url: '../php_provjere/posiljke_u_dolasku_xml.php',
        type: 'GET',
        dataType: 'xml',
        success: function (xml) {
            $(xml).find('posiljka').each(function () {
                var id = $(this).find('id').text();
                var ured = $(this).find('ured').text();
                var datum_pristizanja = $(this).find('datum_pristizanja').text();
                var racun = $(this).find('racun').text();
                if (id != 0) {
                    if (datum_pristizanja === "" && ured === "") {
                        $('#tablica1').append('<tr><td>' + id + '</td><td>' + '<div style="color:red">Pošiljka još nije poslana.</div>' + '</td><td>' + '<div style="color:red">Pošiljka nije pristigla na odredište.</div>' + '</td><td>' + '-' + '</td></tr>');
                    }
                    if (datum_pristizanja === "" && ured !== "") {
                        $('#tablica1').append('<tr><td>' + id + '</td><td>' + ured + '</td><td>' + '<div style="color:red">Pošiljka nije pristigla na odredište.</div>' + '</td><td>' + '-' + '</td></tr>');
                    }
                    if (datum_pristizanja !== "" && racun === "") {
                        $('#tablica1').append('<tr><td>' + id + '</td><td>' + ured + '</td><td>' + datum_pristizanja + '<div style="color:green">Pošiljka spremna za isporuku!</div>' + '</td><td>' + '<div id="detalji" style="font-weight:bold;text-decoration: underline;color:blue">Detalji</div>' + '</td></tr>');
                    }
                    if (datum_pristizanja !== "" && racun !== "") {
                        $('#tablica1').append('<tr><td>' + id + '</td><td>' + ured + '</td><td>' + datum_pristizanja + '<div style="color:green">Pošiljka isporučena!</div>' + '</td><td>' + '<div id="detalji" style="font-weight:bold;text-decoration: underline;color:blue">Detalji</div>' + '</td></tr>');
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

    $('#tablica1 tbody').on('click', '#detalji', function () {
        $('#tablicaDetalji').show();
        var tbody = document.getElementById('tablica2').getElementsByTagName('tbody')[0];
        tbody.innerHTML = '';
        id = ($(this).closest('tr')).find('td:eq(0)').text();
        $.ajax({
            url: '../php_provjere/detalji_posiljke.php?posiljkaID=' + id,
            type: 'GET',
            datatype: 'xml',
            success: function (xml) {
                $(xml).find('posiljka').each(function () {
                    var id = $(this).find('id').text();
                    var ured = $(this).find('ured').text();
                    var ime = $(this).find('ime').text();
                    var prezime = $(this).find('prezime').text();
                    var datum_otpreme = $(this).find('datum_otpreme').text();
                    var datum_pristizanja = $(this).find('datum_pristizanja').text();
                    var cijena = $(this).find('cijena').text();
                    var tezina = $(this).find('tezina').text();
                    var racun = $(this).find('racun').text();
                    var zahtjev = $(this).find('zahtjev').text();
                    if (id != 0) {
                        if (datum_pristizanja === "") {
                            $('#tablica2').append('<tr><td>' + id + '</td><td>' + ured + '</td><td>' + ime + ' ' + prezime + '</td><td>' + datum_otpreme + '</td><td>' + '<div style="color:red">Pošiljka nije pristigla na odredište.</div>' + '</td><td>' + cijena + '</td><td>' + tezina + '</td><td>' + '<div style="color:red">Račun nije izdan.</div>' + '</td></tr>');
                        }
                        if (datum_pristizanja !== "" && racun === "" && zahtjev === "") {
                            $('#tablica2').append('<tr><td>' + id + '</td><td>' + ured + '</td><td>' + ime + ' ' + prezime + '</td><td>' + datum_otpreme + '</td><td>' + datum_pristizanja + '<div style="color:green">Pošiljka spremna za isporuku!</div>' + '</td><td>' + cijena + '</td><td>' + tezina + '</td><td>' + '<div style="color:red">Račun nije izdan.</div>' + '</td><td>' + '<div id="racun" style="text-decoration: underline;color:blue">Zatraži račun.</div>' + '</td></tr>');
                        }
                        if (datum_pristizanja !== "" && racun === "" && zahtjev !== "") {
                            $('#tablica2').append('<tr><td>' + id + '</td><td>' + ured + '</td><td>' + ime + ' ' + prezime + '</td><td>' + datum_otpreme + '</td><td>' + datum_pristizanja + '<div style="color:green">Pošiljka spremna za isporuku!</div>' + '</td><td>' + cijena + '</td><td>' + tezina + '</td><td>' + '<div style="color:red">Račun nije izdan.</div>' + '</td><td>' + 'Zahtjev za račun već poslan.' + '</td></tr>');
                        }
                        if (datum_pristizanja !== "" && racun !== "") {
                            $('#tablica2').append('<tr><td>' + id + '</td><td>' + ured + '</td><td>' + ime + ' ' + prezime + '</td><td>' + datum_otpreme + '</td><td>' + datum_pristizanja + '<br>' + '<div style="color:green">Pošiljka isporučena!</div>' + '</td><td>' + cijena + '</td><td>' + tezina + '</td><td>' + racun + '</td></tr>');
                        }
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

    $('#tablica2 tbody').on('click', '#racun', function () {
        id = ($(this).closest('tr')).find('td:eq(0)').text();
        $.ajax({
            url: '../php_provjere/zatrazi_racun.php?posiljkaID=' + id,
            type: 'GET',
            datatype: 'xml',
            success: function (xml) {
                //simulira klik na polje detalji u tablici kako bi se u tablici upisalo da je zahtjev
                //za izdavanjem računa već poslan
                $('#detalji').trigger('click');
            }
        });
    });

});