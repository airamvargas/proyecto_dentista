$(document).on('submit', '#form_registro', function () {

  var formData = new FormData($(this)[0]);
  const url = `${BASE_URL}Rest_registro`;

  //AJAX.
  $.ajax({
    url: url,
    type: 'POST',
    data: formData,
    dataType: 'json',
    success: function (data) {
      if (data.status == 200) {
        Swal.fire({
          position: 'center',
          title: 'Gracias',
          icon: 'success',
          text: 'Su información está en proceso de validación, en breve se asignará su número de proveedor y contraseña al correo electrónico registrado',
          showConfirmButton: false,
          timer: 6500
        })
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Algo salio mal, vuelve a intentarlo',
          showConfirmButton: false,
        })
      }
    },
    cache: false,
    contentType: false,
    processData: false
  });
  return false;
});