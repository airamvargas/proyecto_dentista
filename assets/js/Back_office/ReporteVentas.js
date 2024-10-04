/* Desarrollador: Airam V. Vargas López
Fecha de creacion: 13 de noviembre de 2023
Fecha de Ultima Actualizacion: 14 de novimebre de 2023
Perfil: Back Office
Descripcion: JS detalles de la cotizacion */ 

get_total();

/*TABLA DE PRODUCTOS COTIZADOS*/
var dataTable = $('#crm_estudios').DataTable({
    ajax: {
        url: `${BASE_URL}Api/Cotizaciones/Cotizaciones_x_producto/readCotizationxProducts`,
        data: { 'id': id_cotizacion },
        type: "post",
    },
    searching: false,
    paging: false,
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],

    columns: [
        {
            data: 'name',

        },
        {
            data: 'price',
            render: function (data, type, row, meta) {
                return currency(data, { symbol: "$", separator: "," }).format();
            }
        },
        {
            data: 'cantidad'
        },
        {
            data: 'status_lab', 
            render: function (data, type, row, meta) {
                if(row.status_consulta < 200){
                    switch(data){
                        case "100":
                            status_name = "SIN AUTORIZAR"
                        break;
                        case "101":
                            status_name = "SOLICITUD DE SERVICIO"
                        break; 
                        case "102":
                            status_name = "ACEPTADA POR UN TOMADOR"
                        break; 
                        case "103":
                            status_name = "PROCESO ANALISIS"
                        break; 
                        case "104":
                            status_name = "CAPTURA DE RESULTADOS"
                        break; 
                        case "105":
                            status_name = "VALIDACIÓN Y LIBERACIÓN"
                        break; 
                        case "106":
                            status_name = "PENDIENTE DE TOMA DE MUESTRA"
                        break; 
                        case "107":
                            status_name = "TOMA DE MUESTRA"
                        break; 
                        case "108":
                            status_name = "TOMA DE MUESTRA FINALIZADA"
                        break; 
                        case "109":
                            status_name = "RECOLECTA DE MUESTRA"
                        break; 
                        case "110":
                            status_name = "ESTUDIO LIBERADO"
                        break;
                        case "110":
                            status_name = "ESTUDIO LIBERADO"
                        break;
                    }
                    return status_name;
                } else {
                    if(row.consulta_status =! "3"){
                        switch(row.status_consulta){
                            case "200":
                                status_name = "CONSULTA PENDIENTE"
                            break;
                            case "201":
                                status_name = "CONSULTA ACEPTADA"
                            break;
                            case "202":
                                status_name = "CONSULTA RECHAZADA"
                            break;
                            case "203":
                                status_name = "PACIENTE EN SALA DE ESPERA"
                            break;
                        }
                    } else {
                        status_name = "CONSULTA TERMINADA"
                    }
                    return status_name;
                }
            }
        }
    ],
    ordering: false,
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

$("#crm_estudios_info").hide();

/*TABLA DE PAGOS REALIZADOS EN LA ORDEN DE SERVICIO */
var dataTable = $('#crm_pagos').DataTable({
    ajax: {
        url: `${BASE_URL}Api/Back_office/ReporteCuentas/pagosCotizacion`,
        data: { 'id': id_cotizacion },
        type: "post",
    },
    searching: false,
    paging: false,
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],

    columns: [
        {
            data: 'folio_pago',
        },
        {
            data: 'forma_pago',
        },
        {
            data: 'tipo_pago',
        },
        {
            data: 'pagado',
            render: function (data, type, row, meta) {
                var resp = data == null ? currency(row.amount, { symbol: "$", separator: "," }).format() : currency(data, { symbol: "$", separator: "," }).format();;
                return resp;
            }
        },
        {
            data: 'fecha_pago',
            render: function (data, type, row, meta) {
                return moment(row.created_at).format("DD-MM-YYYY");
            }
        }
    ],
    ordering: false,
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});
$("#crm_pagos_info").hide();

/* OBTENER PRECIO TOTAL */
function get_total() {
    $('#loader').toggle();
    const URL = `${BASE_URL}Api/Cotizaciones/Cotizaciones_x_producto/get_total`;

    $.ajax({
        url: URL,
        method: 'POST',
        data: { id_cotizacion: id_cotizacion },
        dataType: 'json',
        success: function (data) {
            $("#total").children().remove();
            total = `<span>${currency(data[0]['total'], { symbol: "$", separator: "," }).format()}</span>`
            $("#total").append(total);
            $("#total_precio").val(data[0]['total']);
            $('#loader').toggle();
        },
        error: function (error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}


