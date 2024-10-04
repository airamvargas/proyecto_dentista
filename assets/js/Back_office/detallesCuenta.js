/* Desarrollador: Airam V. Vargas López
Fecha de creacion: 28 de noviembre de 2023
Fecha de Ultima Actualizacion: 30 de noviembre de 2023
Perfil: Back Office
Descripcion: JS del reporte de cuentas por cobrar */

/*TABLA DE ABONOS INDIVIDUALES POR EMPRESA*/
var dataTable = $('#crm_abonos').DataTable({
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/readIndividuales`,
        data: {id_company : id_company},
        type: "post",
    },
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],

    columns: [
        {
            data: 'c_fecha',
            render: function (data, type, row, meta) {
                return moment(row.created_at).format("DD-MM-YYYY");
            }

        },
        {
            data: 'abono',
            render: function (data, type, row, meta) {
                return currency(data, { symbol: "$", separator: "," }).format();
            }

        },
        {
            data: 'abono',
            render: function (data, type, row, meta) {
                if(row.saldo_utilizado == null){
                    return currency(data, { symbol: "$", separator: "," }).format();
                } else {
                    total = parseFloat(data) - parseFloat(row.saldo_utilizado);
                    return currency(total, { symbol: "$", separator: "," }).format();
                }
                
            }

        },
        {
            data: 'concepto',

        },
        {
            data: 'medio_pago',
        },
        {
            data: 'comprobante',
            render: function (data, type, row, meta) {
                let comprobante = data == null ?  `` :  `<a href="${BASE_URL}../../public/uploads/back_office/comprobante_pago/${data}" target="_blank"><button id="${data}" class="btn btn-teal comprobante solid pd-x-20 btn-circle btn-sm mr-2" title="Ver comprobante"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></button></a>`
                return comprobante;
            }
        },
        {
            data: 'id',
            render: function (data, type, row, meta) {
                if(row.saldo_utilizado == null){
                    return `<div class="d-flex"><a href="${BASE_URL}Back_office/ReporteCuentas/detallesAdeudo/${data}"><button class="btn btn-primary pagar solid pd-x-20 btn-circle btn-sm mr-2" title="Pagar pendientes"><i class="fa fa-money fa-2x" aria-hidden="true"></i></button></a>
                    <button id="${data}" class="btn btn-warning update solid pd-x-20 btn-circle btn-sm mr-2" title="Editar datos"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button><button id="${data}" class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm mr-2" title="Eliminar abono"><i class="fa fa-trash fa-2x" aria-hidden="true"></i></button></div>`
                } else {
                    return `<div class="d-flex"><a href="${BASE_URL}Back_office/ReporteCuentas/detallesAdeudo/${data}"><button class="btn btn-primary pagar solid pd-x-20 btn-circle btn-sm mr-2" title="Pagar pendientes"><i class="fa fa-money fa-2x" aria-hidden="true"></i></button></a>
                    <button id="${data}" class="btn btn-warning update solid pd-x-20 btn-circle btn-sm mr-2" title="Editar datos"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button></div>`
                }
            }
        }
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

//Boton actualiza datos del abono individual
$(document).on('click', '.update', function(){
    let id = $(this).attr('id');
    let url = `${BASE_URL}${CONTROLADOR}/getIndividual/${id}`
    getValores(url);
});

//Eliminar abono individual
$(document).on('click', '.delete', function(){
    let id = $(this).attr('id');
    $("#id_abono").val(id);
    $('#modal_delete').modal('show');
});

//Ver detalles de los adeudos que tiene la esa compañia
$(document).on('click', '#detalles', function(){
    location.href = `${BASE_URL}Back_office/ReporteCuentas/detallesAdeudo/${id_company}`;
});


//Enviar datos a actualizar
$(document).on('submit', '#updateAbonos', function(e) {
    e.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}${CONTROLADOR}/updateAbonos`;
    let FORMDATA = new FormData($(this)[0]);
    let form = $('#updateAbonos');
    let modal = $('#modal_editar');
    send(url, FORMDATA, dataTable, modal, form);
});

$(document).on('submit', '#abonosDelete', function(e) {
    e.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}${CONTROLADOR}/deleteAbonos`;
    let FORMDATA = new FormData($(this)[0]);
    let form = $('#abonosDelete');
    let modal = $('#modal_delete');
    send(url, FORMDATA, dataTable, modal, form);
});

$("#regresar").click(function(){
    $('#loader').toggle();
});

let getValores = (url) => {
    $('#loader').toggle();
    fetch(url).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            fecha = moment(response[0].c_fecha).format("YYYY-MM-DD");
            $("#company").val(response[0].empresa);
            $("#id_company").val(response[0].id_company);
            $("#fecha").val(fecha);
            $("#abono").val(response[0].abono);
            $("#concepto").val(response[0].concepto);
            $('#medio_pago').val(response[0].medio_pago);
            $("#id_update").val(response[0].id);
            $("#modal_editar").modal('toggle');
            $('#loader').toggle(); 
    }).catch(err => alert(err));
}

let send = (url, data, reload, modal, form, ref) => {
    fetch(url, {
        method: "POST",
        body: data,
    }).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            response.status == 200 ? notificacion(response.msg, true, reload, modal, form, ref) : notificacion(response.msg, false)
    }).catch(err => alert(err))
}

//notificaciones
let notificacion = (mensaje, flag, reload, modal, form, ref) => {
    console.log(ref);
    if (flag) {
        var imagen = BASE_URL + "../../assets/img/correcto.png";
        var background = "linear-gradient(to right, #00b09b, #96c93d)";

    } else {
        var imagen = BASE_URL + "../../assets/img/cancelar.png";
        var background = "linear-gradient(to right, #f90303, #fe5602)";
    }

    if (reload) {
        reload.ajax.reload();
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