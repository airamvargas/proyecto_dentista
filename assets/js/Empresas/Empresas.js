//archivos
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

var dataTable = $('#datatable1').DataTable({
    ajax: BASE_URL + '/Empresas/tabla_empresas',
    columns: [
         {
            data: 'logo',
            render: function(data, type, row, meta) {
                return data == '' ? '<img style="width:70px; height: 70px;" src="../../public/images/default_user.png" class="img-fluid img-thumbnail" />' : '<img style="width:70px; height: 70px;" src="../../public/images/logos/' + data +  ' " class="img-fluid img-thumbnail" />'
            }
        }, 
        {
            data: 'marca'
        },
        {
            data: 'razon_social'
        },
        {
            data: 'rfc'
        },
        {
            data: 'address'
        },
        {
            data: 'tel'
        },
        {
            data: 'correo'
        },
        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<div class="d-flex"><button onclick="enviarId(' + data + ')"" data-toggle="modal" data-target="#modal_actualizacion" class="btn btn-warning  btn-update pd-x-20 mr-1"><i class="fa fa-pencil mr-1" aria-hidden="true"></i>Editar</button>' + 
                    '<button onclick="deleteId(' + data + ')"" data-toggle="modal" data-target="#modaldemo2" class="btn btn-danger pd-x-20"><i class="fa fa-trash mr-1" aria-hidden="true"></i>Eliminar</button></div>' 
            }
        }, 
        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<button class="btn btn-indigo"><i class="fa fa-eye mr-1" aria-hidden="true"></i><a href=" '+ BASE_URL+ 'Documentacion/doc_empresa/' + data + ' " class="text-white">Archivos</a></button>'  
            }
        },         
    ],  

    responsive: true,



   language: {
        searchPlaceholder: 'Buscar...',
        //bLengthChange: false,
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
        paginate: {
            first: "Primera",
            last: "Última",
            next: "Siguiente",
            previous: "Anterior"
        },
        loadingRecords: "Cargando...",
        processing: "Procesando...",
        zeroRecords: "No se ha encontrado nada atraves de ese filtrado",
    },       
    columnDefs: [
        {targets: 2 ,className: "space-none" }, 
        {targets: 4 ,className: "space-none" }, 
        
            
    ],  
  });
  
  //Actualizar datos de la empresa
  function enviarId(id) {
    //alert(id);
    const ruta = `${BASE_URL}empresas/obtenerEmpresa`;
    data = {
      id: id
    }

    $.ajax({
      type: "POST",
      url: ruta,
      dataType: "JSON",
      data: data,
      success: function(response) {
        console.log(response);

        $("#nombre").val(response[0].business_name);
        $("#file-logo").val(response[0].logo);
        $("#direccion").val(response[0].address);
        $("#id_empresa").val(response[0].id);
        $('#marca').val(response[0].marca);
        $('#razon').val(response[0].razon_social);
        $('#rfc').val(response[0].rfc)
        $('#tel').val(response[0].tel)
        $('#correo').val(response[0].correo)
      },
    });
  }

  //Eliminar id traido de la base
  function deleteId(id) {
    $("#id_emp").val(id);
  }

/*RECARGA DE AJAX*/
function reloadData() {
    $('#loader').toggle();
    dataTable.ajax.reload();
    $('#loader').toggle();
}

/* CREAR UNA NUEVA EMPRESA */
$(document).on('submit', '#Nempresa', function() {
  $('#modaldemo1').modal('toggle');
 
  var formData = new FormData($(this)[0]);
  const url = `${BASE_URL}Empresas/crear`;   
  
  $.ajax({
      url: url,
      type: 'POST',
      data: formData,
      dataType: 'json',
      success: function(data) {
          console.log(data);
          if (data.status == 200) {
              Toastify({
                  text: data.msg,
                  duration: 3000,
                  className: "info",
                  avatar: "../../assets/img/correcto.png",
                  style: {
                      background: "linear-gradient(to right, #00b09b, #96c93d)",
                  },
                  offset: {
                      x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                      y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                  },
              }).showToast();

              document.getElementById("Nempresa").reset();
              reloadData();

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

              //$('#modaldemo3').modal('toggle');
          }

      },
      cache: false,
      contentType: false,
      processData: false
  });
  return false;
});


/* EDITAR UNA EMPRESA*/
$(document).on('submit', '#prueba', function() {
  // console.log("di un click");
  const formData = new FormData($(this)[0]);
  const url_srt = `${BASE_URL}Empresas/editarDatos`;

  $.ajax({
      url: url_srt,
      type: 'POST',
      data: formData,
      dataType: 'json',
      success: function(data) {
          console.log(data);
          if (data.status == 200) {
              Toastify({
                  text: data.msg,
                  duration: 3000,
                  className: "info",
                  avatar: "../../assets/img/correcto.png",
                  style: {
                      background: "linear-gradient(to right, #00b09b, #96c93d)",
                  },
                  offset: {
                      x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                      y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                  },

              }).showToast();

              $('#modal_actualizacion').modal('toggle');
              document.getElementById("prueba").reset();
              reloadData();


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

              $('#modal_actualizacion').modal('toggle');
          }

      },
      cache: false,
      contentType: false,
      processData: false
  });
  return false;
});

/*ELIMINAR EMPRESA*/
$(document).on('submit', '#DeleteForm', function() {
  const formData = new FormData($(this)[0]);
  const url = `${BASE_URL}Empresas/borrar`;

  $.ajax({
      url: url,
      type: 'POST',
      data: formData,
      dataType: 'json',
      success: function(data) {
          console.log(data);
          if (data.status == 200) {
              Toastify({
                  text: data.msg,
                  duration: 3000,
                  className: "info",
                  avatar: "../../assets/img/correcto.png",
                  style: {
                      background: "linear-gradient(to right, #00b09b, #96c93d)",
                  },
                  offset: {
                      x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                      y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                  },

              }).showToast();

              $('#modaldemo2').modal('toggle');
              reloadData();
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
              $('#modaldemo2').modal('toggle');
          }

      },
      cache: false,
      contentType: false,
      processData: false
  });
  return false;
});









