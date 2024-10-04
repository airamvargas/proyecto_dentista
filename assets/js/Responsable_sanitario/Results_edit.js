const getResults = () => {
    $('#loader').toggle();
    bandera = parseFloat(resultados[0]['bandera'])
    console.log(bandera);
    if(bandera == 2){
        documento = `<div class="row col-12">
            <div class="col-12 col-lg-4">
                <h6 class="col-12 text-center mt-3 mt-lg-0">Archivo de Resultados</h6>
                <div class="col-lg-12 text-center mt-2 mt-lg-10 mg-t-10">
                    <i class="fa fa-file-pdf-o fa-3x text-danger" aria-hidden="true" id="text-val"></i> <br>
                    <a href="${BASE_URL}../../public/uploads/resultados/${resultados[0]['documento']}" class="down-doc">Ver archivo</a> 
                </div>
            </div>
            <div  class="col-lg-4 mg-b-25">
                <div class="col-sm-12 mg-t-20 mg-sm-t-0">
                    <label class="form-control-label">NUEVO ARCHIVO: </label>
                    <div class="file-drop-area">
                        <span class="choose-file-button">Subir Archivo</span>
                        <span id="name-file" class="file-message">Arrastra el archivo aqui</span>
                        <input title="Solo aceptan formatos PDF" id="file_documento" class="file-input" type="file" name="file_documento" accept=".pdf">
                    </div>
                </div>
                <input type="hidden" name="name_photo" value="${resultados[0]['documento']}">
                <input type="hidden" name="id_results" value="${resultados[0]['id']}">
                <input type="hidden" name="id_cita" value="${resultados[0]['id_cita']}">
            </div>
        </div>`
        $('#subir_archivo').append(documento);

        const fotter = `<div class="form-layout-footer">
            <button type="submit" class="btn btn-success pd-x-20">GUARDAR Y LIBERAR</button>
            <a href="${BASE_URL}/Responsable_sanitario/Muestras"><button type="button"  class="btn btn-danger cancelar">Cancelar</button></a>
        </div>`;

        $('#botones').append(fotter);
    } else {
        resultados.forEach((v, i) => {
            if (v.question_type == "1") {
                let inputs = `<div class="col-lg-4">
                <div class="form-group">
                    <label  class="form-control-label">${v.name_analito}: <span class="tx-danger">*</span><small class="form-text text-muted">min: ${v.referencia_min} max: ${v.referencia_max}</small></label>
                        <input title="datos numericos"  class="form-control" type="number" step="any" name="resultado[]" value="${v.answer_analito}" required >
                        <input class="form-control" type="hidden" name="id_result[]" value="${v.id}" required>
                        <input class="form-control" type="hidden" name="tipo[]" value="${v.question_type}" required>
                </div>
            </div>`
    
                $('#foranalitos').append(inputs);
    
            } else {
                let inputs = `<div class="col-lg-4">
                <div class="form-group">
                    <label  class="form-control-label">${v.name_analito}: <span class="tx-danger">*</span><small id="emailHelp" class="form-text text-muted">referencia: ${v.referencia_min}</small></label>
                    <input title="datos numericos"  class="form-control" type="text" name="resultado[]" value="${v.answer_analito}" required>
                    <input class="form-control" type="hidden" name="id_result[]" value="${v.id}" required>
                    <input class="form-control" type="hidden" name="tipo[]" value="${v.question_type}" required>
                </div>
            </div>`
    
                $('#foranalitos').append(inputs);
    
            }
    
        })
        const fotter = `<div class="form-layout-footer">
            <button class="btn btn-success  mg-r-5">Guardar y liberar</button>
            <a href="${BASE_URL}/Responsable_sanitario/Muestras"><button type="button"  class="btn btn-danger cancelar">Cancelar</button></a>
        </div>`;
    
        $('#fitter').append(fotter);
    }
    
    $('#loader').toggle();
}

getResults();


$(document).on('submit', '#formresults', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Responsable_sanitario/Muestras/updateAnalito`;
    let FORMDATA = new FormData($(this)[0]);
    let redirect = `Responsable_sanitario/muestras`;
    send(url, FORMDATA, false, false, false, redirect);
});

//ARCHIVO QUE SE VA A SUBIR
$(document).on('change', '#file_documento', function() {
    var filesCount = $(this)[0].files.length;
    var textbox = $(this).prev();
    var ext = $(this).val().split('.').pop();
    var archivo = document.getElementById("file_documento").files[0];

    if (ext == "pdf") {
        if (filesCount === 1) {
            var reader = new FileReader();
            reader.readAsDataURL(archivo);
            var fileName = $(this).val().split('\\').pop();
            textbox.text(fileName);
        } else {
            textbox.text(filesCount + ' files selected');
        }
    } else {
        $(this).val('');
        Toastify({
            text: "El archivo debe tener formato jpeg, png o jpg",
            duration: 3000,
            className: "info",
            style: {
                background: "linear-gradient(to right, red, orange)",
            },
            offset: {
                x: 50, 
                y: 90 
            },
        }).showToast();
    }
});

//Enviar archivo de resultados
$(document).on('submit', '#formSubir', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Resultados/Captura/editarArchivo`;
    let FORMDATA = new FormData($(this)[0]);
    let redirect = `Responsable_sanitario/Muestras`
    send(url, FORMDATA, false, false, false, redirect);
});

