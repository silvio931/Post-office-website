$('document').ready(function () {
    $('#placanjeRacuna').hide();
    $.ajax({
        url: '../php_provjere/moji_racuni_xml.php',
        type: 'GET',
        dataType: 'xml',
        success: function (xml) {
            $(xml).find('racun').each(function () {
                var racun = $(this).find('racun').text();
                var posiljka = $(this).find('posiljka').text();
                var ime = $(this).find('ime').text();
                var prezime = $(this).find('prezime').text();
                var datum_izdavanja = $(this).find('datum_izdavanja').text();
                var jedCijena = $(this).find('jedCijena').text();
                var tezina = $(this).find('tezina').text();
                var obrada = $(this).find('obrada').text();
                var cijena = $(this).find('cijena').text();
                var datum_placanja = $(this).find('datum_placanja').text();
                var putanjaSlike = $(this).find('putanjaSlike').text();
                var javna = $(this).find('javna').text();
                if (racun !== '0') {
                    if (datum_placanja !== "") {
                        if (javna === '1') {
                            $('#tablica1').append('<tr><td>' + racun + '</td><td>' + posiljka + '</td><td>' + ime + ' ' + prezime + '</td><td>' + datum_izdavanja + '</td><td>' + jedCijena + '</td><td>' + tezina + '</td><td>' + obrada + '</td><td>' + cijena + '</td><td>' + datum_placanja + '</td><td>' + '<img src="../slike_racuna/' + putanjaSlike + '" style="width:200px;">' + '</td><td>' + 'Da' + '</td><td>' + 'Račun plaćen.' + '</td></tr>');
                        }
                        if (javna === '0') {
                            $('#tablica1').append('<tr><td>' + racun + '</td><td>' + posiljka + '</td><td>' + ime + ' ' + prezime + '</td><td>' + datum_izdavanja + '</td><td>' + jedCijena + '</td><td>' + tezina + '</td><td>' + obrada + '</td><td>' + cijena + '</td><td>' + datum_placanja + '</td><td>' + '<img src="../slike_racuna/' + putanjaSlike + '" style="width:200px;">' + '</td><td>' + 'Ne' + '</td><td>' + 'Račun plaćen.' + '</td></tr>');
                        }
                    }
                    if (datum_placanja === "" && putanjaSlike === "" && javna === '0') {
                        $('#tablica1').append('<tr><td>' + racun + '</td><td>' + posiljka + '</td><td>' + ime + ' ' + prezime + '</td><td>' + datum_izdavanja + '</td><td>' + jedCijena + '</td><td>' + tezina + '</td><td>' + obrada + '</td><td>' + cijena + '</td><td>' + 'Račun nije plaćen.' + '</td><td>' + '-' + '</td><td>' + '-' + '</td><td>' + '<div id="platiRacun" style="font-weight:bold;text-decoration: underline;color:blue">Plati račun</div>' + '</td></tr>');
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


    $('#tablica1 tbody').on('click', '#platiRacun', function () {
        id = ($(this).closest('tr')).find('td:eq(0)').text();

        $('#placanjeRacuna').show();
        $('#racunID').val(id);

    });


});