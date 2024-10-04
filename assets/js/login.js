select_alojamiento();

function select_alojamiento() {
    //alert("dentro de la funcion");
    const url = `${BASE_URL}Mattes/Api/Arrendador_api/Detalle_propiedad`;
    var alojamiento = $("#tipo-alojamiento");
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log(data);
            //const ch = data['data'];
            alojamiento.append(`<option  value=""> SELECCIONA ALOJAMIENTO </option>`);
            $(data).each(function(i, v) {
                alojamiento.append(`<option  value="${v.id}"> ${v.name}</option>`);
            })
        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}



$(document).ready(function() {
    $(document).on('submit', '#detalle-propiedad', function() {
        //document.getElementById("Bancarios").click();

        //Obtenemos datos formulario.
        //var form = $("#form-personales");
        var formData = new FormData($(this)[0]);
        //document.getElementById("d_bancarios").click();
        const url = `${BASE_URL}Mattes/Api/Arrendador_api/Detalle_propiedad/creat`;

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

                    $('#id').val(data.id);
                    document.getElementById("ubicacion").submit();


                    //location.href = BASE_URL + "Mattes/Arrendador/Propiedad_ubicacion";

                } else {
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
                }

            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });
}); //Fin document. */