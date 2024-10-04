//NOTAS PRIMERA VEZ //
$(document).on('click', '#tab-nota', function () {
    $('#loader').toggle();
   notas1vez();
});



function notas1vez() {
    const url = BASE_URL + "/Api/HCV/Pacientes/Historia_clinica/Primera_nota/index/"+id_paciente;
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#primeravez').children().remove();
            $('#note-general').children().remove();
            if(Object.keys(data).length > 0){
                $("#primeravez").append( '<p class="ml-3"><b>Nombre del médico:</b>&nbsp '+data.fullname+'</p>');
                $("#primeravez").append( '<p class="ml-3"><b>Fecha:</b>&nbsp '+data.fecha+'</p>');
                $("#note-general").append( '<p class="ml-3 text-justify">'+data.nota+'</p>');
            }else{
                $("#note-general").append('<h1 class="mt-6 text-center">SIN DATOS </h1>');
            }
            $('#loader').toggle();
        },
        error: function(error) {
            alert('hubo un error al enviar los datos');
        }
    });

}

//TABLA DIAGNOSTICO//
let datanota = $('#diag-nota').DataTable({
    'ajax': {
        'url': BASE_URL + '/Administrativo/Rest_Notas',
        'data': {
            'id_paciente': id_paciente
        },
        'type': 'post',

    },
    columns: [{
            data: "enfermedad"
        },
        {
            data: 'fecha'
        },
    ],
    "bPaginate": false,
    "searching": false,
});