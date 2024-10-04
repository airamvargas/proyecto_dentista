/* 
Fecha de Ultima Actualizacion: 28-agosto-2023
Perfil: Paciente
Descripcion: Perfil de inicio con las citas programadas */ 
let uname = `<h5 class="user-name">${user_name}</h5>`;
$("#user_name").append(uname);
if((imagen == null) || (imagen == "")){
    photo = `<img id="profile_image" src="${BASE_URL}../uploads/default.png" class="rounded-circle img-fluid mx-auto" style="width: 80%;">`;
    $("#photo-profile").append(photo);
} else {
    photo = `<img id="profile_image" src="${BASE_URL}../uploads/paciente/fotos/${imagen}" class="rounded-circle img-fluid mx-auto" style="width: 150px; height: 150px;">`;
    $("#photo-profile").append(photo);
}

//Datatable citas de pacientes
var dataTable = $('#crm_citas_paciente').DataTable({
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/readAppointmentPatient`,
        data: {},
        type: "post",
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
            data: 'tipo_consulta', 
            render: function(data, type, row, meta) {
                if(data == null){
                    return `Labotatorio`
                } else {
                    return data;
                }
            }
        },
        { 
            data: 'doctor',
            render: function(data, type, row, meta) {
                if(data == null){
                    return `Laboratorio`
                } else {
                    return data;
                }
            }
        },
        { 
            data: 'consultorio' 
        },
        { 
            data: 'status_name'
        }
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});
