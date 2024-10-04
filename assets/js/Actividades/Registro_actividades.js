//FORMATO EN ESPAÑOL FECHA
moment.locale("es");

get_empresas();
get_users();

var dataTable = $('#actividades-table').DataTable({
  ajax: {
    url: `${BASE_URL}/Actividades/Registro_actividades/get_datos`,
    type: "post",
  },
  lengthMenu: [
    [25, 50, 100, 999999],
    ["25", "50", "100", "Mostrar todo"],
  ],

  columns: [
    {
      data: 'photo',
      render: function (data, type, row, meta) {
        return data == '' ? '<img style="width:70px; height: 70px;" src="../../public/images/default_user.png" class="img-fluid" />' : '<img style="width:70px; height: 70px;" src="../../../public/images/' + data + ' " class="img-fluid" />'
      }
    },

    {
      data: "fecha",
      render: function (data, type, row, meta) {
        return moment(data).format("DD/MM/YY");
      }
    },
    {
      data: 'rubro'
    },
    {
      data: 'marca'
    },
    {
      data: 'actividad'
    },
    {
      data: 'user_name'
    },
    {
      data: 'concluida'
    },
    {
      data: "id",
      render: function (data, type, row, meta) {
        return `<div class="d-flex"><button type="button" id="${data}" data-toggle="modal" data-target="#modal_update" class="btn btn-warning btn-update mr-1"><i class="fa fa-pencil" aria-hidden="true"></i>
        Editar</button> <button type="button" id="${data}" data-toggle="modal" data-target="#modal_delete" class="btn btn-danger btn-delete mr-1"><i class="fa fa-trash" aria-hidden="true"></i>
        Eliminar</button>`;
      },
    },
  ],
  language: {
    searchPlaceholder: 'Buscar...',
    sSearch: '',
    lengthMenu: '_MENU_ Filas por página',
  }
});

$(document).on("click", ".btn-update", function () {
  let id = $(this).attr('id');
  let json = { id: id };

  $.ajax({
    url: `${BASE_URL}Actividades/Registro_actividades/get_update`,
    type: "POST",
    data: json,
    dataType: "JSON",
    success: function (data) {
      $("#empresa_update option[value= " + data[0].empresa + "]").attr("selected", true);
      $('#id_update').val(data[0].id);
      $('#fecha_update').val(data[0].fecha);
      $('#rubro_update').val(data[0].rubro);
      $('#actividad_update').val(data[0].actividad);
      $("#responsable_update option[value= " + data[0].responsable + "]").attr("selected", true);
      $("#concluida_update option[value= " + data[0].concluida + "]").attr("selected", true);
      $('#loader').toggle();
    },
    error: function (error) {
      console.log(error);
    },
  }); //AJAX
});

$(document).on("click", ".btn-delete", function () {
  let id = $(this).attr('id');
  $("#id_delete").val(id);

});

//FUNCIONES
function get_empresas() {
  const empresas = BASE_URL + "/Cotizaciones/get_empresas";
  var select = $(".empresa");
  $.ajax({
    url: empresas,
    method: "GET",
    dataType: "json",
    success: function (data) {
      const ch = data;
      $(ch).each(function (i, v) {
        select.append(
          '<option  value="' + v.id + '" >' + v.marca + "</option>"
        );
      });
    },
    error: function (error) {
      alert("hubo un error al enviar los datos");
    },
  });
}

function get_users() {
  const usuarios = BASE_URL + "/Actividades/Registro_actividades/get_users";
  var select = $(".responsable");
  $.ajax({
    url: usuarios,
    method: "GET",
    dataType: "json",
    success: function (data) {
      const ch = data;
      $(ch).each(function (i, v) {
        select.append(
          '<option  value="' + v.id + '" >' + v.user_name + "</option>"
        );
      });
    },
    error: function (error) {
      alert("hubo un error al enviar los datos");
    },
  });
}