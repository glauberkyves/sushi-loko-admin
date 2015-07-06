$('#idPromocao').multiSelect();

$('.datepicker').datepicker({
    format: 'dd/mm/yyyy',
    language: 'pt-BR'
});

$("#noEmailResponsavel").autocomplete({
    serviceUrl: "/super/franquia/usuario/buscar",
    type: "POST",
    minChars: 3,
    maxHeight: 400,
    onSelect: function (suggestion) {
        if(suggestion.data) {
            $('#idResponsavel').val(suggestion.data);
            $('#form-franquia input[id=noResponsavel]').val(suggestion.noPessoa);
        } else {
            $("#noEmailResponsavel").val("");
        }
    },
    onSearchStart: function(){
        $(this).addClass("spinner");
    },
    onSearchComplete:function(){
        $(this).removeClass("spinner");
    },
    onSearchError:function(){
        $(this).removeClass("spinner");
    }
});

$("#noEmailOperador").autocomplete({
    serviceUrl: "/super/franquia/usuario/buscar",
    type: "POST",
    minChars: 3,
    maxHeight: 400,
    onSelect: function (suggestion) {
        if(suggestion.data) {
            $('#idOperador').val(suggestion.data);
            $('#form-franquia input[id=noOperador]').val(suggestion.noPessoa);
        } else {
            $("#noEmailOperador").val("");
        }
    },
    onSearchStart: function(){
        $(this).addClass("spinner");
    },
    onSearchComplete:function(){
        $(this).removeClass("spinner");
    },
    onSearchError:function(){
        $(this).removeClass("spinner");
    }
});

$('#cadastrarResponsavel').click(function(e)
{
    e.preventDefault();

    var $button = $(this);
    var $form   = $('#form-cadastrar-usuario');

    if($form.valid())
    {
        $button.hide();

        $.post('/super/usuario/cadastro.html', $form.serialize())
            .done(function(data){
                if(data.valido) {
                    $('#idResponsavel').val(data.id_usuario);
                    $('#form-franquia input[id=noResponsavel]').val(data.noPessoa);
                    $('#form-franquia input[id=noEmailResponsavel]').val(data.noEmail);

                    $('#cadastrarUsuario').modal('hide');
                }
            })
            .fail(function(data) {
                console.log(data);
            });
    }
});

$('#cadastrarOperador').click(function(e)
{
    e.preventDefault();

    var $button = $(this);
    var $form   = $('#form-cadastrar-usuario');

    if($form.valid())
    {
        $button.hide();

        $.post('/super/usuario/cadastro.html', $form.serialize())
            .done(function(data){
                if(data.valido) {
                    $('#idResponsavel').val(data.id_usuario);
                    $('#form-franquia input[id=noOperador]').val(data.noPessoa);
                    $('#form-franquia input[id=noEmailOperador]').val(data.noEmail);

                    $('#cadastrarUsuario').modal('hide');
                }
            })
            .fail(function(data) {
                console.log(data);
            });
    }
});

$('.cadastrarOperador').click(function(e)
{
    $('#form-cadastrar-usuario').get(0).reset();
    $('#cadastrarResponsavel').hide();
    $('#cadastrarOperador').show();
});

$('.cadastrarResponsavel').click(function(e)
{
    $('#form-cadastrar-usuario').get(0).reset();
    $('#cadastrarOperador').hide();
    $('#cadastrarResponsavel').show();
});

$('#nuCep').on("keyup", function (e)
{
    var cep = $.trim($('#nuCep').val()).replace('-', '');
    if (cep.length >= 8)
    {
        $("#nuCep").addClass("spinner");
        $('#noLogradouro').focus();

        $.ajax({
            url: "/buscar-cep",
            data: {
                cep: $('#nuCep').val()
            }
        }).done(function (data) {
            if (data) {
                $('#idEstado').val(data.idEstado);
                $('#noLogradouro').val(data.noLogradouro);

                getMunicipio(data.idEstado, data.idMunicipio);
                getBairro(data.idMunicipio, data.idBairro);
            } else {
                $("#cepErro").modal('show');
                $("#nuCep").removeClass("spinner");
            }
        }).fail(function (data) {
            $("#nuCep").removeClass("spinner");
        });
    }
});

$('#idEstado').change(function () {
    if ($(this).val()) {
        getMunicipio($(this).val());
    }
});

$('#idMunicipio').change(function () {
    if ($(this).val()) {
        getBairro($(this).val());
    }
});

function getMunicipio(idEstado, idMunicipio)
{
    $.ajax({
        url: "/lista-municipios",
        data: {
            estado: idEstado
        }
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

function getBairro(idMunicipio, idBairro)
{
    $.ajax({
        url: "/lista-bairros",
        data: {
            municipio: idMunicipio
        },
        complete:   function () {
            $("#nuCep").removeClass("spinner");
        }
    }).done(function (data)
    {
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