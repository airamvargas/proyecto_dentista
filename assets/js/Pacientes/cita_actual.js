let getDatos = () => {
  $('#loader').toggle();
  let url = `${BASE_URL}Api/Pacientes/Consulta/getNombre/${id_cita}`;
  fetch(url).then(response => response.json()).catch(err => alert(err))
    .then(response => {
      console.log(response);
      $("#n_paciente").append(`<h3 class="text-left">Paciente: ${response[0]['paciente']}</h3>`)
      $("#div_folio").append(`<h3 class="text-center">Folio: ${response[0]['id']}</h3>`)
      $('#loader').toggle();
    }).catch(err => alert(err));
}

let getTotal = () => {
  $('#loader').toggle();
  let url = `${BASE_URL}Api/Pacientes/Consulta/getTotal/${id_cita}`;
  fetch(url).then(response => response.json()).catch(err => alert(err))
    .then(response => {
      $("#total").children().remove();
      total = `<span>${currency(response[0]['total'], { symbol: "$", separator: "," }).format()}</span>`
      $("#total").append(total);
      $("#total_precio").val(response[0]['total']);
      $('#loader').toggle();
    }).catch(err => alert(err));
}

getDatos();
getTotal();

$(document).on('submit', '#insertTratamiento', function(e){
  e.preventDefault();
  document.getElementById('agregar').disabled = true;
  $('#loader').toggle();
  let url = `${BASE_URL}Api/Pacientes/Consulta/add_tratamiento`;
  let FORMDATA = new FormData($(this)[0]);
  let form = $('#insertTratamiento');
  //let modal = $('#modal_reasignar');
  send(url, FORMDATA, tratamientos, false, form);
  document.getElementById('agregar').disabled = false;
  getTotal();
});

var tratamientos = $('#tratamientos').DataTable({
  ajax: {
    url: BASE_URL + '/Api/Pacientes/Consulta/trata_x_cita',
    data: { 'id_cita': id_cita },
    type: "post",
  },
  lengthMenu: [
    [10, 25, 50, 100, 999999],
    ["10", "25", "50", "100", "Mostrar todo"],
  ],
  columns: [
    {
      data: 'tratamiento'
    },
    {
      data: 'observaciones'
    },
    {
      data: 'cantidad'
    },
    {
      data: 'precio'
    },
    {
      data: "id",
      render: function (data, type, row, meta) {
        return '<div class="d-flex justify-content-center"><button id="' + data + '"  class="btn btn-danger eliminar solid pd-x-20 btn-circle btn-sm" title="Eliminar tratamiento"><i class="fa fa-trash" aria-hidden="true"></i></button></div>'
      }
    },
  ],
  language: {
    searchPlaceholder: 'Buscar...',
    sSearch: '',
    lengthMenu: '_MENU_ Filas por página',
  }
});

//ELIMINAR PACIENTE
$(document).on('click', '.eliminar', function(){
  let id_trat = $(this).attr('id');
  $('#modal_delete').modal('show');
  $("#id_delete").val(id_trat);
});

$(document).on('submit', '#formDelete', function(e) {
  e.preventDefault();
  //document.getElementById('btn_eliminar').disabled = true;
  $('#loader').toggle();
  let url = `${BASE_URL}Api/Pacientes/Consulta/eliminarTrata`;
  let FORMDATA = new FormData($(this)[0]);
  let form = $('#formDelete');
  let modal = $('#modal_delete');
  send(url, FORMDATA, tratamientos, modal, form);
  document.getElementById('agregar').disabled = false;
  getTotal();
});

//FUNCION PARA EL INPUT DE AUTOCOMPLETE
const autoCompleteJS = new autoComplete({
  placeHolder: "Buscar tratamiento...",
  threshold: 2,
  diacritics: true,
  data: {
  src: async (query) => {
    try {
      const source = await fetch(`${BASE_URL}Api/Catalogos/Procedimientos/readTratamiento/${query}`);
      const data = await source.json(); 
      return data;
    } catch (error) {
      return error;
    }
  },
    keys: ["nombre", "precio"],
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
        <br><br>`;
        list.appendChild(message);
      } else {
        const message = document.createElement("div");
        message.setAttribute("class", "no_result");
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
      $${data.value.precio}
      </span>`;
    },
  },

  events: {
    input: {
      selection: (event) => {
        $("#autoComplete").val(event.detail.selection.value.nombre)
        $("#precio").val(event.detail.selection.value.precio)
        $("#id_tratamiento").val(event.detail.selection.value.id)
        $("#id_paciente").val(id_paciente)
        $("#folio").val(id_cita)
      }
    }
  }
});