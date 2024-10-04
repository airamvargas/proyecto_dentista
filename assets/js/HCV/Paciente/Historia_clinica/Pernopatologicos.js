$(document).ready(function () {
  document.getElementById("PerNoPatologicos").click();
});

$("#tab_no_pat").on("click", function () {
  $("#id_nopatologicos").val(id_paciente);
  reloadDataAnimales();
  reloadDataServicios();
  get_nopat();
  sendFormDel_Animales();
  sendFormDel_Servicios();
});

//DATOS NO PATOLOGICOS - GUARDAR
$(document).on('submit', '#formCreateNoPatologicos', function () {
  $('#loader').toggle();
  var FORMDATA = new FormData();

  let talla = $('#talla').val();
  let peso = $('#peso').val();
  let tatuaje = $('#tatuaje').val();
  let piercing = $('#perfo').val();
  let tuberculosis = $('#tuber').val();
  let humo = $('#humo').val();
  let casa = $('#estatus-casa').val();

  FORMDATA.append("talla", talla);
  FORMDATA.append("peso", peso);
  FORMDATA.append("tatuajes", tatuaje);
  FORMDATA.append('piercing', piercing);
  FORMDATA.append('tuberculosis', tuberculosis);
  FORMDATA.append('humo_lena', humo);
  FORMDATA.append('casa_propia', casa);
  FORMDATA.append('user_id', id_paciente)

  const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Pernopatologicos/create`

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

/* TABLA DE ANIMALES QUE TIENE EL PACIENTE*/
var dataAnimales = $('#pat_animales').DataTable({
  ajax: {
    url: `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Pernopatologicos/readAnimals`,
    data: {id_paciente : id_paciente},
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
      data: 'name'
    },
    {
      data: "id",
      render: function(data, type, row, meta) {
        return '<div class="d-flex justify-content-center"><button type="button" id="' + row.id +
        '" data-toggle="modal" data-target="#modal_delete_animales" class="ml-1 btn btn btn-danger anim btn-circle btn-sm pd-x-20" title="Eliminar animal"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
      }
    },
  ],
  language: {
    searchPlaceholder: 'Buscar...',
    sSearch: '',
    lengthMenu: '_MENU_ Filas por página',
  }
});
$("#pat_animales_info").remove();

/* TABLA DE SERVICIOS CON LOS QUE CUENTA EL PACIENTE*/
var dataServicios = $('#pat_servicios').DataTable({
  ajax: {
    url: `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Pernopatologicos/readServices`,
    data: {id_paciente : id_paciente},
    type: "post",
  },
  searching: false,
  paging: false,
  lengthMenu: [
    [10, 25, 50, 100, 999999],
    ["10", "25", "50", "100", "Mostrar todo"],
  ],
  columns: [        
    {
      data: 'servicio'
    },
    {
        data: "id",
        render: function(data, type, row, meta) {
          return '<div class="d-flex justify-content-center"><button type="button" id="' + row.id +
          '" data-toggle="modal" data-target="#modal_delete_servicios" class="ml-1 btn btn btn-danger del-servicios btn-circle btn-sm pd-x-20" title="Eliminar servicio"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
        }
    },
  ],
  language: {
    searchPlaceholder: 'Buscar...',
    sSearch: '',
    lengthMenu: '_MENU_ Filas por página',
  }
});
$("#pat_servicios_info").remove();

// DATOS PARA ACTUALIZAR
function get_nopat() {
  $('#loader').toggle();
  const no_pat = BASE_URL + 'Api/HCV/Pacientes/Historia_clinica/Pernopatologicos/readNoPat/'+id_paciente;

  $.ajax({
    url: no_pat,
    method: 'POST',
    dataType: 'json',
    success: function(data) {
      if(data != ""){
        $('#talla').val(data[0].talla);
        $('#peso').val(data[0].peso);
        $('#tatuaje').val(data[0].tatuajes);
        $('#perfo').val(data[0].piercing);
        $('#tuber').val(data[0].tuberculosis);
        $('#humo').val(data[0].humo_lena);
        $('#estatus-casa').val(data[0].casa_propia);
      }
      $('#loader').toggle();
    },
    error: function(error) {
      alert('hubo un error al enviar los datos');
    }
  });
}

//AGREGAR ANIMALES
$(document).on('click', '#btnanimales', function() {
  if($("#animales").val() != ""){
    $("#loader").toggle();
    var FORMDATA = new FormData();
    const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Pernopatologicos/createAnimal`;

    let animal = $("#animales").val();

    FORMDATA.append("name", animal);
    FORMDATA.append('user_id', id_paciente);

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
          document.getElementById("animales").value = "";
          reloadDataAnimales();
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
  } else {
    Toastify({
      text: "Selecciona un animal para agregar",
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
});

//Obtener id animal
$(document).on('click', '.anim', function() {
  let id_buton = $(this).attr('id');
  $('#animal').val(id_buton);
});

//Borrar animales
function sendFormDel_Animales() {
  $(document).on('submit', '#delete_form_animales', function() {
    $("#loader").toggle();
    var FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Pernopatologicos/deleteAnimal`;
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
          document.getElementById("delete_form_animales").reset();
          $('#modal_delete_animales').modal('toggle');
          reloadDataAnimales();
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
          $("#modal_delete_animales").modal("toggle");
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
}

//AGREGAR SERVICOS
$(document).on('click', '#btn_servicios', function() {
  if($("#servicios").val() != ""){
    $("#loader").toggle();
    var FORMDATA = new FormData();

    let servicio = $("#servicios").val();

    FORMDATA.append('servicio', servicio);
    FORMDATA.append('user_id', id_paciente);

    const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Pernopatologicos/createService`;
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
          document.getElementById("servicios").value = "";
          reloadDataServicios();
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
  } else {
    Toastify({
      text: "Selecciona un servicio para agregar",
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
});

/*RELOAD DATATABLE */
function reloadDataAnimales() {
  $("#loader").toggle();
  dataAnimales.ajax.reload();
  $("#loader").toggle();
}

/*RELOAD DATATABLE SERVICIOS*/
function reloadDataServicios() {
  $("#loader").toggle();
  dataServicios.ajax.reload();
  $("#loader").toggle();
}

//Obtener id del servicio
$(document).on('click', '.del-servicios', function() {
  let id_buton = $(this).attr('id');
  $('#servicio').val(id_buton);
});

//Borrar servicios
function sendFormDel_Servicios() {
  $(document).on('submit', '#delete_form_servicios', function() {
    $("#loader").toggle();
    var FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}Api/HCV/Pacientes/Historia_clinica/Pernopatologicos/deleteService`;
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
          document.getElementById("servicios").value = "";
          $('#modal_delete_servicios').modal('toggle');
          reloadDataServicios();
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
          $("#modal_delete_servicios").modal("toggle");
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
}