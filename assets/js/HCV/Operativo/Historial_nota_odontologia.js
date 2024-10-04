readPaciente();
readOdontologia();

var dataProcedimientos = $('#crm_procedimientos').DataTable({
    ajax: {
      url: `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perpatologicos/showCirugias`,
      data: {id_paciente : id_paciente},
      type: "POST",
    },
    lengthMenu: [
      [10, 25, 50, 100, 999999],
      ["10", "25", "50", "100", "Mostrar todo"],
    ],
    searching: false,
    paging: false,
    columns: [        
      {
        data: 'name'
      },
    ],
    language: {
      searchPlaceholder: 'Buscar...',
      sSearch: '',
      lengthMenu: '_MENU_ Filas por página',
    }
});
$("#crm_procedimientos_info").remove();

//Obtener datos del paciente
function readPaciente() {
    $('#loader').toggle();
    const URL = `${BASE_URL}Api/HCV/Operativo/Nota_medica/readPaciente`;

    $.ajax({
        url: URL,
        method: 'POST',
        data: {id_paciente: id_paciente},
        dataType: 'json',
        success: function (data) {
            if((data["imagen"] == null) || (data["imagen"] == "")){
                let photo = `<img id="img-user" class="rounded-circle img-fluid" src="${BASE_URL}../uploads/default.png">`;
                $(".img-profile").append(photo);
            } else {
                let photo = `<img id="img-user" class="rounded-circle img-fluid" src="${BASE_URL}../uploads/paciente/fotos/${data['imagen']}">`;
                $(".img-profile").append(photo);
            }
            let namePaciente = `<span>${data['nombre']}</span>`;
            let edadPaciente = `<span>${data['edad']}</span>`;
            let sexoPaciente = `<span>${data['genero']}</span>`;
            let folio = `<span>${id_cita}</span>`;

            $("#folio").append(folio);
            $(".nombre").append(namePaciente);
            $(".edad").append(edadPaciente);
            $(".sexo").append(sexoPaciente);
            $('#loader').toggle();
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
}

//Obtener datos de la cita
function readOdontologia() {
    $('#loader').toggle();
    const URL = `${BASE_URL}${CONTROLADOR}/show`;
  
    $.ajax({
        url: URL,
        method: 'POST',
        data: {id_cita: id_cita},
        dataType: 'json',
        success: function (data) {
            if(data != ""){
                $("#marcha").val(data[0]['marcha']);
                $("#mov_anormales").val(data[0]['mov_anormales']);
                $("#facies").val(data[0]['facies']);
                $("#complexion").val(data[0]['complexion']);
                $("#posicion").val(data[0]['posicion']);
                $("#personal").val(data[0]['cuidado_personal']);
                $("#cara").val(data[0]['cara']);
                $("#craneo").val(data[0]['craneo']);
                $("#cuello").val(data[0]['cuello']);
                $("#nariz").val(data[0]['nariz']);
                $("#oidos").val(data[0]['oidos']);
                $("#ojos").val(data[0]['ojos']);
                $("#lesiones").val(data[0]['lesion']);
                $("#localizacion").val(data[0]['localizacion']);
                $("#forma").val(data[0]['forma']);
                $("#color").val(data[0]['color']);
                $("#superficie").val(data[0]['superficie']);
                $("#bordes").val(data[0]['bordes']);
                $("#consistencia").val(data[0]['consistencia']);
                $("#base").val(data[0]['base']);
                $("#tiempo_evol").val(data[0]['tiempo_evolucion']);
                $("#cepillado").val(data[0]['cepillado']);
                $("#hilo_dental").val(data[0]['hilo_dental']);
                $("#enjuague").val(data[0]['enjuague']);
                $("#succion").val(data[0]['succion']);
                $("#deglucion").val(data[0]['deglucion_atipica']);
                $("#respirador").val(data[0]['respirador_bucal']);
                $("#alteraciones").val(data[0]['alteraciones']);
                $("#dolor").val(data[0]['dolor']);
                $("#dificultad").val(data[0]['dificultad_incapacidad']);
                $("#ruidos").val(data[0]['ruidos']);
                $("#desviacion").val(data[0]['desviacion']);
                $("#edema").val(data[0]['edema']);
            }
            $('#loader').toggle();
        },
        error: function (error) {
            alert('Hubo un error al enviar los datos');
        }
    });
}