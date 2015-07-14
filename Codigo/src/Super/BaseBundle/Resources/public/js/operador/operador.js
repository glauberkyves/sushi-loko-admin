jQuery.fn.autocompleteByName = function() {
    $(this).autocomplete({
        serviceUrl: "/super/franqueador/franquia/usuario/buscar?q=nome",
        type: "POST",
        minChars: 3,
        maxHeight: 400,
        onSelect: function (suggestion) {
            if(suggestion.data) {
                console.log(suggestion);
                $(this).closest('.divOperador').find("[name='idOperador[]']").val(suggestion.data);
                $(this).closest('.divOperador').find('#noEmail').val(suggestion.noEmail);
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
};

/*
* Inicio do cadastro dinamico do operador
*/

$(".noOperador").autocompleteByName();

$('#adicionarOperador').click(function(e){
    var i = $('.divOperador').length + 1;
    var div = document.getElementById('divOperador'), clone = div.cloneNode(true);

    clone.setAttribute('id', clone.id + i);
    clone.getElementsByClassName('remover')[0].setAttribute('onclick', "removeElement('"+clone.id+"')");
    clone.getElementsByClassName('titulo')[0].textContent = i+'º Operador';
    clone.getElementsByClassName('noOperador')[0].setAttribute('class', 'form-control required noOperador'+i);

    $('#form-franquia-operador .operadores').append(clone);
    $('.noOperador'+i).autocompleteByName();
});

function removeElement(id) {
    if($('.divOperador').length > 1) {
        var i = 1;
        $('#' + id).remove();
        $('.divOperador').each(function () {
            $(this).find('.titulo').text(i + "º Operador");
            i++;
        });
    }
}