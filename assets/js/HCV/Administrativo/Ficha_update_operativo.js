// DATOS DE LA FICHA DE IDENTIFICACION DEL OPERATIVO
getMedico();
function getMedico() {
  $('#loader').toggle();
  let id_medico = $("#id").val();
  const URL = `${BASE_URL}${CONTROLADOR}/getOperativo/${id_medico}`;
  $.ajax({
    url: URL,
    data: { id: id_medico },
    method: "post",
    dataType: "json",
    success: function (success) {
      //FOTO DE PERFIL DEL OPERATIVO  
      console.log(success);
      var foto_oper = success[0].FILE_USER;      
      $("#name_foto").val(foto_oper);
      if (foto_oper == null || foto_oper == "") {
        let photo = `<img id="img-user" class="rounded-circle img-fluid" src="${BASE_URL}../../public/uploads/default.png">`;
        $(".photo-oper").append(photo);
      } else {
        let pathphoto = `${BASE_URL}../uploads/medico/fotos`;
        let photo = `<img id="img-user" class="rounded-circle img-fluid" src="${pathphoto}/${foto_oper}">`;
        $(".photo-oper").append(photo);
      }

      //Tomador de muestra
      if(success[0].id_group === "7"){
        $('#discipline').hide();
        $('#laboratorio').hide();
      }
      //Medico
      if(success[0].id_group === "8"){
        $('#laboratorio').hide();
        $('#category').hide();
        $('.tb_tomador').hide();
      }
      //Laboratorio
      if(success[0].id_group === "9"){
        $('#discipline').hide();
        $('#category').hide();
        $('.tb_tomador').hide();
      }

      console.log(success[0].password);

      var img_ine = success[0].FILE_INE;
      $("#id_user").val(success[0].user_id);
      $("#id_identity").val(success[0].ID);
      $("#correo").val(success[0].email);
      $("#old_password").val(success[0].password);
      $("#upd_nombre").val(success[0].NAME);
      $("#upd_apellido1").val(success[0].F_LAST_NAME);
      $("#upd_apellido2").val(success[0].S_LAST_NAME);
      $("#upd_fecha").val(success[0].BIRTHDATE);
      $("#upd_tel").val(success[0].PHONE_NUMBER);
      $("#upd_desc").val(success[0].DESC_PERSONAL);
      $("#cp_search").val(success[0].CP);
      $("#id_original").val(success[0].CAT_CP_ID);
      $("#delegacion").val(success[0].delegacion);
      $("#estado").val(success[0].estado);
      $("#colonia").val(success[0].colonia);
      $("#autocomplete").val(success[0].STREET_NUMBER);
      $("#latitud").val(success[0].LATITUD);
      $("#longitud").val(success[0].LONGITUD);
      $("#group").val(success[0].id_group);
      $("#discip").val(success[0].disciplina_id);
      $("#entrada").val(success[0].entry_time);
      $("#salida").val(success[0].departure_time);
      $("#especial").val(success[0].nom_especialidad);
      $("#id_especial").val(success[0].especialidad_id);
      $("#n_cedula").val(success[0].NUMBER_PROFESSIONAL_CERTIFICATE);
      $("#n_esp").val(success[0].NUMBER_SPECIALTY_CERTIFICATE);
      $("#name_ine").val(img_ine);
      
      $('#loader').toggle();

      //Validacion del INE subido
      if((img_ine == null) || (img_ine == "")){
        $("#down_ine").removeAttr('href');
      }else {
        const url_ine = `${BASE_URL}../public/uploads/medico/ine/${img_ine}`;
        ine = document.getElementById("down_ine");
        ine.setAttribute("href", url_ine);
      }      
    },
    error: function (xhr, text_status) {
      $("#loader").toggle();
    },
  });
}

// TABLA DE UNIDADES DE NEGOCIO DEL OPERATIVO*/
dataTable = $("#tb_unidades").DataTable({
  ajax: {
    url: `${BASE_URL}${CONTROLADOR}/get_unidades`,
    data: { id: idmedico },
    type: "post",
  },
  columns: [
    {
      data: "unidad_negocio",
    },
    {
      data: "id",
      render: function (data, type, row, meta) {
        return (
          '<button id="' +
          data +
          '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm mr-2" type="button" title="Eliminar unidad" data-toggle="modal" data-target="#modal_deleteUN"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
        );
      },
    },
  ],
  "dom": 'lrtip',
  paging: false,
  info: false
});

// TABLA DE AREAS DEL TOMADOR DE MUESTRA
dataTableAreas = $("#tb_areas").DataTable({
  ajax: {
    url: `${BASE_URL}${CONTROLADOR}/get_areas`,
    data: { id: idmedico },
    type: "post",
  },
  columns: [
    {
      data: "area",
    },
    {
      data: "id",
      render: function (data, type, row, meta) {
        return (
          '<button id="' +
          data +
          '"  class="btn btn-danger deleteArea solid pd-x-20 btn-circle btn-sm mr-2" type="button" title="Eliminar área" data-toggle="modal" data-target="#modal_deleteArea"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button></div>'
        );
      },
    },
  ],
  "dom": 'lrtip',
  paging: false,
  info: false
});


// RELOAD DATATABLE 
function reloadData(dataTable) {
  //$("#loader").toggle();
  dataTable.ajax.reload();
  //$("#loader").toggle();
}

// RELOAD DATATABLE 
function reloadDataAreas() {
  $("#loader").toggle();
  dataTableAreas.ajax.reload();
  $("#loader").toggle();
} 

// UPDATE FICHA DE IDENTIFICACION DEL OPERATIVO
$(document).on("submit", "#formUpdateFO", function () {
  $("#loader").toggle();

  let id_medico = $("#id_user").val();
  const FORMDATA = new FormData($(this)[0]);
  //FORMDATA.append('id_identity', id_medico);
  const URL = `${BASE_URL}${CONTROLADOR}/update_`;
  $.ajax({
    url: URL,
    type: "POST",
    data: FORMDATA,
    dataType: "json",
    success: function (data) {
      if (data.status == 200) {
        Toastify({
          text: data.msg,
          duration: 5000,
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
        location.href = `${BASE_URL}HCV/Administrativo/Principal_Operativo`;
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
      },
    }).showToast();
  });
  return false;
});

// UNIDAD DE NEGOCIO A AGREGAR EN LA ACTUALIZACION DEL IDENTITY
$(document).on("click", ".agregar", function () {
  let user = $("#id_user").val();
  let unidad = $("#unit").val();
  const URL = `${BASE_URL}${CONTROLADOR}/createUnidad`;

  if (unidad.length > 0) {
    $.ajax({
      url: URL,
      type: "POST",
      data: { id_user: user, unidad: unidad },
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
          reloadData(dataTable);
          $("#unit").val("");
          $("#loader").toggle();
        }else{
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
          $("#loader").toggle();
        }
      },
    });
  } else {
    Toastify({
      text: "Selecciona una opción",
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

// AREA DEL TOMADOR DE MUESTRA A AGREGAR EN LA ACTUALIZACION DEL IDENTITY
$(document).on("click", ".agregarArea", function () {
  let user = $("#id_user").val();
  let area = $("#area").val();
  const URL = `${BASE_URL}${CONTROLADOR}/createArea`;

  if (area.length > 0) {
    $.ajax({
      url: URL,
      type: "POST",
      data: { id_user: user, area: area },
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
          reloadData(dataTableAreas);
          $("#area").val(""); //limpia el select cuando ya se inserto
          $("#loader").toggle();
        }else{
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
          $("#loader").toggle();
        }
      },
    });
  } else {
    Toastify({
      text: "Selecciona una opción",
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

// ID DE LA UNIDAD DE NEGOCIO A ELIMINAR DEL OPERATIVO
$(document).on("click", ".delete", function () {
  let unidad = $(this).attr("id");
  $("#modal_deleteUN").modal("toggle");
  $("#id_delete").val(unidad);
});

// DELETE UNIDAD DE NEGOCIO DEL OPERATIVO
$(document).on("submit", "#formDeleteUN", function () {
  $("#loader").toggle();
  $("#modal_deleteUN").modal("toggle");
  const FORMDATA = new FormData($(this)[0]);
  const URL = `${BASE_URL}${CONTROLADOR}/delete_unidad`;
  $.ajax({
    url: URL,
    type: "POST",
    data: FORMDATA,
    dataType: "json",
    success: function (data) {
      if (data.status == 200) {
        $("#loader").toggle();
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
            x: 50,
            y: 90,
          },
        }).showToast();
        reloadData(dataTable);
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
        $("#modal_deleteUN").modal("toggle");
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

// ID DEL AREA A ELIMINAR DEL TOMADOR DE MUESTRA 
$(document).on("click", ".deleteArea", function () {
  let area = $(this).attr("id");
  $("#modal_deletearea").modal("toggle");
  $("#id_delete_area").val(area);
});

// DELETE AREA DEL TOMADOR DE MUESTRA
$(document).on("submit", "#formDeleteArea", function () {
  $("#loader").toggle();
  $("#modal_deletearea").modal("toggle");
  const FORMDATA = new FormData($(this)[0]);
  const URL = `${BASE_URL}${CONTROLADOR}/delete_area`;
  $.ajax({
    url: URL,
    type: "POST",
    data: FORMDATA,
    dataType: "json",
    success: function (data) {
      if (data.status == 200) {
        $("#loader").toggle();
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
            x: 50,
            y: 90,
          },
        }).showToast();
        reloadData(dataTableAreas);
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
        $("#modal_deletearea").modal("toggle");
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



