get_alergias();
get_id_alergia();
sendFormDel_Alergias();
get_infectocontagiosas();
get_id_infectados();
sendFormDel_infecciosas();
get_infancia();
sendFormDel_infancia();
get_id_infancia();
get_base();
get_id_base();
sendFormDel_base();
get_personalesPatologicos();
get_procedimientos();
get_id_cirugias();
sendFormDel_Cirugias();

function get_personalesPatologicos() {

    const url = BASE_URL+'/Administrativo/Rest_PerPatologicos/get_perpatologicos';

    nutricionales = {
        id_paciente: id_paciente
    }

    $.ajax({
        url: url,
        method: 'POST',
        dataType: 'json',
        data: JSON.stringify(nutricionales),
        success: function(data) {
            console.log(data[0]);
            $('#trans').val(data[0].Transfucion);
            $('#des_trans').val(data[0].Desc_transfucion); 
            $('#frac').val(data[0].Fractura_esguince_lucacion);
            $('#frac-des').val(data[0].Desc_fractura);
            $('#periodicidad').val(data[0].Cantidad_consumo);

            const sustancias = data[0].Consumo_sustancias;

            console.log(sustancias);


            switch (sustancias) {
                case "Ninguna":
                    document.querySelector('#ninguna').checked = true;
                  break;
                case "Tabaco":
                    document.querySelector('#tabaco').checked = true;
                  break;
             
                /* case "Fortificados":
                    document.querySelector('#fortificados').checked = true;
                break; */
 
                default:
                    document.querySelector('#otros').checked = true;
                    //$('#otro2').val(bebida);
                break;
              }
             

            
   
        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });

}



function get_alergias() {
    //alert("dentro de la funcion");
    const enfermedad =  BASE_URL+ '/Administrativo/Rest_PerPatologicos/get_alergias';
    var enfermedades = $("#select-alergia");
    $.ajax({
        url: enfermedad,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            //console.log()
            const ch = data['data'];
            $(ch).each(function(i, v) { // indice, valor
                enfermedades.append('<option  value="' + v.COMMON_NAMES + '">' + v.COMMON_NAMES + '</option>');
            })
        },
        error: function(error) {
           // alert('hubo un error al enviar los datos');
        }
    });
}


//tabla alergias//

let dataTablealergias = $('#table_alergias').DataTable({
    'ajax' : {
        'url' :  BASE_URL+'/Administrativo/Rest_PerPatologicos/get_alergias_paciente',
        'data' : { 'id_paciente' : id_paciente },
        'type' : 'post',
       
    }, 
    columns: [

        {
            data: 'Name'
        },

        {
            data: "Id",
            render: function(data, type, row, meta) {
                return '<button type="button" id="' + row.Id + '" data-toggle="modal" data-target="#modal_delete_alergias" class="ml-1 btn btn btn-danger btn_alergias btnborder pd-x-20"><i class="fa fa-trash-o fa-lg mr-1" aria-hidden="true"></i>ELIMINAR</button>'
            }
        },
    ],
    "bPaginate": false,
    "searching": false,
});

function reloadDatalergias() {
    $('#loader').toggle();
    dataTablealergias.ajax.reload();
    $('#loader').toggle();
}



//guardar alergia//
$(document).on('click', '#guardar_alergias', function() {
   /* if ($("#alergia").val().length < 1) {
        $('#modal_alergias').modal('toggle');
        alert('selecciona todos los campos');
    } else {*/
        $('#loader').toggle();
        $('#modal_alergias').modal('toggle');
        var url_str = BASE_URL+'/Administrativo/Rest_PerPatologicos/create_alergia';
        var alergiasForm = $("#form_perpatologicos").serializeArray();
        var loginFormObject = {};

        $.each(alergiasForm, function(i, v) {
            loginFormObject[v.name] = v.value;
        });

        $.ajax({
            url: url_str, // url where to submit the request
            type: "POST", // type of action POST || GET
            dataType: 'JSON', // data type
            data: JSON.stringify(loginFormObject), // post data || get data
            success: function(result) {
                //console.log(result);
                if (result.status == 200) {
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    reloadDatalergias();
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_created').modal('toggle');
            },
            error: function(xhr, text_status) {
                //console.log(xhr, text_status);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_created').modal('toggle');
            }
        });

    //}
});

//borrar alergias//

function get_id_alergia() {
    $(document).on('click', '.btn_alergias', function() {
        let id_butona = $(this).attr('id');
        $('#input_alergias').val(id_butona);

    });
}

function sendFormDel_Alergias() {
    $(document).on('click', '#borrar_alergias', function() {
        $('#loader').toggle();
        var url_str =  BASE_URL+'/Administrativo/Rest_PerPatologicos/delete_alergia';
        var Form = $("#delete_form_alergias").serializeArray();
        var FormObject = {};
        $.each(Form,
            function(i, v) {
                FormObject[v.name] = v.value;
            }
        );
        $.ajax({
            url: url_str,
            type: "POST",
            dataType: 'json',
            data: JSON.stringify(FormObject),
            success: function(result) {
                if (result.status == 200) {
                    //console.log(result);
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    reloadDatalergias();
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_delete_alergias').modal('toggle');
            },
            error: function(xhr, resp, text) {
                //console.log(xhr, resp, text);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_delete_alergias').modal('toggle');
            }
        })
    });
}

//select infectocontagiosas//

function get_infectocontagiosas() {
    //alert("dentro de la funcion");
    const enfermedad =  BASE_URL+ '/Administrativo/Rest_PerPatologicos/get_infectocontagiosas';
    var enfermedadesi = $("#infecto");
    $.ajax({
        url: enfermedad,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            //console.log()
            const ch = data['data'];
            $(ch).each(function(i, v) { // indice, valor
                enfermedadesi.append('<option  value="' + v.nombre_comun + '">' + v.nombre_comun + '</option>');
            })
        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}

//GUARGAR INFECTOCONTAGIOSAS//
$(document).on('click', '#guardar_infectados', function() {
    /*if ($("#infectocontagiosa").val().length < 1) {
        $('#modal_infectados').modal('toggle');
        alert('selecciona todos los campos');
    } else {*/
        $('#loader').toggle();
        $('#modal_infectados').modal('toggle');
        var url_str = BASE_URL+ '/Administrativo/Rest_PerPatologicos/create_infecto';
        var alergiasForm = $("#form_perpatologicos").serializeArray();
        var loginFormObject = {};

        $.each(alergiasForm, function(i, v) {
            loginFormObject[v.name] = v.value;
        });

        $.ajax({
            url: url_str, // url where to submit the request
            type: "POST", // type of action POST || GET
            dataType: 'JSON', // data type
            data: JSON.stringify(loginFormObject), // post data || get data
            success: function(result) {
                //console.log(result);
                if (result.status == 200) {
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    reloadDatainfectados();
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_created').modal('toggle');
            },
            error: function(xhr, text_status) {
                //console.log(xhr, text_status);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_created').modal('toggle');
            }
        });

    //}
});




//TABLA INFECTOCONTAGIOSAS//

let dataTableinfectado = $('#table_infectados').DataTable({
    'ajax' : {
        'url' :  BASE_URL+'/Administrativo/Rest_PerPatologicos/get_infecto',
        'data' : { 'id_paciente' : id_paciente },
        'type' : 'post',
       
    }, 
    columns: [

        {
            data: 'Name'
        },

        {
            data: "Id",
            render: function(data, type, row, meta) {
                return '<button type="button" id="' + row.Id + '" data-toggle="modal" data-target="#modal_delete_infectados" class="ml-1 btn btn btn-danger btn_infectados btnborder pd-x-20"><i class="fa fa-trash-o mr-1" aria-hidden="true"></i>ELIMINAR</button>'
            }
        },
    ],
    "bPaginate": false,
    "searching": false,
});

function reloadDatainfectados() {
    $('#loader').toggle();
    dataTableinfectado.ajax.reload();
    $('#loader').toggle();
}


//borrar enfermedades infectocontagiosas//

function get_id_infectados() {
    $(document).on('click', '.btn_infectados', function() {
        let id_butona = $(this).attr('id');
        $('#input_infectados').val(id_butona);

    });
}

//Borrar infecciosas
function sendFormDel_infecciosas() {
    $(document).on('click', '#borrar_infecciosas', function() {
        $('#loader').toggle();
        var url_str = BASE_URL+ '/Administrativo/Rest_PerPatologicos/delete_infecto';
        var Form = $("#delete_form_infectados").serializeArray();
        var FormObject = {};
        $.each(Form,
            function(i, v) {
                FormObject[v.name] = v.value;
            }
        );
        $.ajax({
            url: url_str,
            type: "POST",
            dataType: 'json',
            data: JSON.stringify(FormObject),
            success: function(result) {
                if (result.status == 200) {
                    //console.log(result);
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    reloadDatainfectados();
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_delete_infectados').modal('toggle');
            },
            error: function(xhr, resp, text) {
                //console.log(xhr, resp, text);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_deletemodal_delete_infectados_cirugias').modal('toggle');
            }
        })
    });
}


//select enfermedades de la infancia//
function get_infancia() {
    //alert("dentro de la funcion");
    const enfermedad =  BASE_URL+ '/Administrativo/Rest_PerPatologicos/get_infancia';
    var enfermedades = $("#tipica");
    $.ajax({
        url: enfermedad,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            //console.log(data);
            const ch = data['data'];
            $(ch).each(function(i, v) { // indice, valor
                enfermedades.append('<option  value="' + v.nombre_comun + '">' + v.nombre_comun + '</option>');
            })
        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}

//tabla enfermedades de la infancia//

let dataTablenfermedadesi = $('#table_enfermedades_infancia').DataTable({
    'ajax' : {
        'url' : BASE_URL+ '/Administrativo/Rest_PerPatologicos/get_enfermedades_infancia',
        'data' : { 'id_paciente' : id_paciente },
        'type' : 'post',
       
    }, 

    columns: [

        {
            data: 'Name'
        },

        {
            data: "Id",
            render: function(data, type, row, meta) {
                return '<button type="button" id="' + row.Id + '" data-toggle="modal" data-target="#modal_delete_infancia" class="ml-1 btn btn btn-danger btn_infancia btnborder pd-x-20"><i class="fa fa-trash-o mr-1" aria-hidden="true"></i>ELIMINAR</button>'
            }
        },
    ],
    "bPaginate": false,
    "searching": false,
});

function reloadDataenfermedadesi() {
    $('#loader').toggle();
    dataTablenfermedadesi.ajax.reload();
    $('#loader').toggle();
}


///GUARDAR ENFERMEDADES DE LA INFANCIA///
$(document).on('click', '#guardar_infancia', function() {
    if ($("#tipica").val().length < 1) {
        $('#modal_infancia').modal('toggle');
        alert('selecciona todos los campos');

    } else {
        $('#loader').toggle();
        $('#modal_infancia').modal('toggle');
        var url_str = BASE_URL+ '/Administrativo/Rest_PerPatologicos/create_infancia';
        var alergiasForm = $("#form_perpatologicos").serializeArray();
        var loginFormObject = {};

        $.each(alergiasForm, function(i, v) {
            loginFormObject[v.name] = v.value;
        });

        $.ajax({
            url: url_str, // url where to submit the request
            type: "POST", // type of action POST || GET
            dataType: 'JSON', // data type
            data: JSON.stringify(loginFormObject), // post data || get data
            success: function(result) {
                console.log(result);
                if (result.status == 200) {
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    reloadDataenfermedadesi();
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_created').modal('toggle');
            },
            error: function(xhr, text_status) {
                //console.log(xhr, text_status);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_created').modal('toggle');
            }
        });

    }
});


///BORRAR INFANCIA//
function get_id_infancia() {
    $(document).on('click', '.btn_infancia', function() {
        let id_butona = $(this).attr('id');
        $('#input_infancia').val(id_butona);

    });
}

//Borrar infancia
function sendFormDel_infancia() {
    $(document).on('click', '#borrar_infancia', function() {
        $('#loader').toggle();
        var url_str = BASE_URL+ '/Administrativo/Rest_PerPatologicos/delete_infancia';
        var Form = $("#delete_form_infancia").serializeArray();
        var FormObject = {};
        $.each(Form,
            function(i, v) {
                FormObject[v.name] = v.value;
            }
        );
        $.ajax({
            url: url_str,
            type: "POST",
            dataType: 'json',
            data: JSON.stringify(FormObject),
            success: function(result) {
                if (result.status == 200) {
                    console.log(result);
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    reloadDataenfermedadesi();
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_delete_infancia').modal('toggle');
            },
            error: function(xhr, resp, text) {
                //console.log(xhr, resp, text);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_delete_infancia').modal('toggle');
            }
        })
    });
}

//ENFERMEDADES BASE//

//select de enfermedades base//
function get_base() {
    //alert("dentro de la funcion");
    const enfermedad =  BASE_URL+ '/Administrativo/Rest_PerPatologicos/base';
    var enfermedades = $("#enfermedades_base");
    $.ajax({
        url: enfermedad,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log(data);
            const ch = data['data'];
            enfermedades.append('<option  value="">Selecciona enfermedad base</option>');
            $(ch).each(function(i, v) { // indice, valor
                enfermedades.append('<option  value="' + v.CAPITULO + '">' + v.CAPITULO + '</option>');
            })
        },
        error: function(error) {
           // alert('hubo un error al enviar los datos');
        }
    });
}



$("#enfermedades_base").change(function() {
    const base =  $('#enfermedades_base').val();
    if(base === ""){
        $('#benfermedad').val("");
        $("#benfermedad").prop('disabled', true);

    }else{
        $('#benfermedad').val("");
        $("#benfermedad").prop('disabled', false);

        //predectivo enfermedad base//

        $("#benfermedad").keyup(function() {
            //var searchresult = document.getElementById("esResult");

            var especialidad = $('#benfermedad').val();
            var url_str = BASE_URL + "/Administrativo/Rest_PerPatologicos/enfermedades_base";
                var language = {
                    "enfermedad": especialidad,
                    "limit": "20",
                    "offset": "0",
                    "capitulo": base 
        
                };
                $.ajax({
                    url: url_str,
                    type: 'POST',
                    dataType: 'json',
                    data: JSON.stringify(language),
                    success: function(response) {
                        console.log(response)
                        let info = response.data;
                        console.log(info);
                        var len = info.length;
                        $("#esResult").empty();
                        for (var i = 0; i < len; i++) {
                            //var id = info[i].ID;
                            var name = info[i].NOMBRE;
                            //console.log(searchResult)
                            $("#esResult").append("<li value='" + name + "'>" + name + "</li>");
        
                        }
                        // binding click event to li
                       $("#esResult li").bind("click", function() {
                            var value = $(this).text(); 
                            $("#benfermedad").val(value);
                            $("#esResult").empty(); 
                        }); 
                    }
                }); 
        });
         
    }    
});

//guardar base//

$(document).on('click', '#guardar_base', function() {
    if ($("#enfermedades_base").val().length < 1) {
        $('#modal_base').modal('toggle');
        alert('selecciona todos los campos');

    } else {
        $('#loader').toggle();
        $('#modal_base').modal('toggle');
        var url_str = BASE_URL + "/Administrativo/Rest_PerPatologicos/create_base";
        var alergiasForm = $("#form_perpatologicos").serializeArray();
        var loginFormObject = {};

        $.each(alergiasForm, function(i, v) {
            loginFormObject[v.name] = v.value;
        });

        $.ajax({
            url: url_str, // url where to submit the request
            type: "POST", // type of action POST || GET
            dataType: 'JSON', // data type
            data: JSON.stringify(loginFormObject), // post data || get data
            success: function(result) {
                console.log(result);
                if (result.status == 200) {
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    reloadDataenfermedadesb();
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_created').modal('toggle');
            },
            error: function(xhr, text_status) {
                //console.log(xhr, text_status);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_created').modal('toggle');
            }
        });

    }
});




//TABLA ENFERMEDADES BASE//

let dataTablenfermedadesB = $('#table_enfermedadesB').DataTable({
    'ajax' : {
        'url' : BASE_URL+ '/Administrativo/Rest_PerPatologicos/get_enfermedades_base',
        'data' : { 'id_paciente' : id_paciente },
        'type' : 'post',
       
    }, 
    columns: [

        {
            data: 'enfermedad'
        },
        {
            data: 'grupo'
        },

        {
            data: "id",
            render: function(data, type, row, meta) {
                return '<button type="button" id="' + row.id + '" data-toggle="modal" data-target="#modal_delete_base" class="ml-1 btn btn btn-danger btn_base btnborder pd-x-20"><i class="fa fa-trash-o mr-1" aria-hidden="true"></i>ELIMINAR</button>'
            }
        },
    ],
    "bPaginate": false,
    "searching": false,
});


function reloadDataenfermedadesb() {
    $('#loader').toggle();
    dataTablenfermedadesB.ajax.reload();
    $('#loader').toggle();
}

//borrar enfermedades base//
function get_id_base() {
    $(document).on('click', '.btn_base', function() {
        let id_butona = $(this).attr('id');
        $('#input_base').val(id_butona);

    });
}

//Borrar infancia
function sendFormDel_base() {
    $(document).on('click', '#borrar_base', function() {
        $('#loader').toggle();
        var url_str = BASE_URL + "/Administrativo/Rest_PerPatologicos/delete_base";
        var Form = $("#delete_form_base").serializeArray();
        var FormObject = {};
        $.each(Form,
            function(i, v) {
                FormObject[v.name] = v.value;
            }
        );
        $.ajax({
            url: url_str,
            type: "POST",
            dataType: 'json',
            data: JSON.stringify(FormObject),
            success: function(result) {
                if (result.status == 200) {
                    console.log(result);
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    reloadDataenfermedadesb();
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_delete_base').modal('toggle');
            },
            error: function(xhr, resp, text) {
                //console.log(xhr, resp, text);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_delete_base').modal('toggle');
            }
        })
    });
}

//personas patologicas//

$(document).on('click', '#guardar_per_pat', function() {
  /*   if ($("#transfusion").val().length < 1) {
        $('#modal_per_pat').modal('toggle');
        alert('selecciona todos los campos');

    } else { */
        $('#loader').toggle();
        $('#modal_per_pat').modal('toggle');
        var url_str = BASE_URL + "/Administrativo/Rest_PerPatologicos/created_per_patologicos";
        var periForm = $("#form_perpatologicos").serializeArray();
        var loginFormObject = {};

        $.each(periForm, function(i, v) {
            loginFormObject[v.name] = v.value;
        });

        $.ajax({
            url: url_str, // url where to submit the request
            type: "POST", // type of action POST || GET
            dataType: 'JSON', // data type
            data: JSON.stringify(loginFormObject), // post data || get data
            success: function(result) {
                console.log(result);
                if (result.status == 200) {
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    reloadDataservi();
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_created').modal('toggle');
            },
            error: function(xhr, text_status) {
                //console.log(xhr, text_status);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_created').modal('toggle');
            }
        });

    //}
});

//cirugias//

function get_procedimientos() {
    //alert("dentro de la funcion");
    const enfermedad =  BASE_URL+ '/Administrativo/Rest_PerPatologicos/get_procedimientos';
    var enfermedades = $("#procedimiento");
    $.ajax({
        url: enfermedad,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log(data)
            const ch = data['data'];
            $(ch).each(function(i, v) { // indice, valor
                enfermedades.append('<option  value="' + v.nombre + '">' + v.nombre + '</option>');
            })
        },
        error: function(error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}

//tabla//
let dataTablecirugias = $('#table_cirugias').DataTable({
    'ajax' : {
        'url' : BASE_URL+ '/Administrativo/Rest_PerPatologicos/get_cirugias',
        'data' : { 'id_paciente' : id_paciente },
        'type' : 'post',
       
    }, 

    columns: [

        {
            data: 'Name'
        },

        {
            data: "Id",
            render: function(data, type, row, meta) {
                return '<button type="button" id="' + row.Id + '" data-toggle="modal" data-target="#modal_delete_cirugias" class="ml-1 btn btn btn-danger btn_cirugias btnborder pd-x-20"><i class="fa fa-trash-0 mr-1" aria-hidden="true"></i>ELIMINAR</button>'
            }
        },
    ],
    "bPaginate": false,
    "searching": false,
});

function reloadDatacirugias() {
    $('#loader').toggle();
    dataTablecirugias.ajax.reload();
    $('#loader').toggle();
}

function get_id_cirugias() {
    $(document).on('click', '.btn_cirugias', function() {
        let id_butona = $(this).attr('id');
        $('#input_cirugias').val(id_butona);

    });
}

$(document).on('click', '#guardar_cirugias', function() {
    if ($("#procedimiento").val().length < 1) {
        $('#modal_cirugias').modal('toggle');
        alert('selecciona todos los campos');

    } else {
        $('#loader').toggle();
        $('#modal_cirugias').modal('toggle');
        var url_str = BASE_URL+'/Administrativo/Rest_PerPatologicos/create_cirugia';
        var alergiasForm = $("#form_perpatologicos").serializeArray();
        var loginFormObject = {};

        $.each(alergiasForm, function(i, v) {
            loginFormObject[v.name] = v.value;
        });

        $.ajax({
            url: url_str, // url where to submit the request
            type: "POST", // type of action POST || GET
            dataType: 'JSON', // data type
            data: JSON.stringify(loginFormObject), // post data || get data
            success: function(result) {
                console.log(result);
                if (result.status == 200) {
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    reloadDatacirugias();
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_created').modal('toggle');
            },
            error: function(xhr, text_status) {
                //console.log(xhr, text_status);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_created').modal('toggle');
            }
        });

    }
});


//borrar cirugias//
function sendFormDel_Cirugias() {
    $(document).on('click', '#borrar_cirugias', function() {
        $('#loader').toggle();
        var url_str = BASE_URL+'/Administrativo/Rest_PerPatologicos/delete_cirugias';
        var Form = $("#delete_form_cirugias").serializeArray();
        var FormObject = {};
        $.each(Form,
            function(i, v) {
                FormObject[v.name] = v.value;
            }
        );
        $.ajax({
            url: url_str,
            type: "POST",
            dataType: 'json',
            data: JSON.stringify(FormObject),
            success: function(result) {
                if (result.status == 200) {
                    console.log(result);
                    $('#success').text(result.messages.success);
                    $('#succes-alert').show();
                    reloadDatacirugias();
                } else {
                    $('#error').text(result.error);
                    $('#error-alert').show();
                }
                $('#loader').toggle();
                $('#modal_delete_cirugias').modal('toggle');
            },
            error: function(xhr, resp, text) {
                //console.log(xhr, resp, text);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
                $('#modal_delete_cirugias').modal('toggle');
            }
        })
    });
}





