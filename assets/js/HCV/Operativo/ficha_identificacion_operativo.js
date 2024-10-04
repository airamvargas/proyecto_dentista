getMedico();

if(group == 8){
    $("#tb_areas").hide();
}

/*TABLA DE UNIDADES DE NEGOCIO DEL OPERATIVO*/
    var dataTable = $("#tb_unidades").DataTable({
        ajax: {
        url: `${BASE_URL}${CONTROLADOR}/get_unidades`,
        data: { },
        type: "post",
    },
    searching: false,
    paging: false,
    lengthMenu: [
        [10, 25, 50, 100, 999999],
        ["10", "25", "50", "100", "Mostrar todo"],
    ],
    columns: [
        {
            data: "unidad_negocio",
        },
    ],
    language: {
        searchPlaceholder: "Buscar...",
        sSearch: "",
        lengthMenu: "_MENU_ Filas por página",
    },
});
$("#tb_unidades_info").remove();

/*UPDATE FICHA DE IDENTIFICACION DEL OPERATIVO*/
$(document).on("submit", "#formUpdate", function () {
    $("#loader").toggle();
    
    const FORMDATA = new FormData($(this)[0]);
    const URL = `${BASE_URL}${CONTROLADOR}/update_`;
    $.ajax({
        url: URL,
        type: "POST",
        data: FORMDATA,
        dataType: "json",
        success: function (data) {
            if (data.status == 200) {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../assets/img/correcto.png",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    },
                    offset: {
                        x: 50,
                        y: 90,
                    },
                }).showToast();
                $("#loader").toggle();

            } else {
                Toastify({
                    text: data.msg,
                    duration: 3000,
                    className: "info",
                    avatar: BASE_URL + "../../../assets/img/cancelar.png",
                    style: {
                        background: "linear-gradient(to right, #f90303, #fe5602)",
                    },
                    offset: {
                        x: 50,
                        y: 90,
                    },
                }).showToast();
                $("#loader").toggle();
            }
        },
        cache: false,
        contentType: false,
        processData: false,
    }).fail(function (jqXHR, textStatus, errorThrown) {
        $("#loader").toggle();
        switch (jqXHR.status) {
        case 404:
            mensaje = "respuesta o pagina no encontrada";
            break;
        case 500:
            mensaje = "Error en el servidor";
            break;
        case 0:
            mensaje = "no conecta verifica la conexion";
            break;
        }
        Toastify({
            text: mensaje,
            duration: 3000,
            className: "info",
            avatar: "../../../assets/img/cancelar.png",
            style: {
                background: "linear-gradient(to right, #f90303, #fe5602)",
            },
            offset: {
                x: 50,
            },
        }).showToast();
    });
    return false;
});
  
// DATOS DE LA FICHA DE IDENTIFICACION DEL OPERATIVO
function getMedico() {
    $('#loader').toggle();
    const URL = `${BASE_URL}${CONTROLADOR}/getOperativo`;
    $.ajax({
        url: URL,
        method: "post",
        dataType: "json",
        success: function (success) {
            $("#group").prop('disabled', 'disabled');
            $("#discip").prop('disabled', 'disabled');
            document.getElementById('entrada').readOnly = true;
            document.getElementById('salida').readOnly = true;
            var foto_oper = success[0].FILE_USER;
            $("#name_foto").val(foto_oper);
            if (foto_oper == null || foto_oper == "") {
                let photo = `<img id="img-user" class="rounded-circle img-fluid" src="${BASE_URL}../../writable/uploads/profile/default.png">`;
                $(".photo-oper").append(photo);
            } else {
                let pathphoto = `${BASE_URL}../uploads/medico/fotos`;
                let photo = `<img id="img-user" class="rounded-circle img-fluid" src="${pathphoto}/${foto_oper}">`;
                $(".photo-oper").append(photo);
            }

             //Tomador de muestra
            /* if(success[0].id_group === "7"){
                $('#discipline').hide();
                $('#laboratorio').hide();
                area();        
            }
            //Medico
            if(success[0].id_group === "8"){
                $('#laboratorio').hide();
                $('#category').hide();
                $('.tb_tomador').hide();
            }
            //Laboratorio
            if(success[0].id_group === "9"){
                $('#discipline').hide();
                $('#category').hide();
                $('.tb_tomador').hide();
            } */

            $("#id_user").val(success[0].user_id);
            $("#id_identity").val(success[0].ID);
            $("#correo").val(success[0].email);
            $("#old_password").val(success[0].password);
            $("#upd_nombre").val(success[0].NAME);
            $("#upd_apellido1").val(success[0].F_LAST_NAME);
            $("#upd_apellido2").val(success[0].S_LAST_NAME);
            $("#upd_fecha").val(success[0].BIRTHDATE);
            $("#upd_tel").val(success[0].PHONE_NUMBER);
            $("#upd_desc").val(success[0].DESC_PERSONAL);
            $("#cp_search").val(success[0].CP);
            $("#id_original").val(success[0].CAT_CP_ID);
            $("#delegacion").val(success[0].delegacion);
            $("#estado").val(success[0].estado);
            $("#colonia").val(success[0].colonia);
            $("#autocomplete").val(success[0].STREET_NUMBER);
            $("#latitud").val(success[0].LATITUD);
            $("#longitud").val(success[0].LONGITUD);
            $("#group").val(success[0].id_group);
            $("#discip").val(success[0].disciplina_id);
            $("#unit").val(success[0].id_cat_business_unit);
            $("#entrada").val(success[0].entry_time);
            $("#salida").val(success[0].departure_time);
            $("#especial").val(success[0].nom_especialidad);
            $("#id_especial").val(success[0].especialidad_id);
            $("#n_cedula").val(success[0].NUMBER_PROFESSIONAL_CERTIFICATE);
            $("#n_esp").val(success[0].NUMBER_SPECIALTY_CERTIFICATE);
            $("#name_ine").val(success[0].FILE_INE);
            $("#codigo").val(success[0].code);
            $('#loader').toggle();
        },
        error: function (xhr, text_status) {
            $("#loader").toggle();
        },
    });
}

// TABLA DE AREAS DEL TOMADOR DE MUESTRA¿
dataTableAreas = $("#tb_areas").DataTable({
    ajax: {
        url: `${BASE_URL}${CONTROLADOR}/get_areas`,
        data: { id: idmedico },
        type: "post",
    },
    
    searching: false,
    paging: false,
    columns: [
        {
            data: "area",
        },

    ],
    language: {
        searchPlaceholder: "Buscar...",
        sSearch: "",
        lengthMenu: "_MENU_ Filas por página",
    },
});
$("#tb_areas_info").remove();

