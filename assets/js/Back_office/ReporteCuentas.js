/* Desarrollador: Airam V. Vargas López
Fecha de creacion: 27 de noviembre de 2023
Fecha de Ultima Actualizacion: 28 de noviembre de 2023
Perfil: Back Office
Descripcion: JS del reporte de cuentas por cobrar */

//Obtener analitos del estudio
let getCompany = () => {
    $('#loader').toggle();
    let url_company = `${BASE_URL}Api/Catalogos/Empresas/read`;
    fetch(url_company).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            var select = $("#empresa");
            select.append(`<option value="">Selecciona una empresa</option>`);
            $(response['data']).each(function (i, v) {
                select.append(`<option value="${v.id}"> ${v.name}</option>`);
            });

        $('#loader').toggle();
    }).catch(err => alert(err))
}
getCompany();

$(document).on('submit', '#formAbonos', function(e) {
    e.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}${CONTROLADOR}/insertAbonos`;
    let FORMDATA = new FormData($(this)[0]);
    let form = $('#formAbonos');
    let modal = $('#myModal');
    send(url, FORMDATA, dataTable, modal, form);
});

//archivo comprobante de pago
$(document).on('change', '#file_comprobante', function() {
    var filesCount = $(this)[0].files.length;
    var textbox = $(this).prev();
    var ext = $(this).val().split('.').pop();
    var archivo = document.getElementById("file_comprobante").files[0];

    if (ext == "jpeg" || "png" || "jpg" || "pdf") {
        if (filesCount === 1) {
            var reader = new FileReader();
            reader.readAsDataURL(archivo);
            var fileName = $(this).val().split('\\').pop();
            textbox.text(fileName);
        } else {
            textbox.text(filesCount + ' files selected');
        }
    } else {
        $(this).val('');
        Toastify({
            text: "El archivo debe tener formato jpeg, png. jpg o pdf",
            duration: 3000,
            className: "info",
            style: {
                background: "linear-gradient(to right, red, orange)",
            },
            offset: {
                x: 50, 
                y: 90 
            },
        }).showToast();
    }
});

/*TABLA DE PRODUCTOS COTIZADOS*/
var dataTable = $('#crm_abonosTotales').DataTable({
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/readAbonos`,
        type: "post",
    },
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],

    columns: [
        {
            data: 'empresa',

        },
        {
            data: 'total_abonos',
            render: function (data, type, row, meta) {
                total = parseFloat(data) - parseFloat(row.total_residuo);
                return currency(total, { symbol: "$", separator: "," }).format();
            }
        },
        {
            data: 'adeudo_total',
            render: function (data, type, row, meta) {
                if(parseFloat(data) == parseFloat(row.adeudo_pagado)){
                    total = parseFloat(row.adeudo_pagado) - parseFloat(data);
                    return currency(total, { symbol: "$", separator: "," }).format();
                } else if (data == null){
                    total = 0;
                    return currency(total, { symbol: "$", separator: "," }).format();
                } else if (parseFloat(data) != parseFloat(row.adeudo_pagado)){
                    total = parseFloat(data) - parseFloat(row.total_residuo);
                    return currency(total, { symbol: "$", separator: "," }).format();
                }
            }
        },
        {
            data: 'id_company',
            render: function (data, type, row, meta) {
                return `<button id="${data}" class="btn btn-primary detalles solid pd-x-20 btn-circle btn-sm mr-2" title="Detalles cuenta"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></button>`
            }
        }
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

//Detalles individuales de la cuenta
$(document).on('click', '.detalles', function(){
    id_company = $(this).attr('id');
    location.href = `${BASE_URL}Back_office/ReporteCuentas/detallesCuenta/${id_company}`;
});


let send = (url, data, reload, modal, form, ref) => {
    fetch(url, {
        method: "POST",
        body: data,
    }).then(response => response.json()).catch(err => alert(err)).then(response => {
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