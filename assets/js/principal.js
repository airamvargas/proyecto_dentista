//FORMATO EN ESPAÑOL FECHA
moment.locale("es");

/* TABLA DE PACIENTES */
var citas = $('#citas_programadas').DataTable({
  ajax: {
    url: BASE_URL + '/Api/Pacientes/Agendar_cita/get_citas',
    type: "post",
  },
  lengthMenu: [
    [10, 25, 50, 100, 999999],
    ["10", "25", "50", "100", "Mostrar todo"],
  ],
  columns: [
    {
      data: 'fecha',
      render: function (data, type, row, meta) {
        return moment(data).format("DD-MMM-YY");
      }
    },
    {
      data: 'fecha',
      render: function (data, type, row, meta) {
        return moment(data).format('LT')
      }
    },
    {
      data: 'paciente'
    },
    {
      data: 'observaciones'
    },
    {
      data: "id",
      render: function (data, type, row, meta) {
        return '<div class="d-flex justify-content-center"> <button id="' + data + '" title="Reasignar cita" class="btn btn-warning reasignar solid pd-x-20 btn-circle btn-sm mr-2"><i class="fa fa-clock-o" aria-hidden="true"></i></button>' +
        '<button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm" title="Cancelar cita" data-toggle="modal" data-target="#modal_delete"><i class="fa fa-ban" aria-hidden="true"></i></button></div>'
      }
    },
  ],
  language: {
    searchPlaceholder: 'Buscar...',
    sSearch: '',
    lengthMenu: '_MENU_ Filas por página',
  }
});

$(document).on('click', '.reasignar', function(){
  $('#loader').toggle();
  const url = `${BASE_URL}/Api/Pacientes/Agendar_cita/read_cita`;
  let id_cita = $(this).attr('id');

  $.ajax({
    url: url,
    data: { id_cita: id_cita },
    method: 'post', //en este caso
    dataType: 'json',
    success: function (success) {
      fecha =  moment(success[0].fecha).format('YYYY-MM-DD');
      $('#fechaH').val(fecha);
      $('#comentarios').val(success[0].observaciones);
      $('#id_reasignar').val(success[0].id);
      $('#modal_reasignar').modal('toggle');
      $('#loader').toggle();
      get_horasdip();
    },
    error: function (xhr, text_status) {
      $('#loader').toggle();
    }
  });
});

$(document).on('change', '#fechaH', function(){
  get_horasdip();
});

$(document).on('submit', '#reasignarCitas', function(e){
  e.preventDefault();
    //document.getElementById('btn_eliminar').disabled = true;
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Pacientes/Agendar_cita/reasignar`;
    let FORMDATA = new FormData($(this)[0]);
    let form = $('#reasignarCitas');
    let modal = $('#modal_reasignar');
    send(url, FORMDATA, citas, modal, form);
});

function get_horasdip(){
  $("#horasdisp").empty();
  let id_cita = $("#id_reasignar").val();
  let fecha = $("#fechaH").val()
  $('#loader').toggle();
  let url = `${BASE_URL}Api/Pacientes/Agendar_cita/get_horasdip/${id_cita}/${fecha}`;
  fetch(url).then(response => response.json()).catch(err => alert(err))
  .then(response => {
    $("#horasdisp").append(`<option  value="">Selecciona una hora</option>`);
    const ch = response;
    $(ch).each(function(i, v) {
      $("#horasdisp").append(`<option  value="${v}">${v}</option>`);
    }); 
    $('#loader').toggle();
  }).catch(err => alert(err))
}

