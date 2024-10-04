<!-- Desarrollador: Airam Vargas
Fecha de creacion: 02 - octubre - 2023
Fecha de Ultima Actualizacion: 04 - octubre - 2023
Perfil: Recepcion
Descripcion: Imprimir ticket de orden de servicio  -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../../assets/css/HCV/operativo/Etiquetas.css" media="print"/>
</head>
            
<div class="row pt-0 mg-t-0 hidden-print" id="elementos">
    <div id="imagen" class="col-12"></div>
</div>
<div id="btnImprimir" class="mx-2 text-center hidden-print">
    <button class="btn btn-teal mr-1 col-2" id="imprimir">Imprimir ticket</button>
    <a id="ordenServicio" target="_blank"><button class="btn btn-purple ml-1 mr-1 col-2" id="imprimir_orden">Imprimir orden de servicio</button></a>
    <button class="btn btn-success ml-1 col-2" id="continuar">Continuar</button>
</div>

<script>
    let id_cotizacion = parseFloat(<?= $id; ?>);
</script>