$("#agregar-estado").on("click", function () {
    $("#modal_agregar").modal("show");
});

get_empresas();

$(document).on("change", "#file-estado", function () {
    // alert("dentro");
  
    var filesCount = $(this)[0].files.length;
    var textbox = $(this).prev();
    var ext = $(this).val().split(".").pop();
    var archivo = document.getElementById("file-estado").files[0];
  
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

$(document).on("change", "#file-estado-update", function () {
    // alert("dentro");
  
    var filesCount = $(this)[0].files.length;
    var textbox = $(this).prev();
    var ext = $(this).val().split(".").pop();
    var archivo = document.getElementById("file-estado-update").files[0];
  
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

var data_statements = $("#estados-table").DataTable({
    ajax: {
      url: `${BASE_URL}Contabilidad/Estados_financieros/get_statements`,
      data: {},
      type: "post",
    },
  
    lengthMenu: [
      [50, 100, 999999],
      ["50", "100","Mostrar todo"],
    ],

    order: [[0, 'desc']],
  
    columns: [
      {
        data: "id",
      },
      {
        data: "year",
      },
      {
        data: "month",
      },
      {
        data: "business_name",
      },
      {
        data: "eeff",
      },
      {
        data: "pdf",
        render: function (data, type, row, meta) {
          return `<i class="fa fa-file-pdf-o fa-3x text-danger" aria-hidden="true" id="text-val"></i> <br>
          <a id="down_carta" href="${BASE_URL}/../../../public/Estados_financieros/${data}" class="down-doc" download>Ver archivo </a> `
        },
      },
      {
        data: "id",
        render: function (data, type, row, meta) {
          return `<div class="d-flex"><button type="button" id="${data}" data-toggle="modal" data-target="#modal_update" class="btn btn-warning btn-update mr-1"><i class="fa fa-pencil" aria-hidden="true"></i>
          Editar</button> <button type="button" id="${data}" data-toggle="modal" data-target="#modal_delete" class="btn btn-danger btn-delete mr-1"><i class="fa fa-trash" aria-hidden="true"></i>
          Eliminar</button>`;
        },
      },
    ],
    "columnDefs": [
      {
        "targets": [ 0 ],
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

$(document).on("click", ".btn-update", function (event) {
    event.preventDefault();
    
    let id_buton = $(this).attr("id");
    let json = {
      id: id_buton,
    };
    console.log(id_buton);

    $.ajax({
      url: `${BASE_URL}Contabilidad/Estados_financieros/get_statements_update`,
      type: "POST",
      data: json,
      dataType: "JSON",
      success: function (success) {
        switch (success[0].month) {
          case "Enero":
            mes = "01";
          break;
          case "Febrero":
            mes = "02";
          break;
          case "Marzo":
            mes = "03";
          break;
          case "Abril":
            mes = "04";
          break;
          case "Mayo":
            mes = "05";
          break;
          case "Junio":
            mes = "06";
          break;
          case "Julio":
            mes = "07";
          break;
          case "Agosto":
            mes = "08";
          break;
          case "Septiembre":
            mes = "09";
          break;
          case "Octubre":
            mes = "10";
          break;
          case "Noviembre":
            mes = "11";
          break;
          case "Diciembre":
            mes = "12";
          break;
        }
        fecha = success[0].year+"-"+mes+"-"+"01";
        $("#empresa_update").val(success[0].id_bussiness);
        $("#eeff_update").val(success[0].eeff);
        $("#id_updatef").val(success[0].id);
        $("#fecha_update").val(fecha);
      },
      error: function (error) {
        console.log(error);
      },
    }); //AJAX
}); 

$(document).on("click", ".btn-delete", function (event) {
  event.preventDefault();
  let id = $(this).attr("id");
  //console.log(id);
  $("#id_deletef").val(id);
  $("#modal_delete").modal("show");
});

// FUNCIONES
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