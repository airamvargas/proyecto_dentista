readPaciente();

//TABLA CITAS ACEPTADAS
var dataTableHistorial = $('#crm_historial_citas').DataTable({
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/show`,
        data: {id_paciente : id_paciente},
        type:'post'
    },

    columns: [
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
                return moment(hora).format('HH:mm') + ' hrs';
            }
        },
        { 
            data: 'doctor'
        },
        
        { 
            data: 'id_cita',
            render: function(data, type, row, meta) {
                return `<div class="d-flex justify-content-center"><a href="${BASE_URL}HCV/Operativo/Historial_citas/nota_medica/${row.id_cita}"><button title="Ver nota médica" class="btn btn-primary solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></button></a></div>`;
            }
        },
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
}); 

function readPaciente() {
    $('#loader').toggle();
    const URL = `${BASE_URL}Api/HCV/Operativo/Nota_medica/readPaciente`;

    $.ajax({
        url: URL,
        method: 'POST',
        data: {id_paciente: id_paciente},
        dataType: 'json',
        success: function (data) {
            let namePaciente = `<span>Paciente: ${data['nombre']}</span>`;
            $("#nombre_paciente").append(namePaciente);
            $('#loader').toggle();
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
}