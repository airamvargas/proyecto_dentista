//alert(tipo);

//console.log(tipo);


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
//document.getElementById("defaultOpen").click();

$(document).ready(function() {

    switch (tipo) {
        case "0":
            $('#nutricion').hide();
            $('#psicologia').hide();
            $('#diag_nutri').hide();
            document.getElementById("defaultOpen").click();
            break;

        case "1":
            $("#nutricion").hide();
            $("#diag_nutri").hide();
            $("#medicamento").hide();
            $("#defaultOpen").hide();
            $("#evidencia").hide();
            document.getElementById("psicologia").click();
            break;

        case "2":
            $("#psicologia").hide();
            $("#diag_nutri").hide();
            $("#medicamento").hide();
            $("#defaultOpen").hide();
            $("#evidencia").hide();
            $("#procedimientos").hide();
            document.getElementById("nutricion").click();
            break;

        case "3":
            $("#psicologia").hide();
            $("#diag_nutri").hide();
            $("#nutricion").hide();
            $("#defaultOpen").hide();
            document.getElementById("evidencia").click();
            break;

        case "4":
            $("#nutricion").hide();
            $("#diag_nutri").hide();
            $("#medicamento").hide();
            $("#defaultOpen").hide();
            $("#evidencia").hide();
            document.getElementById("psicologia").click();

        case "6":
            $("#psicologia").hide();
            $("#procedimientos").hide();
            $("#nutricion").hide();
            $("#diag_nutri").hide();
            $("#medicamento").hide();
            $("#defaultOpen").hide();

            document.getElementById("evidencia").click();
            break;

    }

    const enfermedad = BASE_URL + 'paciente/Rest_Nota_Medica/index/' + id_cita;

    $.ajax({
        url: enfermedad,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.length > 0) {

                $('#fc').text(data[0].FC);
                $('#fr').text(data[0].FR);
                $('#temp').text(data[0].Temp);
                $('#ta').text(data[0].TA + "/" + data[0].TA2);
                $('#oxigeno').text(data[0].satO2);
                $('#capilar').text(data[0].md_dl);
                $('#peso').text(data[0].Peso);
                $('#talla').text(data[0].Talle);
                $('#imc').text(data[0].Talle);


            }


            console.log(data[0].nota);

        },
        error: function(error) {
            // alert('hubo un error al obtener los datos');
        }
    });



    const diagnosticos = BASE_URL + 'paciente/Rest_Nota_Medica/get_diagnosticos/' + id_cita;
    $.ajax({
        url: diagnosticos,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            $ulanimales = $("#ul_diagnosticos");
            $.each(data, function(i, item) {
                $ulanimales.append( // append directly here
                    '<li data-grid-id="' + item.enfermedad +
                    '">' + item.enfermedad + '</li>');
            });

        },
        error: function(error) {
            alert('hubo un error al obtener los datos');
        }
    });


    const notas = BASE_URL + 'paciente/Rest_Nota_Medica/get_nota/' + id_cita;
    $.ajax({
        url: notas,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // console.log(data);
            $('#medico').text(data[0].NAME + " " + data[0].F_LAST_NAME + " " + data[0].S_LAST_NAME);
            $('#nota').text(data[0].nota);


        },
        error: function(error) {
            alert('hubo un error al obtener los datos');
        }
    });
});


get_nutricion();
get_psycologia();
get_evidencia();
get_diagnostico_nutricional();
get_receta();
get_procedimientos();
get_laboratorio();

//api nutricion

function get_nutricion() {
    const notas = BASE_URL + 'paciente/Rest_Nota_Medica/get_nutricion/' + id_cita;
    $.ajax({
        url: notas,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log("aqui");
            console.log(data);
            $('#cintura').text(data[0].cintura + " " + "cm");
            $('#cadera').text(data[0].cadera + " " + "cm");
            $('#pantorrilla').text(data[0].pantorrilla + " " + "cm");
            $('#masam').text(data[0].masa_muscular + "%");
            $('#gc').text(data[0].grasa_corporal + "%");
            $('#gv').text(data[0].grasa_visceral + "%");
            $('#act').text(data[0].agua_corporal + "%");
            $('#mb').text(data[0].tasa_metabolica);
            $('#em').text(data[0].edad_metabolica);
            $('#peso').text(data[0].peso);
            $('#talla').text(data[0].talla);
            $('#imc').text(data[0].imc);
            $('#nota-nutri').text(data[0].nota);
            $('#medico-nutricion ').text(data[0].NAME + " " + data[0].F_LAST_NAME + " " + data[0].S_LAST_NAME);

        },
        error: function(error) {
            // alert('hubo un error al obtener los datos');
        }
    });

}

///api psicologia

function get_psycologia() {
    const notas = BASE_URL + 'paciente/Rest_Nota_Medica/get_psicologia/' + id_cita;
    $.ajax({
        url: notas,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            //console.log(data);
            $('#tecnica').text(data[0].tecnica);
            $('#abordaje').text(data[0].tipo_abordaje);
            $('#emocion').text(data[0].estado_emocional);
            $('#objetivo').text(data[0].objectivo_consulta);
            $('#nota-psico').text(data[0].nota);
            $('#medico-psci').text(data[0].NAME + " " + data[0].F_LAST_NAME + " " + data[0].S_LAST_NAME);

         


        },
        error: function(error) {
            //alert('hubo un error al obtener los datos');
        }
    });

}

//// api evidencia//

function get_evidencia() {
    const notas = BASE_URL + 'paciente/Rest_Nota_Medica/get_evidencia/' + id_cita;
    $.ajax({
        url: notas,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            //console.log(data);
            let html = '';
            let i;
            for (i = 0; i < data.length; i++) {

                html += '<tr>' +
                    '<td>' + data[i].descripcion + '</td>' +
                    '<td>' + '<a target="_blank" href="' + BASE_URL + '../../assets/img/' + data[i].id_folio + '-' + data[i].id_patient + '-' + data[i].name_foto + '" >' + '<i class="fa fa-file fa-3x" aria-hidden="true"></i>' + '</a>' + '</td>' +
                    '</tr>';
            }

            $('#tabla_evidencias').html(html);


        },
        error: function(error) {
            //alert('hubo un error al obtener los datos');
        }
    });

}

//API DIAGNOSTICO NUTRICIONAL//

function get_diagnostico_nutricional() {
    const notas = BASE_URL + 'paciente/Rest_Nota_Medica/get_diagnostico_nutricional/' + id_cita;
    $.ajax({
        url: notas,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // console.log(data);
            let html = '';
            let i;
            for (i = 0; i < data.length; i++) {

                html += '<tr>' +
                    '<td>' + data[i].tipo + '</td>' +
                    '<td>' + data[i].balance + '</td>' +
                    '<td>' + data[i].grasa + '</td>' +
                    '<td>' + data[i].ingesta + '</td>' +
                    '</tr>';
            }

            $('#tabla_nutricional').html(html);



        },
        error: function(error) {
            // alert('hubo un error al obtener los datos');
        }
    });

}

////RECETA



function get_receta() {
    const notas = BASE_URL + 'paciente/Rest_Nota_Medica/get_medicamentos/' + id_cita;
    $.ajax({
        url: notas,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log(data);
            let = longitud = data.length;
            //alert(longitud);

            if (data.length == 0) {
                $('#btn-pdf').prop('disabled', true);
                $('#send-pdf').prop('disabled', true);

            } else {
                let html = '';
                let i;
                for (i = 0; i < data.length; i++) {

                    html += '<tr>' +
                        '<td>' + data[i].medicamento + '</td>' +
                        '<td>' + data[i].presentacion + '</td>' +
                        '<td>' + data[i].indicaciones + '</td>' +
                        '</tr>';
                }

                $('#tabla_medicamentos').html(html);
                $('.id_patient').val(data[0].id_patient);
                $('.id_folio').val(data[0].id_folio);
                $('.id_doctor').val(data[0].id_medico);
                $('.indicaciones').val(data[0].indicaciones_secundarias);
                $('#indicaciones-secundarias').text(data[0].indicaciones_secundarias);


            }
        },
        error: function(error) {
            // alert('hubo un error al obtener los datos');
        }
    });

}


function get_procedimientos() {
    const notas = BASE_URL + 'paciente/Rest_Nota_Medica/get_procedimientos/' + id_cita;
    $.ajax({
        url: notas,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            //console.log(data);
            let html = '';
            let i;
            for (i = 0; i < data.length; i++) {

                html += '<tr>' +
                    '<td>' + data[i].nombre + '</td>' +
                    '</tr>';
            }

            $('#tabla_procedimientos').html(html);

            if (data[0].name_pdf != null) {
                $('#img-div').prepend('<a target="_blank" href="' + BASE_URL + '../recetas/' + data[0].name_pdf + '"><img style="width:8%" src="' + BASE_URL + '../../assets/img/icono_pdf.png" alt="MDN"></a>');
            } else {

            }


        },
        error: function(error) {
            // alert('hubo un error al obtener los datos');
        }
    });

}


function get_laboratorio() {
    const notas = BASE_URL + 'paciente/Rest_Nota_Medica/get_laboratorio/' + id_cita;
    $.ajax({
        url: notas,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log(data);
            let html = '';
            let i;
            for (i = 0; i < data.length; i++) {

                html += '<tr>' +
                    '<td>' + data[i].nombre + '</td>' +
                    '<td>' + data[i].preparacion + '</td>' +
                    '</tr>';
            }

            $('#tabla_laboratorio').html(html);

            if (data[0].name_pdf != null) {
                $('#img-div').prepend('<a target="_blank" href="' + BASE_URL + '../recetas/' + data[0].name_pdf + '"><img style="width:8%" src="' + BASE_URL + '../../assets/img/icono_pdf.png" alt="MDN"></a>');
            } else {

            }


        },
        error: function(error) {
            // alert('hubo un error al obtener los datos');
        }
    });

}