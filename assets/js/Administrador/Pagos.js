//FORMATO EN ESPAÑOL FECHA
moment.locale("es");

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
                $('#maquina').val(data[0].name);
                $('#c-serie').val(data[0].serie);
                $('#c-modelo').val(data[0].model);
                $('#updempresa').val(data[0].business_name);
                $('#updmaquina').val(data[0].name);
                $('#upserie').val(data[0].serie);
                $('#updmodelo').val(data[0].model);
                $('#loader').toggle();

            }
        },
    });
}); 

globalusd = $('#uds').val();
globaltc = $('#tc').val();



$("#uds").blur(function () {
    $("#pesos").val(" ");
    globalusd = $(this).val();
    if(globaltc.length === 0){
    }else{
        let tcfrloat = parseFloat(globaltc);
        let udsfloat = parseFloat(globalusd);
        let pesos = tcfrloat * udsfloat;
        let pesos_curr = currency(pesos).format();
        $("#pesos").val(pesos_curr);
         
    } 

    let uds_curr = currency(globalusd).format();
    $("#uds").val(uds_curr);
});


$("#tc").blur(function () {
    $("#pesos").val(" ");
    globaltc = $(this).val();
    if(globalusd.length === 0){
    }else{
        let tcfrloat = parseFloat(globaltc);
        let udsfloat = parseFloat(globalusd);
        let pesos = tcfrloat * udsfloat;
        let pesos_curr = currency(pesos).format();
        $("#pesos").val(pesos_curr);
         
    } 


    let tc_curr = currency(globaltc).format();
    $("#tc").val(tc_curr);
});

$("#pesos").blur(function () {
    let pesos = $(this).val();
    let pesos_curr = currency(pesos).format();
    $("#pesos").val(pesos_curr);
});

//GUARDAR PAGO//

$(document).on('submit', '#formPago', function () {

    var formData = new FormData($(this)[0]);
    const url = `${BASE_URL}Administrador/Pagos/addPays`;

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
                document.getElementById("formPago").reset();
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





/*RECARGA DE AJAX*/
function reloadData() {
    $('#loader').toggle();
    dataTable.ajax.reload();
    $('#loader').toggle();
}

//UPDATE PAGO//
$(document).on('click', '.up', function () {
    $('#ficha').children().remove();
    $('#file-cot').children().remove();
    $('#loader').toggle();
    $('#upserie').val('');
    $('#updmodelo').val('')
    const url = `${BASE_URL}Administrador/Pagos/getPago`;
    let pago = $(this).attr('id');
    $.ajax({
        url: url,
        data: { id: pago },
        method: 'post', //en este caso
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data) {
                var formattedDate = new Date(data.date); 
                var d = formattedDate.getDate(); 
                var m = formattedDate.getMonth(); 
                m += 1;
                var y = formattedDate.getFullYear();
                console.log(d + "/" + m + "/" + y);
                $('#updfecha').val(y + "-" + m + "-" + d);
                $('.clientes').val(data.id_cotization_x_product);
                $('#updempresa').val(data.business_name);
                $('#updmaquina').val(data.name);
                $('#upserie').val(data.serie);
                $('#updmodelo').val(data.model);
                $('#concepto').val(data.concept);
                let uds = currency(data.uds).format();
                let tc = currency(data.tc).format();
                let pesos = currency(data.pesos).format();
                $('#upduds').val(uds);
                $('#updtc').val(tc);
                $('#updpesos').val(pesos);
                $('#updporciento').val(data.porciento);
                $('#updbanco').val(data.banco);
                $('#id_pago').val(data.id);
                $('#comprobante').val(data.proof_of_payment);
                $('#factura').val(data.invoice_receipt);

                if (data.proof_of_payment != " ") {
                    let ficha = $('#ficha');
                    let html_ficha = '<label class="form-control-label mt-2">COMPROBANTE:</label><a class="form-control" href="../../Pagos/Comprobante/' + data.proof_of_payment + '" target="_blank"><img src="../../../assets/img/pdf.png" ></a>'
                    +'<button type ="button"  id="' + data.id + '""  data-index="'+data.proof_of_payment+'" data-tipo="0"    class="btn btn-danger mt-2  solid pd-x-20 delete-file" style="border-radius: 10px;"><i class="fa fa-trash-o fa-lg mr-1" aria-hidden="true"></i> ELIMINAR</button>'
                    $(ficha).html(html_ficha);
                }

                if(data.invoice_receipt != " "){
                    let cotizacion = $('#file-cot');
                    let html_cotizacion = '<label class="form-control-label mt-2">FACTURA:</label><a class="form-control" href="../../Pagos/Facturas/' + data.invoice_receipt + '" target="_blank"><img src="../../../assets/img/pdf.png" ></a>'
                    +'<button type ="button" id="' + data.id + '""  data-index="'+data.invoice_receipt+'"  data-tipo="1" class="btn btn-danger mt-2  solid pd-x-20 delete-file" style="border-radius: 10px;"><i class="fa fa-trash-o fa-lg mr-1" aria-hidden="true"></i> ELIMINAR</button>'
                    $(cotizacion).html(html_cotizacion);

                }
                $('#loader').toggle();
                $('#updateModal').modal('show');
            }
          
        },
        error: function (xhr, text_status) {
            $('#loader').toggle();
        }
    });

});

$(".maquinas-client").change(function () {
    let modelo = $(this).children('option:selected').data('model');
    let serie = $(this).children('option:selected').data('serie');
    $('#upserie').val(serie);
    $('#updmodelo').val(modelo);

});






$("#upduds").blur(function () {
    $("#updpesos").val(" ");
    let uds = $(this).val();
    let tc = $("#updtc").val();
    let newtc1 = tc.replace('$', '');
    let newtc2 = newtc1.replace(',', '');
    let newuds1 = uds.replace('$', '');
    let newuds2 = newuds1.replace(',', '');

    let tcfrloat = parseFloat(newtc2);
    let udsfloat = parseFloat(newuds2);
    let pesos = tcfrloat * udsfloat;

    let pesos_curr = currency(pesos).format();
    $("#updpesos").val(pesos_curr);   
    let usd_curr = currency(uds).format();
    $("#upduds").val(usd_curr);  
});

$("#updtc").blur(function () {
    $("#updpesos").val(" ");
    let uds = $("#upduds").val();
    let tc = $(this).val();

    let newtc1 = tc.replace('$', '');
    let newtc2 = newtc1.replace(',', '');
    let newuds1 = uds.replace('$', '');
    let newuds2 = newuds1.replace(',', '');

    let tcfrloat = parseFloat(newtc2);
    let udsfloat = parseFloat(newuds2);
    let pesos = tcfrloat * udsfloat;

    
    let pesos_curr = currency(pesos).format();
    $("#updpesos").val(pesos_curr);   


    let tc_curr = currency(tc).format();
    $("#updtc").val(tc_curr);
});

$("#updpesos").blur(function () {
    let tc = $(this).val();
    let tc_curr = currency(tc).format();
    $("#updpesos").val(tc_curr);
});


/* ACTUALIZAR PAGOS */ 

$(document).on('submit', '#formUpdatePago', function() {
    // console.log("di un click");
    const formData = new FormData($(this)[0]);
    const url = `${BASE_URL}Administrador/Pagos/updatePago`;

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
                document.getElementById("formUpdatePago").reset();
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
    const url = `${BASE_URL}Administrador/Pagos/deletePago`;

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
    const url = `${BASE_URL}Administrador/Pagos/deleteFiles`;

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


//cambios//
/* function get_empresas() {
    const url = `${BASE_URL}Proveedores/getEmpresas`;
    var empresas = $(".empresas");
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#loader').toggle();
            console.log(data);
            //const ch = data['data'];
            empresas.append(`<option  value=""> SELECCIONA EMPRESA </option>`);
            $(data).each(function (i, v) {
                empresas.append(`<option  value="${v.id}"> ${v.business_name}</option>`);
            })



        },
        error: function (error) {
            //alert('hubo un error al enviar los datos');
        }
    });
} */

//listado de productos//
/* $(".empresas").change(function () {
    let id_empresa = $(this).val();
    $(".maquinas").empty();

    if (id_empresa) {
        const url = `${BASE_URL}Administrador/Pagos/getMaquina/${id_empresa}`;

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var proveedor = $(".maquinas");
                proveedor.append(`<option  value="" data-model=" " data-serie=" "> SELECCIONA MAQUINA </option>`);
                $(data).each(function (i, v) {
                    proveedor.append(`<option  value="${v.id}" data-model="${v.model}" data-serie="${v.type}"> ${v.name} </option>`);
                })

                $(".maquinas-client").empty();
                var maquina = $(".maquinas-client");
                maquina.append(`<option  value="" data-model=" " data-serie=" "> SELECCIONA MAQUINA </option>`);
                $(data).each(function (i, v) {
                    maquina.append(`<option  value="${v.id}" data-model="${v.model}" data-serie="${v.type}"> ${v.name} </option>`);
                })
            },
            cache: false,
            contentType: false,
            processData: false
        });

    }

    return false;
}); */


/* $(".maquinas").change(function () {
    let modelo = $('.maquinas').children('option:selected').data('model');
    let serie = $('.maquinas').children('option:selected').data('serie');
    $('#c-serie').val(serie);
    $('#c-modelo').val(modelo);

}); */



  /*     $(".maquinas-client").empty();
                var proveedor = $(".maquinas-client");
                proveedor.append(`<option  value="" data-model=" " data-serie=" "> SELECCIONA MAQUINA </option>`);
                $(data.productos).each(function (i, v) {
                    proveedor.append(`<option  value="${v.id}" data-model="${v.model}" data-serie="${v.type}"> ${v.name} </option>`);
                }); */

                // setTimeout(function () {
                //     $(".maquinas-client").val(data.pagos.id_product);
                //     let modelo = $('.maquinas-client').children('option:selected').data('model');
                //     let serie = $('.maquinas-client').children('option:selected').data('serie');
                //     $('#upserie').val(serie);
                //     $('#updmodelo').val(modelo);
                //     $('#loader').toggle();
                //     $('#updateModal').modal('show');
                // }, 5000);

