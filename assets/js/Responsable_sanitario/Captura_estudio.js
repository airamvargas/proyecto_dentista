
const getAnalitos = () => {

    $('#loader').toggle();
    console.log(analitos);
    if (analitos.length > 0) {
        if (error.length > 0) {
            let inputs = `<div class="col-lg-12">
                <h5 style="color: red;">ANALITOS SIN RANGO DE EDAD</h5>
                <small class="form-text text-muted">Los siguientes analitos no tienen un rango de edad para este paciente favor de comunicarse con el administrador para realizar el ajuste indicado</small><br><br>`;


            $('#foranalitos').append(inputs);
            error.forEach((v, i) => {
                let inputs = `<div class="col-lg-12">
                <p>${v[0].analito}</p>`
                $('#foranalitos').append(inputs);
            });

            const fotter = `<div class="form-layout-footer">
            <a href="${BASE_URL}/Responsable_sanitario/Muestras"><button type="button"  class="btn btn-primary cancelar">Regresar</button></a>
        </div>`;
            $('#fitter').append(fotter);
            $('#loader').toggle();



        } else {
            analitos.forEach((v, i) => {

                switch (v[0].result) {
                    case "1":
                        const number = `<div class="col-lg-4">
                        <div class="form-group">
                            <label  class="form-control-label">${v[0].name}: <span class="tx-danger">*</span><span><small class="form-text text-muted">min: ${v[0].min} max: ${v[0].max}</small></span></label>
                                <input title="datos numericos" step="any"  class="form-control" type="number" name="resultado[]" required >
                                <input  class="form-control" type="hidden" name="analito[]" value="${v[0].name}" required>
                                <input class="form-control" type="hidden" name="id_analito[]" value="${v[0].id_analito}" required>
                                <input class="form-control" type="hidden" name="tipo[]" value="${v[0].result}" required >
                        </div>
                    </div>`

                        $('#foranalitos').append(number);

                        break;

                    case "2":
                        let text = `<div class="col-lg-4">
                        <div class="form-group">
                            <label  class="form-control-label">${v[0].name}: <span class="tx-danger">*</span> <span> <small id="emailHelp" class="form-text text-muted">referencia: ${v[0].min}</small></span></label>
                                <input class="form-control" type="text" name="resultado[]" required>
                                <input class="form-control" type="hidden" name="analito[]" value="${v[0].name}" required">
                                <input class="form-control" type="hidden" name="id_analito[]" value="${v[0].id_analito}" required">
                                <input class="form-control" type="hidden" name="tipo[]" value="${v[0].result}" required">
                        </div>
                    </div>`
                        $('#foranalitos').append(text);
                        break;

                    case "3":
                        let neutro = `<div class="col-lg-4">
                        <div class="form-group">
                            <label  class="form-control-label">${v[0].name}: <span class="tx-danger">*</span> <span> <small id="emailHelp" class="form-text text-muted">referencia: ${v[0].min}</small></span></label>
                            <select class="form-control" name="resultado[]" id="result">
                            <option value="SELECCIONA UN RESULTADO" selected disabled>Selecciona una opción</option>
                            <option value="Negativo">Negativo</option>
                            <option value="Positivo">Positivo</option>
                        </select>
                                <input class="form-control" type="hidden" name="analito[]" value="${v[0].name}" required">
                                <input class="form-control" type="hidden" name="id_analito[]" value="${v[0].id_analito}" required">
                                <input class="form-control" type="hidden" name="tipo[]" value="${v[0].result}" required">
                        </div>
                    </div>`
                        $('#foranalitos').append(neutro);

                }

            })
            const fotter = `<div class="form-layout-footer">
                            <button class="btn btn-success  mg-r-5">Guardar</button>
                            <a href="${BASE_URL}/Responsable_sanitario/Muestras"><button type="button"  class="btn btn-danger cancelar">Cancelar</button></a>
                        </div>`;

            $('#fitter').append(fotter);
            $('#loader').toggle();

        }

    } else {
        let inputs = `<div class="col-lg-12">
            <h2 style="color: red;">ESTUDIO SIN ANALITOS</h2>
            <small class="form-text text-muted font-weight-bold">No se encontraron analitos para este estudio, comunicarse con el administrador para que realizar el ajuste correspondiente.</small><br><br>`;
        $('#foranalitos').append(inputs);
        const fotter = `<div class="form-layout-footer">
                        <a href="${BASE_URL}/Responsable_sanitario/Muestras"><button type="button"  class="btn btn-primary cancelar">Regresar</button></a>
                    </div>`;
        $('#fitter').append(fotter);
        $('#loader').toggle();

    }
}

getAnalitos();


$(document).on('submit', '#formresults', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Responsable_sanitario/Muestras/results`;
    let FORMDATA = new FormData($(this)[0]);
    FORMDATA.append('id_cita', cita);
    FORMDATA.append('id_study', estudio);
    FORMDATA.append('id_paciente', paciente);
    let redirect = `Responsable_sanitario/muestras`;
    send(url, FORMDATA, false, false, false, redirect);
});

