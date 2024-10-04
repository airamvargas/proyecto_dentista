<script src="../../../assets/lib/jquery/jquery.js"></script>

<link href="../../../assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
<link href="../../../assets/lib/select2/css/select2.min.css" rel="stylesheet">
<script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script src="https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js"></script>
<link href="<?= base_url() ?>../../../assets/lib/SpinKit/spinkit.css" rel="stylesheet">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script> -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap4.min.js"></script>  -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

<style>
    #datatable1 tbody td,
    th {
        text-align: center;
    }
</style>



<style>
    .dt-buttons {
    margin-bottom: 1rem !important;
}

.buttons-copy,
.buttons-csv,
.buttons-excel,
.buttons-pdf,
.buttons-print {
    background-color: #4561a7 !important;
    color: white;
    border-color: #4561a7;
    border-radius: 10px;
    font-size: 16px;
    margin-right: 14px;
    padding: 3px 10px;
}

.buttons-copy::before,
.buttons-csv::before,
.buttons-excel::before,
.buttons-pdf::before,
.buttons-print::before {
    font-family: "FontAwesome";
    margin-right: 4px;
}

.buttons-copy::before {
    content: '\f24d';
}

.buttons-csv::before {
    content: '\f0f6';
}

.buttons-excel::before {
    content: '\f1c3 ';
}

.buttons-pdf::before {
    content: '\f1c1';
}

.buttons-print::before {
    content: '\f02f';
}
</style>

<style>
    table.dataTable thead th, 
    table.dataTable thead td,
    #datatable1 tbody th, 
    table.dataTable tbody td {
        text-align: center !important;
    }
</style>

<!-- ########## START: MAIN PANEL ########## -->

<div id="loader" class="modal fade show" style=" padding-left: 0px; z-index: 999999999;">
  <div class="modal-dialog modal-dialog-vertical-center" role="document">
    <div class="d-flex ht-300 pos-relative align-items-center">
      <div class="sk-chasing-dots">
        <div class="sk-child sk-dot1 bg-red-800"></div>
        <div class="sk-child sk-dot2 bg-green-800"></div>
      </div>
    </div>
  </div>
</div>


<!-- CREAR PAGO -->

<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-success pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">AGREGAR NUEVO PAGO</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formPago" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Datos Pago</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row mg-b-25">
                            <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">FECHA DE PAGO: <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="date" name="fecha_pago" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">CLIENTE: <span><span
                                                    class="tx-danger">*</span></label>
                                        <select class="form-control clientes" name="cliente" id="cliente" required>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">EMPRESA: <span
                                                class="tx-danger"></span></label>
                                        <input id="empresa" class="form-control" type="text" class="form-control"
                                        disabled>
                                    </div>
                                </div><!-- col-4 -->


                               <!--  <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">EMPRESA: <span><span
                                                    class="tx-danger">*</span></label>
                                        <select class="form-control empresas" name="empresa" id="empresas" required>
                                        </select>
                                    </div>
                                </div> -->

                             

                               <!--  <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">MAQUINA: <span><span
                                                    class="tx-danger">*</span></label>
                                        <select class="form-control maquinas" name="producto" id="empresas" required>
                                        </select>
                                    </div>
                                </div> -->

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">MAQUINA: <span
                                                class="tx-danger"></span></label>
                                        <input id="maquina" class="form-control" type="text" class="form-control"
                                        disabled>
                                    </div>
                                </div><!-- col-4 -->

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">SERIE: <span
                                                class="tx-danger"></span></label>
                                        <input id="c-serie" type="text" class="form-control" name="serie" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">MODELO: <span
                                                class="tx-danger"></span></label>
                                        <input id="c-modelo" class="form-control" type="text" class="form-control" name="modelo"
                                        disabled>
                                    </div>
                                </div><!-- col-4 -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">CONCEPTO DE PAGO: <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="concepto" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">USD: <span
                                                class="tx-danger">*</span></label>
                                        <input id="uds" class="form-control" type="text" name="uds" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">T.C: <span
                                                class="tx-danger">*</span></label>
                                        <input id="tc" class="form-control" type="text" name="tc" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">PESOS: <span
                                                class="tx-danger">*</span></label>
                                        <input id="pesos" class="form-control" type="text" name="pesos" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">%: <span
                                                class="tx-danger">*</span></label>
                                        <input id="pesos" class="form-control" type="text" name="porciento" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">BANCO RECEPTOR: <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="banco" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">COMPROBANTE DE PAGO <span
                                                class="tx-danger">*</span></label>
                                        <label class="custom-file">
                                            <input type="file" id="file" class="custom-file-input" name="comprobante" required
                                                accept=".jpg, .png , .jpge , .pdf">
                                            <span class="custom-file-control custom-file-label"></span>
                                        </label>
                                    </div>
                                </div><!-- col-4 -->

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">FACTURA O RECIBO <span
                                                class="tx-danger">*</span></label>
                                        <label class="custom-file">
                                            <input type="file" id="file" class="custom-file-input" name="factura" required
                                            accept=".jpg, .png , .jpge , .pdf">
                                            <span class="custom-file-control custom-file-label"></span>
                                        </label>
                                    </div>
                                </div><!-- col-4 -->

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success pd-x-20">Agregar</button>
                    <button type="button" class="btn btn btn-danger pd-x-20" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div>

<!-- ACTUALIZAR PAGO-->

<div id="updateModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-warning  pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ACTUALIZAR PAGO</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUpdatePago" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Datos Pago</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row mg-b-25">
                            <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">FECHA DE PAGO: <span
                                                class="tx-danger">*</span></label>
                                        <input id="updfecha" class="form-control" type="date" name="fecha_pago" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">CLIENTE: <span><span
                                                    class="tx-danger">*</span></label>
                                        <select class="form-control clientes" name="cliente" id="empresas" required>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">EMPRESA: <span
                                                class="tx-danger"></span></label>
                                        <input id="updempresa" class="form-control" type="text" class="form-control"
                                        disabled>
                                    </div>
                                </div><!-- col-4 -->

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">MAQUINA: <span
                                                class="tx-danger"></span></label>
                                        <input id="updmaquina" class="form-control" type="text" class="form-control"
                                        disabled>
                                    </div>
                                </div><!-- col-4 -->


                              <!--   <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">EMPRESA: <span><span
                                                    class="tx-danger">*</span></label>
                                        <select class="form-control empresas" name="empresa" id="empresas" required>
                                        </select>
                                    </div>
                                </div> -->
<!-- 
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">CLIENTE: <span><span
                                                    class="tx-danger">*</span></label>
                                        <select class="form-control clientes" name="cliente" id="empresas" required>
                                        </select>
                                    </div>
                                </div> -->

                              <!--   <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">MAQUINA: <span><span
                                                    class="tx-danger">*</span></label>
                                        <select class="form-control maquinas-client" name="producto" id="empresas" required>
                                        </select>
                                    </div>
                                </div> -->

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">SERIE: <span
                                                class="tx-danger"></span></label>
                                        <input id="upserie" type="text" class="form-control" name="serie" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">MODELO: <span
                                                class="tx-danger"></span></label>
                                        <input id="updmodelo" class="form-control" type="text" class="form-control" name="modelo"
                                        disabled>
                                    </div>
                                </div><!-- col-4 -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">CONCEPTO DE PAGO: <span
                                                class="tx-danger">*</span></label>
                                        <input id="concepto" class="form-control" type="text" name="concepto" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">UDS: <span
                                                class="tx-danger">*</span></label>
                                        <input id="upduds" class="form-control" type="text" name="uds" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">T.C: <span
                                                class="tx-danger">*</span></label>
                                        <input id="updtc" class="form-control" type="text" name="tc" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">PESOS: <span
                                                class="tx-danger">*</span></label>
                                        <input id="updpesos" class="form-control" type="text" name="pesos" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">%: <span
                                                class="tx-danger">*</span></label>
                                        <input id="updporciento" class="form-control" type="text" name="porciento" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">BANCO RECEPTOR: <span
                                                class="tx-danger">*</span></label>
                                        <input id="updbanco" class="form-control" type="text" name="banco" required>
                                    </div>
                                </div>

                                <input id="id_pago" class="form-control" type="hidden" name="id" required>
                                <input id="comprobante" class="form-control" type="hidden" name="name_comprobante" required>
                                <input id="factura" class="form-control" type="hidden" name="name_facturas" required>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">COMPROBANTE DE PAGO <span
                                                class="tx-danger"></span></label>
                                        <label class="custom-file">
                                            <input type="file" id="file" class="custom-file-input" name="comprobante" 
                                                accept=".jpg, .png , .jpge , .pdf">
                                            <span class="custom-file-control custom-file-label"></span>
                                        </label>
                                    </div>
                                </div><!-- col-4 -->

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">FACTURA O RECIBO <span
                                                class="tx-danger"></span></label>
                                        <label class="custom-file">
                                            <input type="file" id="file" class="custom-file-input" name="factura" 
                                            accept=".jpg, .png , .jpge , .pdf">
                                            <span class="custom-file-control custom-file-label"></span>
                                        </label>
                                    </div>
                                </div><!-- col-4 -->

                                <div class="col-lg-6">
                                    <div class="form-group" id="ficha">

                                    </div>
                                </div><!-- col-4 -->
                                <div class="col-lg-6">
                                    <div class="form-group" id="file-cot">

                                    </div>
                                </div><!-- col-4 -->

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning  pd-x-20">ACTUALIZAR</button>
                    <button type="button" class="btn btn btn-danger pd-x-20" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div>

<!--Modal delete-->
<div id="modal_delete" class="modal fade">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-danger pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Eliminar pago</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="delete_form">
                <div class=" pd-20">
                    <p class="mg-b-5">¿Desea eliminar este producto? </p>
                    <input type="hidden" name="id_delete" id="id_delete">
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger pd-x-20 btnbtn-delete"><i class="fa fa-trash mr-1"
                            aria-hidden="true"></i>Eliminar</button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i
                            class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->


<!-- DELETE FILE -->
<div id="modal_delete-file" class="modal fade">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-danger pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Elimianr producto</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="delete_form_file">
                <div class=" pd-20">
                    <p class="mg-b-5">¿Desea eliminar este producto? </p>
                    <input type="hidden" name="id_delete" id="id-file">
                    <input type="hidden" name="tipo" id="tipo">
                    <input type="hidden" name="name" id="file-name">
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger pd-x-20 btnbtn-delete"><i class="fa fa-trash mr-1"
                            aria-hidden="true"></i>Eliminar</button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i
                            class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->




<div class="sl-mainpanel">
    <div class="sl-pagebody">
        <div class="card pd-20 pd-sm-40">

            <div class="sl-page-title">
                <h5 class="text-uppercase"><?=$title?></h5>
                <p><?=$description?></p>
               <!--  <p class="mg-b-20 mg-sm-b-30">Catálogo de productos</p> -->
            </div><!-- sl-page-title -->

            <div class="col-md-3 pl-0">
                <a href="" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"
                        aria-hidden="true"></i>AGREGAR</a><br><br>
            </div>


            <div class="">
                <table id="datatable1" class="table display table-responsive pagos nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <!-- <th class="wd-15p">Folio</th> -->
                            <th class="wd-15p">Id</th>
                            <th class="wd-15p">Fecha de pago</th>
                            <th class="wd-15p">Empresa</th>
                            <th class="wd-15p text-left">Cliente</th>
                            <th class="wd-15p">CONCEPTO</th>
                            <th class="wd-15p">MAQUINA</th>
                            <th class="wd-15p">SERIE</th>
                            <th class="wd-15p">MODELO</th>
                            <th class="wd-15p">USD</th>
                            <th class="wd-15p">T.C</th>
                            <th class="wd-15p">PESOS</th>
                            <th class="wd-15p">%</th>
                            <th class="wd-15p">BANCO</th>
                            <th class="wd-15p">COMPROBANTE</th>
                            <th class="wd-15p">FACTURA</th>
                            <th class="wd-15p">ACCIONES</th> 
                        </tr>
                    </thead>
                    
                    <tbody>
                    </tbody>
                </table>
            </div><!-- table-wrapper -->
        </div>
    </div>
</div>

<script src="../../assets/lib/datatables/jquery.dataTables.js"></script>
<script src="../../assets/lib/datatables-responsive/dataTables.responsive.js"></script>
<script src="../../assets/lib/select2/js/select2.min.js"></script>

<script>
    //datatable//

    var dataTable = $('#datatable1').DataTable({
        order: [[0, 'desc']],

        dom: 'Blfrtip',
        buttons: [
            'excel'
        ],


        ajax: BASE_URL + '/Administrador/Pagos/getPagos',

        columns: [
            {
                data: "id",
                render: function(data, type, row, meta) {
                    return '<p id="' + row.id + '">' + row.id + '</p>'
                }
            },
            {
            data: "date",
                render: function(data, type, row, meta) {
                    return moment(data).format("DD/MM/YY");
                }   
            },
            {
                data: 'business_name',
                /*  render: function (data, type, row, meta) {
                    return `<p> ${data.charAt(0).toUpperCase() + data.slice(1).toLowerCase()}  </p>`
                } */
            },
            {
                data: 'cliente',
                render: function(data, type, row, meta) {
                    return '<p class="text-left" id="' + row.cliente + '">' + row.cliente + '</p>'
                }
                /*  render: function (data, type, row, meta) {
                    return `<p> ${data.charAt(0).toUpperCase() + data.slice(1).toLowerCase()}  </p>`
                } */
            },
            {
                data: 'concept',
                /*  render: function (data, type, row, meta) {
                    return `<p> ${data.charAt(0).toUpperCase() + data.slice(1).toLowerCase()}  </p>`
                } */
            },
            {
                data: 'name',
                /*  render: function (data, type, row, meta) {
                    return `<p> ${data.charAt(0).toUpperCase() + data.slice(1).toLowerCase()}  </p>`
                } */
            },
            {
                data: 'serie'
            },
            {
                data: 'model'
                /*  render: function(data, type, row, meta) {
                    return '<p>' + currency(data, { useVedic: true }).format() + '</p>'
                } */
            },
            {
                data: 'uds',
                render: function (data, type, row, meta) {
                    return '<p>' + currency(data).format() + '</p>'
                }
            },
            {
                data: 'tc',
                render: function (data, type, row, meta) {
                    return '<p>' + currency(data).format() + '</p>'
                }
            },
            {
                data: 'pesos',
                render: function (data, type, row, meta) {
                    return '<p>' + currency(data).format() + '</p>'
                }
            },
            {
                data: 'porciento', render: function (data, type, row, meta) {
                    return '<p>' +data +"%" +'</p>'
                }
            },
            {
                data: 'banco'
            },
            {
                data: 'proof_of_payment',
                render: function (data, type, row, meta) {
                    return  data != " "  ?'<a href="../../Pagos/Comprobante/' + data + '" target="_blank">' + '<button type="button" class="  mg-b-10" data-dismiss="modal"><img src="../../../assets/img/Pdf-removebg-preview.png"  width="40px">' + '</button>' + '</a>'
                    : " "
                }
            },
            {
                data: 'invoice_receipt',
                render: function (data, type, row, meta) {
                    return  data != " "  ? '<a href="../../Pagos/Facturas/' + data + '" target="_blank">' + '<button type="button" class="  mg-b-10" data-dismiss="modal"><img src="../../../assets/img/Pdf-removebg-preview.png"  width="40px">' + '</button>' + '</a>'
                    : " "
                }
            },

            {
                data: "id",
                render: function (data, type, row, meta) {
                    return '<button id="' + data + '"" class="btn btn-warning up solid pd-x-20" style="border-radius: 10px;"><i class="fa fa-pencil fa-lg mr-1" aria-hidden="true"></i> EDITAR</button>' +
                    '<button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 ml-1 " style="border-radius: 10px;"><i class="fa fa-trash-o fa-lg mr-1" aria-hidden="true"></i>ELIMINAR</button>'
                }    
            },
        ],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
        ], 
        language: {
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            lengthMenu: '_MENU_ Filas por página',
        },
    
        lengthMenu: [
            [50, 10, 25, 100, 999999],
            ["50", "10", "25", "100", "Mostrar todo"],
        ],
    });
</script>