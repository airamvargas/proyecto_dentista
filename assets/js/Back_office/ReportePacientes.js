/* Desarrollador: Airam V. Vargas López
Fecha de creacion: 22 de noviembre de 2023
Fecha de Ultima Actualizacion:
Perfil: Back Office
Descripcion: JS detalles de las consultas y estudios que se ha realizado el paciente */ 


/*TABLA DE PRODUCTOS COTIZADOS*/
var dataTable = $('#crm_estudios').DataTable({
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/productosPaciente`,
        data: { 'id_usuario': id_usuario},
        type: "post",
    },
    
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],

    columns: [
        {
            data: 'producto',

        },
        {
            data: 'fecha',
            render: function (data, type, row, meta) {
                if(data == null){
                    return moment(row.created_at).format("DD-MM-YYYY");
                } else {
                    return data;
                }
            }
        },
        {
            data: 'medico'
        },
        {
            data: 'price'
        },
        {
            data: 'approved',
            render: function (data, type, row, meta) {
                if(data == null){
                    return row.estatus;
                } else {
                    switch(data){
                        case "0":
                            return row.estatus;
                        case "1":
                            return 'Consulta aceptada';
                        case "2":
                            return 'Consulta cancelada';
                        case "3":
                            return 'Consulta terminada';
                    }
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
