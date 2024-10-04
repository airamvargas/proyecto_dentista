//FORMATO EN ESPAÑOL FECHA
moment.locale("es");

get_empresas();
getClientes();

$(".clientes").change(function () {
   // $('#myModal').modal('toggle');
    let client = $(this).children("option:selected").data("index");
    $("#cliente").val(client);
    $('#loader').toggle();
    let id = $(this).val();
    const url = `${BASE_URL}/Administrador/Pagos/getCompra`;
    $.ajax({
        url: url,
        type: 'POST',
        data: {'id':id},
        dataType: 'json',
        success: function (data) {
            if(data){
                $("#empresa option[value= " + data[0].id_empresa + "]").attr("selected", true);
                $('#proveedor').val(data[0].name_proveedor);
                $('#id_proveedor').val(data[0].proveedor_id);
                $('#id_maquina').val(data[0].id_cat_products);
                $('#maquina').val(data[0].name);
                $('#modelo').val(data[0].model);
                $('#loader').toggle();

            }
        },
    });
});

$("#cliente").hide();
$("#cliente_update").hide();

$(document).on("change", "#file-pdf", function () {
    // alert("dentro");
  
    var filesCount = $(this)[0].files.length;
    var textbox = $(this).prev();
    var ext = $(this).val().split(".").pop();
    var archivo = document.getElementById("file-pdf").files[0];
  
    if (ext == "pdf") {
      if (filesCount === 1) {
        var reader = new FileReader();
        reader.readAsDataURL(archivo);
        var fileName = $(this).val().split("\\").pop();
        textbox.text(fileName);
        reader.onloadend = function () {
          document.getElementById("file").src = reader.result;
        };
      } else {
        textbox.text(filesCount + " files selected");
      }
    } else {
      $(this).val("");
      alert("el archivo debe ser un documento pdf");
    }
});

$(".check_model").on("click", function () {
    if ($(this).is(":checked")) {
        $("#modelo").prop("readonly", false);
    } else {
        $("#modelo").prop("readonly", true);
    }
});

$(".check_proveedor").on("click", function () {
    if ($(this).is(":checked")) {
        $("#proveedor").prop("readonly", false);
    } else {
        $("#proveedor").prop("readonly", true);
    }
});

$(".check_maquina").on("click", function () {
    if ($(this).is(":checked")) {
        $("#maquina").prop("readonly", false);
    } else {
        $("#maquina").prop("readonly", true);
    }
});

$(".check_cliente").on("click", function () {
    if ($(this).is(":checked")) {
        $("#id_cliente").hide();
        $("#cliente").show();
        $(".clientes").empty();
        $("#cliente").prop("required", true);
        $("#id_cliente").prop("required", false);
        /* document.getElementById("maquina").value = "";
        document.getElementById("modelo").value = "";
        document.getElementById("proveedor").value = ""; */
        
    } else {
        $("#id_cliente").show();
        $("#cliente").hide();
        $("#cliente").empty();
        getClientes();
        $("#id_cliente").prop("required", true);
        $("#cliente").prop("required", false);
    }
});

$("#cliente").keyup(function () {
    document.getElementById("id_cliente").value = "";
});

$("#maquina").keyup(function () {
    document.getElementById("id_maquina").value = 0;
});

$("#proveedor").keyup(function () {
    document.getElementById("id_proveedor").value = 0;
});

$("#tipo_cambio").change(function () {
    var usd = $("#usd_pago").val();
    let usd_currency = currency(usd, {symbol: "", separator: ",", precision: 2}).format();
    let cambio = $(this).val();
    let cambio_currency = currency(cambio, {symbol: "$", separator: ",", precision: 4}).format();
    let newStr = cambio_currency.slice(1);
    let newreal = newStr.replace(",","");
    let newTotal = usd_currency.replace(",","");
    var pesos = parseFloat(newTotal) * parseFloat(newreal);
    //console.log(pesos);
    var pesos_c = currency(pesos, {symbol: "$", separator: ",", precision: 2}).format();
    $("#pesos").val(pesos_c);
    $("#usd_pago").val(usd_currency);
    $("#tipo_cambio").val(cambio_currency); 
});

$("#usd_pago").change(function () {
  var usd = $(this).val();
  let usd_currency = currency(usd, {symbol: "", separator: ",", precision: 2}).format();
  let cambio = $("#tipo_cambio").val();
  let cambio_currency = currency(cambio, {symbol: "$", separator: ",", precision: 4}).format();
  let newStr = cambio_currency.slice(1);
  let newreal = newStr.replace(",","");
  let newTotal = usd_currency.replace(",","");
  var pesos = parseFloat(usd_currency) * parseFloat(newreal);
  var pesos_c = currency(pesos, {symbol: "$", separator: ",", precision: 2}).format();
  $("#pesos").val(pesos_c);
  $("#usd_pago").val(usd_currency);
  $("#tipo_cambio").val(cambio_currency);
});

$(document).on("change", "#file-pdf-up", function () {
    // alert("dentro");
  
    var filesCount = $(this)[0].files.length;
    var textbox = $(this).prev();
    var ext = $(this).val().split(".").pop();
    var archivo = document.getElementById("file-pdf-up").files[0];
  
    if (ext == "pdf") {
      if (filesCount === 1) {
        var reader = new FileReader();
        reader.readAsDataURL(archivo);
        var fileName = $(this).val().split("\\").pop();
        textbox.text(fileName);
        reader.onloadend = function () {
          document.getElementById("file").src = reader.result;
        };
      } else {
        textbox.text(filesCount + " files selected");
      }
    } else {
      $(this).val("");
      alert("el archivo debe ser un documento pdf");
    }
});


$(".check_clienteup").on("click", function () {
    if ($(this).is(":checked")) {
        $("#id_cliente_up").hide();
        $("#cliente_update").show();
        $(".clientes").empty();
        $("#cliente_update").prop("required", true);
        $("#id_cliente_up").prop("required", false);
        /* document.getElementById("maquina").value = "";
        document.getElementById("modelo").value = "";
        document.getElementById("proveedor").value = ""; */
        
    } else {
        $("#id_cliente_up").show();
        $("#cliente_update").hide();
        $("#cliente_update").empty();
        getClientes();
        $("#id_cliente_up").prop("required", true);
        $("#cliente_update").prop("required", false);
    }
});

$("#cliente_update").keyup(function () {
    document.getElementById("id_cliente_up").value = "";
});

$("#maquina_update").keyup(function () {
    document.getElementById("id_maquinaup").value = "";
});

$("#proveedor_update").keyup(function () {
    document.getElementById("id_proveedor_up").value = 0;
});

$("#cambio_update").change(function () {
    var usd = $("#usd_update").val();
    let usd_currency = currency(usd);
    let cambio = $(this).val();
    let cambio_currency = currency(cambio, {symbol: "$", separator: ",", precision: 4}).format();
    let newStr = cambio_currency.slice(1);
    let newreal = newStr.replace(",","");
    //let newTotal = usd_currency.replace(",","");
    var pesos = parseFloat(usd_currency) * parseFloat(newreal);
    var pesos_c = currency(pesos, {symbol: "$", separator: ",", precision: 2}).format();
    $("#pesos_update").val(pesos_c);
    $("#usd_update").val(usd_currency);
    $("#cambio_update").val(cambio_currency);
});

$("#usd_update").change(function () {
  var usd = $(this).val();
  let usd_currency = currency(usd);
  let cambio = $("#cambio_update").val();
  let cambio_currency = currency(cambio, {symbol: "$", separator: ",", precision: 4}).format();
  let newStr = cambio_currency.slice(1);
  let newreal = newStr.replace(",","");
  //let newTotal = usd_currency.replace(",","");
  var pesos = parseFloat(usd_currency) * parseFloat(newreal);
  var pesos_c = currency(pesos, {symbol: "$", separator: ",", precision: 2}).format();
  $("#pesos_update").val(pesos_c);
  $("#usd_update").val(usd_currency);
  $("#cambio_update").val(cambio_currency);
});



$(document).on("click", ".btn-update", function () {
    let id  = $(this).attr('id');
    let json = { id: id};

    $.ajax({
        url: `${BASE_URL}Administrador/Pagos_extranjero/get_datos`,
        type: "POST",
        data: json,
        dataType: "JSON",
        success: function (data) {
            if(data[0].id_cotizaticion_x_producto == 0){
                $("#id_cliente_up").hide();
                $("#cliente_update").show();
                $("#cliente_update").val(data[0].nombre_cliente);
            } else {
                $("#id_cliente_up option[value= " + data[0].id_cotizaticion_x_producto + "]").attr("selected", true);
                $("#cliente_update").val(data[0].nombre_cliente);
            }
            $("#empresa_update option[value= " + data[0].id_empresa + "]").attr("selected", true);
            $('#id_update').val(data[0].id);
            $('#fecha_update').val(data[0].fecha);
            $('#ref_update').val(data[0].referencia);
            $('#banco_update').val(data[0].banco);
            $('#usd_update').val(currency(data[0].usd, {symbol: "", separator: ",", precision: 2}).format());
            $('#cambio_update').val(data[0].tipo_cambio);
            $('#pesos_update').val(currency(data[0].pesos, {symbol: "$", separator: ",", precision: 2}).format());
            $('#proveedor_update').val(data[0].proveedor_name);
            $('#id_proveedor_up').val(data[0].id_proveedor);
            $('#id_maquinaup').val(data[0].id_maquina);
            $('#maquina_update').val(data[0].maquina_name);               
            $('#modelo_update').val(data[0].modelo);
            $('#pago_update').val(data[0].porciento);
            $('#loader').toggle();
        },
        error: function (error) {
            console.log(error);
        },
    }); //AJAX
});

$(document).on("click", ".btn-delete", function () {
  let id  = $(this).attr('id');
  $("#id_delete").val(id);

});

// FUNCIONES
function getClientes() {
    $('#loader').toggle();
    const url = `${BASE_URL}/Administrador/Pagos/get_clientes`;
    var empresas = $(".clientes");
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#loader').toggle();
            //const ch = data['data'];
            empresas.append(`<option  value=""> SELECCIONA CLIENTES </option>`);
            $(data).each(function (i, v) {
                empresas.append(`<option  value="${v.compra}" data-index="${v.razon_social}"> ${v.razon_social}</option>`);
            })

        },
        error: function (error) {
            //alert('hubo un error al enviar los datos');
        }
    });
}

function get_empresas() {
    const empresas = BASE_URL + "/Cotizaciones/get_empresas";
    var select = $(".empresa");
    $.ajax({
      url: empresas,
      method: "GET",
      dataType: "json",
      success: function (data) {
        const ch = data;
        $(ch).each(function (i, v) {
          select.append(
            '<option  value="' + v.id + '" >' + v.business_name + "</option>"
          );
        });
      },
      error: function (error) {
        alert("hubo un error al enviar los datos");
      },
    });
}