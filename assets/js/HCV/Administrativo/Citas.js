
/* Desarrollador: Jesús Esteban Sánchez Alcántara
Fecha de creacion: 29-agosto-2023
Fecha de Ultima Actualizacion: 6-septiembre-2023 
Perfil: Administracion
Descripcion: Desde la parte administrativa se podrán visualizar todas las citas con su status en el que se encuentra cada cita para paciente y medico. La tabla se convirtio a server side*/

//FORMATO EN ESPAÑOL FECHA
moment.locale("es");

//TABLA GENERAL DE CITAS
var dataTable = $('#crm_citas').DataTable({    
    processing: true, 
    serverSide: true, 
    filter: true,
    locale: { format: 'DD-MM-YYYY' },
    lengthMenu: [
        [10, 25, 50, 999999],
        ['10 filas', '25 filas', '50 filas', 'Mostrar todo']
    ],    
    'ajax': {
        'url': `${BASE_URL}${CONTROLADOR}/readAppointment`,
        'data': {},
        'type':'post'
    },    
    columns: [
        { 
            data: 'id_cita',
            render: function(data, type, row, meta) {
                let tipo_consulta = parseFloat(`${row.id_consulta}`);
                switch(tipo_consulta){
                    case 1: // Medicina
                        return parseFloat(row.approved) == 3 ? `<a href="${BASE_URL}HCV/Paciente/Historial_registro/general/${row.id_cita}" target="_blank">${data}</a>` : `${data}`;
                    
                    case 2: //Psicologia
                        return parseFloat(row.approved) == 3 ? `<a href="${BASE_URL}HCV/Paciente/Historial_registro/nota_psicologia/${row.id_cita}" target="_blank">${data}</a>` : `${data}`;
                    
                    case 3: //Nutricion
                        return parseFloat(row.approved) == 3 ? `<a href="${BASE_URL}HCV/Paciente/Historial_registro/nota_nutricion/${row.id_cita}" target="_blank">${data}</a>` : `${data}`;
                    
                    case 4: //Odontologia
                        return parseFloat(row.approved) == 3 ? `<a href="${BASE_URL}HCV/Paciente/Historial_registro/nota_odontologia/${row.id_cita}" target="_blank">${data}</a>` : `${data}`;

                    default:
                        return data;
                }
            }   
        }, 
        { 
            data: 'id_cotizacion',
            render: function(data, type, row, meta) {
                return `<a  href="${BASE_URL}OrdenServicio/Pendientes/imprimir/${row.id_cotizacion}" target="_blank">${data}</a>` 
            }
        }, 
        { 
            data: 'fecha',
             render: function(data, type, row, meta) {
                return moment(data).format("DD-MM-YYYY");
            } 
        },
        { 
            data: 'hora',
            render: function(data, type, row, meta) {
                let hora = `${row.fecha} ${data}`
                return moment(hora).format('HH:mm');
            }
        },     
        { 
            data: 'status_name',
            render: function(data, type, row, meta) {
                let status = parseFloat(`${row.status_lab}`);
                switch(status){
                     case 200:
                        return `<h6 class="text-warning">${data}</h6>`;

                    case 203 :
                        return parseFloat(row.approved) == 3 ? `<h6 class="text-success">Consulta terminada</h6>` : `<h6 class="text-secondary">${data}</h6>`;

                    case 201:
                       return parseFloat(row.approved) == 3 ? false : `<h6 class="text-primary">${data}</h6>`;                    
                    
                     case 202 :
                         return `<h6 class="text-danger">${data}</h6>`;  
                }
            }  
        }, 
        { 
            data: 'paciente',
            render: function(data, type, row, meta) {
                return `<a  href="${BASE_URL}HCV/Administrativo/Ficha_Identificacion_Paciente/updatePaciente/${row.id_identity}" target="_blank">${data}</a>` 
            }
        },
        { 
            data: 'consultorio'
        },       
        { 
            data: 'tipo_consulta'
        }, 
        { 
            data: 'doctor',
            render: function(data, type, row, meta) {
                return `<a  href="${BASE_URL}HCV/Administrativo/Ficha_Identificacion_Operativo/updateOperativo/${row.id_operativo}" target="_blank">${data}</a>` 
            }
        },       
    ],
    ordering: true,
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    },    
}); 

//RELOAD datatable aceptadas
function reloadData() {
    $('#loader').toggle();
    dataTable.ajax.reload();
    $('#loader').toggle();
}
