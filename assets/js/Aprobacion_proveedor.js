$(document).on('submit', '#form_aprobacion', function() {

    var formData = new FormData($(this)[0]);
    const url = `${BASE_URL}Proveedores/update_datos_proveedor`;

    //AJAX.
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(data) {
            if (data.status == 200) {
                Swal.fire({
                    position: 'center',
                    title: 'Gracias',
                    icon: 'success',
                    text: 'Usuario Agregado con exito',
                    showConfirmButton: false,
                    timer: 6500
                })
                location.href = BASE_URL + "/Home/solimed";
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