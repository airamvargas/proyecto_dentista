var dataTable = $('#datatable1').DataTable({
    ajax: BASE_URL + 'Administrativo/Rest_operativos',
    columns: [{
            data: 'id',
            render: function(data, type, row, meta) {
                return `<a href="` + BASE_URL + `Administrativo/operativo/detalle/` + data + `" class="btn btn-primary btn-border pd-x-20"><i class="fa fa-address-card-o "></i></a>`
            }
        },
        //{ data: 'date_time' },
        {
            data: "full_name",
            render: function(data, type, row, meta) {
                return data
            }
        },
        {
            data: "DISCIPLINE",
            render: function(data, type, row, meta) {
                return data
            }
        },
        { data: 'servicios_relaizados' },
        { data: 'notas_pendientes' },
        { data: 'visitas_pagar' },


    ],
    initComplete: function(settings, json) {
        $('.btn_update').on('click', function() {
            //alert("Hola mundo");
            let url = BASE_URL + 'Administrativo/operativo/get_ajax_operativo';
            let id = $(this).attr('id');
            let cp = { id: id }
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: cp,
                success: function(response) {
                    console.log(response);
                    $('#txt_name').val(response[0].NAME);
                    $('#txt_apellido_m').val(response[0].S_LAST_NAME);
                    $('#txt_apellido_p').val(response[0].F_LAST_NAME);
                    $('#id_user').val(response[0].ID_USER);
                    $('#select_profesion option[value=' + response[0].DISCIPLINE + ']').attr('selected', true);
                    $('#modal_update').modal('show');

                }
            });
        })
    },
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});