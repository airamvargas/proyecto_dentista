/* Desarrollador: Airam Vargas
Fecha de creacion: 11 - octubre - 2023
Fecha de Ultima Actualizacion: 25 - octubre - 2023
Perfil: Capturista de resultados
Descripcion: Captura de resultados de las muestras */

$(document).ready(function () {
    //promesa para carga asincrona
    let promise = new Promise(function (resolve, reject) {
        setTimeout(() => resolve(), 1000);
    })
    promise.then(getAnalitos()).catch(err => alert(err));
});

//Obtener analitos del estudio
let getAnalitos = () => {
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Resultados/Captura/getDatos/${id_cita}`;
    fetch(url).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            analitos = response['analitos'];
            errores = response['error'];
            //console.log("HOLA");
            //console.log(response);
            $("#name_study").append(response['estudio']);
            if(errores.length > 0 || analitos.length > 0){
                if(errores.length > 0){ 
                    let inputs = `<div class="col-lg-12 mg-t-20">
                        <h5 style="color: red;">ANALITOS SIN RANGO DE EDAD</h5>
                        <small class="form-text text-muted">Los siguientes analitos no tienen un rango de edad para este paciente favor de comunicarse con el administrador para realizar el ajuste indicado</small><br><br>`;


                    $('#errores').append(inputs);
                    errores.forEach((v, i) => {
                        let inputs = `<div class="col-lg-12">
                        <li>${v[0].analito}</li>`
                        $('#errores').append(inputs);
                    });

                    const fotter = `<div class="form-layout-footer mg-t-20">
                    <a href="${BASE_URL}/Responsable_sanitario/Muestras"><button type="button"  class="btn btn-primary cancelar">Regresar</button></a>
                    </div>`;
                    $('#errores').append(fotter);
                } else {
                    analitos.forEach((v, i) => {
                        switch (v[0].result) {
                            case "1":
                                const number = `<div class="col-lg-4">
                                    <div class="form-group">
                                        <label  class="form-control-label">${v[0].name}: <span class="tx-danger">*</span><span><small class="form-text text-muted">min: ${v[0].min} max: ${v[0].max}</small></span></label>
                                            <input title="datos numericos" step="any"  class="form-control" type="number" name="resultado[]" required >
                                            <input  class="form-control" type="hidden" name="analito[]" value="${v[0].name}" required>
                                            <input class="form-control" type="hidden" name="id_analito[]" value="${v[0].id_exam}" required>
                                            <input class="form-control" type="hidden" name="tipo[]" value="${v[0].result}" required >
                                    </div>
                                </div>`
            
                                    $('#insert_analitos').append(number);
        
                            break;
        
                            case "2":
                                let text = `<div class="col-lg-4">
                                    <div class="form-group">
                                        <label  class="form-control-label">${v[0].name}: <span class="tx-danger">*</span> <span> <small id="emailHelp" class="form-text text-muted">referencia: ${v[0].min}</small></span></label>
                                            <input class="form-control" type="text" name="resultado[]" required>
                                            <input class="form-control" type="hidden" name="analito[]" value="${v[0].name}" required">
                                            <input class="form-control" type="hidden" name="id_analito[]" value="${v[0].id_exam}" required">
                                            <input class="form-control" type="hidden" name="tipo[]" value="${v[0].result}" required">
                                    </div>
                                </div>`
                                $('#insert_analitos').append(text);
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
                                            <input class="form-control" type="hidden" name="id_analito[]" value="${v[0].id_exam}" required">
                                            <input class="form-control" type="hidden" name="tipo[]" value="${v[0].result}" required">
                                    </div>
                                </div>`
                                $('#insert_analitos').append(neutro);
                            break;
                        }
                    });
                    const fotter = `<div id="botones" class="col-12 row justify-content-end mg-t-20">
                        <button class="btn btn-success  mg-r-5">Guardar</button>
                        <a href="${BASE_URL}Resultados/Captura"><button type="button"  class="btn btn-danger cancelar">Cancelar</button></a>
                    </div>`;
    
                    $('#insert_analitos').append(fotter);
                }
            } else {
                let mensaje = `<div class="col-12 row justify-content-center mg-t-20">
                    <h4>NO HAY ANALITOS REGISTRADOS EN ESTE ESTUDIO, COMUNICATE CON EL ADMINISTRADOR</h4>
                </div>`;
                let boton = `<div class="col-12 row justify-content-center mg-t-20">
                    <button id="cancelar" type="button" class="btn btn btn-danger pd-x-20">Cancelar</button>
                </div>`;
                $("#insert_analitos").append(mensaje); 
                $("#insert_analitos").append(boton);
            }

        $('#loader').toggle();
    }).catch(err => alert(err))
}

$(document).on('click', '#cancelar', function(){
    location.href = `${BASE_URL}Resultados/Captura`
});

$(document).on('submit', '#insert_analitos', function(e) {
    e.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}${CONTROLADOR}/insertAnalitos`;
    let FORMDATA = new FormData($(this)[0]);
    FORMDATA.append('id_cita', id_cita);
    FORMDATA.append('id_paciente', id_paciente)
    send(url, FORMDATA);
});

let send = (url, data, reload, modal, form, ref) => {
    fetch(url, {
        method: "POST",
        body: data,
    }).then(response => response.json()).catch(err => alert(err)).then(response => {
        if(response.status == 200 ){
            Toastify({
                text: response.msg,
                duration: 3000,
                className: "info",
                avatar: BASE_URL + "../../assets/img/correcto.png",
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
                offset: {
                    x: 50,
                    y: 90 
                },
            }).showToast();
            location.href = `${BASE_URL}Resultados/Captura`;
        }else {
            Toastify({
                text: response.msg,
                duration: 5000,
                className: "info",
                avatar: BASE_URL + "../../assets/img/cancelar.png",
                style: {
                    background: "linear-gradient(to right, #f26504, #f90a24)",
                },
                offset: {
                    x: 50,
                    y: 90
                },
            }).showToast();   
            $('#loader').toggle(); 
        }
        
    }).catch(err => alert(err))
}
 

