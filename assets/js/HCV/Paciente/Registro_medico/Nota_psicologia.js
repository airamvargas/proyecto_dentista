readPaciente();
readNota();

//Obtener datos del paciente
function readPaciente() {
  $("#loader").toggle();
  const URL = `${BASE_URL}Api/HCV/Operativo/Nota_medica/readPaciente`;

  $.ajax({
    url: URL,
    method: "POST",
    data: { id_paciente: id_paciente },
    dataType: "json",
    success: function (data) {
      if ((data["imagen"] == null) || (data["imagen"] == "")) {
        let photo = `<img id="img-user" class="rounded-circle img-fluid" src="${BASE_URL}../uploads/default.png">`;
        $(".img-profile").append(photo);
      } else {
        let photo = `<img id="img-user" class="rounded-circle img-fluid" src="${BASE_URL}../uploads/paciente/fotos/${data["imagen"]}">`;
        $(".img-profile").append(photo);
      }
      let namePaciente = `<span>${data["nombre"]}</span>`;
      let edadPaciente = `<span>${data["edad"]}</span>`;
      let sexoPaciente = `<span>${data["genero"]}</span>`;
      let folio = `<span>${id_cita}</span>`;

      $("#folio").append(folio);
      $(".nombre").append(namePaciente);
      $(".edad").append(edadPaciente);
      $(".sexo").append(sexoPaciente);
      $("#loader").toggle();
    },
    error: function (error) {
      alert("Hubo un error al enviar los datos");
    },
  });
}

//Obtener datos del paciente
function readNota() {
  $("#loader").toggle();
  const URL = `${BASE_URL}Api/HCV/Operativo/Nota_medica/readNota`;

  $.ajax({
    url: URL,
    method: "POST",
    data: { id_cita: id_cita },
    dataType: "json",
    success: function (data) {
      if (data != "") {
        $("#nota_psic").val(data[0]["nota"]);
        $("#metodo_tecnica").val(data[0]["tecnica"]);
        $("#tipo_aborddaje").val(data[0]["tipo_abordaje"]);
        $("#edo_emocional").val(data[0]["estado_emocional"]);
        $("#objetivo").val(data[0]["objectivo_consulta"]);
      }

      $("#loader").toggle();
    },
    error: function (error) {
      alert("Hubo un error al enviar los datos");
    },
  });
}

var dataProcedimientos = $("#crm_procedimientos").DataTable({
  ajax: {
    url: `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Perpatologicos/showCirugias`,
    data: { id_paciente: id_paciente },
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
      data: "name",
    },
  ],
  language: {
    searchPlaceholder: "Buscar...",
    sSearch: "",
    lengthMenu: "_MENU_ Filas por página",
  },
});
$("#crm_procedimientos_info").remove();
