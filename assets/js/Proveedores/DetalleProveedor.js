//alert(id);


console.log(data);
let html = '';
html += '<img src="../../../../public/images/logos/' + data[0].logo + '" class="img-thumbnail mb-2" style="width: 10%;"/>' + '<p>' + data[0].name_proveedor + '</p>'
$('#imagen').html(html);


var dataTable = $('#datatable1').DataTable({

    ajax: BASE_URL + '/Proveedores/get_productosProvedor/' + id,

    columns: [{
            data: 'media_path',
            render: function(data, type, row, meta) {
                return data == '' ? '<img style="width:80px; height: 80px;" src="../../../../writable/uploads/Mattes/Arrendador/default.png" class="img-fluid" />' : '<img class="rounded" style="width:80px; height: 80px;" src="../../../../public/images/' + data + ' " class="img-fluid" />'
            }
        },
        {
            data: 'name'

        },
        {
            data: 'model'

        },
        {
            data: 'cost_china',
            render: function(data, type, row, meta) {
                return '<p>' + currency(data, { useVedic: true }).format() + '</p>'
            }

        },
        {
            data: 'model_china'

        },
        {
            data: 'su_price',
            render: function(data, type, row, meta) {
                return '<p>' + currency(data, { useVedic: true }).format() + '</p>'
            }

        },
        {
            data: 'delivery_time'

        },
    ],
    columnDefs: [
        { "width": "5%", "targets": 0}, 
        { "width": "10%", "targets": 1}, 
        { "width": "15%", "targets": 2}, 
        { "width": "15%", "targets": 3}, 
        { "width": "15%", "targets": 4}, 
        { "width": "15%", "targets": 5}, 
        { "width": "15%", "targets": 6}       
    ],
    responsive: true,
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});