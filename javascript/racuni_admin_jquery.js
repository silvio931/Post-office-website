$('document').ready(function () {
    $('#azurirajRacun').hide();

    function osvjezi() {
        var tbody = document.getElementById('tablica1').getElementsByTagName('tbody')[0];
        tbody.innerHTML = '';
        $.ajax({
            url: '../php_provjere/racuni_admin_xml.php',
            type: 'GET',
            dataType: 'xml',
            success: function (xml) {
                $(xml).find('racun').each(function () {
                    var id = $(this).find('id').text();
                    var imeIzdao = $(this).find('imeIzdao').text();
                    var prezimeIzdao = $(this).find('prezimeIzdao').text();
                    var imePrimatelj = $(this).find('imePrimatelj').text();
                    var prezimePrimatelj = $(this).find('prezimePrimatelj').text();
                    var datum_izdavanja = $(this).find('datum_izdavanja').text();
                    var cijena_kg = $(this).find('cijena_kg').text();
                    var tezina = $(this).find('tezina').text();
                    var obrada = $(this).find('obrada').text();
                    var cijena = $(this).find('cijena').text();
                    var datum_placanja = $(this).find('datum_placanja').text();
                    var putanja_slike = $(this).find('putanja_slike').text();
                    var javna = $(this).find('javna').text();
                    if (id != 0) {

                        if (javna === '1') {
                            $('#tablica1').append('<tr><td>' + id + '</td><td>' + imeIzdao + ' ' + prezimeIzdao + '</td><td>' + imePrimatelj + ' ' + prezimePrimatelj + '</td><td>' + datum_izdavanja + '</td><td>' + cijena_kg + '</td><td>' + tezina + '</td><td>' + obrada + '</td><td>' + cijena + '</td><td>' + datum_placanja + '</td><td>' + putanja_slike + '</td><td>' + '<img src="../slike_racuna/' + putanja_slike + '" style="width:200px;">' + '</td><td>' + 'Da' + '</td><td>' + '<div id="azuriraj" style="font-weight:bold;text-decoration: underline;color:blue">Ažuriraj</div>' + '</td><td>' + '<div id="obrisi" style="font-weight:bold;text-decoration: underline;color:blue">Obriši</div>' + '</td></tr>');
                        }
                        if (javna === '0') {
                            $('#tablica1').append('<tr><td>' + id + '</td><td>' + imeIzdao + ' ' + prezimeIzdao + '</td><td>' + imePrimatelj + ' ' + prezimePrimatelj + '</td><td>' + datum_izdavanja + '</td><td>' + cijena_kg + '</td><td>' + tezina + '</td><td>' + obrada + '</td><td>' + cijena + '</td><td>' + datum_placanja + '</td><td>' + putanja_slike + '</td><td>' + '<img src="../slike_racuna/' + putanja_slike + '" style="width:200px;">' + '</td><td>' + 'Ne' + '</td><td>' + '<div id="azuriraj" style="font-weight:bold;text-decoration: underline;color:blue">Ažuriraj</div>' + '</td><td>' + '<div id="obrisi" style="font-weight:bold;text-decoration: underline;color:blue">Obriši</div>' + '</td></tr>');
                        }
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
                $('#izdao').append('<option value="' + id + '">' + ime + ' ' + prezime + '</option>');
            });
        }

    });



    //popunjava dropdown meni za primatelja
    $.ajax({
        url: '../php_provjere/svi_korisnici_xml.php',
        type: 'GET',
        dataType: 'xml',
        success: function (xml) {
            $(xml).find('korisnik').each(function () {
                var id = $(this).find('id').text();
                var ime = $(this).find('ime').text();
                var prezime = $(this).find('prezime').text();
                $('#primatelj').append('<option value="' + id + '">' + ime +  ' ' + prezime + '</option>');
            });
        }

    });




    $('#tablica1 tbody').on('click', '#obrisi', function () {
        id = ($(this).closest('tr')).find('td:eq(0)').text();

        $.ajax({
            url: '../php_provjere/obrisi_racun_admin.php?racunID=' + id,
            type: 'GET',
            datatype: 'xml',
            success: function (xml) {
                osvjezi();
            }
        });

    });



    $('#tablica1 tbody').on('click', '#azuriraj', function () {
        id = ($(this).closest('tr')).find('td:eq(0)').text();
        izdao = ($(this).closest('tr')).find('td:eq(1)').text();
        primatelj = ($(this).closest('tr')).find('td:eq(2)').text();
        cijena = ($(this).closest('tr')).find('td:eq(4)').text();
        tezina = ($(this).closest('tr')).find('td:eq(5)').text();
        obrada = ($(this).closest('tr')).find('td:eq(6)').text();
        putanja = ($(this).closest('tr')).find('td:eq(9)').text();
        javna = ($(this).closest('tr')).find('td:eq(11)').text();

        $('#azurirajRacun').show();

        $('#racunID').val(id);
        $("#izdao option:contains(" + izdao + ")").attr('selected', 'selected');
        $("#primatelj option:contains(" + primatelj + ")").attr('selected', 'selected');
        $('#cijena_kg').val(cijena);
        $('#tezina').val(tezina);
        $('#obrada').val(obrada);
        $('#putanja').val(putanja);
        $('#javna').val(javna);
    });



});