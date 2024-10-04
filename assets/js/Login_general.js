$(document).on('submit', '#form-provedor', function() {

    var formData = new FormData($(this)[0]);
    const url = `${BASE_URL}Login_Proveedores/verify_login`;

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
                    icon: 'success',
                    text: data.messages.success,
                    showConfirmButton: false,
                    timer: 2500
                });

                location.href = BASE_URL + 'Facturas';

            } else {
                Swal.fire({
                    icon: 'error',
                    text: data.messages.success,
                    showConfirmButton: false,
                    timer: 2500
                })
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;
});