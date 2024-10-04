/* Desarrollador: Airam V. Vargas López
Fecha de creacion: 4 de diciembre de 2023
Fecha de Ultima Actualizacion: 11 de enero de 2024
Perfil: Back Office
Descripcion: JS del reporte de detalles del adeudo */

$(document).ready(function() {
    formulario();    
    getRestante();
});

//RECARGAR LA TABLA DE ADEUDOS PAGADOS
function reload_table(){
    table_pagados.ajax.reload();
}

//Enviar listado de adeudos a pagar
$(document).on('submit', '#pagarAdeudo', function(e) {
    e.preventDefault();
    document.getElementById('btn_pagar').disabled = true;
    $('#loader').toggle();
    let url = `${BASE_URL}${CONTROLADOR}/pagarAdeudos`;
    var pagos = table_recive.getData(); 
    let FORMDATA = new FormData($(this)[0]);
    FORMDATA.append('pagos', JSON.stringify(pagos))
    let form = $('#pagarAdeudo');
    let modal = $('#modal_pagar');
    send(url, FORMDATA, modal, form);
});

// Eliminar pago
$(document).on('click', '.delete', function(){
    let id_pago_abono = $(this).attr('id');
    $("#id_pago_abono").val(id_pago_abono);
    $("#modal_delete").modal('toggle');
});

$(document).on('submit', '#eliminarPago', function(e) {
    e.preventDefault();
    document.getElementById('btn_eliminar').disabled = true;
    $('#loader').toggle();
    let url = `${BASE_URL}${CONTROLADOR}/eliminarPago`;
    let FORMDATA = new FormData($(this)[0]);
    let form = $('#eliminarPago');
    let modal = $('#modal_delete');
    send(url, FORMDATA, modal, form);
});

//Cerrar pago de adeudo
$(document).on('click', '.cerrar', function(){
    let id_pago_abono = $(this).attr('id');
    $("#id_pago_abono_cerrar").val(id_pago_abono);
    $("#modal_cerrar").modal('toggle');
});

$(document).on('submit', '#cerrarPago', function(e) {
    e.preventDefault();
    document.getElementById('btn_cerrar').disabled = true;
    $('#loader').toggle();
    let url = `${BASE_URL}${CONTROLADOR}/cerrarPago`;
    let FORMDATA = new FormData($(this)[0]);
    let form = $('#cerrarPago');
    let modal = $('#modal_cerrar');
    send(url, FORMDATA, modal, form);
});

//Pagar adeudos seleccionados
let formulario = () => {
    $(document).on('click', '#pagar_deuda', function(){
        var data = table_recive.getData(); 
        $("#id_company").val(id_company);
        $("#id_abono").val(id_abono);
        if(data.length > 0){
            sobrante = 0;
            var TOTAL = 0;
            var newRestante = parseFloat(RESTANTE);
            $(data).each(function (i, v) {
                if(v.pagado == null){
                    newAmount = parseFloat(v.total);
                } else {
                    newAmount = parseFloat(v.pagado)
                }
                
                if(newRestante == 0){
                    Toastify({
                        text: "NO TIENE SALDO DISPONIBLE PARA PAGAR",
                        duration: 3000,
                        className: "info",
                        avatar: BASE_URL + "../../assets/img/cancelar.png",
                        style: {
                            background: "linear-gradient(to right, #f90303, #fe5602)"
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },
                    }).showToast();
                } else {
                    if(sobrante == 0){
                        if(newRestante >= newAmount){
                            sobrante = newRestante - newAmount;
                            if(sobrante < 0){
                                TOTAL = TOTAL + 0;
                            } else{
                                TOTAL = TOTAL + newAmount;
                            }
                        }else {
                            resta = newAmount - newRestante;
                            pago = newAmount - resta;
                            TOTAL = TOTAL + pago;
                        }
                    } else {
                        if(sobrante >= newAmount){
                            TOTAL = TOTAL + newAmount;
                            sobrante = newRestante - TOTAL;
                        } else {
                            resta = newAmount - sobrante;
                            pago = newAmount - resta;
                            TOTAL = TOTAL + pago;
                        }
                    }                    
                }
            });

            if(TOTAL <= newRestante){
                $("#modal_pagar").modal('toggle');
            } else {
                Toastify({
                    text: "EL MONTO A PAGAR DEBE SER IGUAL O MENOR AL TOTAL DISPONIBLE",
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f90303, #fe5602)"
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
            }
            
        } else {
            Toastify({
                text: "NO HA SELECCIONADO NINGÚN DATO",
                duration: 3000,
                className: "info",
                avatar: BASE_URL + "../../assets/img/cancelar.png",
                style: {
                    background: "linear-gradient(to right, #f90303, #fe5602)"
                },
                offset: {
                    x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                    y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                },
            }).showToast();
        }
    });
}

//Se obtiene el monto restante del abono
let getRestante = () => {
    $('#loader').toggle();
    $("#pagados").children().remove();
    $("#por_pagar").children().remove();
    $("#pendientes").children().remove();
    let url =  `${BASE_URL}${CONTROLADOR}/getRestante/${id_abono}`
    fetch(url).then(response => response.json()).catch(err => alert(err)).then(response => {
        $("#total_disponible").children().remove();
        RESTANTE = parseFloat(response);
        $("#total_disponible").append(`<span>${ currency(RESTANTE, { symbol: "$", separator: "," }).format()}</span>`);
        if(RESTANTE == 0){
            $("#pagar_deuda").hide();
        } else {
            $("#pagar_deuda").show();
        }
        let pagados = `<h4 style="color: black; font-style: italic !important;">Adeudos pagados<h4/>`;
        $("#pagados").append(pagados);
        let por_pagar = `<h4 style="color: black; font-style: italic !important;">Adeudos por pagar<h4/>`;
        $("#por_pagar").append(por_pagar);
        let pendientes = `<h4 style="color: black; font-style: italic !important;">Adeudos pendientes<h4/>`;
        $("#pendientes").append(pendientes);
        reload_table();
        table_reciver();
        tabla_adeudos();
        $('#loader').toggle();
    }).catch(err => alert(err));
}

//Tabla a donde se mueven las cuentas que se desean pagar
function table_reciver(){
    $('#loader').toggle();
    table_recive = new Tabulator("#crm_x_pagar", {
        data:[], //assign data to table
        height: 200,
        layout:"fitColumns",
        layoutColumnsOnNewData:true,
        //autoColumns:true, //create columns from data field names
        pagination:"local",
        paginationSize:20,
        //resizableRows:true, 
        //autoResize:true,
        //layout:"fitData",
        movableRows:true,
        movableRowsConnectedTables:"#crm_abonos",
        movableRowsReceiver: "add",
        movableRowsSender: "delete", 
        //renderHorizontal:"virtual",
        //resizableColumnFit:true,
        //resizableRowGuide: true,
        rowHeader:{formatter:"responsiveCollapse", width:70, hozAlign:"center", resizable:true, headerSort:false},
        rowFormatter:function(row){
            var rows_data = row.getData();
            if(rows_data.adeudo == null){
                row.getElement().children[6].innerText = rows_data.total;
            }
        },
        //collumns:collumns
        autoColumns:false,
        columns:[
            {formatter:"rowSelection", titleFormatter:"rowSelection", hozAlign:"center", headerSort:false, cellClick:function(e, cell){}},

            {title:"Convenio", field:"convenio", width:200, hozAlign:"right"},
            {title:"Monto total", field:"total", width:200, hozAlign:"right"},
            {title:"Monto a pagar", field:"adeudo", width:200, hozAlign:"right"},
            {title:"# Orden de Servicio", field:"orden_servicio", hozAlign:"right"},
            {title:"Fecha", field:"fecha", hozAlign:"right", formatter:"datetime", formatterParams:{
                outputFormat:"dd/MM/yyyy",
            }}
        ]
    });
    $('#loader').toggle();
}

//Tabla de cuentas pendientes por pagar
function tabla_adeudos(){
    $('#loader').toggle();
    var url_adeudos = `${BASE_URL}Api/Back_office/ReporteCuentas/adeudos`;
    $.ajax({
        url: url_adeudos,
        type: "POST",
        data: { id_company : id_company},
        success: function(result) {
            var tabledata = result.data;
            table = new Tabulator("#crm_abonos", {
                data:tabledata, //assign data to table
                minHeight: 200,
                
                autoColumns:true, //create columns from data field names
                pagination:"local",    
                selectable:true,   //paginate the data
                paginationSize:20, 
                movableRows:true,
                movableRowsConnectedTables:"#crm_x_pagar",
                movableRowsReceiver: "add",
                movableRowsSender: "delete",
                renderHorizontal:"virtual",
                rowFormatter: function(row){
                    var rows_data = row.getData();
                    if(rows_data.adeudo == null){
                        row.getElement().children[6].innerText = rows_data.total;
                    } 
                },
                //collumns:collumns
                autoColumns:false,
                columns:[
                    {formatter:"rowSelection", titleFormatter:"rowSelection", hozAlign:"center", headerSort:false, cellClick:function(e, cell){}},
                    {title:"Convenio", field:"convenio", width:200, hozAlign:"right"},
                    {title:"Monto total", field:"total", width:250, hozAlign:"right"},
                    {title:"Monto a pagar", field:"adeudo", width:250, hozAlign:"right"},
                    {title:"# Orden de Servicio", field:"orden_servicio", hozAlign:"right"},
                    {title:"Fecha", field:"fecha", hozAlign:"right", formatter:"datetime", formatterParams:{
                        outputFormat:"dd/MM/yyyy",
                    }}
                ]
            });
            $('#loader').toggle();
        },
        error: function(xhr, text_status) {
            $('#loader').toggle();
            $('#error-alert').show();
            $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
    
        }
    });
}

let send = (url, data, modal, form) => {
    $('#loader').toggle();
    fetch(url, {
        method: "POST",
        body: data,
    }).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            if(response.status == 200){
                notificacion(response.msg, true, modal, form);
                getRestante();
                document.getElementById('btn_pagar').disabled = false;
                document.getElementById('btn_eliminar').disabled = false;
                document.getElementById('btn_cerrar').disabled = false;
            } else {
                notificacion(response.msg, false);
            }
            $('#loader').toggle();
    }).catch(err => alert(err))
}

//notificaciones
let notificacion = (mensaje, flag, modal, form, ref) => {
    if (flag) {
        var imagen = BASE_URL + "../../assets/img/correcto.png";
        var background = "linear-gradient(to right, #00b09b, #96c93d)";

    } else {
        var imagen = BASE_URL + "../../assets/img/cancelar.png";
        var background = "linear-gradient(to right, #f90303, #fe5602)";
    }

    if (modal) {
        $(modal.selector).modal('toggle');
    }

    if (form) {
        $(form.selector).trigger("reset");

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
    
    if (ref) {
        setTimeout(() => {
            window.location.href = BASE_URL + ref;
        }, "1000");
    }

    document.getElementById('pagar_deuda').disabled = false;
    $('#loader').toggle();
}


