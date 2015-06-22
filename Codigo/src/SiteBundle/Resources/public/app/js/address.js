$(document).ready(function () {
    $('#estado').change(function () {
        $.get('/lista-municipios', {estado: $(this).val()}, function (data) {
            $('#municipio option').remove();

            $.each(data, function (i, v) {
                $('#municipio').append(new Option(v, i));
            })
        })
    })

    $('#municipio').change(function () {
        $.get('/lista-bairros', {municipio: $(this).val()}, function (data) {
            $('#bairro option').remove();

            $('#bairro').append(new Option('Todos os bairros', ''));
            $.each(data, function (i, v) {
                $('#bairro').append(new Option(v, i));
            })
        })
    })

    $('#menu-estado li').remove()

    var arrEstado = {
        1:  "Acre",
        2:  "Alagoas",
        3:  "Amazonas",
        4:  "Amapá",
        5:  "Bahia",
        6:  "Ceará",
        7:  "Distrito Federal",
        8:  "Espírito Santo",
        9:  "Goiás",
        10: "Maranhão",
        11: "Minas Gerais",
        12: "Mato Grosso do Sul",
        13: "Mato Grosso",
        14: "Pará",
        15: "Paraíba",
        16: "Pernambuco",
        17: "Piauí",
        18: "Paraná",
        19: "Rio de Janeiro",
        20: "Rio Grande do Norte",
        21: "Rondônia",
        22: "Roraima",
        23: "Rio Grande do Sul",
        24: "Santa Catarina",
        25: "Sergipe",
        26: "São Paulo",
        27: "Tocantins"
    }

    $.each(arrEstado, function (i, v) {
        var li = '<li><a href="' + $('#menu-estado').attr('data-url') + '?estado=' + i + '">' + v + '</a></li>'

        $('#menu-estado').append(li)
    })
});