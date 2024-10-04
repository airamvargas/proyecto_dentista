let this_js_script = $('#ruta'); // or better regexp to get the file name..
const CONTROLADOR = this_js_script.attr('data-my_var_1');

// DATOS DE LA FICHA DE IDENTIFICACION DEL PACIENTE
getPaciente();
function getPaciente() {
  $('#loader').toggle();
  let id_paciente = $("#id").val(); 
  
  const URL = `${BASE_URL}${CONTROLADOR}/getPaciente`;
  $.ajax({
    url: URL,
    data: { id: id_paciente },
    method: "post",
    dataType: "json",
    success: function (success) {
      //FOTO DE PERFIL DEL PACIENTE
      var foto_oper = success[0].PATH;      
      $("#name_foto").val(foto_oper);
      if (foto_oper == null || foto_oper == "") {
        let photo = `<img id="img-user" class="rounded-circle img-fluid" src="${BASE_URL}../../writable/uploads/profile/default.png">`;
        $(".photo-oper").append(photo);
      } else {
        let pathphoto = `${BASE_URL}../uploads/paciente`;
        let photo = `<img id="img-user" class="rounded-circle img-fluid" src="${pathphoto}/${foto_oper}">`;
        $(".photo-oper").append(photo);
      }
      $("#id_user").val(success[0].ID_USER);
      $("#id_identity").val(success[0].ID);
      $("#correo").val(success[0].email);
      $("#old_password").val(success[0].password);
      $("#nombre").val(success[0].NAME);
      $("#ap_paterno").val(success[0].F_LAST_NAME);
      $("#ap_materno").val(success[0].S_LAST_NAME);
      $("#fec_nac").val(success[0].BIRTHDATE);
      $("#sex").val(success[0].SEX);
      $("#nacionalidad").val(success[0].ID_CAT_NATIONALITY);
      if (success[0].ID_CAT_NATIONALITY != "Mexico") {
        $("#birthplace").empty();
        $("#birthplace").append('<option  value="">Selecciona lugar de nacimiento</option>');
        $("#birthplace").append('<option  value="NE">' + "NE" + '</option>');
      } else {
          const ruta = BASE_URL + "HCV/Operativo/Hcv_Rest_Paciente/get_estados";
          $.ajax({
              type: "GET",
              url: ruta,
              dataType: "JSON",
              success: function(data) {
                  //$("#birthplace").empty();
                  $("#birthplace").append('<option  value="">Selecciona lugar de nacimiento</option>');
                  $(data).each(function(i, v) { // indice, valor
                      $("#birthplace").append('<option  value="' + v.state + '">' + v.state + '</option>');
                  });
                  $("#birthplace").val(success[0].BIRTHPLACE);
                  
              },
              error: function() {
                  alert("Hubo un erro al obtener los datos");
              }
          });
      }
      $("#birthplace").val(success[0].BIRTHPLACE);
      $("#curp").val(success[0].CURP);
      $("#telefono").val(success[0].PHONE_NUMBER);
      $("#cp_search").val(success[0].CP);
      $("#id_original").val(success[0].ID_ZIP_CODE);
      $("#delegacion").val(success[0].ID_CAT_MUNICIPALITY);
      $("#estado").val(success[0].ID_CAT_STATE_OF_RESIDENCE);
      $("#colonia").val(success[0].ID_CAT_TOWN);
      $("#autocomplete").val(success[0].street_other);
      $("#latitud").val(success[0].LATITUD);
      $("#longitud").val(success[0].LONGITUD);
      $("#academico").val(success[0].formacion);
      $("#id_academic").val(success[0].ID_CAT_ACADEMIC);
      $("#ocupacion").val(success[0].JOB);
      $("#cat_marital_status").val(success[0].ID_CAT_MARITAL_STATUS);
      $("#genero").val(success[0].ID_CAT_GENDER_IDENTITY);
      if(success[0].ID_CAT_GENDER_IDENTITY == "Otro"){
          $('#othergender').show();
          $('#othergender').val(success[0].other_gender)
      } else {
          $('#othergender').hide();
      }
      $("#otro_genero").val(success[0].other_gender);
      $("#id_religion").val(success[0].ID_CAT_RELIGION);
      $("#religion").val(success[0].religion);
      $("#id_lengua").val(success[0].ID_CAT_INDIGENOUS_LENGUAGE);
      $("#lenguas").val(success[0].lengua);
      
      comunidad  =  success[0].ANSWER_INDIGENOUS_COMUNITY;
      if(comunidad === "Si"){
        $("#si").prop("checked", true);
      }else{
        $("#no").prop("checked", true);
      }
      $('#loader').toggle();
    },
    error: function (xhr, text_status) {
      $("#loader").toggle();
    },
  });
}

// Checked lengua indigena
$(document).ready(function() {
  let Checked = null;
  //The class name can vary
  for (let CheckBox of document.getElementsByClassName('check')) {
      CheckBox.onclick = function() {
          if (Checked != null) {
              Checked.checked = false;
              Checked = CheckBox;
          }
          Checked = CheckBox;
      }
  }
});

/*UPDATE FICHA DE IDENTIFICACION DEL PACIENTE*/
$(document).on("submit", "#formUpdateFP", function () {
  $("#loader").toggle();

  let id_medico = $("#id_user").val();
  const FORMDATA = new FormData($(this)[0]);
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
        location.href = `${BASE_URL}HCV/Administrativo/Pacientes`;
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
      avatar: "../../../assets/img/cancelar.png",
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