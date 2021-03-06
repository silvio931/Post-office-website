$('document').ready(function () {
    $('#dodajSljedeciUred').hide();

    $.ajax({
        url: '../php_provjere/zaprimanje_posiljki_xml.php',
        type: 'GET',
        dataType: 'xml',
        success: function (xml) {
            $(xml).find('posiljka').each(function () {
                var id = $(this).find('id').text();
                var pocetni = $(this).find('pocetni').text();
                var trenutni = $(this).find('trenutni').text();
                var sljedeci = $(this).find('sljedeci').text();
                var zavrsni = $(this).find('zavrsni').text();
                if (id != 0) {


                    $('#tablica1').append('<tr><td>' + id + '</td><td>' + pocetni + '</td><td>' + trenutni + '</td><td>' + sljedeci + '</td><td>' + zavrsni + '</td><td>' + '<div id="postavi" style="font-weight:bold;text-decoration: underline;color:blue">Odaberi</div>' + '</td></tr>');




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


    $('#tablica1 tbody').on('click', '#postavi', function () {
        id = ($(this).closest('tr')).find('td:eq(0)').text();
        sljedeci = ($(this).closest('tr')).find('td:eq(3)').text();
        zavrsni = ($(this).closest('tr')).find('td:eq(4)').text();

        $('#dodajSljedeciUred').show();
        $('#posiljkaID').val(id);



        if (sljedeci === zavrsni) {
            $('#sljedeciUredID').hide();
            $('#sljedeci').hide();
            $('#sljedeciUredlbl').hide();
            $('#sljedecilbl').hide();
            $('#submitSpremi').hide();
            $('#submitIsporuka').show();
        }

        if (sljedeci !== zavrsni) {
            $("#submitSpremi").attr("disabled", true);
            $('#sljedeciUredID').val("");
            $('#sljedeci').val("");

            $('#sljedeciUredID').show();
            $('#sljedeci').show();
            $('#sljedeciUredlbl').show();
            $('#sljedecilbl').show();
            $('#submitSpremi').show();
            $('#submitIsporuka').hide();
        }

        $.ajax({
            url: '../php_provjere/zaprimanje_posiljki_dohvati_id_xml.php?naziv=' + sljedeci,
            type: 'GET',
            dataType: 'xml',
            success: function (xml) {
                $(xml).find('ured').each(function () {
                    var trenutniID = $(this).find('id').text();

                    $('#trenutni').val(sljedeci);
                    $('#trenutniUredID').val(trenutniID);


                });
            }

        });

    });


    $('#sljedeci').blur(function () {
        $("#submitSpremi").attr("disabled", true);
        naziv = $('#sljedeci').val();


        $.ajax({
            url: '../php_provjere/zaprimanje_posiljki_dohvati_id_xml.php?naziv=' + naziv,
            type: 'GET',
            dataType: 'xml',
            success: function (xml) {
                $(xml).find('ured').each(function () {
                    var id = $(this).find('id').text();
                    if (id === '0') {
                        $('#sljedeciUredID').val("Ne postoji ovaj ured!");
                        $("#submitSpremi").attr("disabled", true);
                    }
                    if (id > 0) {
                        $('#sljedeciUredID').val(id);
                        $("#submitSpremi").attr("disabled", false);
                    }
                });
            }

        });
    });

});