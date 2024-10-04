//alert("aqui");

$(document).on('submit', '#form-factura', function() {

    var formData = new FormData($(this)[0]);
    const url = `${BASE_URL}Facturas/upload_xml`;

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

                reloadData();
                document.getElementById("form-factura").reset();

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


