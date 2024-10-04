var dataTable = $('#route_table').DataTable({
    ajax: BASE_URL + 'Logistica/Rest_PedidosHistorial',

    columns: [{
            data: 'order_id',
            render: function(data, type, row) {
                return `<span data-index="` + data + `" class="details">` + data + `</span>`;
            }
        },
        { data: 'business_name' },
        {
            data: 'Fecha',
            render: function(data, type, row, meta) {
                return '<span id="fecha_row">' + row.Fecha_orden + '</span>' + data;

            }
        },


        { data: 'address' },
        { data: 'destination' },
        { data: 'product' },
        {
            data: "status",
            render: function(data, type, row, meta) {
                //return data;
                switch (data) {
                    case '1':
                        return `<span class="label-secondary">` + row.text_status + `</bspan>`;
                        break;
                    case '2':
                        return `<span class="label-secondary">` + row.text_status + `</bspan>`;
                        break;
                    case '3':
                        return `<span class="label-secondary">` + row.text_status + `</bspan>`;
                        break;
                    case '4':
                        return `<span class="label-secondary">` + row.text_status + `</bspan>`;
                        break;
                    case '5':
                        return `<span class="label-secondary">` + row.text_status + `</bspan>`;
                        break;
                    case '6':
                        return `<span class="label-teal">` + row.text_status + `</bspan>`;
                        break;
                    case '7':
                        return `<span class="label-success">` + row.text_status + `</bspan>`;
                        break;
                    case '8':
                        return `<span class="label-danger">` + row.text_status + `</bspan>`;
                    case '9':
                        return `<span class="label-danger">` + row.text_status + `</bspan>`;
                    case '10':
                        return `<span class="label-danger">` + row.text_status + `</bspan>`;
                        break;
                    default:
                        return `<span class="label-secondary">` + row.text_status + `</bspan>`;
                        break;
                }
            }
        },

        {
            data: "status",
            render: function(data, type, row, meta) {
                return data == "1" || data == "2" || data == "4" || data == "5" || data == "6" ?
                    '<button data-index="' + row.order_id + '"" class="delete btn btn btn-danger pd-x-20 mg-x-20" style="border-radius: 10px;">Cancelar</button>' :
                    ''
            }
        },


    ],
    responsive: false,
    "scrollX": true,
    "sScrollX": "100%",
    "sScrollXInner": "110%",
    "bScrollCollapse": true,
    "fixedColumns": {
        "leftColumns": 1
    },




    // responsive: false,
    // "scrollX": true,
    ordering: true,
    language: {
        searchPlaceholder: 'BUSCAR...',
        sSearch: '',
        lengthMenu: '_MENU_ ENVIOS/PAGINA',
    }
});


function reloadData() {
    $('#loader').toggle();
    dataTable.ajax.reload();
    $('#loader').toggle();
}

function getSucursal() {

    const socios = base_url + 'Logistica/Rest_SucursalesBO/get_socios';
    var getsocios = $("#socios");

    $.ajax({
        url: socios,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            const ch = data['data'];
            console.log(ch);

            $(ch).each(function(i, v) { // indice, valor
                //console.log(v);
                getsocios.append('<option value="' + v.id + '">' + v.business_name + '</option>');
            })
        },
        error: function(error) {
            alert('hubo un error al enviar los datos');
        }
    });

    $("#socios").on('change', function() {
        alert(this.value);

        const url = "<?= base_url(); ?>/sucursales/getSucursal/" + this.value;
        var sucursales = $("#sucursales");

        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                const ch = data['data'];
                console.log(ch);

                $(ch).each(function(i, v) { // indice, valor
                    console.log(v);
                    sucursales.append('<option value="' + v.id + '">' + v.name + '</option>');
                })
            },
            error: function(error) {
                alert('hubo un error al enviar los datos');
            }
        });

    });
}


$(document).ready(function() {

    // Handler for .ready() called.
});

$(document).on('click', '.details', function() {
    var url_str = base_url + '/Api/bo_pedidos/get_order';
    $('#loader').toggle();
    let id_buton = $(this).data('index');
    $('#submit_form_upd').data('index', $(this).data('index'));
    $('#show_confirmation').data('index', $(this).data('index'));
    $('#id_upd').val(id_buton);
    let json = {
        id: $(this).data('index')
    };

    let objson = JSON.stringify(json);

    $.ajax({
        url: url_str,
        data: objson,
        method: 'post', //en este caso
        dataType: 'json',
        success: function(success) {
            //$("#detail_table").empty();
            detail = success['data'];
            tableBody = $("#detail_table_body");
            tableBody.empty();
            detail_data = Object.entries(detail['0'])
            detail_data.forEach(element => {
                console.log(element);
                if (element[0] == 'Fragil') {
                    console.log('en fragil')
                    if (element[1] == '1') {
                        element[1] = 'Si';
                    } else {
                        element[1] = 'No';
                    }
                }
                markup = "<tr><td>" + element[0] + "</td><td>" + element[1] + "</td></tr>";
                tableBody.append(markup);
            })
            let lng = parseFloat(success['data'][0].length);
            let lat = parseFloat(success['data'][0].latitude);
            // console.log("soy la longitud:"+lng);
            // console.log("soy la latitud"+lat);
            //initMap(lat,lng);

            success['data']['events'].forEach(element => {
                if (element.id_cat_of_events == 1) {
                    markup = "<tr><td>COMENTARIO RECOLECCIÓN</td><td>" + element.coment + "</td></tr>";
                    tableBody.append(markup);
                }
            });


            success['data']['files'].forEach(element => {
                if (element.id_type_of_file == 1) {
                    markup = "<tr><td class=\"label-teal\">EVIDENCIA DE RECOLECCION</td><td><img style=\"width:100%\" id=\"recolecta\" src=\"" + base_url + "/../images/" + element.name + "\"/></td></tr>";
                    tableBody.append(markup);
                }
            });



            success['data']['events'].forEach(element => {
                if (element.id_cat_of_events == 2) {
                    markup = "<tr><td>COMENTARIO ENTREGA</td><td>" + element.coment + "</td></tr>";
                    tableBody.append(markup);
                }
            });



            success['data']['files'].forEach(element => {
                if (element.id_type_of_file == 2) {
                    markup = "<tr><td class=\"label-teal\">EVIDENCIA DE ENTREGA</td><td><img style=\"width:100%\" id=\"entrega\" src=\"" + base_url + "/../images/" + element.name + "\"/></td></tr>";
                    tableBody.append(markup);
                }
            });

            $('#loader').toggle();
            $('#modal_update').modal('show');
        },
        error: function(xhr, text_status) {
            $('#loader').toggle();
        }
    });
});

function myFunction() {
    console.log($(this));
    alert($(this).attr('value'));
}

$(document).on('click', '.delete', function() {
    $("#submit_form_del").data('index', $(this).data('index'));
    var actualHour = new Date();
    var limitHour = new Date();
    limitHour.setHours(20);
    limitHour.setMinutes(0);
    if (actualHour.getTime() < limitHour.getTime()) {
        $("#text_delete").text('¿Estas seguro que deseas cancelar este envio? Esta operacion no se puede deshacer y puede generar un cargo por servico');
    } else {
        $("#text_delete").text('¿Estas seguro que deseas cancelar este envio? Esta operacion no se puede deshacer');
    }
    $("#modal_delete").modal('show');
});

$(document).on('click', '#submit_form_del', function() {
    $("#modal_delete").modal('hide');
    $('#loader').toggle();
    var url_str = base_url + 'Rest_Pedidos_LiberadosBO/cancel';
    let json = {
        id: $(this).data('index')
    };
    $.ajax({
        url: url_str,
        data: JSON.stringify(json),
        method: 'post', //en este caso
        dataType: 'json',
        success: function(success) {
            console.log(success);
            if (success.status == "200") {
                alert(success.messages.success);
            }
            reloadData();
            $('#loader').toggle();
        },
        error: function(xhr, text_status) {
            $('#loader').toggle();
        }
    });
})