/* Desarrollador: Airam V. Vargas López
Fecha de creacion: 4 de diciembre de 2023
Fecha de Ultima Actualizacion: 
Perfil: Back Office
Descripcion: JS del reporte de detalles del adeudo */

var array_to_ship = Array();
var table = null;
var RESTANTE = 0;

$(document).ready(function() {
    getRestante();
    formulario();
});

$(document).on('submit', '#pagarAdeudo', function(e) {
    e.preventDefault();
    document.getElementById('btn_pagar').disable = true;
    $('#loader').toggle();
    let url = `${BASE_URL}${CONTROLADOR}/pagarAdeudos`;
    var pagos = table_recive.getData(); 
    let FORMDATA = new FormData($(this)[0]);
    FORMDATA.append('pagos', JSON.stringify(pagos))
    let form = $('#pagarAdeudo');
    let modal = $('#modal_pagar');
    send(url, FORMDATA, modal, form);
});

function tabla_pagados(){
    $('#loader').toggle();
    var url_csv = BASE_URL + '/Api/Back_office/ReporteCuentas/pagados';
    $.ajax({
        url: url_csv,
        type: "POST",
        data: { id_abono : id_abono},
        success: function(result) {
            //console.log(result.data);
            //define data array
            var tabledata = result.data;
            table = new Tabulator("#crm_pagados", {
                data:tabledata, //assign data to table
                autoColumns: false, //create columns from data field names
                pagination:"local",    
                selectable:true,   //paginate the data
                paginationSize:20, 
                renderHorizontal:"virtual",
                columns:[
                    {title:"Folio", field:"folio", width:200, hozAlign:"right"},
                    {title:"Convenio", field:"convenio", width:200, hozAlign:"right"},
                    {title:"Monto a pagar", field:"Pago", width:250, hozAlign:"right"},
                    {title:"Monto pagado", field:"monto_pagado", width:250, hozAlign:"right"},
                    {title:"# Orden de Servicio", field:"Orden_servicio", hozAlign:"right"},
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

function tabla_adeudos(){
    $('#loader').toggle();
    var url_csv = BASE_URL + '/Api/Back_office/ReporteCuentas/adeudos';
    $.ajax({
        url: url_csv,
        type: "POST",
        data: { id_company : id_company},
        success: function(result) {
            var tabledata = result.data;
            table = new Tabulator("#crm_abonos", {
                data:tabledata, //assign data to table
                autoColumns:true, //create columns from data field names
                pagination:"local",    
                selectable:true,   //paginate the data
                paginationSize:20, 
                movableRows:true,
                movableRowsConnectedTables:"#crm_x_pagar",
                movableRowsReceiver: "add",
                movableRowsSender: "delete",
                renderHorizontal:"virtual",
                //rowClickPopup:rowPopupFormatter,
                rowFormatter:function(row){
                    var rows_data = row.getData();
                    if(rows_data.pagado == null){
                        row.getElement().children[6].innerText = rows_data.total;
                    } 
                },
                //collumns:collumns
                autoColumns:false,
                columns:[
                    {formatter:"rowSelection", titleFormatter:"rowSelection", hozAlign:"center", headerSort:false, cellClick:function(e, cell){}},
                    {title:"Convenio", field:"convenio", width:200, hozAlign:"right"},
                    {title:"Monto total", field:"total", width:250, hozAlign:"right"},
                    {title:"Monto a pagar", field:"pagado", width:250, hozAlign:"right"},
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

function table_reciver(){
    $('#loader').toggle();
    table_recive = new Tabulator("#crm_x_pagar", {
        data:[], //assign data to table
        autoColumns:true, //create columns from data field names
        pagination:"local",
        paginationSize:20,
        movableRows:true,
        movableRowsConnectedTables:"#crm_abonos",
        movableRowsReceiver: "add",
        movableRowsSender: "delete", 
        renderHorizontal:"virtual",
        rowFormatter:function(row){
            var rows_data = row.getData();
            if(rows_data.pagado == null){
                row.getElement().children[6].innerText = rows_data.total;
            }
        },
        //collumns:collumns
        autoColumns:false,
        columns:[
            {formatter:"rowSelection", titleFormatter:"rowSelection", hozAlign:"center", headerSort:false, cellClick:function(e, cell){}},

            {title:"Convenio", field:"convenio", width:200, hozAlign:"right"},
            {title:"Monto total", field:"total", width:250, hozAlign:"right"},
            {title:"Monto a pagar", field:"pagado", width:250, hozAlign:"right"},
            {title:"# Orden de Servicio", field:"orden_servicio", hozAlign:"right"},
            {title:"Fecha", field:"fecha", hozAlign:"right", formatter:"datetime", formatterParams:{
                outputFormat:"dd/MM/yyyy",
            }}
        ]
    });
    $('#loader').toggle();
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
                document.getElementById('pagar_deuda').disable = false;
                getRestante();
            } else {
                notificacion(response.msg, false);
                document.getElementById('pagar_deuda').disable = false;
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

    $('#loader').toggle();
}