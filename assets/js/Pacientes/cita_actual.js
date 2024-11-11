let getData = () => {
    $('#loader').toggle();
    let url = `${BASE_URL}Api/Pacientes/Consulta/getNombre/${id_cita}`;
    fetch(url).then(response => response.json()).catch(err => alert(err))
        .then(response => {
            console.log(response);
            $("#n_paciente").append(`<h3 class="text-left">Paciente: ${response[0]['paciente']}</h3>`)
            $("#div_folio").append(`<h3 class="text-center">Folio: ${response[0]['id']}</h3>`)
            $('#loader').toggle();
        }).catch(err => alert(err))
}

getData();
//autoComplete_input();

//FUNCION PARA EL INPUT DE AUTOCOMPLETE
const autoCompleteJS = new autoComplete({
    placeHolder: "Buscar tratamiento...",
    threshold: 2,
    diacritics: true,
    data: {
    src: async (query) => {
        try {
            const source = await fetch(`${BASE_URL}Api/Catalogos/Procedimientos/readTratamiento/${query}`);
            const data = await source.json(); 
            return data;
        } catch (error) {
            return error;
        }
    },
        keys: ["nombre", "precio"],
    },

    resultsList: {
        tag: "ul",
        id: "autoComplete_list",
        class: "results_list",
        destination: "#autoComplete",
        position: "afterend",
        maxResults: 100,
        noResults: true,
        element: (list, data) => {
            if(!data.results.length){
            $('#actualizar').hide();
            const message = document.createElement("div");
            message.setAttribute("class", "no_result");
            message.innerHTML = `<span class="pd-x-20">Ningún resultado para "${data.query}". Agregue los datos del paciente para continuar.</span> 
            <br><br>`;
            list.appendChild(message);
            } else {
            const message = document.createElement("div");
            message.setAttribute("class", "no_result");
            list.appendChild(message);
            }
            list.setAttribute("data-parent", "food-list");
        },
    },
    
    resultItem: {
    highlight: true,
        element: (item, data) => {
            
            item.innerHTML = `
            <span style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden; color: black !important; font-size: 1.2rem !important">
            ${data.match}
            </span>
            
            <span style="display: flex; align-items: center; font-size: 13px; font-weight: 100; color: black !important; text-transform: uppercase; font-size: 1rem !important" color: rgba(0,0,0,.2);">
            $${data.value.precio}
            </span>`;
            $('#actualizar').show();
        },
    },

    events: {
        input: {
            selection: (event) => {
                $("#autoComplete").val(event.detail.selection.value.nombre)
                $("#precio").val(event.detail.selection.value.precio)
                $("#id_tratamiento").val(event.detail.selection.value.id)
                $("#id_paciente").val(id_paciente)
                $("#folio").val(id_cita)
            }
        }
    }
});