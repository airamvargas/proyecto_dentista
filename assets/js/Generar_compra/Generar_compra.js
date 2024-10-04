//FORMATO EN ESPAÑOL FECHA
moment.locale("es");

getClientes();


function getClientes() {
    $('#loader').toggle();
    const url = `${BASE_URL}/Administrador/Pagos/get_clientes`;
    var empresas = $(".clientes");
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#loader').toggle();
            //const ch = data['data'];
            empresas.append(`<option  value=""> SELECCIONA CLIENTES </option>`);
            $(data).each(function (i, v) {
                empresas.append(`<option  value="${v.compra}"> ${v.razon_social}</option>`);
            })

        },
        error: function (error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}

$(".clientes").change(function () {
   // $('#myModal').modal('toggle');
    $('#loader').toggle();
    let id = $(this).val();
    const url = `${BASE_URL}/Administrador/Pagos/getCompra`;
    $.ajax({
        url: url,
        type: 'POST',
        data: {'id':id},
        dataType: 'json',
        success: function (data) {
            if(data){
                $('#empresa').val(data[0].business_name);
                $('#proveedor').val(data[0].name_proveedor);
                $('#id_proveedor').val(data[0].proveedor_id);
                $('#maquina').val(data[0].name);
                $('#id_maquina').val(data[0].id_cat_products);
                $('#serie').val(data[0].serie);
                $('#modelo').val(data[0].model);
                $('#voltage').val(data[0].volatje);
                $('#nombre_ingles').val(data[0].english_name);
                $('#model_china').val(data[0].model_china);
                $('#price').val(data[0].cost_china);
                $('#fabrication').val(data[0].dias_fabricacion);
                $('#salida').val(data[0].embark);
                $('#loader').toggle();

            }
        },
    });
}); 

var dataTable = $('#datatable1').DataTable({
    order: [[0, 'desc']],
    ajax: { 
        url: BASE_URL + '/Generar_Compra/get_buys',
        data: {},
        type: "post",
    },
    lengthMenu: [
        [25, 50, 100, 999999],
        ["25", "50", "100", "Mostrar todo"],
    ],
    columns: [
        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<p id="' + row.id + '">' + row.id + '</p>'
            }
        },        
        {
            data: 'c_date',
            render: function(data, type, row, meta) {
                /*var now = new Date(data)
                return '<span class="d-none">' + data + '</span>' + '<p>' + now.toLocaleDateString() + '</p>'; */
                return moment(data).format("DD/MM/YY");
            }
        },
        {
            data: 'numero_oc'
        },
        {
            data: 'business_name'
        },
        {
            data: 'razon_social'
        },
        {
            data: 'name_proveedor'
        },
        {
            data: 'name'
        },
        {
            data: 'MODEL'
        },
        {
            data: 'price',
            render: function(data, type, row, meta) {
                return '<p>' + currency(data, { useVedic: true }).format() + '</p>'
            }
        },
        {
            data: 'DELIVERY'
        },
        {
            data: "id",
            render: function(data, type, row, meta) {
                return `<i class="fa fa-file-pdf-o fa-3x text-danger" aria-hidden="true" id="text-val"></i> <br>
                <a id="down_carta" href="${BASE_URL}/../../Compras/compra${data}.pdf" class="down-doc" download>Ver archivo </a> `
            }
        },
        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<button onclick="deleteId(' + data + ')"" data-toggle="modal" data-target="#modaldemo2" class="btn btn-danger pd-x-20"><i class="fa fa-trash mr-1" aria-hidden="true"></i>Eliminar</button>'
            }
        },
    ],
   "columnDefs": [
        {
            "targets": [ 0 ],
            "visible": false,
            "searchable": false
        }
    ], 
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

/*RECARGA DE AJAX*/
function reloadData() {
    $('#loader').toggle();
    dataTable.ajax.reload();
    $('#loader').toggle();
}