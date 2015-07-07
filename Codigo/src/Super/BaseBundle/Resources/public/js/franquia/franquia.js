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
        $("#cepCarregando").modal('show');
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

                $("#cepCarregando").modal('hide');
            } else {
                $("#cepCarregando").modal('hide');
                $("#cepErro").modal('show');
            }
        }).fail(function (data) {
            $("#cepCarregando").modal('hide');
            $("#cepErro").modal('show');
        });
    }
});

$('.buscarCep').click(function ()
{
    if ($('#nuCep').val())
    {
        $("#cepCarregando").modal('show');
        $.ajax({
            url:  "/buscar-cep",
            data: {
                cep: $('#nuCep').val()
            }
        }).done(function (data) {
            if (data) {
                $('#idEstado').val(data.idEstado);
                $('#noLogradouro').val(data.noLogradouro);

                getMunicipio(data.idEstado, data.idMunicipio);
                getBairro(data.idMunicipio, data.idBairro);

                $("#cepCarregando").modal('hide');
            } else {
                $("#cepCarregando").modal('hide');
                $("#cepErro").modal('show');
            }
        }).fail(function (data) {
            $("#cepCarregando").modal('hide');
            $("#cepErro").modal('show');
        });
    }
})