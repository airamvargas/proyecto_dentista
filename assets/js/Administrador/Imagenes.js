
get_seccion();
getImagenes();

function get_seccion() {
    const url = `${BASE_URL}/Administrador/Imagenes_avance/getCatimagenes`;
    var empresas = $(".seccion");
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log("clientes");
            console.log(data);
            //const ch = data['data'];
            empresas.append(`<option  value=""> SELECCIONA SECCIÓN </option>`);
            $(data).each(function (i, v) {
                empresas.append(`<option  value="${v.id}"> ${v.name}</option>`);
            })

        },
        error: function (error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}


filesToUpload = [];
fileIdCounter = 0;
$(document).on('change', '#file', function (evt) {
    var archivos = $(this)[0].files
    for (var i = 0; i < evt.target.files.length; i++) {
        fileIdCounter++;
        var file = evt.target.files[i];
        filesToUpload.push({
            file: file
        });

        if (filesToUpload.length >= 6) {
            alert(filesToUpload[i].file.name + " " + "Se descarto");
            filesToUpload.splice(i, 1);
        }

    };

    $(".imagenes-prev").children().remove();


    read_files(filesToUpload);

});

function read_files(filesToUpload) {

    $(filesToUpload).each(function (i, v) {
        var reader = new FileReader();
        reader.readAsDataURL(filesToUpload[i].file);
        reader.onloadend = function () {

            var elementos = `<div class="col-3" style="margin-bottom: 13px;">
                                    <button id=${i} type="button" class="btn-close b-elemento" aria-label="Close">X</button>
                                    <img class="img-fluid img-thumbnail" src="${reader.result}" alt="" >
                                </div>`;
            $(".imagenes-prev").append(elementos);

        }
    });


}

$(document).on('click', '#upload', function () {
    $(".imagenes-prev").children().remove();
    filesToUpload = [];
    console.log(filesToUpload);
});


$(document).on('click', '.b-elemento', function (e) {
    let id_buton = $(this).attr('id');
    filesToUpload.splice(id_buton, 1);
    $(this).parent().remove();
    console.log(filesToUpload);

});


$("#send_form").click(function (e) {
    e.preventDefault();
    const seccion = $('.seccion').val();

    console.log(seccion.length);


    if (filesToUpload.length == 0) {
        console.log("son 0")
        Toastify({
            text: "Rellena Todos los campos",
            duration: 3000,
            className: "info",
            // avatar: "../../assets/img/logop.png",
            style: {
                background: "linear-gradient(to right, red, orange)",
            },
            offset: {
                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },

        }).showToast();
    } else {

        if (seccion.length == 0) {
            Toastify({
                text: "Rellena Todos los campos",
                duration: 3000,
                className: "info",
                // avatar: "../../assets/img/logop.png",
                style: {
                    background: "linear-gradient(to right, red, orange)",
                },
                offset: {
                    x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                    y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                },

            }).showToast();

        } else {
            var formData = new FormData();
            $(filesToUpload).each(function (i, v) {
                formData.append('files[]', filesToUpload[i].file);
            });

            formData.append('seccion', seccion);
            formData.append('id_cotizacion', id_cotizacion);

            const url = `${BASE_URL}/Administrador/Imagenes_avance/insert_imagenes`;

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (data.status == 200) {
                        Toastify({
                            text: data.msg,
                            duration: 3000,
                            className: "info",
                            avatar: "../../../../../assets/img/correcto.png",
                            style: {
                                background: "linear-gradient(to right, #00b09b, #96c93d)",
                            },
                            offset: {
                                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                            },

                        }).showToast();
                        $('#myModal').modal('toggle');
                        // document.getElementById("formPago").reset();
                        location.reload();
                        // reloadData();

                    } else {
                        Toastify({
                            text: data.msg,
                            duration: 3000,
                            className: "info",
                            avatar: "../../../../../assets/img/cancelar.png",
                            style: {
                                background: "linear-gradient(to right, #f26504, #f90a24)",
                            },
                            offset: {
                                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                            },

                        }).showToast();

                        $('#myModal').modal('toggle');
                    }

                },
                cache: false,
                contentType: false,
                processData: false
            });
            return false;
        }
    }

});



function getImagenes() {
    $('#loader').toggle();

    const url = `${BASE_URL}/Administrador/Imagenes_avance/getImagenes`;

    $.ajax({
        url: url,
        data: { 'id_cotizacion': id_cotizacion },
        method: 'post', //en este caso
        dataType: 'json',
        success: function (data) {

            if (data.china) {
                $(data.china).each(function (i, v) {
                    let china = `<div class="col-2" style="height: 190px;">
                                    <img style="height: 125px; border-radius: 14px;" src="../../../../ImagenesAvance/${v.foto}" class="img-thumbnail d-block w-new pop" alt="...">
                                    <button id="${v.id}"  class="btn btn-danger delete-file solid pd-x-20 ml-1 " style="border-radius: 10px;"><i class="fa fa-trash-o fa-lg mr-1" aria-hidden="true"></i>ELIMINAR</button>
                                </div>`;
                    $('.china').append(china);
                });
            }

            if (data.empaque) {
                $(data.empaque).each(function (i, v) {
                    let empaque = `<div class="col-2" style="height: 190px;">
                                    <img style="height: 125px; border-radius: 14px;" src="../../../../ImagenesAvance/${v.foto}" class="img-thumbnail d-block w-new pop" alt="...">
                                    <button id="${v.id}"  class="btn btn-danger delete-file solid pd-x-20 ml-1 " style="border-radius: 10px;"><i class="fa fa-trash-o fa-lg mr-1" aria-hidden="true"></i>ELIMINAR</button>
                                </div>`;
                    $('.empaque').append(empaque);


                });
            }

            if (data.placa) {
                $(data.placa).each(function (i, v) {
                    let placa = `<div class="col-2" style="height: 190px;">
                                    <img style="height: 125px; border-radius: 14px;" src="../../../../ImagenesAvance/${v.foto}" class="img-thumbnail d-block w-new pop" alt="...">
                                    <button id="${v.id}"  class="btn btn-danger delete-file solid pd-x-20 ml-1 " style="border-radius: 10px;"><i class="fa fa-trash-o fa-lg mr-1" aria-hidden="true"></i>ELIMINAR</button>
                                </div>`;
                    $('.placa').append(placa);
                });
            }

            if (data.aduanas) {
                $(data.aduanas).each(function (i, v) {
                    let aduanas = `<div class="col-2" style="height: 190px;">
                                    <img style="height: 125px; border-radius: 14px;" src="../../../../ImagenesAvance/${v.foto}" class="img-thumbnail d-block w-new pop" alt="...">
                                    <button id="${v.id}"  class="btn btn-danger delete-file solid pd-x-20 ml-1 " style="border-radius: 10px;"><i class="fa fa-trash-o fa-lg mr-1" aria-hidden="true"></i>ELIMINAR</button>
                                </div>`;
                    $('.aduanas').append(aduanas);


                });
            }

            if (data.cliente) {
                $(data.cliente).each(function (i, v) {
                    let cliente = `<div class="col-2" style="height: 190px;">
                                    <img style="height: 125px; border-radius: 14px;" src="../../../../ImagenesAvance/${v.foto}" class="img-thumbnail d-block w-new pop" alt="...">
                                        <button id="${v.id}"  class="btn btn-danger delete-file solid pd-x-20 ml-1 " style="border-radius: 10px;"><i class="fa fa-trash-o fa-lg mr-1" aria-hidden="true"></i>ELIMINAR</button>
                                </div>`;
                    $('.cliente').append(cliente);


                });
            }

            $('#loader').toggle();
        },
        error: function (xhr, text_status) {
            $('#loader').toggle();
        }
    });

}


$(document).on('click', '.pop', function () {
    let attr = $(this).attr('src');
    $('.imagepreview').attr('src', attr);
    $('#imagemodal').modal('show');
});


//borrar imgen//

$(document).on('click', '.delete-file', function () {
    const id = $(this).attr('id');
    $('#id_delete').val(id);
    $('#modal_delete').modal('toggle');

});

$(document).on('submit', '#delete_form', function () {
    const formData = new FormData($(this)[0]);
    const url = `${BASE_URL}Administrador/Imagenes_avance/deleteImagen`;

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            if (data.status == 200) {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../../assets/img/correcto.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50,
                        y: 90
                    },

                }).showToast();

                $('#modal_delete').modal('toggle');
                location.reload();
                //$('#updateModal').modal('toggle');
                //reloadData();


            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: "../../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f26504, #f90a24)",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },

                }).showToast();
                $('#modal_delete-file').modal('toggle');
                $('#updateModal').modal('toggle');
            }

        },
        cache: false,
        contentType: false,
        processData: false
    });
    return false;

});










