//FORMATO EN ESPAÑOL FECHA
moment.locale("es");

const input = document.getElementById("autoComplete");

$(document).on('click', '#agregar_btn', function(){
  $("#modal_create").modal('toggle');
});

$(document).on('submit', '#registroPaciente', function(e) {
  e.preventDefault();
  //document.getElementById('btn_eliminar').disabled = true;
  $('#loader').toggle();
  let url = `${BASE_URL}Api/Pacientes/Registro_paciente/registro_paciente`;
  let FORMDATA = new FormData($(this)[0]);
  let form = $('#registroPaciente');
  let modal = $('#modal_create');
  ref = `/Pacientes/Historial_clinica/index/`
  send(url, FORMDATA, false, modal, form, ref);
});

if(input) {
  const autoCompleteJS = new autoComplete({
    placeHolder: "Buscar paciente...",
    threshold: 2,
    diacritics: true,
    data: {
      src: async (query) => {
        try {
          const source = await fetch(`${BASE_URL}Api/Pacientes/Registro_paciente/readPacientes/${query}`);
          const data = await source.json(); 
          return data;
        
        } catch (error) {
          return error;
        }
      },
      keys: ["nombre", "tel_cel"],
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
        <span style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden; color: black !important; font-size: 1.2rem !important">
        ${data.match}
        </span>
        
        <span style="display: flex; align-items: center; font-size: 13px; font-weight: 100; color: black !important; text-transform: uppercase; font-size: 1rem !important" color: rgba(0,0,0,.2);">
        ${data.value.tel_cel}
        </span>`;
        $('#actualizar').show();
      },
    },

    events: {
      input: {
        selection: (event) => {/* 
          $(".no_result").hide();
          $('#form_agregar').hide();*/
          document.getElementById("actualizarPaciente").reset(); 
          $("#editarDatos").show();
          $("#nombre").val(event.detail.selection.value.nombre);
          $("#tel_celular").val(event.detail.selection.value.tel_cel);
          $("#sex").val(event.detail.selection.value.sex)
          $("#f_nacimiento").val(event.detail.selection.value.f_nacimiento)
          $("#lugar_nac").val(event.detail.selection.value.lugar_nac)
          $("#tel_casa").val(event.detail.selection.value.tel_casa)
          $("#direccion").val(event.detail.selection.value.direccion)
          $("#id_paciente").val(event.detail.selection.value.id)
        }
      }
    }
  });
}

$(document).on('click', '#continuar', function(e) {
  e.preventDefault();
  //document.getElementById('btn_eliminar').disabled = true;
  $('#loader').toggle();
  let url = `${BASE_URL}Api/Pacientes/Registro_paciente/consulta`;
  let FORMDATA = new FormData();
  ref = `/Pacientes/Consultas/index/`
  send(url, FORMDATA, false, false, false, ref);
});

let send = (url, data, reload, modal, form, ref) =>
  fetch(url, {
    method: "POST",
    body: data,
  }).then(response => response.json()).catch(err => alert(err))
    .then(response => {
      response.status == 200 ? notificacion(response.msg, true, reload, modal, form, ref+response.id) : notificacion(response.msg, false)
  }).catch(err => alert(err))

//notificaciones
let notificacion = (mensaje, flag, reload, modal, form, ref) => {
  console.log(ref);
  if (flag) {
    var imagen = BASE_URL + "../../assets/img/correcto.png";
    var background = "linear-gradient(to right, #00b09b, #96c93d)";

  } else {
    var imagen = BASE_URL + "../../assets/img/cancelar.png";
    var background = "linear-gradient(to right, #f90303, #fe5602)";
  }

  if (reload) {
    reload.ajax.reload();
  }

  if (modal) {
    $(modal.selector).modal('toggle');
  }

  if (form) {
    $(form.selector).trigger("reset");
  }

  Toastify({
    text: mensaje,
    duration: 3000,
    className: "info",
    avatar: imagen,
    style: {
      background: background
    },
    offset: {
      x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
      y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
    },
  }).showToast();
  
  if (ref) {
    setTimeout(() => {
      window.location.href = BASE_URL + ref;
    }, "1000");
  }

  $('#loader').toggle();
}

