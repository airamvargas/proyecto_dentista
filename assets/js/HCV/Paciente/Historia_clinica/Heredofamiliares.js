get_enfermedades();
$("#id_heredofamiliares").val(id_paciente);

var dataTableH = $("#crm_heredofamiliares").DataTable({
  ajax: {
    url: `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Heredofamiliares/read`,
    data: {id_paciente :  id_paciente},
    type: "post",
  },
  lengthMenu: [
    [10, 25, 50, 100, 999999],
    ["10", "25", "50", "100", "Mostrar todo"],
  ],
  searching: false,
  paging: false,
  columns: [      
    {
      data: "rama",
    },
    {
      data: "parentesco",
    },
    {
      data: "common_name",
    },
    {
      data: "id",
      render: function (data, type, row, meta) {
        return (
          '<div class="d-flex justify-content-center"><button type="button" id="' +
          row.id +
          '" data-toggle="modal" data-target="#modal_delete" class="btn btn btn-danger delete btn-circle btn-sm pd-x-20"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
        );
      },
    },
  ],
  language: {
    searchPlaceholder: "Buscar...",
    sSearch: "",
    lengthMenu: "_MENU_ Filas por página",
  }
});
$("#crm_heredofamiliares_info").remove();

//CREATE REGISTRO DE ENFERMEDAD A INSERTAR
$(document).on("submit", "#formCreateHeredofamiliares", function () { 
  $("#loader").toggle();
  var FORMDATA = new FormData();

  let rama = $('#rama').val();
  let parentesco = $('#parentesco').val();
  let enfermedad = $('#heredofam').val();

  FORMDATA.append('user_id', id_paciente);
  FORMDATA.append('rama', rama);
  FORMDATA.append('parentesco', parentesco);
  FORMDATA.append('enfermedad', enfermedad);

  const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Heredofamiliares/create`;

  $.ajax({
    url: URL,
    type: "POST",
    data: FORMDATA,
    dataType: "json",
    success: function (data) {
      //Si el estatus es 200 fue conpletado el proceso
      if (data.status == 200) {
        $("#loader").toggle();
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
        document.getElementById("formCreateHeredofamiliares").reset();
        reloadDataH();
      } else {
        $("#loader").toggle();
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

//GET ID ATTIBUTE BUTTON
$(document).on('click', '.delete', function () {
  let product = $(this).attr('id');
  $('#modal_delete').modal('toggle');
  $("#id_delete").val(product);
});

//ELIMINAR REGISTRO DE ENFERMEDAD DE LA TABLA
$(document).on('submit', '#delete_form', function () {
  $('#loader').toggle();
  $('#modal_delete').modal('toggle');
  const FORMDATA = new FormData($(this)[0]);
  const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Heredofamiliares/delete_`;
  $.ajax({
    url: URL,
    type: 'POST',
    data: FORMDATA,
    dataType: 'json',
    success: function (data) {
      if (data.status == 200) {
        $('#loader').toggle();
        //notification library
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
        reloadDataH();
      } else {
        $('#loader').toggle();
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
        $('#modal_delete').modal('toggle');
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
      avatar: BASE_URL +"../../assets/img/cancelar.png",
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

//RELOAD DATATABLE 
function reloadDataH() {
  $("#loader").toggle();
  dataTableH.ajax.reload();
  $("#loader").toggle();  
}

// SELECT CON EL CATALOGO DE ENFERMEDADES
function get_enfermedades() {
  const URL = `${BASE_URL}Api/Catalogos/Diseases/readHeredofam`;
  var enfermedades = $("#heredofam");
  $.ajax({
    url: URL,
    method: "GET",
    dataType: "json",
    success: function (data) {
    enfermedades.append(`<option value="">Selecciona</option>`);
      $(data).each(function (i, v) {
        enfermedades.append(
          `<option value="${v.id}"> ${v.common_name}</option>`
        );
      });
    },
    error: function (error) {
      alert("hubo un error al enviar los datos");
    },
  });
}
