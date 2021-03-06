$('document').ready(function () {
    $('#blokiranjeKorisnika').hide();
    $.ajax({
        url: '../php_provjere/izdani_racuni_xml.php',
        type: 'GET',
        dataType: 'xml',
        success: function (xml) {
            $(xml).find('racun').each(function () {
                var racunID = $(this).find('racunID').text();
                var primatelj = $(this).find('primatelj').text();
                var ime = $(this).find('ime').text();
                var prezime = $(this).find('prezime').text();
                var datum_izdavanja = $(this).find('datum_izdavanja').text();
                var jedCijena = $(this).find('jedCijena').text();
                var tezina = $(this).find('tezina').text();
                var obrada = $(this).find('obrada').text();
                var ukupna_cijena = $(this).find('ukupna_cijena').text();
                var datum_placanja = $(this).find('datum_placanja').text();
                var putanja_slike = $(this).find('putanja_slike').text();
                var slika_javna = $(this).find('slika_javna').text();
                var blokiran = $(this).find('blokiran').text();
                if (racunID != 0) {
                    if (datum_placanja === "") {
                        if (blokiran === "") {
                            $('#tablica1').append('<tr><td>' + racunID + '</td><td>' + primatelj + '</td><td>' + ime + ' ' + prezime + '</td><td>' + datum_izdavanja + '</td><td>' + jedCijena + '</td><td>' + tezina + '</td><td>' + obrada + '</td><td>' + ukupna_cijena + '</td><td>' + '<div style="color:red">Račun nije plaćen!</div>' + '</td><td>' + '-' + '</td><td>' + '-' + '</td><td>' + '<div id="detalji" style="font-weight:bold;text-decoration: underline;color:blue">Detalji</div>' + '</td></tr>');
                        }
                        if (blokiran !== "") {
                            $('#tablica1').append('<tr><td>' + racunID + '</td><td>' + primatelj + '</td><td>' + ime + ' ' + prezime + '</td><td>' + datum_izdavanja + '</td><td>' + jedCijena + '</td><td>' + tezina + '</td><td>' + obrada + '</td><td>' + ukupna_cijena + '</td><td>' + '<div style="color:red">Račun nije plaćen!<br>Korisnik blokiran.</div>' + '</td><td>' + '-' + '</td><td>' + '-' + '</td><td>' + '<div id="detalji" style="font-weight:bold;text-decoration: underline;color:blue">Detalji</div>' + '</td></tr>');
                        }
                    }
                    if (datum_placanja !== "") {
                        if (slika_javna === '1') {
                            $('#tablica1').append('<tr><td>' + racunID + '</td><td>' + primatelj + '</td><td>' + ime + ' ' + prezime + '</td><td>' + datum_izdavanja + '</td><td>' + jedCijena + '</td><td>' + tezina + '</td><td>' + obrada + '</td><td>' + ukupna_cijena + '</td><td>' + datum_placanja + '</td><td>' + '<img src="../slike_racuna/' + putanja_slike + '" style="width:200px;">' + '</td><td>' + 'Da' + '</td><td>' + '-' + '</td></tr>');
                        }
                        if (slika_javna === '0') {
                            $('#tablica1').append('<tr><td>' + racunID + '</td><td>' + primatelj + '</td><td>' + ime + ' ' + prezime + '</td><td>' + datum_izdavanja + '</td><td>' + jedCijena + '</td><td>' + tezina + '</td><td>' + obrada + '</td><td>' + ukupna_cijena + '</td><td>' + datum_placanja + '</td><td>' + '<img src="../slike_racuna/' + putanja_slike + '" style="width:200px;">' + '</td><td>' + 'Ne' + '</td><td>' + '-' + '</td></tr>');
                        }
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
        id = ($(this).closest('tr')).find('td:eq(0)').text();
        primateljID = ($(this).closest('tr')).find('td:eq(1)').text();
        primatelj = ($(this).closest('tr')).find('td:eq(2)').text();
        izdan = ($(this).closest('tr')).find('td:eq(3)').text();
        var sada = new Date();
        var datum = new Date(izdan);
        var dani = (sada.getTime() - datum.getTime()) / 1000 / 60 / 60 / 24;
        blokiran = ($(this).closest('tr')).find('td:eq(8)').text();

        $('#blokiranjeKorisnika').show();
        $('#racunID').val(id);
        $('#primateljID').val(primateljID);
        $('#primatelj').val(primatelj);
        $('#dani').val(parseInt(dani));
        if (dani <= 7 || blokiran === "Račun nije plaćen!Korisnik blokiran.") {
            $("#submit").attr("disabled", true);
        }
        if (dani > 7 && blokiran !== "Račun nije plaćen!Korisnik blokiran.") {
            $("#submit").attr("disabled", false);
        }

    });

});