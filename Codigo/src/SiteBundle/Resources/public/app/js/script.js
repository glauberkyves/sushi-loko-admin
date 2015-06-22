$(document).ready(function(){

    // JS of Denisson
    $(".gsearch-wrap .gsearchform .col-xs-12 a").click(function(){
        var buscaAvancada = $('.gsearch-wrap .gsearchform .gsearch-content .gsearch-field  section');
        if($(".buscaAvancadaAtivado").size() == 1)
        {
            buscaAvancada.fadeOut();
            $(this).removeClass("buscaAvancadaAtivado");
        }else{
            buscaAvancada.fadeIn();
            $(this).toggleClass("buscaAvancadaAtivado");
        }
    });

});
