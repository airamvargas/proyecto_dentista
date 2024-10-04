
getNotaNutricion();
readPaciente();

// Tabla con el diagnostico nutricional del paciente
var dataNutricional = $('#table_nutricional').DataTable({
  ajax: {
    url: `${BASE_URL}Api/HCV/Operativo/Nota_medica_nutricion/readNutricional`,
    data: {id_folio : id_cita},
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
      data: 'tipo'
    },
    {
      data: 'balance'
    },
    {
      data: 'grasa'
    },
    {
      data: 'ingesta'
    },
  ],
  language: {
    searchPlaceholder: 'Buscar...',
    sSearch: '',
    lengthMenu: 'MENU Filas por página',
  }
});

// OBTENER LOS DATOS DE NOTA MEDICA DE NUTRICION DEL PACIENTE
function getNotaNutricion() {
  $('#loader').toggle();

  const URL = `${BASE_URL}Api/HCV/Operativo/Nota_medica_nutricion/readNutricion`;
  $.ajax({
    url: URL,
    data: { id_cita: id_cita },
    method: "post",
    dataType: "json",
    success: function (success) {
      $("#id_user").val(success[0].patient_id);
      $("#nota_nutricion").val(success[0].nota);
      $("#cintura").val(success[0].cintura);
      $("#cadera").val(success[0].cadera);
      $("#pantorrilla").val(success[0].pantorrilla);
      $("#masa_muscular").val(success[0].masa_muscular);
      $("#grasa_corporal").val(success[0].grasa_corporal);
      $("#grasa_visceral").val(success[0].grasa_visceral);
      $("#agua_corporal").val(success[0].agua_corporal);
      $("#tasa_metabolica").val(success[0].tasa_metabolica);
      $("#edad_metabolica").val(success[0].edad_metabolica);
      $("#peso").val(success[0].peso);
      $("#talla").val(success[0].talla);
      $("#imc").val(success[0].imc);
      
      $('#loader').toggle();
    },
    error: function (xhr, text_status) {
      $("#loader").toggle();
    },
  });
}

//Obtener datos del paciente
function readPaciente() {
  $('#loader').toggle();
  const URL = `${BASE_URL}Api/HCV/Operativo/Nota_medica_nutricion/readPaciente`;

  $.ajax({
    url: URL,
    method: 'POST',
    data: {id_paciente: id_paciente},
    dataType: 'json',
    success: function (data) {
      if(data['imagen'] == null){
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