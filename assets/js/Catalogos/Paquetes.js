get_categorias();
$("#precio_fijo").hide();

//FORMATO CURRENCY EN LOS INPUT DE PRECIO
$(document).on('change', '#precio', function(){
    let costo = $(this).val();
    let consto_curr = currency(costo, { symbol: "", separator: "," }).format();
    $(this).val(consto_curr);
});

$(document).on('change', '#price', function(){
    let costo = $(this).val();
    let consto_curr = currency(costo, { symbol: "", separator: "," }).format();
    $(this).val(consto_curr);
});

var dataTable = $('#crm_packets').DataTable({

    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/readPackets`,
        data: {},
        type: "post",
    },
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],

    columns: [
        {
            data: 'packet',
        },
        { 
            data: 'total_studies',
        },
        /* {
            data: 'suma',
            render: function(data, type, row, meta) {
                if(data == 0 && row.sum_price == "0.00"){
                    return "-"
                } else if(data == 0 && row.price != "0.00"){
                    return currency(row.price, { symbol: "$", separator: "," }).format()
                } else {
                    return currency(row.price_total, { symbol: "$", separator: "," }).format()
                }
            }
        }, */
        { 
            data: 'preparation',
        },

        {
            data: "id_insumo",
            render: function(data, type, row, meta) {
                return '<div class="d-flex flex-column flex-md-row justify-content-center col-sm-12"><a href="'+BASE_URL+'Catalogos/Paquetes/add_studies/'+data+'"><button class="btn btn-purple add solid pd-x-20 btn-circle btn-sm mr-2 mt-sm-2" title="Agregar estudios"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></button></a>' +
                '<button id="' + row.id_product + '" class="btn btn-warning update solid pd-x-20 btn-circle btn-sm mr-2 mt-sm-2" title="Editar datos"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
                '<button id="' + row.id_product + '" data-index="'+data+'"  class="btn btn-danger delete-insum solid pd-x-20 btn-circle btn-sm mt-sm-2" title="Eliminar registro"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
                
            }
        },

    ],
    "columnDefs": [
        { className: "wrapbox", "targets": [ 2 ] },
        { className: "wrapbox", "targets": [ 1 ] },
        { className: "wrapbox", "targets": [ 0 ] }
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

/* OBTENER DATOS DEL PAQUETE*/
$(document).on('click', '.update', function() {
    $('#loader').toggle();
    const url = `${BASE_URL}${CONTROLADOR}/readPacket`;
    let categoria = $(this).attr('id');

    $.ajax({
        url: url,
        data: { id: categoria },
        method: 'post', //en este caso
        dataType: 'json',
        success: function(success) {
            $('#name').val(success[0].packet); 
            $('#prescription').val(success[0].preparation);
            $('#update_Categoria').val(success[0].id_category);
            $('#id_update').val(success[0].id_product);
            $('#id_insumoup').val(success[0].id_insumo);
            const url_estudios = `${BASE_URL}Catalogos/Paquetes/add_studies/${success[0].id_insumo}`;
            estudios = document.getElementById("ver-estudios");
            estudios.setAttribute("href", url_estudios);
            $('#updateModal').modal('show');
            $('#loader').toggle();
        },
        error: function(xhr, text_status) {
            $('#loader').toggle();
        }
    });
});

//BTN DELETE
$(document).on('click', '.delete-insum', function(){
    let producto = $(this).attr('id');
    let insumo = $(this).data('index');

    $("#id_delete").val(producto);
    $("#id_insumodel").val(insumo);
    $('#modal_delete').modal('toggle');
});

/* CALCULAR DESCUENTO */
$(document).on('change', '#descuento', function() {
    let descuento = parseFloat($(this).val());
    let desc = 100 - descuento;
    let TOTAL = $('#total_sum').val();
    let newTotal = TOTAL.replace(",", "");
    
    final = parseFloat(newTotal) * parseFloat((desc/100));
    $('#price_total').val(currency(final, { symbol: "", separator: "," }).format())

});

// ACTIVAR SUMA DE PRODUCTOS
$('#suma').on('click', function() {
    let status = $(this).prop("checked");

    if (status) {
        $("#suma_precios").show();
        $("#precio_fijo").hide();
        $("#price_fij").removeAttr('requiered');
    } else {
        $("#suma_precios").hide();
        $("#precio_fijo").show();
        $("#price_fij").attr('requiered', 'required');

    }

});

$('#price_fij').on('change', function() {
    let val = $(this).val()
    $('#price_fij').val(currency(val, { symbol: "", separator: "," }).format())

});

//OBTENER CATEGORIA
function get_categorias() {
    $('#loader').toggle();
    const url = `${BASE_URL}Api/Catalogos/Products/readCategoria`;
    var empresas = $(".categoria");
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            empresas.append(`<option  value=""> SELECCIONA UNA CATEGORIA </option>`);
            $(data).each(function(i, v) {
                empresas.append(`<option  value="${v.id}"> ${v.name}</option>`);
            });
            $('#loader').toggle();
        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}


/*ASIGNAR PRECIO*/
/*$(document).on('submit', '#form_price', function () {
    $('#loader').toggle();
    var FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}${CONTROLADOR}/updatePrice`
    
    $.ajax({
        url: URL,
        type: 'POST',
        data: FORMDATA,
        dataType: 'json',
        success: function (data) {
            //Si el estatus es 200 fue conpletado el proceso
            if (data.status == 200) {
                $('#loader').toggle();
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../../assets/img/correcto.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
                $('#modal_price').modal('toggle');
                document.getElementById("form_price").reset();
                reloadData();
            } else {
                $('#loader').toggle();
                Toastify({
                    text: data.msg,
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
                $('#myModal').modal('toggle');
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
            avatar: "../../../../../assets/img/cancelar.png",
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
}); */

/* DEFINIR PRECIO DEL PAQUETE */
/*$(document).on('click', '.price', function() {
    $('#loader').toggle()
    let packet = $(this).attr('id');
    const url = `${BASE_URL}${CONTROLADOR}/sumStudies`;

    $.ajax({
        url: url,
        data: { id: packet },
        method: 'post', //en este caso
        dataType: 'json',
        success: function(success) {
            $("#texto-precio").children().remove();
            $("#texto-precio").append(`<h6>TOTAL SUMA ESTUDIOS: ${success[0].suma}</h6>`);
            if (success[0].bandera == 0 && success[0].price_total == "0.00") {
                $("#suma").prop("checked", true);
                $("#suma_precios").show();
                $("#precio_fijo").hide();
                $("#price_fij").removeAttr('requiered');
                $('#total_sum').val(currency(success[0].suma, { symbol: "", separator: "," }).format());
                $("#descuento").val(success[0].descuento) 
                if(success[0].price_total == "0.00"){
                    $('#price_total').val(currency(success[0].suma, { symbol: "", separator: "," }).format()); 
                } else {
                    $('#price_total').val(currency(success[0].price_total, { symbol: "", separator: "," }).format()); 
                } 
            } else if(success[0].bandera == 0 && success[0].price_total != "0.00"){
                $("#suma").prop("checked", false);
                $("#suma_precios").hide();
                $("#precio_fijo").show();
                $("#price_fij").attr('requiered', 'required');
                $('#total_sum').val(currency(success[0].suma, { symbol: "", separator: "," }).format()); 
                $("#descuento").val(success[0].descuento)
                $("#price_fij").val(currency(success[0].price, { symbol: "", separator: "," }).format()); 
                if(success[0].price_total == "0.00"){
                    $('#price_total').val(currency(success[0].suma, { symbol: "", separator: "," }).format()); 
                } else {
                    $('#price_total').val(currency(success[0].price_total, { symbol: "", separator: "," }).format()); 
                } 
            }else {
                $("#suma").prop("checked", true);
                $("#suma_precios").show();
                $("#precio_fijo").hide();
                $('#total_sum').val(currency(success[0].suma, { symbol: "", separator: "," }).format()); 
                $("#descuento").val(success[0].descuento);
                $('#price_total').val(currency(success[0].price_total, { symbol: "", separator: "," }).format()); 
                $("#price_fij").removeAttr('requiered');
        
            }
            $('#id_price').val(packet); 
            $('#modal_price').modal('show');
            $('#loader').toggle(); 
        },
        error: function(xhr, text_status) {
            $('#loader').toggle();
        }
    });
});*/
