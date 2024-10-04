$(document).on('submit', '#formCreate', function () {
    $('#loader').toggle();
    $('#myModal').modal('toggle');
    const FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}/Api/Cotizaciones/Cajas`;
    $.ajax({
        url: URL,
        type: 'POST',
        data: FORMDATA,
        dataType: 'json',
        success: function (data) {
            if (data.status == 200) {
                //notification library
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../assets/img/correcto.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                $('#loader').toggle();
                reloadData();
            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f90303, #fe5602)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                $('#loader').toggle();
                $('#myModal').modal('toggle');
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;
});

var dataTable = $('#datatable').DataTable({
    ajax: `${BASE_URL}Api/Cotizaciones/Cajas/redDatatable`,

    columns: [
        {
            data: 'id',

        },
        {
            
            data: 'full_name',

        },
        {
            data: 'status_caja',
            render: function (data, type, row, meta) {
                return data == 1 ? moment(row.date_start).format("DD/MM/YY") :  moment(row.date_close).format("DD/MM/YY")

            }


        },
        {
            data: 'updated_at',
            render: function (data, type, row, meta) {
                return  moment(data).format('HH:mm:ss')

            }


        },

        {
            data: 'status_caja',
            render: function (data, type, row, meta) {
                return data == 1 ? '<p>'+ row.name_autor+'</p>' : '<p>'+ row.name_final+'</p>' 
            }


        },

        {
            data: 'status_caja',
            render: function (data, type, row, meta) {
                return data == 1 ? "<b><p style='color: green;'>" + "ABIERTA" + "</p></b>" : "<b><p style='color: red;'>" + "CERRADA" + "</p></b>"

            }

        },

        {
            data: 'name_status'
        },



        {
            data: 'starting_amount',
            render: function (data, type, row, meta) {
                return currency(data, { symbol: "$", separator: "," }).format()

            }


        },
        {
            data: 'final_amount',
            render: function (data, type, row, meta) {
                if (row.monto_final == null) {
                    let monto_final = currency(0).add(row.starting_amount);
                    let currency_final = currency(monto_final, { symbol: "$", separator: "," }).format()
                    return currency_final;

                } else {
                    let monto_final = currency(row.monto_final).add(row.starting_amount);
                    let currency_final = currency(monto_final, { symbol: "$", separator: "," }).format()
                    return currency_final;
                }
            }
        },

        {
            data: 'final_amount',
            render: function (data, type, row, meta) {
                return currency(data, { symbol: "$", separator: "," }).format()

            }
        },

        {
            data: 'final_amount',
            render: function (data, type, row, meta) {
                if (data == "0.00") {
                    return ""
                } else {

                    let monto_final = currency(row.monto_final).add(row.starting_amount);
                    let currency_final = currency(monto_final, { symbol: "$", separator: "," }).format();
                    let monto_final_caja = currency(data, { symbol: "$", separator: "," }).format();
                    let resta = currency(monto_final_caja).subtract(monto_final);

                    if (resta < 0) {
                        let dinero_rest = currency(resta, { symbol: "$", separator: "," }).format();
                        return '<b><p style="color:red;">' + dinero_rest + '</p></b>'

                    } else {
                        let dinero_rest = currency(resta, { symbol: "$", separator: "," }).format();
                        return '<b><p style="color:blue;">' + dinero_rest + '</p></b>'

                    }
                }

            }
        },

        {
            data: "id",
            render: function (data, type, row, meta) {
                return row.status_caja == 1 ? '<a href="' + BASE_URL + 'Cotizacion/Pagos_efectivo/index/' + data + '"><button style="cursor: pointer;"  title="VER PAGOS EN EFECTIVO" id="' + data + '"" class="btn btn-info solid pd-x-20 btn-circle btn-sm"><i class="fa fa-money fa-2x" aria-hidden="true"></i></button></a>' +
                    '<button style="cursor: pointer;" title="CERRAR CAJA" id="' + data + '" data-index="' + currency(row.monto_final).add(row.starting_amount) + '" class="btn btn-danger delete solid pd-x-20 ml-1 btn-circle btn-sm"><i   class="fa fa-lock fa-2x" aria-hidden="true"></i></button>'
                    :'<a  href="' + BASE_URL + 'Cotizacion/Cajas/reciboPdf/' + data + '"><button style="cursor: pointer;" title="VER RECIBO" id="' + data + '"" class="btn btn-warning solid pd-x-20 btn-circle btn-sm"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></button></a>'+" "+
                    '<a  href="' + BASE_URL + 'Cotizacion/Pagos_efectivo/index/' + data + '"><button style="cursor: pointer;" title="VER PAGOS EN EFECTIVO" id="' + data + '"" class="btn btn-info solid pd-x-20 btn-circle btn-sm"><i class="fa fa-money fa-2x" aria-hidden="true"></i></button></a>'

            }
        },


    ],

    "columnDefs": [
        {
            "targets": [0],
            "visible": false,
            "searchable": false
        }
    ],

    order: [[0, 'desc']],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    },
    responsive: true
});

//cerar caja
$(document).on('click', '.delete', function () {
    document.getElementById("formDelete").reset();
    let product = $(this).attr('id');
    let monto_final = $(this).data('index');
    $('#monto-total').val(currency(monto_final, { symbol: "$", separator: "," }).format());
    $('#modal_delete').modal('toggle');
    $("#id_delete").val(product);
});

//fomulario cerrar caja
/*DELETE*/
$(document).on('submit', '#formDelete', function () {
    $('#loader').toggle();
    $('#modal_delete').modal('toggle');
    const FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}Api/Cotizaciones/Cajas/closeBox`;
    $.ajax({
        url: URL,
        type: 'POST',
        data: FORMDATA,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            switch (data.status) {
                case 200:
                    $('#loader').toggle();
                    //notification library
                    Toastify({
                        text: data.msg,
                        duration: 3000,
                        className: "info",
                        avatar: BASE_URL + "../../assets/img/correcto.png",
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },
                    }).showToast();
                    reloadData();
                    break;
                case 202:
                    $('#loader').toggle();
                    //notification library
                    Toastify({
                        text: data.msg,
                        duration: 3000,
                        className: "info",
                        avatar: BASE_URL + "../../assets/img/correcto.png",
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },
                    }).showToast();
                    reloadData();
                    $('#myModal').modal('toggle');
                    break;
                case 400:
                    $('#loader').toggle();
                    Toastify({
                        text: data.msg,
                        duration: 3000,
                        className: "info",
                        avatar: BASE_URL + "../../assets/img/cancelar.png",
                        style: {
                            background: "linear-gradient(to right, #f90303, #fe5602)",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },

                    }).showToast();
                    $('#modal_delete').modal('toggle');
                    break;
            }
        },
        cache: false,
        contentType: false,
        processData: false
    }).fail(function (jqXHR, textStatus, errorThrown) {
        $('#loader').toggle();
        switch (jqXHR.status) {
            case 404:
                mensaje = "respuesta o pagina no encontrada";
                break;
            case 500:
                mensaje = "Error en el servidor";
                break;
            case 0:
                mensaje = "no conecta verifica la conexion";
                break;
        }
        Toastify({
            text: mensaje,
            duration: 3000,
            className: "info",
            avatar: "../../../assets/img/cancelar.png",
            style: {
                background: "linear-gradient(to right, #f90303, #fe5602)",
            },
            offset: {
                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
        }).showToast();
    });
    return false;
});

/*RELOAD DATATABLE */
function reloadData() {
    $('#loader').toggle();
    dataTable.ajax.reload();
    $('#loader').toggle();
}


//adicion de los montos 
$("#monto-intro").on("change", function () {
    let monto = $(this).val()
    let contado = $(this).val(currency(monto, { symbol: "$", separator: "," }).format());
    let monto_caja = $('#monto-total').val();
    let final = $(this).val();
    let resta = currency(monto_caja).subtract(final);
    $('#monto-restante').val(currency(resta, { symbol: "$", separator: "," }).format());
  
});


//cambio de select de tipo de cierre
/* $("#cierre").on( "change", function() {
   if($(this).val() == "3"){
    $('#btn-close').text("ARQUEO CAJA");
   }else{
    $('#btn-close').text("CERAR CAJA");
   }
})
 */

//monto final 
/* $("#monto-intro").on("change", function () {
    let monto = $(this).val()
    $(this).val(currency(monto, { symbol: "$", separator: "," }).format());
}) */

