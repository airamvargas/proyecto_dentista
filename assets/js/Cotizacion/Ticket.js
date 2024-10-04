
getDatos();

function getDatos(){
    let URL = `${BASE_URL}Api/Cotizaciones/Generar_compra/ticket/${id_cotizacion}`;
    fetch(URL).then((response) => response.json()).catch((err) => alert(err))
    .then((response) => {
        $("#toolbarContainer").addClass('hidden-print');
        //let cotizacion = response['cotizacion'];
        let total = parseFloat(response['total'][0]['total']);
        Unidades(total);
        Decenas(total);
        Centenas(total);
        Miles(total);
        Millones(total);
        NumeroALetras(total)
        // Formato del ticket    
        let logo =  `<div class="container negro">
            <div class="row">
                <div class="col-12 text-center mb-0 pt-0">
                    <img src="${BASE_URL}../../assets/img/logo_doisy.jpg" alt="Logo doisy" class="img-fluid" style="width: 150px; height: 100px;"></img>
                </div>
            </div>
        </div>`;
        let fecha = moment(response['cotizacion'][0]['fecha']).format("DD/MM/YY");

        let ticket = `<div class="container negro">
            <div class="row">
                <div class="text-uppercase etiquetas col-12 mg-t-0 pt-0 mg-b-30">
                    <div id="nombre" class="" style="margin: 0; padding:0;">
                        <p style="margin: 0;"> <b>Folio de venta</b>: ${response['cotizacion'][0]['id']}</p>
                        <p style="margin: 0;"> <b>Fecha de venta</b>: ${fecha}</p>
                        <div class="mt-1" style="border: 1px dashed black;"></div>
                        <p style="margin: 0;"> <b>Sucursal: ${response['cotizacion'][0]['name_conpany']}</b> </p>
                        <p style="margin: 0; font-size:11px;">Domicilio: ${response['cotizacion'][0]['address']}</p>
                        <p style="margin: 0; font-size:11px;">RFC: ${response['cotizacion'][0]['rfc']}</p>
                        
                    </div>
                
                    <div class="mt-1" style="border: 1px dashed black;"></div>
                        <p style="margin: 0; font-size: 0.55rem;"><b>Recepcionista</b>:${response['cotizacion'][0]['recepcionista']}</p>
                    <div class="mb-1" style="border: 1px dashed black;"></div>

                    <p style="margin: 0;"><b>Paciente: ${response['cotizacion'][0]['paciente']}</b></p>

                    <div class="mb-1" style="border: 1px dashed black;"></div>

                    <table style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="quantity text-center" style="width:15%;">Cantidad</th>
                                <th class="description text-center" style="width:50%;">Estudio</th>
                                <th class="price text-center" style="width:25%;">Precio</th>
                            </tr>
                        </thead>
                        <tbody id="body_table"></tbody>
                    </table>
                    <p style="margin: 0; font-size: 0.55rem;">${NumeroALetras(total)}</p>
                    <p id="forma_pago" class="quantity" style="margin: 0; font-size: 0.55rem;">Forma de pago: </p>
                    
                    <div class="row justify-content-center text-center">
                        <div id="codigo-qr" class="col-6 row justify-content-center">
                            <img alt="Código QR" id="codigo">
                        </div>

                    </div>
                    <br>
                    <div class="mb-1" style="border: 1px dashed black;"></div>
                    <p style="margin: 0; font-size:11px;">Atención al cliente <br>
                    Teléfono:${response['cotizacion'][0]['tel_conpany']}</p>
                    <p style="margin: 0; font-size:11px;">Email:${response['cotizacion'][0]['email']}</p> 
                </div>
            </div>
        </div>`;
        
        $("#imagen").append(logo);
        $("#elementos").append(ticket);
        $(response['pagos']).each(function (i, v) {
            let forma_pago = `${v.forma_pago}, `;
            $("#forma_pago").append(forma_pago);
        });
        $(response['productos']).each(function (i, v) {
            let productos = `<tr>
                <td class="quantity text-center">${v.cantidad}</td>
                <td class="description text-center">${v.name}</td>
                <td class="price text-center">$${v.price}</td>
            </tr>`;
            $("#body_table").append(productos);
        });
        let total_table = `<tr class="mg-t-10">
            <td class="quantity text-center"><b>Total</b></td>
            <td class="description"></td>
            <td class="price text-center">$ <b>${response['total'][0]['total']}</b></td>
        </tr>`
        $("#body_table").append(total_table);
        qr_code(response['cotizacion'][0]['codigo_qr']);
        ordenServicio = document.getElementById('ordenServicio');
        url_orden = `${BASE_URL}OrdenServicio/Pendientes/imprimir/${id_cotizacion}`;
        ordenServicio.setAttribute("href", url_orden);
    });            
}
function qr_code(qr){
    new QRious({
        element: document.querySelector("#codigo"),
        value: `${BASE_URL}Resultados/Resultados_paciente/index/${qr}`, // La URL o el texto
        size: 140,
        backgroundAlpha: 1, // 0 para fondo transparente
        foreground: "#000000", // Color del QR
        level: "L", // Puede ser L,M,Q y H (L es el de menor nivel, H el mayor)
    });
}


$(document).on('click', '#imprimir', function() {
    $("#elementos").removeClass('hidden-print');
    window.print();
    $("#elementos").addClass('hidden-print');
});

$(document).on('click', '#continuar', function() {
    location.href = `${BASE_URL}OrdenServicio/Pendientes`;
});


function Unidades(total) {
    switch(total) {
        case 1: return "UN";
        case 2: return "DOS";
        case 3: return "TRES";
        case 4: return "CUATRO";
        case 5: return "CINCO";
        case 6: return "SEIS";
        case 7: return "SIETE";
        case 8: return "OCHO";
        case 9: return "NUEVE";
    }

    return "";
}//Unidades()

function Decenas(total){

    decena = Math.floor(total/10);
    unidad = total - (decena * 10);

    switch(decena)
    {
        case 1:
            switch(unidad)
            {
                case 0: return "DIEZ";
                case 1: return "ONCE";
                case 2: return "DOCE";
                case 3: return "TRECE";
                case 4: return "CATORCE";
                case 5: return "QUINCE";
                default: return "DIECI" + Unidades(unidad);
            }
        case 2:
            switch(unidad)
            {
                case 0: return "VEINTE";
                default: return "VEINTI" + Unidades(unidad);
            }
        case 3: return DecenasY("TREINTA", unidad);
        case 4: return DecenasY("CUARENTA", unidad);
        case 5: return DecenasY("CINCUENTA", unidad);
        case 6: return DecenasY("SESENTA", unidad);
        case 7: return DecenasY("SETENTA", unidad);
        case 8: return DecenasY("OCHENTA", unidad);
        case 9: return DecenasY("NOVENTA", unidad);
        case 0: return Unidades(unidad);
    }
}//Unidades()

function DecenasY(strSin, numUnidades) {
    if (numUnidades > 0)
    return strSin +  " Y " + Unidades(numUnidades)

    return strSin;
}//DecenasY()

function Centenas(total) {
    centenas = Math.floor(total / 100);
    decenas = total - (centenas * 100);

    switch(centenas)
    {
        case 1:
            if (decenas > 0)
                return "CIENTO "+ Decenas(decenas);
            return "CIEN";
        case 2: return "DOSCIENTOS " + Decenas(decenas);
        case 3: return "TRESCIENTOS " + Decenas(decenas);
        case 4: return "CUATROCIENTOS " + Decenas(decenas);
        case 5: return "QUINIENTOS " + Decenas(decenas);
        case 6: return "SEISCIENTOS " + Decenas(decenas);
        case 7: return "SETECIENTOS " + Decenas(decenas);
        case 8: return "OCHOCIENTOS " + Decenas(decenas);
        case 9: return "NOVECIENTOS " + Decenas(decenas);
    }

    return Decenas(decenas);
}//Centenas()

function Seccion(total, divisor, strSingular, strPlural) {
    cientos = Math.floor(total / divisor)
    resto = total - (cientos * divisor)

    letras = "";

    if (cientos > 0)
        if (cientos > 1)
            letras = Centenas(cientos) + " " + strPlural;
        else
            letras = strSingular;

    if (resto > 0)
        letras += "";

    return letras;
}//Seccion()

function Miles(total) {
    divisor = 1000;
    cientos = Math.floor(total / divisor)
    resto = total - (cientos * divisor)

    strMiles = Seccion(total, divisor, "MIL", "MIL");
    strCentenas = Centenas(resto);

    if(strMiles == "")
        return strCentenas;

    return strMiles + " " + strCentenas;
}//Miles()

function Millones(total) {
    divisor = 1000000;
    cientos = Math.floor(total / divisor)
    resto = total - (cientos * divisor)

    strMillones = Seccion(total, divisor, "UN MILLON DE", "MILLONES DE");
    strMiles = Miles(resto);

    if(strMillones == "")
        return strMiles;

    return strMillones + " " + strMiles;
}//Millones()

function NumeroALetras(total) {
    var data = {
        numero: total,
        enteros: Math.floor(total),
        centavos: (((Math.round(total * 100)) - (Math.floor(total) * 100))),
        letrasCentavos: "",
        letrasMonedaPlural: 'PESOS',//“PESOS”, 'Dólares', 'Bolívares', 'etcs'
        letrasMonedaSingular: 'PESO', //“PESO”, 'Dólar', 'Bolivar', 'etc'

        letrasMonedaCentavoPlural: "“CENTAVOS”",
        letrasMonedaCentavoSingular: "“CENTAVO”"
    };

    if (data.centavos > 0) {
        data.letrasCentavos = "CON " + (function (){
            if (data.centavos == 1){
                return Millones(data.centavos) + " " + data.letrasMonedaCentavoSingular;
            }
            else {
                return Millones(data.centavos) + " " + data.letrasMonedaCentavoPlural;
            }
                
        })();
    };

    if(data.enteros == 0)
        return "“CERO ”" + data.letrasMonedaPlural +" " + data.letrasCentavos;
    if (data.enteros == 1)
        return Millones(data.enteros) + " " + data.letrasMonedaSingular + " " + data.letrasCentavos;
    else
        return Millones(data.enteros) + " " + data.letrasMonedaPlural + " " + data.letrasCentavos;
}
