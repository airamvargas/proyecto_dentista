/* Desarrollador: Airam Vargas
Fecha de creacion:
Fecha de Ultima Actualizacion: 06 - 09 -2023 por Airam Vargas
Perfil: Recepcionista
Descripcion: Busqueda de pacientes por nombre, correo y/o telefono */

//FORMATO EN ESPAÑOL FECHA
moment.locale("es");
country();

const input = document.getElementById("autoComplete");
$('#form_agregar').hide();
$('#datos-info').hide();
console.log("hola");

if(input){
  const autoCompleteJS = new autoComplete({
    placeHolder: "Buscar paciente...",
    threshold: 2,
    diacritics: true,
    data: {
      src: async (query) => {
        try {
          const source = await fetch(`${BASE_URL}Searchs/Rest_search/readPacientes/${query}`);
          const data = await source.json(); 
          return data;
        
        } catch (error) {
          return error;
        }
      },
      keys: ["NAME", "PHONE_NUMBER"],
    },

    resultsList: {
      tag: "ul",
      id: "autoComplete_list",
      class: "results_list",
      destination: "#autoComplete",
      position: "afterend",
      maxResults: 100,
      noResults: true,
      element: (list, data) => {
        if(!data.results.length){
          $('#actualizar').hide();
          const message = document.createElement("div");
          message.setAttribute("class", "no_result");
          message.innerHTML = `<span class="pd-x-20">Ningún resultado para "${data.query}". Agregue los datos del paciente para continuar.</span> 
          <br><br>
          <div class="pd-x-20">
            <button id="agregar" type="submit" class="btn btn-success pd-x-20 float-right"><i class="fa fa-plus" aria-hidden="true"></i> AGREGAR PACIENTE</button>
          </div>`;
          list.appendChild(message);
        } else {
          const message = document.createElement("div");
          message.setAttribute("class", "no_result");
          message.innerHTML = `<br><br>
          <div class="pd-x-20">
            <button id="agregar" type="submit" class="btn btn-success pd-x-20 float-right"><i class="fa fa-plus" aria-hidden="true"></i> AGREGAR PACIENTE</button>
          </div>`;
          list.appendChild(message);
        }
        list.setAttribute("data-parent", "food-list");
      },
    },
    
    resultItem: {
      highlight: true,
      element: (item, data) => {
        
        item.innerHTML = `
        <span style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
        ${data.match}
        </span>
        
        <span style="display: flex; align-items: center; font-size: 13px; font-weight: 100; text-transform: uppercase; color: rgba(0,0,0,.2);">
        ${data.value.PHONE_NUMBER}
        </span>`;
        $('#actualizar').show();
      },
    },

    events: {
      input: {
        selection: (event) => {
          $(".no_result").hide();
          $('#form_agregar').hide();
          document.getElementById("form_agregar").reset();
          let correo = event.detail.selection.value.email;
          let telefono = event.detail.selection.value.PHONE_NUMBER;
          get_pacientes(correo, telefono);
        }
      }
    }
  });
}

$(document).on('click', '#agregar', function() {
  $('#form_agregar').show();
  document.getElementById("form_agregar").reset();
  document.getElementById("id_user").value = "";
  $('#datos-info').hide();
  $('#actualizar').hide();
  $(".no_result").remove();
});

$(document).on('click', '#actualizar', function() {
  $('#loader').toggle();
  var formData = new FormData();

  let id_usuario = $("#id_user").val();
  let nombre = $('#n_cliente').val();
  let ap_paterno = $('#ap_paterno').val();
  let ap_materno = $('#ap_materno').val();
  let correo = $('#correo').val();
  let telefono = $('#telefono').val();
  let f_nacimiento = $('#f_nacimiento').val();
  let nacionalidad = $('#nacionalidad').val();
  let sexo = $('#sexo').val();
  let cp = $('#cp_id').val();

  formData.append("id_user", id_usuario);
  formData.append("n_cliente", nombre);
  formData.append("ap_paterno", ap_paterno);
  formData.append("ap_materno", ap_materno);
  formData.append("correo", correo);
  formData.append("telefono", telefono);
  formData.append('f_nacimiento', f_nacimiento);
  formData.append("nacionalidad", nacionalidad);
  formData.append("sexo", sexo);
  formData.append("cp_id", cp);

  const URL = `${BASE_URL}Api/Pacientes/Identity/update_`;

  $.ajax({
    url: URL,
    type: 'POST',
    data: formData,
    dataType: 'json',
    success: function(data) {
      if (data.status == 200) {
        Toastify({
          text: data.msg,
          duration: 3000,
          className: "info",
          avatar: `${BASE_URL}../../assets/img/correcto.png`,
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
          avatar: "../../assets/img/cancelar.png",
          style: {
            background: "linear-gradient(to right, #f26504, #f90a24)",
          },
          offset: {
            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
          },
        }).showToast();
        document.getElementById("form-update").disabled = false;
      }
    },
    cache: false,
    contentType: false,
    processData: false
  });
  return false;
});

$(document).on('submit', '#form_agregar', function(e) {
  e.preventDefault();
  $('#loader').toggle();
  let id_cp = $("#cp_id").val();
  
  if(!id_cp){
    Toastify({
      text: "SELECCIONA UN CÓDIGO POSTAL PARA CONTINUAR CON EL REGISTRO",
      duration: 3000,
      className: "info",
      // avatar: "../../assets/img/logop.png",
      style: {
        background: "linear-gradient(to right, #cf0000, #e98c35)",
      },
      offset: {
        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
      },
    }).showToast();
    $('#loader').toggle();
  } else {
    document.getElementById("add_datos").disabled = true;
    var formData = new FormData($(this)[0]);
    const url = `${BASE_URL}Api/Pacientes/Identity/create`;

    //AJAX.
    $.ajax({
      url: url,
      type: 'POST',
      data: formData,
      dataType: 'json',
      success: function(data) {
        if (data.status == 200) {
          Toastify({
            text: data.msg,
            duration: 3000,
            className: "info",
            // avatar: "../../assets/img/logop.png",
            style: {
              background: "linear-gradient(to right, #00b09b, #96c93d)",
            },
            offset: {
              x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
              y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },

          }).showToast();
          document.getElementById("add_datos").disabled = false;
          location.href = `${BASE_URL}Cotizaciones/ordenServicio/${data.id_cotizacion}`;

        } else {
          Toastify({
            text: data.messages.success,
            duration: 3000,
            className: "info",
            // avatar: "../../assets/img/logop.png",
            style: {
              background: "linear-gradient(to right, #cf0000, #e98c35)",
            },
            offset: {
              x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
              y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
          }).showToast();
          document.getElementById("agregar").disabled = false;
        }
      },
      cache: false,
      contentType: false,
      processData: false
    });
    return false;
  }
  
});

$("#cp_search").keyup(function() { //BUSQUEDA DE CODIGO POSTAL
  var search2 = document.getElementById("cp_search").value;
  let searchresult2 = document.getElementById("searchResult");
  var url_str = `${BASE_URL}Api/Cp/getCp `;
  var cp = {
    "search": search2,
    "limit": "15",
    "offset": "0"

  };
  if (search2 != "") {
    let colonia;
    let id;

    $.ajax({
      url: url_str,
      type: 'POST',
      dataType: 'json',
      data: JSON.stringify(cp),
      success: function(response) {
        info = response.data;
        var len = info.length;
        $("#cpResult").empty();
        for (var i = 0; i < len; i++) {
          id = info[i].ID;
          var cp = info[i].CP;
          colonia = info[i].ASENTAMIENTO;
          allinfo = info[i];
          $("#cpResult").append("<li value='" + id + "'>" + cp + " " + colonia + "</li>");
        }

        // binding click event to li
        $("#cpResult li").bind("click", function() {
          var value = $(this).text();
          var id2 = this.value
          $("#cp_search").val(value);
          console.log(info);
          console.log(id2)
          $("#cpResult").empty();
          var len = info.length;
          for (var i = 0; i < len; i++) {
            if (info[i].ID == id2) {
              $("#colonia").val(info[i].ASENTAMIENTO);
              $("#delegacion").val(info[i].MUNICIPIO);
              $("#estado").val(info[i].ESTADO);
              $('#cp_id').val(info[i].ID);
            }
          }
        });
      }
    });
  }
});

$(document).on('click', '#d_paciente', function(){
  //$('#loader').toggle();
  var id_user = $(this).data('index');

  const URL = `${BASE_URL}${CONTROLADOR}/readPaciente`;

  $.ajax({
    url: URL,
    method: 'POST',
    data: { id_user : id_user},
    dataType: 'json',
    success: function (data) {
      $("#datosPaciente").children().remove();
      $('#datos-info').hide();
      $('#form_agregar').show();
      if(data != "") {
        console.log(data);
        $("#n_cliente").val(data[0]['user_name']);
        $("#ap_paterno").val(data[0]['F_LAST_NAME']);
        $("#ap_materno").val(data[0]['S_LAST_NAME']);
        $("#correo").val(data[0]['email']);
        $("#telefono").val(data[0]['PHONE_NUMBER']);
        $("#f_nacimiento").val(data[0]['BIRTHDATE']);
        $("#ID_CAT_NATIONALITY").val(data[0]['user_name']);
        $("#sexo").val(data[0]['SEX']);
        $("#cp_search").val(`${data[0]['CP']} - ${data[0]['ASENTAMIENTO']} `);
        $("#cp_id").val(data[0]['ID_ZIP_CODE']);
        $("#autoComplete").val("");
        $("#id_user").val(data[0]['ID_USER']);
        $("#id_usuario").val();
      }
      //$('#loader').toggle();
    },
    error: function (error) {
      //alert('hubo un error al enviar los datos');
    }
  }); 
});

//OBTENER NACIONALIDADES
function country(){
  $.getJSON(`${BASE_URL}/../../../assets/js/country.json`, function(json) {
    for (let i = 0; i < json.length; i++) {
      $("#nacionalidad").append("<option value='" + json[i].country + "'>" + json[i].country + "</option>");
    }
  });
}

//BUSQUEDA POR CORREO Y/O TELEFONO DEL TELEFONO
function get_pacientes(correo, telefono){
  $('#loader').toggle();
  const URL = `${BASE_URL}${CONTROLADOR}/get_pacientes`;

  $.ajax({
    url: URL,
    method: 'POST',
    data: { correo: correo,
      telefono : telefono
    },
    dataType: 'json',
    success: function (data) {
      $("#datosPaciente").children().remove();
      $('#datos-info').show();
      if(data != "") {
        $(data).each(function (i, v) {
          let email = v.email != "" ? `${v.email}` : `-`
          let telefono = v.PHONE_NUMBER != "" ? `${v.PHONE_NUMBER}` : `-`
          let questions = `<div class="row justify-content-center text-center align-items-center mg-t-20">
            <div class="col-lg-3 mg-t-10 mg-sm-t-10">
                <p>${v.NAME}</p>
            </div>
            <div class="col-lg-3 mg-t-10 mg-sm-t-10">
                <p>${email}</p>
            </div>
            <div class="col-lg-3 mg-t-10 mg-sm-t-10">
                <p>${telefono}</p>
            </div>
            <div class="col-lg-3 mg-t-10 mg-sm-t-10">
              <div class="d-flex justify-content-center">
                <button id="d_paciente" data-index="${v.ID_USER}" title="Continuar con paciente" class="btn btn-success solid pd-x-20 btn-circle btn-md"><i class="fa fa-check fa-2x" aria-hidden="true"></i>
                </button>
              </div>
            </div>
          </div>`;
          $("#datosPaciente").append(questions);
        });
      }
      $('#loader').toggle();
    },
    error: function (error) {
      //alert('hubo un error al enviar los datos');
    }
  }); 
}
