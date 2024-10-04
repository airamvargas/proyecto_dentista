if (genero === "Hombre") {

    $('#gine').hide();
    $('#peri').hide();


}
if (genero === "Mujer") {
    $('#andro').hide();
    $('#peri').hide();

}
if (edad < 5) {
    $('#peri').show();
    $('#gine').hide();
    $('#andro').hide();
}


get_Ipays();
update_ipays();
get_efc();
update_efc();
notas1vez()


function notas1vez() {
    const data_notas = BASE_URL + "/Administrativo/Rest_Notas/get_nota";
    nota = {
        id_paciente: id_paciente
    }
    $.ajax({
        url: data_notas,
        method: 'POST',
        dataType: 'json',
        data: JSON.stringify(ipays),
        success: function (data) {
            console.log("nota: " + data);
            let full_name = data.NAME + " " + data.F_LAST_NAME;
            let fecha_nota = data.date;
            let general_nota = data.nota;
            document.getElementById('name-medico').innerHTML = full_name;
            document.getElementById('fecha-nota').innerHTML = fecha_nota;
            document.getElementById('note-general').innerHTML = general_nota;
        },
        error: function (error) {
            // alert('hubo un error al enviar los datos');
        }
    });

}

//TABLA DIAGNOSTICO//
let dataTablets = $('#diag-nota').DataTable({
    'ajax': {
        'url': BASE_URL + '/Administrativo/Rest_Notas',
        'data': {
            'id_paciente': id_paciente
        },
        'type': 'post',

    },
    columns: [{
            data: "enfermedad"
        },
        {
            data: 'fecha'
        },
    ],
    "bPaginate": false,
    "searching": false,
});


function openCity(evt, cityName) {
    // Declare all variables
    var i, tabcontent, tablinks;
    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";

}

document.getElementById("defaultOpen").click();


function get_Ipays() {
    const data_ipays = BASE_URL + "/Hcv_Rest_Historia_Clinica_Operativo/get_ipays";
    ipays = {
        id_paciente: id_paciente
    }

    $.ajax({
        url: data_ipays,
        method: 'POST',
        dataType: 'json',
        data: JSON.stringify(ipays),
        success: function (data) {
            console.log("ipays: " + data[0].interrogatorio);
            let interrogario = data[0].interrogatorio;
            let id_ipays = data[0].id;
            $("#sistema").val(interrogario);
            $("#id_pys").val(id_ipays);
        },
        error: function (error) {
            //alert('hubo un error al enviar los datos');
        }
    });

}

//update IPAys//

function update_ipays() {
    $(document).on('click', '#send_ipays', function () {
        let sistema = $("#sistema").val();
        if (sistema < 1) {
            alert("el campo no puede estar vacio");
        } else {
            $('#loader').toggle();
            const url_str = BASE_URL + "/Hcv_Rest_Historia_Clinica_Operativo/update_ipays";
            var Form = $("#form_ip").serializeArray();
            var FormObject = {};
            $.each(Form,
                function (i, v) {
                    FormObject[v.name] = v.value;
                }
            );
            $.ajax({
                url: url_str,
                type: "POST",
                dataType: 'json',
                data: JSON.stringify(FormObject),
                success: function (result) {
                    if (result.status === 200) {
                        $('#success').text(result.messages.success);
                        $('#succes-alert').show();
                        get_Ipays();
                        setTimeout(function () {
                            $('#succes-alert').hide();
                        }, 3000);



                    } else {
                        $('#error').text(result.error);
                        $('#error-alert').show();
                    }
                    $('#loader').toggle();

                },
                error: function (xhr, resp, text) {
                    console.log(xhr, resp, text);
                    $('#loader').toggle();
                    $('#error-alert').show();
                    $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');

                }
            })

        }
    });
}


///Modulo efc///

function get_efc() {

    const data_ipays = BASE_URL + "/Hcv_Rest_Historia_Clinica_Operativo/get_efc";

    ipays = {
        id_paciente: id_paciente
    }

    $.ajax({
        url: data_ipays,
        method: 'POST',
        dataType: 'json',
        data: JSON.stringify(ipays),
        success: function (data) {
            console.log("etc: " + data[0].exploracion_fisica);
            let exploracion = data[0].exploracion_fisica;
            let id_efc = data[0].id;
            $("#exploracion").val(exploracion);
            $("#id_efc").val(id_efc);
        },
        error: function (error) {
            //alert('hubo un error al enviar los datos');
        }
    });

}


//update efc//

function update_efc() {
    $(document).on('click', '#send_efc', function () {
        let exploracion = $("#exploracion").val();
        if (exploracion < 1) {
            alert("el campo no puede estar vacio");
        } else {
            $('#loader').toggle();
            const url_str = BASE_URL + "/Hcv_Rest_Historia_Clinica_Operativo/update_etc";
            var Form = $("#form_efc").serializeArray();
            var FormObject = {};
            $.each(Form,
                function (i, v) {
                    FormObject[v.name] = v.value;
                }
            );
            $.ajax({
                url: url_str,
                type: "POST",
                dataType: 'json',
                data: JSON.stringify(FormObject),
                success: function (result) {
                    if (result.status === 200) {
                        $('#success').text(result.messages.success);
                        $('#succes-alert').show();
                        get_Ipays();
                        setTimeout(function () {
                            $('#succes-alert').hide();
                        }, 3000);

                    } else {
                        $('#error').text(result.error);
                        $('#error-alert').show();
                    }
                    $('#loader').toggle();

                },
                error: function (xhr, resp, text) {
                    console.log(xhr, resp, text);
                    $('#loader').toggle();
                    $('#error-alert').show();
                    $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');

                }
            })

        }
    });
}