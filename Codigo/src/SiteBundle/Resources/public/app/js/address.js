$('#idEstado').change(function () {
    $.get('/lista-municipios', {estado: $(this).val()}, function (data) {
        $('#idMunicipio option').remove();

        $.each(data, function (i, v) {
            $('#idMunicipio').append(new Option(v, i));
        })
    })
})

$('#idMunicipio').change(function () {
    $.get('/lista-bairros', {municipio: $(this).val()}, function (data) {
        $('#idBairro option').remove();

        $('#idBairro').append(new Option('Selecione', ''));
        $.each(data, function (i, v) {
            $('#idBairro').append(new Option(v, i));
        })
    })
})

$('#nuCep').blur(function () {
    $('.buscar-cep').click();
});

$('.buscar-cep').click(function () {
    if ($('#nuCep').val()) {
        $.ajax({
            url:  "/buscar-cep",
            data: {cep: $('#nuCep').val()}
        }).done(function (data) {
            if (data) {
                $('#idEstado').val(data.idEstado);
                $('#noLogradouro').val(data.noLogradouro);

                getMunicipio(data.idEstado, data.idMunicipio);
                getBairro(data.idMunicipio, data.idBairro);
            }
        });
    }
})

$('#idEstado').change(function () {
    if ($(this).val()) {
        getMunicipio($(this).val());
    }
})

$('#idMunicipio').change(function () {
    if ($(this).val()) {
        getBairro($(this).val());
    }
})

function getMunicipio(idEstado, idMunicipio) {
    $.ajax({
        url:  "/lista-municipios",
        data: {estado: idEstado}
    }).done(function (data) {
        $('#idMunicipio option').remove();

        $('#idMunicipio').append(new Option('Selecione', ''));
        $.each(data, function (i, v) {
            $('#idMunicipio').append(new Option(v, i));
        })

        if (idMunicipio) {
            $('#idMunicipio' + ' option[value=' + idMunicipio + ']').attr('selected', 'selected');
        }
    });
}

function getBairro(idMunicipio, idBairro) {
    $.ajax({
        url:  "/lista-bairros",
        data: {municipio: idMunicipio}
    }).done(function (data) {
        $('#idBairro option').remove();

        $('#idBairro').append(new Option('Selecione', ''));
        $.each(data, function (i, v) {
            $('#idBairro').append(new Option(v, i));
        })

        if (idBairro) {
            $('#idBairro' + ' option[value=' + idBairro + ']').attr('selected', 'selected');
        }
    });
}