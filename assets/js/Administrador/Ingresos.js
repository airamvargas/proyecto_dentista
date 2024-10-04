//get_empresas();
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
                empresas.append(`<option  value="${v.compra}" data-index="${v.id_user_client}"> ${v.razon_social}</option>`);
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
    let id_user = $(this).children('option:selected').data('index');
    const url = `${BASE_URL}/Administrador/Pagos/getCompra`;
    $.ajax({
        url: url,
        type: 'POST',
        data: {'id':id},
        dataType: 'json',
        success: function (data) {
          if(data){
                $('.empresa').val(data[0].business_name);
                $('.id-empresa').val(data[0].id_empresa);
                $('.cliente-id').val(id_user);
                $('#loader').toggle();

            } 
        },
    });
}); 

//globalusd = $('#uds').val();
//globaltc = $('#tc').val();

$("#tipo_cambio").blur(function () {
    var cambio = $(this).val();
    let cambio_curl = currency(cambio).format();
    $("#tipo_cambio").val(cambio_curl);
});

$("#importe").blur(function () {
    var importe = $(this).val();
    let importe_cur = currency(importe).format();
    $("#importe").val(importe_cur);
});

$("#iva").blur(function () {
    var iva = $(this).val();
    let iva_cur = currency(iva).format();
    $("#iva").val(iva_cur);
    var timporte = $("#importe").val();
    var c = currency(timporte).add(iva_cur).format(); 
    $('#total').val(c);
});

//GUARDAR PAGO//

$(document).on('submit', '#formIngreso', function () {
    var formData = new FormData($(this)[0]);
    const url = `${BASE_URL}Contabilidad/Ingresos/addIngreso`;

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (data) {
            console.log(data);
          if (data.status == 200) {
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
                $('#myModal').modal('toggle');
                document.getElementById("formIngreso").reset();
                reloadData();

            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f26504, #f90a24)",
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
    });
    return false;
});


//datatable//




/*RECARGA DE AJAX*/
function reloadData() {
    $('#loader').toggle();
    dataTable.ajax.reload();
    $('#loader').toggle();
}

//UPDATE INGRESO//
$(document).on('click', '.up', function () {
    $('#ficha').children().remove();
    $('#file-cot').children().remove();
    $('#loader').toggle();
    const url = `${BASE_URL}Contabilidad/Ingresos/getIngreso`;
    let id = $(this).attr('id');
    $.ajax({
        url: url,
        data: { id: id },
        method: 'post', //en este caso
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data) {
                $('#upd-fechafactura').val(data[0].fecha_factura);
                $('.clientes').val(data[0].id_cotizacion_x_producto);
                $('.empresa').val(data[0].business_name);
                $('#upd-razonsocial').val(data[0].razon_social);
                $('#upd-concepto').val(data[0].concepto);
                $('#upd-moneda').val(data[0].moneda);
                $('#cliente-id').val(data[0].id_cliente);
                $('#upd-idempresa').val(data[0].id_empresa);

                let tipocambio =  data[0].tipo_cambio;
                let currcambio = currency(tipocambio).format();
                $('#upd-tipocambio').val(currcambio);

                let importe =  data[0].importe;
                let currimporte = currency(importe).format();
                $('#upd-importe').val(currimporte);

                let iva =  data[0].iva;
                let curriva = currency(iva).format();
                $('#upd-iva').val(curriva);

                let total =  data[0].total;
                let currtotal = currency(iva).format();
                $('#upd-total').val(currtotal);
                $('#upd-fechapago').val(data[0].fecha_pago);

                $('#id_ingreso').val(data[0].id);
                $('#name-pdf').val(data[0].pdf);
                $('#name-xml').val(data[0].xml);

                if (data[0].pdf != " ") {
                    let ficha = $('#ficha');
                    let html_ficha = '<label class="form-control-label mt-2">PDF:</label><a class="form-control" href="../../Contabiliadad/Ingresos/' + data[0].pdf + '" target="_blank"><img src="../../../assets/img/pdf.png" ></a>'
                    +'<button type ="button"  id="' + data[0].id + '""  data-index="'+data[0].pdf+'" data-tipo="0"    class="btn btn-danger mt-2  solid pd-x-20 delete-file" style="border-radius: 10px;"><i class="fa fa-trash-o fa-lg mr-1" aria-hidden="true"></i> ELIMINAR</button>'
                    $(ficha).html(html_ficha);
                }

             /*    if(data.xml != " "){
                    let cotizacion = $('#file-cot');
                    let html_cotizacion = '<label class="form-control-label mt-2">XML:</label><a class="form-control" href="../../Contabiliadad/Ingresos/' + data[0].xml + '" target="_blank"><img src="../../../assets/img/iconxml.png" style="width: 17%;" ></a>'
                    +'<button type ="button" id="' + data[0].id + '""  data-index="'+data.invoice_receipt+'"  data-tipo="1" class="btn btn-danger mt-2  solid pd-x-20 delete-file" style="border-radius: 10px;"><i class="fa fa-trash-o fa-lg mr-1" aria-hidden="true"></i> ELIMINAR</button>'
                    $(cotizacion).html(html_cotizacion);
                } */

                $('#loader').toggle();
                $('#updateModal').modal('show');
            }
          
        },
        error: function (xhr, text_status) {
            $('#loader').toggle();
        }
    });

});


$("#upd-tipocambio").blur(function () {
    var cambio = $(this).val();
    let cambio_curl = currency(cambio).format();
    $("upd-tipocambio").val(cambio_curl);
});

$("#upd-importe").blur(function () {
    var importe = $(this).val();
    let importe_cur = currency(importe).format();
    $("#upd-importe").val(importe_cur);
});

$("#upd-iva").blur(function () {
    var iva = $(this).val();
    let iva_cur = currency(iva).format();
    $("#upd-iva").val(iva_cur);
    var timporte = $("#upd-importe").val();
    var c = currency(timporte).add(iva_cur).format(); 
    $('#upd-total').val(c);
});

/* ACTUALIZAR PAGOS */ 

$(document).on('submit', '#UpdformIngreso', function() {
    // console.log("di un click");
    const formData = new FormData($(this)[0]);
    const url = `${BASE_URL}Contabilidad/Ingresos/updateIngresos`; 

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(data) {
            console.log(data);
            if (data.status == 200) {
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

                $('#updateModal').modal('toggle');
                document.getElementById("UpdformIngreso").reset();
                reloadData();


            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f26504, #f90a24)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },

                }).showToast();

                $('#updateModal').modal('toggle');
            }

        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;
});



// ELIMINAR PAGO//

$(document).on('click', '.delete', function() {
    let product = $(this).attr('id');
    $('#modal_delete').modal('toggle');
    $("#id_delete").val(product);

});


$(document).on('submit', '#delete_form', function() {
    const formData = new FormData($(this)[0]);
    const url = `${BASE_URL}Contabilidad/Ingresos/deleteIngreso`;

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(data) {
            console.log(data);
            if (data.status == 200) {
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

                $('#modal_delete').modal('toggle');
                reloadData();


            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f26504, #f90a24)",
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
    });
    return false;


});


//borrar archivos

$(document).on('click', '.delete-file',  function(){
    $('#modal_delete-file').modal('toggle');
    const tipo  = $(this).data('tipo');
    const name = $(this).data('index');
    const id = $(this).attr('id');
    $('#id-file').val(id);
    $('#tipo').val(tipo);
    $('#file-name').val(name);

});

//BORRAR ARCHIVO//

$(document).on('submit', '#delete_form_file', function() {
    const formData = new FormData($(this)[0]);
    const url = `${BASE_URL}Contabilidad/Ingresos/deletefile`;

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(data) {
            console.log(data);
            if (data.status == 200) {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../../assets/img/correcto.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50, 
                        y: 90 
                    },

                }).showToast();

                $('#modal_delete-file').modal('toggle');
                $('#updateModal').modal('toggle');
                reloadData();


            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f26504, #f90a24)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },

                }).showToast();
                $('#modal_delete-file').modal('toggle');
                $('#updateModal').modal('toggle');
            }

        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;
});


