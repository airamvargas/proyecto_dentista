//FORMATO EN ESPAÑOL FECHA
moment.locale("es");

get_empresas();

$("#generar-pass").on('click', function () {
  $('#loader').toggle();
  const empresas = BASE_URL + "/Proveedores_mx/generar_pass";
    
  $.ajax({
    url: empresas,
    method: "GET",
    dataType: "json",
    success: function (result) {
      let pass = result;
      $("#password").val(pass);
      $('#loader').toggle();
    },
    error: function (error) {
      alert("hubo un error al enviar los datos");
    },
  });
});

$("#update-pass").on('click', function () {
  $('#loader').toggle();
  const empresas = BASE_URL + "/Proveedores_mx/generar_pass";
    
  $.ajax({
    url: empresas,
    method: "GET",
    dataType: "json",
    success: function (result) {
      let pass = result;
      $("#password_update").val(pass);
      $('#loader').toggle();
    },
    error: function (error) {
      alert("hubo un error al enviar los datos");
    },
  });
});


$(document).on('submit', '#agregar-proveedor', function() {
  $('#loader').toggle();
  var formData = new FormData($(this)[0]);
  const url = BASE_URL + '/Proveedores_mx/agregar_proveedor';

  //AJAX.
  $.ajax({
    url: url,
    type: 'POST',
    data: formData,
    dataType: 'json',
    success: function(data) {
      if (data.status == 200) {
        Toastify({
          text: data.messages.success,
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
        $('#loader').toggle();
        $('#myModal').modal('toggle');
        reloadtable();

      } else {
        Toastify({
          text: data.messages.success,
          duration: 3000,
          className: "info",
          // avatar: "../../assets/img/logop.png",
          style: {
            background: "linear-gradient(to right, #ff0000, #e26f11)",
          },
          offset: {
            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
          },
        }).showToast();
      }
    },
    cache: false,
    contentType: false,
    processData: false
  });
  return false;
});

var data_proveedoresmx = $("#proveedoresmx").DataTable({
  ajax: {
    url: `${BASE_URL}Proveedores_mx/get_proveedoresmx`,
    data: {},
    type: "post",
  },
  
  lengthMenu: [
    [100, 10, 25, 50, 999999],
    ["100", "10", "25", "50", "Mostrar todo"],
  ],

  columns: [
    {
      data: "c_date",
      render: function(data, type, row, meta) {
        return moment(data).format("DD/MM/YY");
      },
    },
    {
      data: "empresa",
    },
    {
      data: "razon_social",
    },
    {
      data: "nombre_comercial",
    },
    {
      data: "rfc",
    },
    {
      data: "producto_servicio",
    },
    {
      data: "pagina_web",
    },
    {
      data: "id_user",
      render: function (data, type, row, meta) {
        return `<div class="d-flex"><button type="button" id="${data}" data-toggle="modal" data-target="#update-datos" class="btn btn-primary btn-update mr-1"><i class="fa fa-eye" aria-hidden="true"></i>
        Detalles</button> <button type="button" id="${data}" data-toggle="modal" data-target="#modal_delete" class="btn btn-danger btn-delete mr-1"><i class="fa fa-trash" aria-hidden="true"></i>
        Eliminar</button></div>`;
      },
    }
  ],
  responsive: true,
  language: {
    searchPlaceholder: "Buscar...",
    sSearch: "",
  },
});

$(document).on('click', '.btn-update', function (){
  $('#loader').toggle();
  document.getElementById("password_update").value = "";
  let id_user = $(this).attr('id');
  const url_accessos = BASE_URL + "/Proveedores_mx/update_datos";
 
  $.ajax({
    url: url_accessos,
    method: "POST",
    data: {id_user : id_user},
    dataType: "json",
    success: function (success) {
      fecha = moment(success['users'][0]['c_date']).format("YYYY-MM-DD");
      $('#id_user').val(success['generales'][0]['id_user']);
      $('#alta_update').val(fecha);
      $('#empresa_update option[value= ' + success['users'][0]['business_id'] + ']').attr("selected", true);
      $('#razon_social').val(success['generales'][0]['razon_social']);
      $('#comercial').val(success['generales'][0]['nombre_comercial']);
      $('#rfc').val(success['generales'][0]['rfc']);
      $('#producto_servicio').val(success['generales'][0]['producto_servicio']);
      $('#pagina').val(success['generales'][0]['pagina_web']);
      $('#contacto').val(success['generales'][0]['nombre_contacto']);
      $('#t_fijo').val(success['generales'][0]['telefono']);
      $('#t_movil').val(success['generales'][0]['movil']);
      $('#email').val(success['users'][0]['email']);
      $('#calle').val(success['generales'][0]['calle']);
      $('#colonia').val(success['generales'][0]['colonia']);
      $('#exterior').val(success['generales'][0]['exterior']);
      $('#interior').val(success['generales'][0]['interior']);
      $('#codigo_postal').val(success['generales'][0]['cp']);
      $('#ciudad').val(success['generales'][0]['cuidad']);
      $('#estado').val(success['generales'][0]['estado']);
      $('#banco').val(success['bancarios'][0]['banco']);
      $('#n_cuenta').val(success['bancarios'][0]['numero_cuenta']);
      $('#clabe').val(success['bancarios'][0]['clabe']);
      $('#moneda').val(success['bancarios'][0]['moneda']);
      $('#loader').toggle();
    },
    error: function (error) {
      alert("hubo un error al enviar los datos");
    },
  });
});

$(document).on('click', '.btn-delete', function (){
  let id_user = $(this).attr('id');
  $('#id_delete').val(id_user);
});

$(document).on('submit', '#delete_form', function() {
  $('#loader').toggle();
  var formData = new FormData($(this)[0]);
  const url = BASE_URL + '/Proveedores_mx/delete_proveedor';
  //AJAX.
  $.ajax({
    url: url,
    type: 'POST',
    data: formData,
    dataType: 'json',
    success: function(data) {
      if (data.status == 200) {
        Toastify({
          text: data.messages.success,
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
        $('#loader').toggle();
        $('#modal_delete').modal('toggle');
        reloadtable();
      } else {
        Toastify({
          text: data.messages.success,
          duration: 3000,
          className: "info",
          // avatar: "../../assets/img/logop.png",
          style: {
            background: "linear-gradient(to right, #ff0000, #e26f11)",
          },
          offset: {
            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
          },
        }).showToast();
      }
    },
    cache: false,
    contentType: false,
    processData: false
  });
  return false;
});


$(document).on('submit', '#update-proveedor', function() {
  $('#loader').toggle();
  var formData = new FormData($(this)[0]);
  const url = BASE_URL + '/Proveedores_mx/update_proveedor';

  //AJAX.
  $.ajax({
    url: url,
    type: 'POST',
    data: formData,
    dataType: 'json',
    success: function(data) {
      if (data.status == 200) {
        Toastify({
          text: data.messages.success,
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
        $('#loader').toggle();
        $('#update-datos').modal('toggle');
        reloadtable();

      } else {
        Toastify({
          text: data.messages.success,
          duration: 3000,
          className: "info",
          // avatar: "../../assets/img/logop.png",
          style: {
            background: "linear-gradient(to right, #ff0000, #e26f11)",
          },
          offset: {
            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
          },
        }).showToast();
      }
    },
    cache: false,
    contentType: false,
    processData: false
  });
  return false;
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
          '<option  value="' + v.id + '" >' + v.business_name + "</option>"
        );
      });
    },
    error: function (error) {
      alert("hubo un error al enviar los datos");
    },
  });
}

function reloadtable() {
  $('#loader').toggle();
  data_proveedoresmx.ajax.reload();
  $('#loader').toggle();
}