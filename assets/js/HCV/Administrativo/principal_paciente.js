//alert('paciente');

loadData();
//data_academic();
sendFormNew();

function loadData() {
    $('#loader').toggle();
    $.ajax({
        url: BASE_URL + 'paciente/identity/get_identity',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log(data);
            $('#loader').toggle();
            /* $('#profile_image').attr("src", BASE_URL + '../../writable/uploads/profile/' + data.identity[0].PATH); */
            $('#name').html(data.identity[0].NAME + " " + data.identity[0].F_LAST_NAME + " " + data.identity[0].S_LAST_NAME);
            if (data.identity[0].verified == 1) {
                let verified = `<i class="fa fa-check-circle sucess display-4 mr-3"></i>
                <p class="h6">Perfil Verificado</p>`;
                $('#verified').html(verified);
            } else {
                let verified = `<i class="icon ion-alert-circled alert-icon tx-52 tx-warning mg-r-20"></i>
                <p class="h6">Perfil no verificado</p>`;
                $('#verified').html(verified);
            }

            console.log(data.identity[0]);
            // if(data.status == 200){
            //     console.log(data);
            //     alert(data.messages);
            //     location.reload();
            // }else{
            //     alert(data.messages)
            // }
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

// $('#datatable1').DataTable({
//     responsive: true,
//     language: {
//         searchPlaceholder: 'Search...',
//         sSearch: '',
//         lengthMenu: 'MENU items/page',
//     }
// });










/*            function data_academic() {

                var url_str = BASE_URL+'/Hcv_Rest_Academic';
                //BASE_URL + 'paciente/identity/get_identity'

                $.ajax({
                    url: url_str,
                    type: "GET",
                    dataType: 'json',
                    success: function(result) {
                        if (result.status == 200) {

                            $('#success').text(result);
                            $('#succes-alert').show();
                            //reloadData();

                            let id = result.data
                            let data_length = id.length

                            let academico = document.getElementById("academico")

                            console.log(academico)

                            for (i = 0; i <= data_length; i++) {


                                var option = document.createElement("option");
                                option.innerHTML = id[i].ACADEMIC_FORMATION;
                                option.value = id[i].ID;
                                academico.appendChild(option);
                            }



                        } else {
                            $('#error').text(result.error);
                            $('#error-alert').show();
                        }
                        //$('#loader').toggle();

                    },
                    error: function(xhr, resp, text) {
                        console.log(xhr, resp, text);
                        $('#loader').toggle();
                        $('#error-alert').show();
                        $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');

                    }
                })

            }*/

$(document).ready(function() {

    $("#pepe").keyup(function() {
        var search = document.getElementById("pepe").value;
        console.log('si es este: ' + search);
        var searchresult = document.getElementById("searchResult");
        var url_str = BASE_URL + '/Hcv_Rest_Indigenous_L';
        var language = {
            "search": search,
            "limit": "10",
            "offset": "0"

        };
        console.log(language);
        $.ajax({
            url: url_str,
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify(language),
            success: function(response) {
                let info = response.data;
                console.log(info);
                var len = info.length;
                $("#searchResult").empty();
                for (var i = 0; i < len; i++) {
                    var id = info[i].ID;
                    var name = info[i].SCIENTIFIC_NAME;
                    console.log("searchResult")

                    $("#searchResult").append("<li value='" + id + "'>" + name + "</li>");

                }

                // binding click event to li
                $("#searchResult li").bind("click", function() {
                    var value = $(this).text();
                    $("#pepe").val(value);
                    $("#searchResult").empty();
                });
            }
        });
    });
});


$(document).ready(function() {
    $("#cp_search").keyup(function() {
        var search2 = document.getElementById("cp_search").value;
        let searchresult2 = document.getElementById("searchResult");
        var url_str = BASE_URL + '/Hcv_Rest_Cp';
        var cp = {
            "search": search2,
            "limit": "20",
            "offset": "0"

        };
        if (search2 != "") {
            let colonia;
            let alcaldia;
            let estado;
            let id;
            let info;

            $.ajax({
                url: url_str,
                type: 'POST',
                dataType: 'json',
                data: JSON.stringify(cp),
                success: function(response) {
                    info = response.data;
                    var len = info.length;
                    $("#cpResult").empty();
                    for (var i = 0; i < len; i++) {
                        id = info[i].ID;
                        var cp = info[i].CP;
                        colonia = info[i].ASENTAMIENTO;
                        alcaldia = info[i].MUNICIPIO;
                        estado = info[i].CIUDAD;
                        allinfo = info[i];
                        $("#cpResult").append("<li value='" + id + "'>" + cp + ", " + colonia + "</li>");
                    }

                    // binding click event to li
                    $("#cpResult li").bind("click", function() {
                        var value = $(this).text();
                        var id2 = this.value
                        $("#cp_search").val(value);
                        console.log(info);
                        console.log(id2)
                        $("#cpResult").empty();
                        var len = info.length;
                        for (var i = 0; i < len; i++) {
                            if (info[i].ID == id2) {
                                $("#colonia").val(info[i].ASENTAMIENTO);
                                $("#delegacion").val(info[i].MUNICIPIO);
                                $("#estado").val(info[i].CIUDAD);
                                console.log(info[i])
                            }
                        }
                    });
                }
            });
        }
    });
});


function sendFormNew() {
    $(document).on('click', '#submit_ficha', function() {
        var url_str = BASE_URL + '/Hcv_Rest_Identity/create';
        var loginForm = $("#ficha_description").serializeArray();
        var loginFormObject = {};
        $.each(loginForm,
            function(i, v) {
                loginFormObject[v.name] = v.value;
                console.log(loginFormObject)
            }
        );
        // send ajax
        $.ajax({
            url: url_str, // url where to submit the request
            type: "POST", // type of action POST || GET
            dataType: 'json', // data type
            data: JSON.stringify(loginFormObject), // post data || get data
            success: function(result) {
                if (result.status == 200) {
                    console.log(result);
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();

                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }

            },
            error: function(xhr, resp, text) {
                console.log(xhr, resp, text);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_delete').modal('toggle');
            }
        })
    });
}




$(document).on('click', '.btn-danger', function() {
    let id = $(this).attr('id');
    $('#id_delete').val(id);
    $('#modal_delete').modal('show');
})




$('.alert .close').on('click', function(e) {
    $(this).parent().hide();
});

function reloadData() {
    $('#loader').toggle();
    sendFormDel.ajax.reload();
    $('#loader').toggle();
}

// Datepicker
$('.fc-datepicker').datepicker({
    showOtherMonths: true,
    selectOtherMonths: true
});

$('#datepickerNoOfMonths').datepicker({
    showOtherMonths: true,
    selectOtherMonths: true,
    numberOfMonths: 2
});


$(document).ready(function() {
    $('#genero').change(function(e) {
        if ($(this).val() === "Otro") {
            $('#othergender').show();
        } else {
            $('#othergender').hide();
        }
    })
});

$(document).ready(function() {
    $('#info').change(function(e) {
        if ($(this).val() === "Otro") {
            $('#otherinfo').show();
        } else {
            $('#otherinfo').hide();
        }
    })
});

$(document).ready(function() {
    let Checked = null;
    //The class name can vary
    for (let CheckBox of document.getElementsByClassName('check')) {
        CheckBox.onclick = function() {
            if (Checked != null) {
                Checked.checked = false;
                Checked = CheckBox;
            }
            Checked = CheckBox;
        }
    }
});


var dataTable = $('#datatable1').DataTable({
    ajax: BASE_URL + 'paciente/Rest_agend',
    "order": [
        [8, "desc"]
    ],
    columns: [{
            data: 'id'
        },

        {
            data: 'id',
            render: function(data, type, row, meta) {
                return '<a href="' + BASE_URL + 'Paciente/Nota_Medica/index/' + data + '" ><button id="' + row.id + '"" class="btn btn-info active btncolor pd-x-20"><i class="fa fa-medkit fa-lg" aria-hidden="true"></i></button></a>'
            }
        }, {
            data: 'tipo_cita',
            render: function(data, type, row, meta) {
                return data == "VIRTUAL" ?
                    '<a href="' + row.link + '" target="_blank"><button type="button" class="ml-1 btn btn+ btn-purple rechazar btnborder pd-x-20"><i class="fa fa-users" aria-hidden="true"></i></button></a>' :
                    data
            }
        },
        {
            data: "fecha",
            render: function(data, type, row, meta) {
                var now = new Date(data)
                return '<span class="d-none">' + data + '</span>' + now.toLocaleDateString();
            }
        },
        {
            data: 'hora'
        },
        {
            data: 'status',
            render: function(data, type, row, meta) {
                return data == 0 ? 'Sin Asignar' : data == 1 ? 'Asignado sin confirmar' : data == 2 ? 'Pendiente de confirmacion' : data == 3 ? 'Confirmado' : data == 6 ? 'Finalizada' : data == 5 ? 'Cancelada' : data == "7" ? '<a href="' + BASE_URL + 'Paciente/Laboratorio/index/' + row.id + '">Solicitud Laboratorio </a>' : 'default';
            }
        },
        {
            data: 'operativo_full_name'

        },
        {
            data: 'type',
            render: function(data, type, row, meta) {
                if (data == 0) {
                    return '<p>Medicina</p>'
                } else if (data == 1) {
                    return '<p>Psicologia</p>'
                } else if (data == 2) {
                    return '<p>Nutricion</p>'
                } else if (data == 3) {
                    return '<p>Fisioterapia</p>'
                } else if (data == 4) {
                    return '<p>Especialidad</p>'
                } else if (data == 6) {
                    return '<p>Laboratorio</p>'
                }
            }

        },
        {
            data: 'observation'
        }, {
            data: 'precio'
        }
        /*{
            data: "id",
            render: function(data, type, row, meta) {
                return '<button id="' + row.id + '"" class="btn btn btn-primary btn-update btncolor pd-x-20">ACTUALIZAR</button>' +
                    '<button id="' + row.id + '" data-toggle="modal" data-target="#modal_delete" class="btn btn btn-danger btnborder pd-x-20">ELIMINAR</button>'
            }
        },*/
    ],
    language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ Filas por página',
    }
});