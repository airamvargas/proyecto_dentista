//FORMATO EN ESPAÑOL FECHA
moment.locale("es");


get_etapas();
function get_etapas() {
    const url = `${BASE_URL}Administrador/Etapas_Venta/getStages`;
    var empresas = $(".empresas");
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            //const ch = data['data'];
            empresas.append(`<option  value=""> SELECCIONAR ETAPA </option>`);
            $(data).each(function (i, v) {
                empresas.append(`<option  value="${v.id}"> ${v.name}</option>`);
            })

        },
        error: function (error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}


var dataTable = $('#datatable1').DataTable({

    ajax: BASE_URL + 'Administrador/Etapas_Venta/getEtapas',
    order: [[0, 'desc']],


    columns: [
        {
            data: "id",

        },



        {
            data: "created_at",
            render: function (data, type, row, meta) {
                return moment(data).format("DD/MM/YY");
            }
        },

        // {data: 'created_at'},
        { data: 'business_name' },
        {
            data: 'razon_social',
            render: function (data, type, row, meta) {
                return '<p class="text-left" id="' + row.razon_social + '">' + row.razon_social + '</p>'
            }
        },
        { data: 'name' },
        { data: 'numero_serie' },
        { data: 'model' },
        // {data: 'ability'},
        // {data: 'price',
        //     render: function (data, type, row, meta) {
        //         return '<p>' + currency(data).format() + '</p>'
        //     }
        // },

        {
            data: 'status_etapa',
            render: function (data, type, row, meta) {
                return data == null ? data = " " : '<p style="color: red; font-weight: bold;">' + data + '</p>'
            }
        },

        {
            data: "id_cot_pto",
            render: function (data, type, row, meta) {
                return '<button id="' + data + '" data-index ="' + row.id_status + '" class="btn btn-warning up solid pd-x-20"><i class="fa fa-pencil fa-lg mr-1" aria-hidden="true"></i> EDITAR</button>';
            }
        },


    ],
    responsive: true,
    "columnDefs": [
        {
            "targets": [0],
            "visible": false,
            "searchable": false
        }
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    },

    lengthMenu: [
        [25, 10, 50, 100, 999999],
        ["25", "10", "50", "100", "Mostrar todo"],
    ],

    //delete cotization 

});


$(document).on('click', '.up', function () {
    let id_p_cotizacion = $(this).attr('id');
    var id_status = $(this).data('index');

    if (id_status == null) {
        var id_status = "";
    }
    $('.empresas').val(id_status);
    $('#id_cot').val(id_p_cotizacion);
    $('#modaldemo2').modal('toggle');

});


$(document).on('submit', '#formUpdate', function () {
    // console.log("di un click");
    const formData = new FormData($(this)[0]);
    const url_srt = `${BASE_URL}Administrador/Etapas_Venta/changeStatus`;

    $.ajax({
        url: url_srt,
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

                $('#modaldemo2').modal('toggle');
                /* document.getElementById("formUpdate").reset(); */
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

                $('#modaldemo2').modal('toggle');
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
