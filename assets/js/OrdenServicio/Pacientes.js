/* Desarrollador: Airam v. Vargas
Fecha de creacion: 22 - 07 - 2024
Fecha de Ultima Actualizacion: 23 - 07 - 2024
Actulizo:
Perfil: Recepcionista
Descripcion: JS del listado de resultados de laboratorio por paciente */

//FORMATO EN ESPAÑOL FECHA
moment.locale("es");

/* TABLA DE CONVENIOS GENERAL CON TODAS LAS EMPRESAS*/
var dataTable = $('#crm_pacientes').DataTable({
    processing: true, 
    serverSide: true, 
    lengthMenu: [
        [10, 25, 50, 999999],
        ['10 filas', '25 filas', '50 filas', 'Mostrar todo']
    ],
    'ajax': {
        'url': `${BASE_URL}${CONTROLADOR}/read`,
        'data': {},
        'type':'post'
    },
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],
    columns: [        
        /*{
            data: 'foto',
            render: function (data, type, row, meta) {
                return (data == '') || (data == null) ? `<img style="width:70px; height: 70px;" class="img-fluid rounded-circle" src="${BASE_URL}../uploads/default.png" >` : `<img style="width:70px; height: 70px;" src="${BASE_URL}../uploads/paciente/fotos/` + data + ' " class="img-fluid rounded-circle" />'
            }
        },*/
        {
            data: 'nombre',
        }, 
        {
            data: 'BIRTHDATE',
            render: function(data, type, row, meta) {
                return moment(data).format("DD-MM-YYYY");
            }
        },       
        {
            data: 'SEX',
        }, 
        {
            data: 'correo',
        },       
        {       
            data: "numero",
            /*render: function (data, type, row, meta) {
                return '<div class="d-flex justify-content-center"><a href="'+BASE_URL+'HCV/Administrativo/Ficha_Identificacion_Paciente/updatePaciente/'+data+'"> <button id="' + data + '"" class="btn btn-warning up solid pd-x-20 btn-circle btn-sm mr-2" title="Editar paciente"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button></a>' +
                '<button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm mr-2" title="Eliminar paciente" data-toggle="modal" data-target="#modal_delete"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
            }*/
        }, 
    ],
    ordering: true,
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});