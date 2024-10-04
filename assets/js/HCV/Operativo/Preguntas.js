//variable global
// pocicion del array solo sea 1 elemento
centinela = 0;
//longitud de los estudios
longitud = estudios.length - 1;


const formulario = (centinela) => {
    $('#loader').toggle();
    $('#formquestions').children().remove();
    console.log(estudios);
    estudios.forEach((element, index) => {
        //veamos que corresponda el index con el centinela del arreglo
        if (centinela == index) {
            id_estudio = element.id;
            let div = $('#studies' + element.id).length;
            if (div < 1) {
                let studies = `<div class="form-layout">
                                    <h5>${element.name}</h5>
                                    <div class="row mg-b-25" id="stydy${element.id}">
                                    </div>
                                </div>`;
                $('#formquestions').append(studies);

                if (preguntas.length > 0) {
                    preguntas.forEach((preguntas) => {
                        if (element.id == preguntas.id_study) {
                            switch (preguntas.type) {
                                case "1":
                                    let abiertas = `<div class="col-lg-4">
                                    <div class="form-group">
                                      <label  class="form-control-label">${preguntas.question}: <span class="tx-danger">*</span></label>
                                      <input class="form-control" type="text" name="respuesta[]" required" >
                                      <input class="form-control" type="hidden" name="pregunta[]" value="${preguntas.question}">
                                      <input class="form-control" type="hidden" name="tipo[]" value="${preguntas.type}">
                                    </div>
                                  </div>`
                                    $('#stydy' + element.id).append(abiertas);
                                    break;


                                case "2":
                                    let select = `<div class="col-lg-4">
                                    <div class="form-group mg-b-10-force">
                                      <label class="form-control-label">${preguntas.question} <span class="tx-danger">*</span></label>
                                      <input class="form-control" type="hidden" name="pregunta[]" value="${preguntas.question}">
                                      <input class="form-control" type="hidden" name="tipo[]" value="${preguntas.type}">
                                      <select id="se${preguntas.id}" name="respuesta[]" class="form-control select2" data-placeholder="Seleccona" required >
                                      </select>
                                    </div>
                                  </div> `;
                                    $('#stydy' + element.id).append(select);
                                    break;

                                case "3":
                                    let check = `<div class="col-lg-4">
                                    <div class="form-group mg-b-10-force">
                                      <label class="form-control-label">${preguntas.question} <span class="tx-danger">*</span></label>
                                      <input class="form-control" type="hidden" name="pregunta[]" value="${preguntas.question}">
                                      <input class="form-control" type="hidden" name="tipo[]" value="${preguntas.type}">
                                      <input class="form-control" type="hidden" name="respuesta[]" value="0"}">
                                      <div id="se${preguntas.id}" class="parsley-checkbox mg-b-0">
                                      </div>
                                    </div>
                                  </div> `;

                                    $('#stydy' + element.id).append(check);
                                    break;
                            }

                            valores.forEach((valores) => {
                                if (preguntas.id == valores.id_questions) {
                                    switch (preguntas.type) {
                                        case "2":
                                            $('#se' + preguntas.id).append(`<option  value="${valores.name}"> ${valores.name}</option>`);
                                            break;

                                        case "3":
                                            let check = ` <label class="ckbox"><input type="checkbox" name="values[]" value="${valores.name}" data-parsley-mincheck="2"
                                            data-parsley-class-handler="#cbWrapper" data-parsley-errors-container="#cbErrorContainer"><span>${valores.name}</span></label>`
                                            $('#se' + preguntas.id).append(check)
                                    }
                                }
                            })
                        }
                    })

                    let button = `<div class="form-layout-footer">
                    <button class="btn btn-success  mg-r-5">Guardar</button>
                    <button type="button"  class="btn btn-danger cancelar">Cancelar</button>
                  </div>`;
                    $('#formquestions').append(button);

                } else {
                    let snquestion = `<div class="col-lg-12">
                    <h3 style="color: red;" class="mt-5 text-center"> ESTUDIO SIN PREGUNTAS</h5>
                </div>`
                    $('#stydy' + element.id).append(snquestion);

                    let button = `<div class="form-layout-footer">
                    <button class="btn btn-success  mg-r-5">Continuar</button>
                    <button type="button"  class="btn btn-danger cancelar">Cancelar</button>
                  </div>`;
                    $('#formquestions').append(button);
                }
            }
        }
    });
    $('#loader').toggle();
}


// A $( document ).ready() block.
$(document).ready(function () {
    //$('#loader').toggle();
    formulario(centinela);
});

//send form
$(document).on('submit', '#formquestions', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/HCV/Operativo/Preguntas/createRequest`;

    let FORMDATA = new FormData($(this)[0])
    FORMDATA.append('id_estudio', id_estudio);
    fetch(url, {
        method: "POST",
        body: FORMDATA,
    }).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            if (response.status == 200) {
                if (centinela == longitud) {
                    window.location.href = BASE_URL + 'HCV/Operativo/TomarMuestras';
                } else {
                    $('#loader').toggle();
                    Toastify({
                        text: response.msg,
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

                    centinela = centinela + 1
                    formulario(centinela);

                }

            } else {
                Toastify({
                    text: response.msg,
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


            }
        }).catch(err => alert(err))

});

//Cancelar
$(document).on('click', '.cancelar', function () {
    $('#id_delete').val(id_estudio);
    $('#modal_delete').modal('toggle');
});

$(document).on('submit', '#form_delete_study', function (evt) {
    evt.preventDefault();
    $('#loader').toggle();
    let url = `${BASE_URL}Api/HCV/Operativo/Preguntas/CancelStudy`;

    let FORMDATA = new FormData($(this)[0])
    FORMDATA.append('id_estudio', id_estudio);

    fetch(url, {
        method: "POST",
        body: FORMDATA,
    }).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            if (response.status == 200) {
                if (centinela == longitud) {
                    window.location.href = BASE_URL + 'HCV/Operativo/TomarMuestras';
                } else {
                    $('#loader').toggle();
                    Toastify({
                        text: response.msg,
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
                    $('#modal_delete').modal('toggle');
                    centinela = centinela + 1
                    formulario(centinela);
                }

            } else {
                Toastify({
                    text: response.msg,
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


            }
        }).catch(err => alert(err))
});




