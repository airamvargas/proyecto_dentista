moment.locale("es");

function escapeHtml(text) {
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}


// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    let min = $("#min").val();
    let max = $("#max").val();
});

var dataTable = $('#crm_ventas').DataTable({
    processing: true,
    serverSide: true,
    order: [
        [0, 'asc']
    ],
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],

    dom: 'Blfrtip',
    buttons: [
        {
            extend: 'excelHtml5',
            text: 'Exportar a Excel',
            
        }
    ],

    ajax: {
        url: `${BASE_URL}Api/Back_office/Reportes/reporteProductos`,
        type: "post",
        data: function (d) {
            d.minDate = $('#min').val();
            d.maxDate = $('#max').val();
        },
    },


    columns: [
        { data: 'id_cotizacion' },
        { data: 'fecha', render: function(data) { return escapeHtml(moment(data).format("YYYY-MM-DD")); } },
        { data: 'unidad' },
        { data: 'convenio', render: function(data) { return escapeHtml(data ? data : '-'); } },
        { data: 'paciente' },
        { data: 'area_lab', render: function(data, type, row) { return escapeHtml(row.name_table == 'cat_packets' || row.name_table == 'cat_products' ? row.categoria : row.area_lab); } },
        { data: 'producto' },
        { data: 'price', render: function(data) { return escapeHtml(currency(data, { symbol: "", separator: "," }).format()); } }
    ],
    ordering: true,
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    },
    initComplete: function (settings, json) {
        $('#crm_ventas thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#crm_ventas thead');
        var api = this.api();
        api
            .columns()
            .eq(0)
            .each(function (colIdx) {
                // Set the header cell to contain the input element
                var cell = $('.filters th').eq(
                    $(api.column(colIdx).header()).index()
                );
                var title = $(cell).text();
                $(cell).html('<input type="text" class="text-center" placeholder="' + title + '" />');

                // On every keypress in this input
                $('input', $('.filters th').eq($(api.column(colIdx).header()).index()))
                    .off('keyup change')
                    .on('keyup change', function (e) {
                        e.stopPropagation();
                        // Get the search value
                        $(this).attr('title', $(this).val());
                        var regexr =
                            '({search})'; //$(this).parents('th').find('select').val();
                        var cursorPosition = this.selectionStart;
                        // Search the column for that value
                        api
                            .column(colIdx)
                            .search(

                                this.value
                            )
                            .draw();

                        $(this)
                            .focus()[0]
                            .setSelectionRange(cursorPosition, cursorPosition);
                    });
            });
        quitaClase();

        function quitaClase() {
            $('.filters').children().removeClass("sorting").removeClass("sorting_asc").removeClass("sorting_desc");
        }

    },
});

// Add event listeners to the two range filtering inputs
// Refilter the table
$('#min').change(function () { dataTable.draw(); });
$('#max').change(function () { dataTable.draw(); });