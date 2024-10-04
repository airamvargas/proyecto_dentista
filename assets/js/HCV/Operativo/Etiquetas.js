
getDatos();

var btnReimprimir = 0;

function getDatos(){
    $("#elementos").children().remove();
    $("#btnImprimir").children().remove();
    let URL = `${BASE_URL}Api/HCV/Operativo/TomarMuestras/barCode/${id_cita}`;
    fetch(URL).then((response) => response.json()).catch((err) => alert(err))
    .then((response) => {
        $("#toolbarContainer").addClass('hidden-print');
        n_labels = response['datos'][0]['n_labels'];
        codigo = response['extra']['codigo'];
        for (var i = 0; i <= (n_labels -1); i++) {
            let etiquetas = `<div class="etiquetas col-12 mg-t-0 mg-b-0"> 
                <div id="nombre" class="text-etiqueta-nombre" style="margin: 0;"><p style="margin: 0;">${response['datos'][0]['paciente']}</p></div>
                <div id="fecha" class="text-etiqueta-fecha row">
                    <p style="margin: 0;">
                        <span class="col-4">FN: ${moment(response['datos'][0]['BIRTHDATE']).format('DD/MM/YYYY')}</span> 
                        <span class="col-4">Edad:${response['extra']['edad']}</span>
                        <span class="col-4">Sexo:${response['extra']['genero']}</span>
                    </p>
                </div>
                <svg class="barcode"></svg>
                <div id="otros"class="text-etiqueta-otros">
                    <p style="margin: 0;">${response['datos'][0]['contenedor']} ${response['datos'][0]['tipo_muestra']}</p>
                </div>
            </div>`;
            $("#elementos").append(etiquetas);
            $("#elementos").addClass('hidden-print');
        }
        mifuncion(codigo);
        if(response['datos'][0]['imprimir'] == 1){
            let btnImprimir = `<button id="reimprimir" class="btn btn-warning active btn-block mg-b-10 codigo col-4" data-cita="${response['datos'][0]['id']}">Reimprimir etiqueta(s)</button>`
            $("#btnImprimir").append(btnImprimir);
        } else {
            let btnImprimir = `<button id="imprimir" class="btn btn-primary active btn-block mg-b-10 codigo col-4">Imprimir etiqueta(s)</button>`
            $("#btnImprimir").append(btnImprimir);
        }
        
    });            
}

$(document).on('click', '#imprimir', function() {
    $("#elementos").removeClass('hidden-print');
    let url = `${BASE_URL}Api/HCV/Operativo/TomarMuestras/imprimirEtiqueta`
    let FORMDATA = new FormData();
    FORMDATA.append('id', id_cita);
    fetch(url, {
        method: "POST",
        body: FORMDATA,
    }).then(response => response.json()).catch(err => alert(err))
    .then(response => {
        if(response.status == 200){
            $("#btnImprimir").addClass('hidden-print');
            window.print();
            getDatos();
        }
    }).catch(err => alert(err))
});

$(document).on('click', '#reimprimir', function() {
    let id = $(this).data('cita');
    $('#id_cita').val(id);
    $('#modal_delete').modal('toggle');
});

//Formulario incidencia para reimprimir
$(document).on('submit', '#form_reimprimir', function (evt) {
    evt.preventDefault();
    let url = `${BASE_URL}Api/HCV/Operativo/TomarMuestras/reimprimir`
    let FORMDATA = new FormData($(this)[0])
    $('#modal_delete').modal('toggle');
    document.getElementById('form_reimprimir').reset()
    fetch(url, {
      method: "POST",
      body: FORMDATA,
    }).then(response => response.json()).catch(err => alert(err))
      .then(response => {
        if(response.status == 200){
            $("#elementos").removeClass('hidden-print');
            $("#btnImprimir").addClass('hidden-print');
            window.print(); 
            getDatos();
        }
    }).catch(err => alert(err))
});

function mifuncion(n){
    JsBarcode('.barcode', codigo.toString(), {
        format: "CODE128C",
        ean128: true,
        lineColor: "#000",
        width: 1.2,
        height: 27,
        display: true,
        fontOptions: "bold",
        fontSize: 12,
        margin: 3,
    });
} 