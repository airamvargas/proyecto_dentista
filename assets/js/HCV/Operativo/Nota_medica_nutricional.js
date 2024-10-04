//carpetas
function openCity(evt, cityName) {
  // Declare all variables
  var i, tabcontent, tablinks;
  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

document.getElementById("defaultOpen").click();

readPaciente();
readDiagnostico();
readProcedimientosNutricion();

//
$(".id_doctor").val(id_doctor);
$(".id_patient").val(id_paciente);
$(".id_folio").val(id_cita);

//BOTON PARA TERMINAR LA CITA
$(document).on("click", "#terminar", function () {
  $("#id_terminar").val(id_cita);
  $("#modal_terminar").modal("toggle");
});

//Terminar cita
$(document).on("submit", "#formTerminar", function () {
  $("#loader").toggle();
  const FORMDATA = new FormData($(this)[0]);
  const URL = `${BASE_URL}${CONTROLADOR}/terminarCita`;
  $.ajax({
    url: URL,
    type: "POST",
    data: FORMDATA,
    dataType: "json",
    success: function (data) {
      if (data.status == 200) {
        Toastify({
          text: data.msg,
          duration: 4000,
          className: "info",
          avatar: BASE_URL + "../../assets/img/correcto.png",
          style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
          },
          offset: {
            x: 50,
            y: 90,
          },
        }).showToast();
        $("#modal_terminar").modal("toggle");
        $("#loader").toggle();
        setTimeout(function () {
          location.href = `${BASE_URL}HCV/Operativo/Citas`;
        }, 7000);
      } else {
        Toastify({
          text: data.msg,
          duration: 3000,
          className: "info",
          avatar: BASE_URL + "../../assets/img/cancelar.png",
          style: {
            background: "linear-gradient(to right, #f90303, #fe5602)",
          },
          offset: {
            x: 50,
            y: 90,
          },
        }).showToast();
        $("#loader").toggle();
      }
    },
    cache: false,
    contentType: false,
    processData: false,
  }).fail(function (jqXHR, textStatus, errorThrown) {
    $("#loader").toggle();
    switch (jqXHR.status) {
      case 404:
        mensaje = "respuesta o pagina no encontrada";
        break;
      case 500:
        mensaje = "Error en el servidor";
        break;
      case 0:
        mensaje = "no conecta verifica la conexion";
        break;
    }
    Toastify({
      text: mensaje,
      duration: 3000,
      className: "info",
      avatar: BASE_URL + "../../assets/img/cancelar.png",
      style: {
        background: "linear-gradient(to right, #f90303, #fe5602)",
      },
      offset: {
        x: 50,
        y: 90,
      },
    }).showToast();
  });
  return false;
});

// Se obtienen los datos del paciente a mostrar en la nota medica
function readPaciente() {
  $("#loader").toggle();
  const URL = `${BASE_URL}Api/HCV/Operativo/Nota_medica_nutricion/readPaciente`;

  $.ajax({
    url: URL,
    method: "POST",
    data: { id_paciente: id_paciente },
    dataType: "json",
    success: function (data) {
      if (data["imagen"] == null || data['imagen'] == "") {
        let photo = `<img id="img-user" class="rounded-circle img-fluid" src="${BASE_URL}../uploads/default.png">`;
        $(".img-profile").append(photo);
      } else {
        let photo = `<img id="img-user" class="rounded-circle img-fluid" src="${BASE_URL}../uploads/paciente/fotos/${data["imagen"]}">`;
        $(".img-profile").append(photo);
      }
      let patientName = `<span>${data["nombre"]}</span>`;
      let patientAge = `<span>${data["edad"]} años</span>`;
      let patientSex = `<span>${data["genero"]}</span>`;
      let folio = `<span>${id_cita}</span>`;

      $("#folio").append(folio);
      $(".nombre").append(patientName);
      $(".edad").append(patientAge);
      $(".sexo").append(patientSex);
      $("#loader").toggle();
    },
    error: function (error) {
      alert("Hubo un error al enviar los datos");
    },
  });
}

// CALCULO DEL INDICE DE MASA CORPORAL (IMC) A TRAVES DE PESO Y TALLA
var total;
var imc;

$("#talla").keyup(function () {
  var peso = $("#peso").val();
  var talla = $("#talla").val() / 100;
  parseFloat(peso);
  parseFloat(talla);
  total = peso / Math.pow(talla, 2);
  imc = total.toFixed(1);
  $("#imc").val(imc);
});

$("#peso").keyup(function () {
  var peso = $("#peso").val();
  var talla = $("#talla").val() / 100;
  parseFloat(peso);
  parseFloat(talla);
  total = peso / Math.pow(talla, 2);
  imc = total.toFixed(1);
  $("#imc").val(imc);
});

/**************************************
 * PESTAÑA DE NUTRICION
 **************************************/
// GUARDA DATOS DE LA PESTAÑA DE NUTRICION DEL PACIENTE
$(document).on("submit", "#formCreateNutricion", function () {
  var form_data = new FormData($(this)[0]);
  const URL = `${BASE_URL}Api/HCV/Operativo/Nota_medica_nutricion/create`;

  $.ajax({
    url: URL,
    type: "POST",
    data: form_data,
    dataType: "json",
    success: function (data) {
      if (data.status == 200) {
        Toastify({
          text: data.msg,
          duration: 3000,
          className: "info",
          avatar: BASE_URL + "../../assets/img/correcto.png",
          style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
          },
          offset: {
            x: 50,
            y: 90,
          },
        }).showToast();
      } else {
        Toastify({
          text: data.msg,
          duration: 3000,
          className: "info",
          avatar: BASE_URL + "../../assets/img/cancelar.png",
          style: {
            background: "linear-gradient(to right, #f26504, #f90a24)",
          },
          offset: {
            x: 50,
            y: 90,
          },
        }).showToast();
      }
    },
    cache: false,
    contentType: false,
    processData: false,
  });
  return false;
});

// OBTENER LOS DATOS DE NOTA MEDICA DE NUTRICION DEL PACIENTE
getNotaNutricion();
function getNotaNutricion() {
  $("#loader").toggle();

  const URL = `${BASE_URL}${CONTROLADOR}/readNutricion`;
  $.ajax({
    url: URL,
    data: { id_cita: id_cita },
    method: "post",
    dataType: "json",
    success: function (data) {
      if (data != "") {
        $("#id").val(data[0].id);
        $("#nota_nutricion").val(data[0].nota);
        $("#cintura").val(data[0].cintura);
        $("#cadera").val(data[0].cadera);
        $("#pantorrilla").val(data[0].pantorrilla);
        $("#masa_muscular").val(data[0].masa_muscular);
        $("#grasa_corporal").val(data[0].grasa_corporal);
        $("#grasa_visceral").val(data[0].grasa_visceral);
        $("#agua_corporal").val(data[0].agua_corporal);
        $("#tasa_metabolica").val(data[0].tasa_metabolica);
        $("#edad_metabolica").val(data[0].edad_metabolica);
        $("#peso").val(data[0].peso);
        $("#talla").val(data[0].talla);
        $("#imc").val(data[0].imc);
      }
      $("#loader").toggle();
    },
    error: function (xhr, text_status) {
      $("#loader").toggle();
    },
  });
}

/*******************************************
 * PESTAÑA DE DIAGNOSTICO NUTRICIONAL
 *******************************************/
// Tabla con el diagnostico nutricional del paciente
var dataNutricional = $("#table_nutricional").DataTable({
  ajax: {
    url: `${BASE_URL}Api/HCV/Operativo/Nota_medica_nutricion/readNutricional`,
    data: { id_folio: id_cita },
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
      data: "tipo",
    },
    {
      data: "balance",
    },
    {
      data: "grasa",
    },
    {
      data: "ingesta",
    },
    {
      data: "id",
      render: function (data, type, row, meta) {
        return (
          '<div class="d-flex justify-content-center"><button type="button" id="' +
          row.id +
          '"class="ml-1 btn btn btn-danger delete-dig btn-circle btn-sm pd-x-20" title="Eliminar"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
        );
      },
    },
  ],
  language: {
    searchPlaceholder: "Buscar...",
    sSearch: "",
    lengthMenu: "_MENU_ Filas por página",
  },
});

/*RELOAD DATATABLE */
function reloadDataNut() {
  $("#loader").toggle();
  dataNutricional.ajax.reload();
  $("#loader").toggle();
}

function reloadData() {
  $("#loader").toggle();
  dataProcedimientos.ajax.reload();
  $("#loader").toggle();
}

//Select del catalogo de diagnosticos
function readDiagnostico() {
  const URL = `${BASE_URL}Api/HCV/Operativo/Nota_medica_nutricion/readDiagnostico`;

  var select = $("#select_diagnostico");
  $.ajax({
    url: URL,
    method: "GET",
    dataType: "json",
    success: function (data) {
      select.empty();
      select.append(`<option value="">Selecciona una opción</option>`);
      $(data).each(function (i, v) {
        select.append(`<option value="${v.id}"> ${v.name}</option>`);
      });
    },
    error: function (error) {
      alert("Hubo un error al enviar los datos");
    },
  });
}

// Select de ingesta a partir del diagnostico seleccionado
$("#select_diagnostico").on("click", function () {
  let value = $("#select_diagnostico option:selected").val();
  const URL = `${BASE_URL}Api/HCV/Operativo/Nota_medica_nutricion/readIngesta/${value}`;

  $.ajax({
    url: URL,
    type: "POST",
    dataType: "json",
    success: function (result) {
      console.log(result);
      $("#ingesta").remove();
      $("#label_ingesta").remove();
      $("#append_ingesta").append(
        '<p id="label_ingesta">Selecciona ingesta</p><select class="custom-select mr-sm-5" name="ingesta" id="ingesta" required><option value="">Selecciona una opción</option></select>'
      );
      for (let i = 0; i < result.length; i++) {
        $("#ingesta").append(
          "<option value=" + result[i].id + ">" + result[i].name + "</option>"
        );
      }
      get_cat_indice1();
    },
    error: function (xhr, resp, text) {
      console.log(xhr, resp, text);
      $("#loader").toggle();
      $("#error-alert").show();
      $("#error").text(" HA OCURRIDO UN ERROR INESPERADO");
    },
  });
});

// Catalogo basado a partir de la ingesta seleccionada
function get_cat_indice1() {
  $("#ingesta").on("click", function () {
    let value = $("#ingesta option:selected").val();
    const URL = `${BASE_URL}Api/HCV/Operativo/Nota_medica_nutricion/get_type_nutricional_indice1/${value}`;

    $.ajax({
      url: URL,
      type: "POST",
      dataType: "json",
      success: function (result) {
        console.log(result);
        $("#alimentacion").remove();
        $("#label_ingesta1").remove();
        $("#append_alimentacion").append(
          '<p id="label_ingesta1">Selecciona una opción</p><select class="custom-select mr-sm-5" name="alimentacion" id="alimentacion" required><option value="">Selecciona una opción</option></select>'
        );
        for (let i = 0; i < result.length; i++) {
          $("#alimentacion").append(
            "<option value=" + result[i].id + ">" + result[i].name + "</option>"
          );
        }
        get_indice2();
      },
      error: function (xhr, resp, text) {
        console.log(xhr, resp, text);
        $("#loader").toggle();
        $("#error-alert").show();
        $("#error").text(" HA OCURRIDO UN ERROR INESPERADO");
      },
    });
  });
}

// Catalogo basado a partir del indice1 seleccionado
function get_indice2() {
  $("#alimentacion").on("click", function () {
    let value = $("#alimentacion option:selected").val();
    const URL = `${BASE_URL}Api/HCV/Operativo/Nota_medica_nutricion/get_type_nutricional_indice2/${value}`;

    $.ajax({
      url: URL,
      type: "POST",
      dataType: "json",
      success: function (result) {
        console.log(result);
        if (result == 0) {
          $("#ingestas").remove();
          $("#label_ingesta2").remove();
        } else {
          $("#ingestas").remove();
          $("#label_ingesta2").remove();
          $("#append_indice2").append(
            '<p id="label_ingesta2">Selecciona una opción</p><select class="custom-select mr-sm-5" name="ingestas" id="ingestas"></select>'
          );
          for (let i = 0; i < result.length; i++) {
            $("#ingestas").append(
              "<option value=" +
                result[i].id +
                ">" +
                result[i].name +
                "</option>"
            );
          }
        }
      },
      error: function (xhr, resp, text) {
        console.log(xhr, resp, text);
        $("#loader").toggle();
        $("#error-alert").show();
        $("#error").text(" HA OCURRIDO UN ERROR INESPERADO");
      },
    });
  });
}

/**************************************
 * PESTAÑA DE EVIDENCIAS
 **************************************/
// GUARDA DATOS DE LA PESTAÑA DE DIAGNOSTICO NUTRICIONAL 
$(document).on("submit", "#formCreateDiagnostico", function () {
  $('#loader').toggle();
  var form_data = new FormData($(this)[0]);
  const URL = `${BASE_URL}Api/HCV/Operativo/Nota_medica_nutricion/createDiagnostico`;

  $.ajax({
    url: URL,
    type: "POST",
    data: form_data,
    dataType: "json",
    success: function (data) {
      if (data.status == 200) {
        Toastify({
          text: data.msg,
          duration: 3000,
          className: "info",
          avatar: BASE_URL + "../../assets/img/correcto.png",
          style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
          },
          offset: {
            x: 50,
            y: 90,
          },
        }).showToast();
        $('#loader').toggle();
        document.getElementById("formCreateDiagnostico").reset();
       reloadDataNut();
      } else {
        Toastify({
          text: data.msg,
          duration: 3000,
          className: "info",
          avatar: BASE_URL + "../../assets/img/cancelar.png",
          style: {
            background: "linear-gradient(to right, #f26504, #f90a24)",
          },
          offset: {
            x: 50,
            y: 90,
          },
        }).showToast();
      }
    },
    cache: false,
    contentType: false,
    processData: false,
  });
  return false;
});

//Obtener id de evidencia para eliminar
$(document).on("click", ".delete-dig", function () {
  let id_evidencia = $(this).attr("id");
  $("#id_delete").val(id_evidencia);
  $("#modal_delete_diag").modal("toggle");
});

//Eliminar un diagnostico
$(document).on("submit", "#formDelDiagnostico", function () {
  $("#loader").toggle();

  const FORMDATA = new FormData($(this)[0]);
  const URL = `${BASE_URL}Api/HCV/Operativo/Nota_medica_nutricion/delete_`;
  $.ajax({
    url: URL,
    type: "POST",
    data: FORMDATA,
    dataType: "json",
    success: function (data) {
      if (data.status == 200) {
        Toastify({
          text: data.msg,
          duration: 3000,
          className: "info",
          avatar: BASE_URL + "../../assets/img/correcto.png",
          style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
          },
          offset: {
            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
            y: 90, // vertical axis - can be a number or a string indicating unity. eg: '2em'
          },
        }).showToast();
        $("#modal_delete_diag").modal("toggle");
        reloadDataNut();
        $("#loader").toggle();
      } else {
        Toastify({
          text: data.msg,
          duration: 3000,
          className: "info",
          avatar: BASE_URL + "../../assets/img/cancelar.png",
          style: {
            background: "linear-gradient(to right, #f90303, #fe5602)",
          },
          offset: {
            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
            y: 90, // vertical axis - can be a number or a string indicating unity. eg: '2em'
          },
        }).showToast();
        $("#loader").toggle();
      }
    },
    cache: false,
    contentType: false,
    processData: false,
  }).fail(function (jqXHR, textStatus, errorThrown) {
    $("#loader").toggle();
    switch (jqXHR.status) {
      case 404:
        mensaje = "respuesta o pagina no encontrada";
        break;
      case 500:
        mensaje = "Error en el servidor";
        break;
      case 0:
        mensaje = "no conecta verifica la conexion";
        break;
    }
    Toastify({
      text: mensaje,
      duration: 3000,
      className: "info",
      avatar: BASE_URL + "../../assets/img/cancelar.png",
      style: {
        background: "linear-gradient(to right, #f90303, #fe5602)",
      },
      offset: {
        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
        y: 90, // vertical axis - can be a number or a string indicating unity. eg: '2em'
      },
    }).showToast();
  });
  return false;
});


/**************************************
 * PESTAÑA DE PROCEDIMIENTOS
 **************************************/
// Tabla con los procedimientos de nutricion hechos al paciente
var dataProcedimientos = $("#tb_procedimientos").DataTable({
  ajax: {
    url: `${BASE_URL}Api/HCV/Operativo/Nota_medica_nutricion/showProcedimientos`,
    data: {id_folio: id_cita },
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
      data: "name_procedimiento",
    }, 
    {
      data: "id",
      render: function (data, type, row, meta) {
        return (
          '<div class="d-flex justify-content-center"><button type="button" id="' +
          row.id +
          '"class="ml-1 btn btn btn-danger proce-del btn-circle btn-sm pd-x-20" title="Eliminar"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
        );
      },
    }, 
  ],
  language: {
    searchPlaceholder: "Buscar...",
    sSearch: "",
    lengthMenu: "_MENU_ Filas por página",
  },
});


function readProcedimientosNutricion() {
  $('#loader').toggle();
  const URL = `${BASE_URL}Api/Catalogos/Tipo_Procedimientos/getProdimientos`;
  var select = $("#procedimientos-nutricion");
  $.ajax({
      url: URL,
      method: 'GET',
      dataType: 'json',
      success: function (data) {
          select.empty();
          select.append(`<option value="">Selecciona una opción</option>`);
          $(data).each(function (i, v) {
              select.append(`<option value="${v.id}"> ${v.commun_name}</option>`);
          });
          $('#loader').toggle();
      },
      error: function (error) {
          alert('Hubo un error al enviar los datos');
      }
  });
}

// Funcion para guardar el nombre del select de catalogo de areas
/* $(document).on('change', '#id_procedimiento', function(){
  let name_specialty = $("#id_procedimiento").children("option:selected").data("index");
  $("#id_name_speciality").val(name_specialty);
});
 */
/* function readProcedimientosPsico() {
  $('#loader').toggle();
  const URL = `${BASE_URL}Api/Catalogos/Tipo_Procedimientos/readProcedimientosPsico`;
  var select = $("#select-procedimientos");
  $.ajax({
      url: URL,
      method: 'GET',
      dataType: 'json',
      success: function (data) {
          select.empty();
          select.append(`<option value="">Selecciona</option>`);
          $(data).each(function (i, v) {
              select.append(`<option value="${v.id}"> ${v.commun_name}</option>`);
          });
          $('#loader').toggle();
      },
      error: function (error) {
          alert('Hubo un error al enviar los datos');
      }
  });
} */

$(document).on('submit', '#form-procedimientos', function () {
  $('#loader').toggle();
  const FORMDATA = new FormData($(this)[0]);
  const URL = `${BASE_URL}Api/HCV/Operativo/Nota_medica_nutricion/createProcedimiento`;
  $.ajax({
    url: URL,
    type: 'POST',
    data: FORMDATA,
    dataType: 'json',
    success: function (data) {
      if (data.status == 200) {
        Toastify({
          text: data.msg,
          duration: 3000,
          className: "info",
          avatar: BASE_URL + "../../assets/img/correcto.png",
          style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
          },
          offset: {
            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
          },
        }).showToast();
        reloadData();
        $('#loader').toggle();
      } else {
        Toastify({
          text: data.msg,
          duration: 3000,
          className: "info",
          avatar: BASE_URL + "../../assets/img/cancelar.png",
          style: {
            background: "linear-gradient(to right, #f90303, #fe5602)",
          },
          offset: {
            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
          },
        }).showToast();
        $('#loader').toggle();
      }
    },
    cache: false,
    contentType: false,
    processData: false
  }).fail(function (jqXHR, textStatus, errorThrown) {
    $('#loader').toggle();
    switch (jqXHR.status) {
      case 404:
        mensaje = "respuesta o pagina no encontrada";
        break;
      case 500:
        mensaje = "Error en el servidor";
        break;
      case 0:
        mensaje = "no conecta verifica la conexion";
        break;
    }
    Toastify({
      text: mensaje,
      duration: 3000,
      className: "info",
      avatar: BASE_URL + "../../assets/img/cancelar.png",
      style: {
        background: "linear-gradient(to right, #f90303, #fe5602)",
      },
      offset: {
        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
      },
    }).showToast();
  });
  return false;
});

//ELIMINAR PROCEDIMIENTOS
$(document).on('click', '.proce-del', function(){
  let id = $(this).attr('id');
  $("#id_delete_proc").val(id);
  $("#modal_delete_procedimientos").modal('toggle');
});

$(document).on('submit', '#formDelProcedimientos', function () {
  $('#loader').toggle();
  $("#modal_delete_procedimientos").modal('toggle');
  const FORMDATA = new FormData($(this)[0]);
  const URL = `${BASE_URL}Api/HCV/Operativo/Nota_medica_nutricion/deleteProcedimiento`;
  $.ajax({
      url: URL,
      type: 'POST',
      data: FORMDATA,
      dataType: 'json',
      success: function (data) {
          if (data.status == 200) {
              Toastify({
                  text: data.msg,
                  duration: 3000,
                  className: "info",
                  avatar: BASE_URL + "../../assets/img/correcto.png",
                  style: {
                      background: "linear-gradient(to right, #00b09b, #96c93d)",
                  },
                  offset: {
                      x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                      y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                  },
              }).showToast();
              reloadData();
              $('#loader').toggle();
          } else {
              Toastify({
                  text: data.msg,
                  duration: 3000,
                  className: "info",
                  avatar: BASE_URL + "../../assets/img/cancelar.png",
                  style: {
                      background: "linear-gradient(to right, #f90303, #fe5602)",
                  },
                  offset: {
                      x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                      y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                  },
              }).showToast();
              $('#loader').toggle();
          }
      },
      cache: false,
      contentType: false,
      processData: false
  }).fail(function (jqXHR, textStatus, errorThrown) {
      $('#loader').toggle();
      switch (jqXHR.status) {
          case 404:
              mensaje = "respuesta o pagina no encontrada";
              break;
          case 500:
              mensaje = "Error en el servidor";
              break;
          case 0:
              mensaje = "no conecta verifica la conexion";
              break;
      }
      Toastify({
          text: mensaje,
          duration: 3000,
          className: "info",
          avatar: BASE_URL + "../../assets/img/cancelar.png",
          style: {
              background: "linear-gradient(to right, #f90303, #fe5602)",
          },
          offset: {
              x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
              y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
          },
      }).showToast();
  });
  return false;
});