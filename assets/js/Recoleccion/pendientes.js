/* Desarrollador: ULISES RODRIGUEZ GARDUÑO
Fecha de creacion: 5-10-2023
Fecha de Ultima Actualizacion: 5-10-2023 por ULISES RODRIGUEZ GARDU;O
Perfil: Recepcionista
Descripcion: JS MUESTRAS PENDIENTES */
var array_to_ship = Array();
var table = null;
$(document).ready(function() {
    //alert($("#month").val());
    //$('#loader').modal('toggle');
    on_scanner(); // init function
    var url_csv = BASE_URL + '/Api/Recoleccion/Pendientes';
    $.ajax({
        url: url_csv,
        type: "POST",
        data: {
        },
        success: function(result) {
            //define data array
            var tabledata = result.data;
            table = new Tabulator("#tab_pendientes", {
                data:tabledata, //assign data to table
                autoColumns:true, //create columns from data field names
                pagination:"local",       //paginate the data
                paginationSize:20, 
                renderHorizontal:"virtual",
                //collumns:collumns
                autoColumns:false,
                columns:[
                    {formatter:"rowSelection", titleFormatter:"rowSelection", hozAlign:"center", headerSort:false, cellClick:function(e, cell){
                      cell.getRow().toggleSelect();
                      //alert("selected");
                      array_to_ship.push(cell.getData());
                    }},
                    //{title:"Folio", field:"Folio", width:200},
                    {title:"Código", field:"Codigo", width:250, hozAlign:"right", sorter:"number"},
                    {title:"Fecha", field:"Fecha", sorter:"date"},
                    {title:"Hora", field:"Hora", hozAlign:"center"},
                    {title:"Tomador de muestra", field:"Tomador de muestra"},
                    {title:"Nombre de cliente", field:"Nombre Cliente"},
                    {title:"Unidad de negocio", field:"Unidad de negocio", hozAlign:"center"}
                  ]
                // autoColumnsDefinitions:function(definitions){
                //     definitions.forEach((column) => {
                //         //column.headerVertical=true
                //         column.cellClick = function(e, cell){
                //         let row = cell.getData();
                //         row.check =  {formatter:"rowSelection", titleFormatter:"rowSelection", hozAlign:"center", headerSort:false, cellClick:function(e, cell){
                //             cell.getRow().toggleSelect();
                //           }}
                //         //console.log(cell.getField());
                //         console.log(row);
                //         ///corrgir la fecha 
                //         //e - the click event object
                //         //cell - cell component
                //     }
                //         // if(column.title == 'Usuario'){
                //         //     column.headerFilter = true;
                //         //     column.headerVertical=false;
                            
                //         // }
                //     });
            
                //     return definitions;
                // }
                });
            //  table.on("rowSelectionChanged", function(data, rows){
            //     document.getElementById("select-stats").innerHTML = data.length;
            //   });
                //$('#loader').modal('toggle');
        },
        error: function(xhr, text_status) {
            //console.log(xhr, text_status);
            $('#loader').toggle();
            $('#error-alert').show();
            $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
    
        }
    })

    $(document).on("click", "#enviar", function (event) {
        $('#modal_delete').modal('toggle');
        var selectedData = table.getSelectedData();
        console.log(selectedData);
    });


    function reloadData(){
        var url_csv = BASE_URL + '/Api/Recoleccion/pendientes';
        $.ajax({
            url: url_csv,
            type: "POST",
            data: {
            },
            success: function(result) {
                //define data array
                var tabledata = result.data;
                table = new Tabulator("#tab_pendientes", {
                    data:tabledata, //assign data to table
                    autoColumns:true, //create columns from data field names
                    pagination:"local",       //paginate the data
                    paginationSize:20, 
                    renderHorizontal:"virtual",
                    //collumns:collumns
                    autoColumns:false,
                    columns:[
                        {formatter:"rowSelection", titleFormatter:"rowSelection", hozAlign:"center", headerSort:false, cellClick:function(e, cell){
                        //cell.getRow().toggleSelect();
                        alert("selected");
                        array_to_ship.push(cell.getData());
                        console.log(array_to_ship);
                        }},
                        //{title:"Folio", field:"Folio", width:200},
                        {title:"Codigo", field:"Codigo", width:250, hozAlign:"right", sorter:"number"},
                        {title:"Fecha", field:"Fecha", sorter:"date"},
                        {title:"Hora", field:"Hora", hozAlign:"center"},
                        {title:"Tomador de muestra", field:"Tomador de muestra"},
                        {title:"Nombre De Cliente", field:"Nombre Cliente"},
                        {title:"Unidad de negocio", field:"Unidad de negocio", hozAlign:"center"}
                    ]
                    // autoColumnsDefinitions:function(definitions){
                    //     definitions.forEach((column) => {
                    //         //column.headerVertical=true
                    //         column.cellClick = function(e, cell){
                    //         let row = cell.getData();
                    //         row.check =  {formatter:"rowSelection", titleFormatter:"rowSelection", hozAlign:"center", headerSort:false, cellClick:function(e, cell){
                    //             cell.getRow().toggleSelect();
                    //           }}
                    //         //console.log(cell.getField());
                    //         console.log(row);
                    //         ///corrgir la fecha 
                    //         //e - the click event object
                    //         //cell - cell component
                    //     }
                    //         // if(column.title == 'Usuario'){
                    //         //     column.headerFilter = true;
                    //         //     column.headerVertical=false;
                                
                    //         // }
                    //     });
                
                    //     return definitions;
                    // }
                    });
                //  table.on("rowSelectionChanged", function(data, rows){
                //     document.getElementById("select-stats").innerHTML = data.length;
                //   });
                    //$('#loader').modal('toggle');
            },
            error: function(xhr, text_status) {
                //console.log(xhr, text_status);
                $('#loader').toggle();
                $('#error-alert').show();
                $('#error').text(' HA OCURRIDO UN ERROR INESPERADO');
        
            }
        })
    }

    //fomulario cerrar caja
/*DELETE*/
$(document).on('submit', '#formRecieve', function (e) {
    e.preventDefault();
    $('#loader').toggle();
    $('#modal_delete').modal('toggle');
    var FORMDATA = new FormData($(this)[0]);
    let muestras = table.getSelectedData();
    FORMDATA.append('muestras', JSON.stringify(muestras));
    var selectedData = table.getSelectedData();
    const URL = `${BASE_URL}Api/Recoleccion/Pendientes/set_status`;
    $.ajax({
        url: URL,
        type: 'POST',
        data:FORMDATA,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            switch (data.status) {
                case 200:
                    reloadData();
                    $('#loader').toggle();
                    //notification library
                    Toastify({
                        text: data.msg,
                        duration: 3000,
                        className: "info",
                        avatar: BASE_URL + "../../assets/img/correcto.png",
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },
                    }).showToast();
                    reloadData();
                    break;
                case 202:
                    $('#loader').toggle();
                    //notification library
                    Toastify({
                        text: data.msg,
                        duration: 3000,
                        className: "info",
                        avatar: BASE_URL + "../../assets/img/correcto.png",
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },
                    }).showToast();
                    reloadData();
                    $('#myModal').modal('toggle');
                    break;
                case 400:
                    $('#loader').toggle();
                    Toastify({
                        text: data.msg,
                        duration: 3000,
                        className: "info",
                        avatar: BASE_URL + "../../assets/img/cancelar.png",
                        style: {
                            background: "linear-gradient(to right, #f90303, #fe5602)",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },

                    }).showToast();
                    $('#modal_delete').modal('toggle');
                    break;
            }
        },
        cache: false,
        contentType: false,
        processData: false
    }).fail(function (jqXHR, textStatus, errorThrown) {
        $('#loader').toggle();
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
                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 90 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
        }).showToast();
    });
    return false;
});

$(document).on("click", "#generate_file", function (event) {
    event.preventDefault();
    
    let muestras = table.getSelectedData();
    // let json = {
    //   muestras: muestras,
    // };
    console.log(muestras);
    var data = new FormData();
    data.append('muestras', JSON.stringify(muestras));

    var xhr = new XMLHttpRequest();
    xhr.open('POST', `${BASE_URL}/Recoleccion/pendientes/file`, true);
    xhr.responseType = 'arraybuffer';
    xhr.onload = function(e) {
       if (this.status == 200) {
          var blob=new Blob([this.response], {type:"application/pdf"});
          var link=document.createElement('a');
          link.href=window.URL.createObjectURL(blob);
          link.download="Entrega_"+new Date()+".pdf";
          link.click();
       }
    };
    xhr.send(data);
  });

function on_scanner() {
    let is_event = false; // for check just one event declaration
    let input = document.getElementById("scanner");
    input.addEventListener("focus", function () {
        if (!is_event) {
            is_event = true;
            input.addEventListener("keypress", function (e) {
                setTimeout(function () {
                    if (e.keyCode == 13) {
                        scanner(input.value); // use value as you need
                        input.select();
                    }
                }, 500)
            })
        }
    });
    document.addEventListener("keypress", function (e) {
        if (e.target.tagName !== "INPUT") {
            input.focus();
        }
    });
}

function scanner(value) {
    if (value == '') return;
   
    rows = table.getRows();
    var found = false;
    rows.forEach(element => {
        if(element.getData().Codigo == value){
            element.select();
            found = true;
        }
        console.log(element.getData().Codigo);
    });
    if(!found){
        alert("Not Found");
    }
    document.getElementById("scanner").value = "";
    
}
})