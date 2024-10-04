//Mostrar imagen y nombre
$(document).on('change', '#file-imagen', function() {
    var filesCount = $(this)[0].files.length;
    var textbox = $(this).prev();
    var ext = $(this).val().split('.').pop();
    var archivo = document.getElementById("file-imagen").files[0];

    if (ext == "png" || "jpg" || "jpeg") {
        if (filesCount == 1) {
            var reader = new FileReader();
            reader.readAsDataURL(archivo);
            var fileName = $(this).val().split('\\').pop();
            textbox.text(fileName);
            reader.onloadend = function() {
                $("#imgen-logo").addClass('img-thumbnail');
                document.getElementById("imgen-logo").src = reader.result;
            }
        } else {
            textbox.text(filesCount + ' files selected');
        }

    } else {
        $(this).val('');
        Toastify({
            text: "El archivo debe ser una imagen",
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
    }
});

$(document).on('change', '#updateImagen', function() {
    var filesCount = $(this)[0].files.length;
    var textbox = $(this).prev();
    var ext = $(this).val().split('.').pop();
    var archivo = document.getElementById("updateImagen").files[0];

    if (ext == "png" || "jpg" || "jpeg") {
        if (filesCount == 1) {
            var reader = new FileReader();
            reader.readAsDataURL(archivo);
            var fileName = $(this).val().split('\\').pop();
            textbox.text(fileName);
            reader.onloadend = function() {
                document.getElementById("img").src = reader.result;
            }
        } else {
            textbox.text(filesCount + ' files selected');
        }

    } else {
        $(this).val('');
        Toastify({
            text: "El archivo debe ser una imagen",
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
    }
});

//Datatable datos empresa
var dataTable = $('#crm_business').DataTable({
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/readBusiness`,
        data: {},
        type: "post",
    },
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],

    columns: [
        {
            data: 'id',
            render: function(data, type, row, meta){
                return data == '' ? `<img style="width:80px; height: 80px;" 
                src="${BASE_URL}../../public/Products/default.png" 
                class="img-fluid" />` : `<img class="rounded" style="width:80px; 
                height: 80px;" src="${BASE_URL}../../assets/img/${row.logo}" class="img-fluid"/>`
            }
        },
        {
            data: 'name',
        },
        { 
            data: 'tel',
        },
        { 
            data: 'address',
        },
        { 
            data: 'rfc',
        },
        { 
            data: 'email',
        },
        { 
            data: 'whatsapp',
        },
        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<div class="d-flex justify-content-center"><button id="' + data + '" class="btn btn-warning update solid pd-x-20 btn-circle btn-sm"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button></div>'
            }    
        },

    ],
    "columnDefs": [
            { className: "wrapbox", "targets": [3] },
        ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});

/* OBTENER DATOS DE LA EMPRESA*/
$(document).on('click', '.update', function() {
    $('#loader').toggle();
    const url = `${BASE_URL}${CONTROLADOR}/readUpdate`;
    let id = $(this).attr('id');

    $.ajax({
        url: url,
        data: { id: id},
        method: 'post', //en este caso
        dataType: 'json',
        success: function(success) {
            document.getElementById("formUpdate").reset();
            if(success[0].logo == ""){
                let html = '';
                html += `<img id="img" src="${BASE_URL}../../public/Products/default.png" class="img-thumbnail" style="width: 30%;"/>`
                $('#imagenUpdate').html(html);
            } else {
                let html = '';
                html += `<img id="img" src="${BASE_URL}../../assets/img/${success[0].logo}" class="img-thumbnail" style="width: 30%;"/>`
                $('#imagenUpdate').html(html);
            }
            $('#updateName').val(success[0].name); 
            $('#updateRfc').val(success[0].rfc);
            $('#updateTelefono').val(success[0].tel); 
            $('#updateAddress').val(success[0].address); 
            $('#updateEmail').val(success[0].email); 
            $('#updateWhatsapp').val(success[0].whatsapp); 
            $('#id_update').val(success[0].id); 
            $('#updateModal').modal('show');
            $('#loader').toggle();
        },
        error: function(xhr, text_status) {
            $('#loader').toggle();
        }
    });
});

$(".cancelar").on('click', function() {
    document.getElementById("formCreate").reset();
    document.getElementById("formUpdate").reset();
    $(".file-message").text("Sin archivo seleccionado");
    $("#imgen-logo").removeAttr('src').removeClass('img-thumbnail');
});