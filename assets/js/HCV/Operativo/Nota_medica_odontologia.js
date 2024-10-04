readPaciente();
readOdontologia();
$("#id_pat").val(id_paciente);
$("#id_fol").val(id_cita);
$("#id_med").val(id_doctor);

$(document).on('click', '#procedimientos', function(){
  readProcedimientosOdonto();
  $(".id_cita").val(id_cita);
});

//BOTON PARA TERMINAR LA CITA
$(document).on('click', '#terminar', function(){
  $('#id_terminar').val(id_cita);
  $("#modal_terminar").modal('toggle');
});

//Terminar cita
$(document).on('submit','#formTerminar', function(){
  $('#loader').toggle();
  const FORMDATA = new FormData($(this)[0]);
  const URL = `${BASE_URL}${CONTROLADOR}/terminarCita`;
  $.ajax({
    url: URL,
    type: 'POST',
    data: FORMDATA,
    dataType: 'json',
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
              x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
              y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
          }).showToast();
          $("#modal_terminar").modal('toggle');
          //$('#loader').toggle();
          setTimeout(function(){
            location.href = `${BASE_URL}HCV/Operativo/Citas`;
          }, 3000);
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

//ENVIAR FORMULARIO DE CITA ODONTOLOGICA
$(document).on('submit', '#formOdontologia', function () {
  $('#loader').toggle();
  const FORMDATA = new FormData($(this)[0]);
  const URL = `${BASE_URL}${CONTROLADOR}/create`;
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

$(document).on('submit', '#form-procedimientos', function () {
  $('#loader').toggle();
  const FORMDATA = new FormData($(this)[0]);
  const URL = `${BASE_URL}Api/HCV/Operativo/Nota_medica/createProcedimiento`;
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
        document.getElementById('select-procedimientos').value = "";
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

var dataProcedimientos = $('#crm_procedimientos').DataTable({
  ajax: {
    url: `${BASE_URL}Api/HCV/Operativo/Nota_medica/showProcedimientos`,
    data: {id_cita : id_cita},
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
      data: 'name_procedimiento'
    },
    {
      data: "id",
      render: function(data, type, row, meta) {
        return '<div class="d-flex justify-content-center"><button type="button" id="' + row.id + '"class="ml-1 btn btn btn-danger proce-del btn-circle btn-sm pd-x-20" title="Eliminar procedimiento"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
      }
    },
  ],
  language: {
    searchPlaceholder: 'Buscar...',
    sSearch: '',
    lengthMenu: '_MENU_ Filas por página',
  }
});
$("#crm_procedimientos_info").remove();

//ELIMINAR PROCEDIMIENTOS
$(document).on('click', '.proce-del', function(){
  let id = $(this).attr('id');
  $("#input_cirugias").val(id);
  $("#modal_delete_cirugias").modal('toggle');
});

$(document).on('submit', '#delete_form_cirugias', function () {
  $('#loader').toggle();
  $("#modal_delete_cirugias").modal('toggle');
  const FORMDATA = new FormData($(this)[0]);
  const URL = `${BASE_URL}Api/HCV/Operativo/Nota_medica/deleteProcedimiento`;
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
      if ((data["imagen"] == null) || (data["imagen"] == "")){
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

// Catalogo de procedimientos de odontologia
function readProcedimientosOdonto() {
  $('#loader').toggle();
  const URL = `${BASE_URL}Api/Catalogos/Tipo_Procedimientos/getProdimientos`;
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
} 

203

//RELOAD datatable aceptadas
function reloadData() {
  $('#loader').toggle();
  dataProcedimientos.ajax.reload();
  $('#loader').toggle();
}

