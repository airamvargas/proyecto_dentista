//Llenado de la base de datos 
var dataTable = $('#datatable1').DataTable({
    ajax: BASE_URL + 'Administrativo/rest_pacientes' ,
    "order": [
        [4, "desc"]
    ],
    columns: [
        {
            data: "ID_USER",
            render: function(data, type, row, meta) {
                return '<a href="'+ BASE_URL +'/administrativo/pacientes/detalle_paciente/'+ data +'" ><button id="' + row.id + '"" class="btn btn btn-primary btncolor pd-x-20">VER</button></a>'
            }
        },
        {
            data: 'ID'
        },
        {
            data: 'NAME'
        },
        {
            data: 'ID_CAT_MUNICIPALITY'
        },
        {
            data: 'verified'
        },
        {
            data: 'verified'
        },
        {
            data: 'verified'
        },
        {
            data: 'verified'
        },{     
            data: "ID",
            render: function(data, type, row, meta) {
                return '<button id="' + row.id + '"" class="btn btn btn-primary btncolor pd-x-20">+</button>'
            }
        }
    ],
    responsive: true,
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});