var dataTable = $('#datatable').DataTable({
    info: false,

    ajax: {
        url: `${BASE_URL}Api/Cotizaciones/Pagos_efectivo/getPayments`,
        data: { 'id': $('#box').val() },
        type: "post",
    },

    searching: false,
    paging: false,
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],

    columns: [
        {
            data:'cotizacion',
            render: function(data, type, row, meta) {
                return `<a  href="${BASE_URL}OrdenServicio/Pendientes/imprimir/${data}" target="_blank">
                <button style="cursor: pointer; font-size: 14px;"  title="VER COTIZACIÓN"  class="btn btn-outline-primary  solid pd-x-20 btn-circle btn-sm">
                ${data}
                </button></a>` 
            }
        },
        {
            data: 'id_cash_box'
        },
        {
            data: 'name'
        },
        {
            data: 'amount',
            render: function (data, type, row, meta) {
                return currency(data, { symbol: "$", separator: "," }).format()

            }

        },

    ],

    footerCallback: function (row, data, start, end, display) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        let intVal = function (i) {
            return parseFloat(i);
        };

        // Total over all pages
        total = api
            .column(3)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);

        // Total over this page
        pageTotal = api
            .column(3, { page: 'current' })
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
        var cantidad = currency(total, { symbol: "$", separator: "," }).format();

        // Update footer
        $(api.column(3).footer()).html("Total: "+cantidad);
    },

    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});