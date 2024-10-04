//FORMATO EN ESPAÑOL FECHA
get_clientes();
moment.locale("es");


function get_datos() {
  setTimeout(function () {
    console.log("aqui");
    update_import();
    get_images();
  }, 5000);
}

// FUNCIONES //
function get_clientes() {
  $('#loader').toggle();
  const url = `${BASE_URL}/Administrador/Pagos/get_clientes`;
  var empresas = $(".cliente");
  $.ajax({
    url: url,
    method: 'GET',
    dataType: 'json',
    success: function (data) {
      $(data).each(function (i, v) {
        empresas.append(`<option  value="${v.compra}"> ${v.razon_social}</option>`);
      })

      get_datos();

     
      
    },
    error: function (error) {
      //alert('hubo un error al enviar los datos');
    }
  });
}

var dataimport = $("#import-table").DataTable({
  order: [[0, 'desc']],
  ajax: {
    url: `${BASE_URL}/Importaciones/getImport`,
    data: {},
    type: "post",
  },

  lengthMenu: [
    [25, 10, 50, 100, 999999],
    ["25", "10", "50", "100", "Mostrar todo"],
  ],

  columns: [
    {
      data: "id",
      render: function (data, type, row, meta) {
        return '<p id="' + row.id + '">' + row.id + '</p>'
      }
    },
    {
      data: "numero_importacion"
    },
    {
      data: "name_maquina"
    },
    {
      data: "modelo"
    },
    {
      data: "razon_social"
    },
    {
      data: "name_proveedor"
    },
    {
      data: "puerto_origen"
    },
    {
      data: "tipo_carga"
    },
    {
      data: "fecha_zarpe",
      render: function (data, type, row, meta) {
        return moment(data).format("DD-MMM-YY");
      }
    },
    {
      data: "fecha_llegada",
      render: function (data, type, row, meta) {
        return moment(data).format("DD-MMM-YY");
      }
    },
    {
      data: "id",
      render: function (data, type, row, meta) {
        return `<div class="d-flex"><button type="button" id="${data}" class="btn btn-primary btn-update mr-1"><i class="fa fa-eye" aria-hidden="true"></i>
        Detalles</button> <button type="button" id="${data}" data-toggle="modal" data-target="#modal_delete" class="btn btn-danger btn-delete mr-1"><i class="fa fa-trash" aria-hidden="true"></i>
        Eliminar</button>`;
      },
    },
  ],
  "columnDefs": [
    {
      "targets": [0],
      "visible": false,
      "searchable": false
    }
  ],
  responsive: true,
  language: {
    searchPlaceholder: "Buscar...",
    sSearch: "",
    lengthMenu: '_MENU_ Filas por página',
  },
});

$("#nueva-importacion").on("click", function () {
  location.href = `${BASE_URL}Insert_import`;
});

$(document).on("click", ".btn-update", function () {
  let id = $(this).attr('id');
  $("#id_import").val(id);
  console.log(id);
  location.href = `${BASE_URL}Importaciones/update_import/${id}`;
});

/* if(id_importup != ""){
  get_images();
  update_import();
}
 */
$(".btn-cancel").on("click", function () {
  location.href = `${BASE_URL}Importaciones`;
});

$(document).on("click", ".btn-delete", function () {
  let id = $(this).attr('id');
  $("#id_import").val(id);
});

$(document).on("change", "#file-lading", function () {
  // alert("dentro");

  var filesCount = $(this)[0].files.length;
  var textbox = $(this).prev();
  var ext = $(this).val().split(".").pop();
  var archivo = document.getElementById("file-lading").files[0];

  if (ext == "pdf") {
    if (filesCount === 1) {
      var reader = new FileReader();
      reader.readAsDataURL(archivo);
      var fileName = $(this).val().split("\\").pop();
      textbox.text(fileName);
      reader.onloadend = function () {
        document.getElementById("file-lading").src = reader.result;
      };
    } else {
      textbox.text(filesCount + " files selected");
    }
  } else {
    $(this).val("");
    alert("el archivo debe ser un documento pdf");
  }
});

$(document).on("change", "#file-invoice", function () {
  // alert("dentro");

  var filesCount = $(this)[0].files.length;
  var textbox = $(this).prev();
  var ext = $(this).val().split(".").pop();
  var archivo = document.getElementById("file-invoice").files[0];

  if (ext == "pdf") {
    if (filesCount === 1) {
      var reader = new FileReader();
      reader.readAsDataURL(archivo);
      var fileName = $(this).val().split("\\").pop();
      textbox.text(fileName);
      reader.onloadend = function () {
        document.getElementById("file-invoice").src = reader.result;
      };
    } else {
      textbox.text(filesCount + " files selected");
    }
  } else {
    $(this).val("");
    alert("el archivo debe ser un documento pdf");
  }
});

$(document).on("change", "#file-packing", function () {
  // alert("dentro");

  var filesCount = $(this)[0].files.length;
  var textbox = $(this).prev();
  var ext = $(this).val().split(".").pop();
  var archivo = document.getElementById("file-packing").files[0];

  if (ext == "pdf") {
    if (filesCount === 1) {
      var reader = new FileReader();
      reader.readAsDataURL(archivo);
      var fileName = $(this).val().split("\\").pop();
      textbox.text(fileName);
      reader.onloadend = function () {
        document.getElementById("file-packing").src = reader.result;
      };
    } else {
      textbox.text(filesCount + " files selected");
    }
  } else {
    $(this).val("");
    alert("el archivo debe ser un documento pdf");
  }
});

$(document).on("change", "#file-pedimento", function () {
  // alert("dentro");

  var filesCount = $(this)[0].files.length;
  var textbox = $(this).prev();
  var ext = $(this).val().split(".").pop();
  var archivo = document.getElementById("file-pedimento").files[0];

  //if (ext == "pdf") {
    if (filesCount === 1) {
      var reader = new FileReader();
      reader.readAsDataURL(archivo);
      var fileName = $(this).val().split("\\").pop();
      textbox.text(fileName);
      reader.onloadend = function () {
        document.getElementById("file-pedimento").src = reader.result;
      };
    } else {
      textbox.text(filesCount + " files selected");
    }
  /*} else {
    $(this).val("");
    alert("el archivo debe ser una imagen");
  }*/
});

$(document).on("change", "#file-import", function () {
  // alert("dentro");

  var filesCount = $(this)[0].files.length;
  var textbox = $(this).prev();
  var ext = $(this).val().split(".").pop();
  var archivo = document.getElementById("file-import").files[0];

  /* if (ext == "pdf") { */
    if (filesCount === 1) {
      var reader = new FileReader();
      reader.readAsDataURL(archivo);
      var fileName = $(this).val().split("\\").pop();
      textbox.text(fileName);
      reader.onloadend = function () {
        document.getElementById("file-import").src = reader.result;
      };
    } else {
      textbox.text(filesCount + " files selected");
    }
  /* } else {
    $(this).val("");
    //alert("el archivo debe ser una imagen");
  } */
});

$(document).on("change", "#file-placa", function () {
  // alert("dentro");

  var filesCount = $(this)[0].files.length;
  var textbox = $(this).prev();
  var ext = $(this).val().split(".").pop();
  var archivo = document.getElementById("file-placa").files[0];

  if (ext == "jpg" || "png") {
    if (filesCount === 1) {
      var reader = new FileReader();
      reader.readAsDataURL(archivo);
      var fileName = $(this).val().split("\\").pop();
      textbox.text(fileName);
      reader.onloadend = function () {
        document.getElementById("file-placa").src = reader.result;
      };
    } else {
      textbox.text(filesCount + " files selected");
    }
  } else {
    $(this).val("");
    alert("el archivo debe ser una imagen");
  }
});

$(document).on("change", "#file-ficha", function () {
  // alert("dentro");

  var filesCount = $(this)[0].files.length;
  var textbox = $(this).next();
  var ext = $(this).val().split(".").pop();
  var archivo = document.getElementById("file-ficha").files[0];

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

$(".cliente").change(function () {
  // $('#myModal').modal('toggle');
  //$('#loader').toggle();
  let id = $(this).val();
  const url = `${BASE_URL}/Administrador/Pagos/getCompra`;
  $.ajax({
    url: url,
    type: 'POST',
    data: { 'id': id },
    dataType: 'json',
    success: function (data) {
      if (data) {
        $('#empresa').val(data[0].business_name);
        $('#maquina').val(data[0].name);
        $('#proveedor').val(data[0].name_proveedor);
        $('#id_proveedor').val(data[0].proveedor_id);
        $('#id_cliente').val(data[0].id_user);
        $('#model_maq').val(data[0].model);
        $('#puerto_origen').val(data[0].embark);
        $('#dom_ent').val(data[0].domocilio_entrega);
        //$('#file-ficha').val(data[0].file_path);
        if (data[0].file_path) {
          $(".ficha").remove();
          let ficha = $('#ficha');
          let html = '<label class="form-control-label">FICHA TECNICA:</label><a class="form-control" href="' + BASE_URL + '../../public/FichaTecnica/' + data[0].file_path + '" target="_blank"><img src="../../assets/img/pdf.png"> Ver archivo</a>';
          $(ficha).append(html);
        }
        //$('#loader').toggle();
      }
    },
  });
});

// importaciones //
$('#tipo_carga').change(function () {
  let valor = $(this).val();
  if (valor == "CARGA SUELTA") {
    $("#carga-suelta").show();

  } else {
    $("#carga-suelta").hide();
  }

});

$('#real_import').change(function () {
  var total = $("#total_pag").val();
  let total_currency = currency(total, { symbol: "$", separator: "," }).format();
  let real = $(this).val();
  let real_currency = currency(real, { symbol: "$", separator: "," }).format();
  let newStr = real_currency.slice(1);
  let newtotal = total_currency.slice(1);
  let newreal = newStr.replace(",", "");
  let newTotal = newtotal.replace(",", "");
  var saldo = parseFloat(newTotal) - parseFloat(newreal);
  var sal = currency(saldo, { symbol: "$", separator: "," }).format();
  $("#saldo").val(sal);
  $("#total_pag").val(total_currency);
  $("#real_import").val(real_currency);
});

$('#total_pag').keyup(function () {
  document.getElementById("real_import").value = "";
  document.getElementById("saldo").value = "";
});

$(document).on("click", ".btn-del-photo", function () {
  let id = $(this).attr('id');
  const url = `${BASE_URL}/Importaciones/delete_images`;
  $.ajax({
    url: url,
    type: 'POST',
    data: { 'id': id },
    dataType: 'json',
    success: function (data) {
      if (data == true) {
        $('#modal_ver').modal('toggle');
        $("#images").children().remove();
        $("#photos_ver").remove();
        get_images();
      }
    },
  });

});

function update_import() {

  const url = `${BASE_URL}/Importaciones/get_import`;
  $.ajax({
    url: url,
    type: 'POST',
    data: { 'id': id_importup },
    dataType: 'json',
    success: function (data) {
      if (data) {
        $('#id_import').val(id_importup);
        $('#num_importacion').val(data[0].numero_importacion);
        $('#cliente_update').val(data[0].id_cotization_x_product);
        //$("#cliente_update option[value= " + data[0].id_cotization_x_product + "]").attr("selected", true);
        $('#id_cliente').val(data[0].id_cliente);
        $('#maquina').val(data[0].name_maquina);
        $('#model_maq').val(data[0].modelo);
        $('#proveedor').val(data[0].name_proveedor);
        $('#id_proveedor').val(data[0].id_proveedor);
        $('#dom_ent').val(data[0].domicilio_entrega);
        $('#puerto_origen').val(data[0].puerto_origen);
        $('#puerto_destino').val(data[0].puerto_destino);
        $('#f_zarpe').val(data[0].fecha_zarpe);
        $('#f_llegada').val(data[0].fecha_llegada);
        $('#tipo_carga').val(data[0].tipo_carga);
        if (data[0].tipo_carga == "CARGA SUELTA") {
          $("#carga-suelta").show();
          $("#c-largo").val(data[0].largo);
          $("#c-ancho").val(data[0].ancho);
          $("#c-alto").val(data[0].alto);
          $("#c-peso").val(data[0].peso);
        } else {
          $("#carga-suelta").hide();
        }
        $('#arancelaria').val(data[0].fraccion_arancelaria);
        $('#monto').val(data[0].monto_declarado);
        $('#maritimo').val(data[0].costo_maritimo);
        $('#trerrestre').val(data[0].costo_terrestre);
        $('#total_pag').val(currency(data[0].total_pagado, { symbol: "$", separator: "," }).format());
        $('#real_import').val(currency(data[0].real_importacion, { symbol: "$", separator: "," }).format());
        $('#saldo').val(currency(data[0].saldo, { symbol: "$", separator: "," }).format());
        if (data[0].file_path) {
          $(".ficha").remove();
          let ficha = $('#ficha');
          let html = '<label class="form-control-label">FICHA TECNICA:</label><a class="form-control" href="' + BASE_URL + '../../public/FichaTecnica/' + data[0].file_path + '" target="_blank"><img src="../../../../assets/img/pdf.png"> Ver archivo</a>';
          $(ficha).append(html);
        }
        if (data[0].bill_of_lading) {
          let bill = $('#bill');
          let html = `<div class="col-sm-2 mg-t-10 mg-sm-t-50">
                        <i class="fa fa-file-pdf-o fa-3x text-danger" aria-hidden="true" id="text-val"></i> <br>
                        <a href = "${BASE_URL + '../../public/Importaciones/' + data[0].bill_of_lading}" target="_blank">Ver archivo </a> 
          </div>`;
          $(bill).append(html);
        }
        if (data[0].invoice) {
          let bill = $('#invoice');
          let html = `<div class="col-sm-2 mg-t-10 mg-sm-t-50">
                        <i class="fa fa-file-pdf-o fa-3x text-danger" aria-hidden="true" id="text-val"></i> <br>
                        <a href = "${BASE_URL + '../../public/Importaciones/' + data[0].bill_of_lading}" target="_blank">Ver archivo </a> 
          </div>`;
          $(bill).append(html);
        }
        if (data[0].packing_list) {
          let bill = $('#packing');
          let html = `<div class="col-sm-2 mg-t-10 mg-sm-t-50">
                        <i class="fa fa-file-pdf-o fa-3x text-danger" aria-hidden="true" id="text-val"></i> <br>
                        <a href = "${BASE_URL + '../../public/Importaciones/' + data[0].packing_list}" target="_blank">Ver archivo </a> 
          </div>`;
          $(bill).append(html);
        }
        if (data[0].pedimento) {
          let bill = $('#pedimento');
          let html = `<div class="col-sm-2 mg-t-10 mg-sm-t-50">
                        <i class="fa fa-file-text-o fa-3x text-info" aria-hidden="true" id="text-val"></i> <br>
                        <a href = "${BASE_URL + '../../public/Importaciones/' + data[0].pedimento}" target="_blank">Ver archivo </a> 
          </div>`;
          $(bill).append(html);
        }
        if (data[0].documentos_impo) {
          let bill = $('#documento-import');
          let html = `<div class="col-sm-2 mg-t-10 mg-sm-t-50">
                        <i class="fa fa-file-text-o fa-3x text-info" aria-hidden="true" id="text-val"></i> <br>
                        <a href = "${BASE_URL + '../../public/Importaciones/' + data[0].documentos_impo}" target="_blank">Ver archivo </a> 
          </div>`;
          $(bill).append(html);
        }
        $('#loader').toggle();
      }
    },
  });
}

function get_images() {
  const url = `${BASE_URL}/Importaciones/get_images`;
  $.ajax({
    url: url,
    type: 'POST',
    data: { 'id': id_importup },
    dataType: 'json',
    success: function (data) {
      if (data[0]) {
        let btn_ver = `<div id="photos_ver" class="col-2 mg-t-10 mg-sm-t-65"><button type="button" id="btn_ver" data-toggle="modal" data-target="#modal_ver" class="btn btn-primary mr-1"><i class="fa fa-eye" aria-hidden="true"></i>
        Ver</button></div>`;
        $("#photo").append(btn_ver);
        $(data).each(function (i, v) {

          let questions = `<div class="row">
                            <div class="col-sm-4 mg-t-10 ">
                              <img id="${v.id}" class="col-12" src="${BASE_URL + '../../public/Importaciones/' + v.name}" alt="First slide">
                            </div>
                            <div class="col-2 mg-t-40">
                              <button type="button" id="${v.id}" data-toggle="modal" data-target="#modal_delphoto" class="btn btn-danger btn-del-photo"><i class="fa fa-trash" aria-hidden="true"></i>
                              Eliminar</button>
                            </div>
          </div>`;

          $("#images").append(questions);
        });
      }
    },
  });
}



