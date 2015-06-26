$.extend($.fn, {
    grid: function (options) {
        return new $.componentGrid(this, options);
    }
});

$.componentGrid = function (element, options) {
    this.init(element, options);
};

$.extend($.componentGrid, {
    grid:    null,
    data:    null,
    options: {
        processing:       true,
        serverSide:       true,
        sAjaxSource:      false,
        AutoWidth:        false,
        bProcessing:      true,
        bServerSide:      true,
        columns:          [],
        bFilter:          false,
        bLengthChange:    false,
        iDisplayLength:   5,
        iDisplayStart:    1,
        bDestroy:         true,
        paginationGrid:   true,
        fnServerParams:   false,
        "fnDrawCallback": function (oSettings) {

//            if ($.componentGrid.data != null) {
//                var idName = $.componentGrid.grid.attr('id');
//                var html = '<div class="recipiente col-md-24">';
//
//                $('#' + idName + '-last').html('');
//
//                $.each($.componentGrid.data, function (i, v) {
//                    $.each($.componentGrid.options.columns, function (ind, val) {
//                        var column = val.data;
//
//                        html = html + '<div data-original-title="';
//                        html = html + $.componentGrid.data[i][column];
//                        html = html + '" class="col-md-24 balao" data-toggle="tooltip" data-placement="bottom" title="';
//                        html = html + $.componentGrid.data[i][column];
//                        html = html + '">';
//                        html = html + $.componentGrid.data[i][column];
//                        html = html + '</div >';
//                    });
//                });
//
//                html = html + '</div>';
//
//                $('#' + idName + '-last').html(html);
//            }
//
//            if (oSettings.jqXHR.responseJSON.aaData.length > 0) {
//                $.componentGrid.data = oSettings.jqXHR.responseJSON.aaData;
//            }
        },
        "oLanguage":      {
            "sEmptyTable":     "Nenhum registro encontrado",
            "sInfo":           "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered":   "(Filtrados de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sInfoThousands":  ".",
            "sLengthMenu":     "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing":     "Processando...",
            "sZeroRecords":    "Nenhum registro encontrado",
            "sSearch":         "Pesquisar",
            "oPaginate":       {
                "sNext":     "Próximo",
                "sPrevious": "Anterior",
                "sFirst":    "Primeiro",
                "sLast":     "Último"
            },
            "oAria":           {
                "sSortAscending":  ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            }
        }
    },

    prototype: {
        init: function (element, options) {
            this.grid = element;
            this.form = $('[id=' + element.attr('data-grid') + ']');

            element.find('[data-column]').each(function(i, v){
                var column = $(this).attr('data-column')
                $.componentGrid.options.columns.push({data: column});
            });

            $.componentGrid.options.sAjaxSource = this.form.attr('action');
            $.extend($.componentGrid.options, options);

            if ($.componentGrid.options.paginationGrid) {
                this.form.on("submit", function () {
                    var params = $(this).serializeArray();

                    $.componentGrid.options.fnServerParams = function (aoData) {
                        $.each(params, function (index, value) {
                            aoData.push({ 'name': value.name, 'value': value.value });
                        });
                    };

                    if (null == $.componentGrid.grid) {
                        $.componentGrid.grid = element.dataTable($.componentGrid.options);
                    } else {
                        $.componentGrid.grid.api().destroy();
                        $.componentGrid.grid = element.dataTable($.componentGrid.options);
                    }

                    return false;
                });
            } else {
                $.componentGrid.grid = $(element).dataTable($.componentGrid.options);
            }
        }
    }
});

$(function () {
    $('*[data-grid]').each(function () {
        $(this).grid();
    })
})