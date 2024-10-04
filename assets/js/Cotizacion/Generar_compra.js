//FORMATO EN ESPAÑOL FECHA
moment.locale("es");
//variables globales
TOTAL = parseFloat(TOTAL);

//check_status();
//funcion validar checkbox
function check_status(){
    let active =  $('#check-total').prop('checked');
   // alert(restante)
    if(active){
        const TOTAL_PAGAR = restante.toString();
        $('#cantidad').attr('readonly', true);
        $("#cantidad").val(currency(TOTAL_PAGAR, { symbol: "$", separator: "," }).format());
    }else{
        $('#cantidad').attr('readonly', false);
        $('#cantidad').val("");
    }
} 


$("#check-total").on( "click", function() {
    check_status();
});


$(".efectivo").hide();
get_total();
readWaypay();


//document.getElementById("agregar").disabled = true;

$(document).on('change', '.formas', function () {
    let forma = $(this).val();
    if (forma == 4) {
        $(".efectivo").show();
        $("#recibido").attr('required', 'required');
    } else {
        $(".efectivo").hide();
        $("#recibido").removeAttr('required');
        //document.getElementById("agregar").disabled = false;
    }
});

$("#cantidad").change(function(){
    let cantidad = parseFloat($(this).val());
    $("#cantidad").val(currency(cantidad, { symbol: "$", separator: "," }).format());
});

$("#recibido").change(function () {
    let cantidad = $("#cantidad").val();
    let recibido = $('#recibido').val();
    let final =  currency(recibido).subtract(cantidad); 
    $(this).val(currency(recibido, { symbol: "$", separator: "," }).format());
    $("#cambio").val(currency(final, { symbol: "$", separator: "," }).format());

    if (final.value < 0) {
        document.getElementById("agregar").disabled = true;
        Toastify({
            text: "EL MONTO RECIBIDO DEBE SER IGUAL O MAYOR AL MONTO DE PAGO",
            duration: 3000,
            className: "info",
            avatar: BASE_URL + "../../assets/img/cancelar.png",
            style: {
                background: "linear-gradient(to right, #f26504, #f90a24)",
            },
            offset: {
                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
        }).showToast();
    } else {
        document.getElementById("agregar").disabled = false;
    }
});

/*AGREGA UN NUEVO PAGO*/
$(document).on('submit', '#insert_pago', function () {
    $('#loader').toggle();
    var formData = new FormData();
    let forma_pago = $('#forma_pago').val();
    var tipo_pago = $('#tipo_pago').val();
    let cantidad = $("#cantidad").val();
    let cantidadNew = cantidad.replace('$', '');
    let cantidadRep = cantidadNew.replace(',', '');

    //console.log(cantidadRep)

    formData.append("id_way_to_pay", forma_pago);
    formData.append("id_payment_type", tipo_pago);
    formData.append("id_cotization", id_cotizacion);
    formData.append('amount', cantidadRep);

    const URL = `${BASE_URL}${CONTROLADOR}/create`;

    $.ajax({
        url: URL,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (data) {
            switch (data.status) {
                //pago guardado
                case 200:
                    notificacion(data.msg, true);
                    document.getElementById("insert_pago").reset();
                    $(".efectivo").hide();
                    get_total();
                    reloadData();
                    $('#loader').toggle();
                    break;
                //error de pago
                case 400:
                    notificacion(data.msg, false);
                    break;
                //crear caja    
                case 202:
                    $('#modal_caja').modal('toggle', { backdrop: 'static', keyboard: false });
                    $('#loader').toggle();
                    break;
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
    
    return false;  
});

/*TABLA DE PRODUCTOS COTIZADOS*/
var dataTable = $('#crm_pagos').DataTable({
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/show`,
        data: { 'id': id_cotizacion },
        type: "post",
    },
    searching: false,
    paging: false,
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],

    columns: [{
        data: 'forma_pago',

    },
    {
        data: 'tipo_pago'
    },
    {
        data: 'amount', 
        render:  function (data, type, row, meta) {
            return currency(data, { symbol: "$", separator: "," }).format()
        }
    },
    {
        data: "id",
        render: function (data, type, row, meta) {
            return '<div class="d-flex justify-content-center"><button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
        }
    },


    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

$("#crm_pagos_info").hide();

/*DELETE*/
$(document).on('submit', '#form_delete', function () {
    $('#loader').toggle();
    $('#modal_delete').modal('toggle');
    const FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}${CONTROLADOR}/delete`;
    $.ajax({
        url: URL,
        type: 'POST',
        data: FORMDATA,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data.status == 200) {
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
                get_total();
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
                $('#modal_delete').modal('toggle');
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

// BOTON DE CONTINUAR
$("#terminar").on('click', function () {
    let restante = $("#restante").val();

    if (restante == 0) {
        $('#loader').toggle();
        const FORMDATA = new FormData();

        FORMDATA.append("id", id_cotizacion);

        const URL = `${BASE_URL}${CONTROLADOR}/status_lab`;
        $.ajax({
            url: URL,
            type: 'POST',
            data: FORMDATA,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data.status == 200) {
                    $('#loader').toggle();
                    location.href = `${BASE_URL}Cotizaciones/ticket/${id_cotizacion}`
                } else {
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
                avatar: BASE_URL + "../../assets/img/cancelar.png",
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
    } else {
        Toastify({
            text: "AÚN NO SE CUBRE EL COSTO TOTAL DE LA COMPRA",
            duration: 3000,
            className: "info",
            avatar: BASE_URL + "../../assets/img/cancelar.png",
            style: {
                background: "linear-gradient(to right, #f26504, #f90a24)",
            },
            offset: {
                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
        }).showToast();
    }
});

/*CAMBIO SELECT DE FORMA DE PAGO */
$("#forma_pago").on('change', function () {
    $('#loader').toggle();
    const FORMA = $(this).val();
    const URL = `${BASE_URL}${CONTROLADOR}/readPaymentType`;
    var tipo_pago = $(".tipo");
    $.ajax({
        url: URL,
        method: 'POST',
        data: { id: FORMA },
        dataType: 'json',
        success: function (data) {
            $(".tipo").empty();
            tipo_pago.append(`<option  value="">Seleccione una opción</option>`);
            $(data).each(function (i, v) {
                tipo_pago.append(`<option  value="${v.id}"> ${v.name}</option>`);
            });
            if(FORMA == 4){
                $(tipo_pago).val(6);
                $(tipo_pago).attr('readonly', true);
            }else{
                $(tipo_pago).attr('readonly', false);
            }

            $('#loader').toggle();
        },
        error: function (error) {
            //alert('hubo un error al enviar los datos');
        }
    });
});

/* OBTENER PRECIO TOTAL RESTANTE */
function get_total() {
    $('#loader').toggle();
    const URL = `${BASE_URL}${CONTROLADOR}/showPayments`;
    $.ajax({
        url: URL,
        method: 'POST',
        data: { id: id_cotizacion },
        dataType: 'json',
        success: function (data) {
            $("#total").children().remove();
            if (data[0]['total_pagos'] == null) {
                suma = 0;
            } else {
                suma = parseFloat(data[0]['total_pagos']);
            }
            restante = TOTAL - suma;
            total_pago = `<span>${currency(restante, { symbol: "$", separator: "," }).format()}</span>`
            $("#total").append(total_pago);
            $("#restante").val(restante);
            check_status();
            $('#loader').toggle();
        },
        error: function (error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}

/* OBTENER FORMAS DE PAGO */
function readWaypay() { //OBTENER LOS CONVENIOS
    $('#loader').toggle();
    const URL = `${BASE_URL}${CONTROLADOR}/readWaypay_`;
    var forma_pago = $(".formas");
    $.ajax({
        url: URL,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            forma_pago.append(`<option  value="">Seleccione una opción</option>`);
            $(data).each(function (i, v) {
                forma_pago.append(`<option  value="${v.id}"> ${v.name}</option>`);
            });
            $('#loader').toggle();
        },
        error: function (error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}

//NOTIFICACIONES TOASTIFY
function notificacion(mensaje, flag) {
    if (flag) {
        var imagen = BASE_URL + "../../assets/img/correcto.png";
        var background = "linear-gradient(to right, #00b09b, #96c93d)";

    } else {
        var imagen = BASE_URL + "../../assets/img/cancelar.png";
        var background = "linear-gradient(to right, #f90303, #fe5602)";
    }
    Toastify({
        text: mensaje,
        duration: 3000,
        className: "info",
        avatar: imagen,
        style: {
            background: background
        },
        offset: {
            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
        },
    }).showToast();
}


/*CREAR CAJA*/
$(document).on('submit', '#formBox', function () {
    $('#loader').toggle();
    $('#modal_caja').modal('toggle');
    const FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}${CONTROLADOR}/createBox`;
    $.ajax({
        url: URL,
        type: 'POST',
        data: FORMDATA,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data.status == 200) {
                $('#loader').toggle();
                $('#insert_pago').submit();
                //notificacion(data.msg, true)
              
            } else {
                notificacion(data.msg, false)
                $('#loader').toggle();
                $('#modal_caja').modal('toggle');
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

/* $("#continuar").on('click', function () {
    let restante = $("#restante").val();

    if (restante == 0) {
        $('#loader').toggle();
        const FORMDATA = new FormData();

        FORMDATA.append("id", id_cotizacion);
        FORMDATA.append('status_lab', 102);

        const URL = `${BASE_URL}${CONTROLADOR}/status_lab`;
        $.ajax({
            url: URL,
            type: 'POST',
            data: FORMDATA,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data.status == 200) {
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
                    
                } else {
                    $('#loader').toggle();
                    Toastify({
                        text: data.msg,
                        duration: 3000,
                        className: "info",
                        avatar: BASE_URL +  "../../assets/img/cancelar.png",
                        style: {
                            background: "linear-gradient(to right, #f90303, #fe5602)",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },

                    }).showToast();
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
                avatar: BASE_URL + "../../assets/img/cancelar.png",
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
    } else {
        Toastify({
            text: "AÚN NO SE CUBRE EL COSTO TOTAL DE LA COMPRA",
            duration: 3000,
            className: "info",
            avatar: BASE_URL + "../../assets/img/cancelar.png",
            style: {
                background: "linear-gradient(to right, #f26504, #f90a24)",
            },
            offset: {
                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
        }).showToast();
    }
}); */

/*OBTENER DATOS UPDATE*/
/* $(document).on('click', '.update', function () {
    $('#loader').toggle();
    let id = $(this).attr('id');
    let url = `${BASE_URL}${CONTROLADOR}/readUpdate`;

    $.ajax({
        url: url,
        data: { id: id },
        method: 'post',
        dataType: 'json',
        success: function (success) {
            $("#forma_update").val(success[0].id_way_to_pay);
            const URL = `${BASE_URL}${CONTROLADOR}/readPaymentType`;
            var tipo_pago = $(".tipo");
            $.ajax({
                url: URL,
                method: 'POST',
                data: { id: success[0].id_way_to_pay },
                dataType: 'json',
                success: function (data) {
                    $(".tipo").empty();
                    tipo_pago.append(`<option  value="">Seleccione una opción</option>`);
                    $(data).each(function (i, v) {
                        tipo_pago.append(`<option  value="${v.id}"> ${v.name}</option>`);
                    });
                    //$('#loader').toggle();
                    $("#tipo_update").val(success[0].id_payment_type);
                },
                error: function (error) {
                    //alert('hubo un error al enviar los datos');
                }
            });

            $("#cantidad_update").val(success[0].amount);
            $("#id_update").val(success[0].id);
            $('#updateModal').modal('show');
            $('#loader').toggle();
        },
        error: function (xhr, text_status) {
            $('#loader').toggle();
        }
    });
});

// UPDATE
$(document).on('submit', '#form_update', function () {
    $('#loader').toggle();
    $('#updateModal').modal('toggle');
    const FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}${CONTROLADOR}/update`;
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
                get_total();
                reloadData();
                $('#loader').toggle();
            } else {
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
                $('#loader').toggle();
                $('#updateModal').modal('toggle');
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
}); */

/* $("#forma_update").on('change', function () {
    $('#loader').toggle();
    const FORMA = $(this).val();

    const URL = `${BASE_URL}${CONTROLADOR}/readPaymentType`;
    var tipo_pago = $(".tipo");
    $.ajax({
        url: URL,
        method: 'POST',
        data: { id: FORMA },
        dataType: 'json',
        success: function (data) {
            $(".tipo").empty();
            tipo_pago.append(`<option  value="">Seleccione una opción</option>`);
            $(data).each(function (i, v) {
                tipo_pago.append(`<option  value="${v.id}"> ${v.name}</option>`);
            });
            $('#loader').toggle();
        },
        error: function (error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}); */

