<!-- Desarrollador: Airam V. Vargas López
Fecha de creacion:
Fecha de Ultima Actualizacion: 07 de febrero de 2024
Perfil: Back Office
Descripcion: Vista de lista de producos en cada convenio -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<link href="../../../assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
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

<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
    <div class="sl-pagebody">
        <div class="card pd-20 pd-sm-40">

            <div class="sl-page-title">
                <h5 class="text-uppercase"><?= $title ?></h5>
                <p><?= $description ?></p>
            </div><!-- sl-page-title -->
            <div class="row">
                <div class="col-lg-2 pl-0">
                    <button type="button" id="add-producto" href="" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"
                    aria-hidden="true"></i>ASIGNAR PRODUCTO</button><br><br>
                </div>

                <div class="col-lg-2 pl-0">
                    <button type="button" id="subir_archivo" href="" class="btn btn-teal"><i class="fa fa-upload mr-1"
                    aria-hidden="true"></i>SUBIR ARCHIVO</button><br><br>
                </div>

            </div>

            


            <div class="">
                <table id="crm_producto_x_convenio" class="table display table-responsive product_list nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="wd-15p text-center">ID_PROD_X_CON</th>
                            <th class="wd-15p text-center">CATEGORÍA</th>
                            <th class="wd-15p text-center">CONVENIO</th>
                            <th class="wd-15p text-center">ID_PRODUCTO</th>
                            <th class="wd-15p text-center">PRODUCTO</th>
                            <th class="wd-15p text-center">PRECIO</th>
                            <th class="wd-15p text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                    </tbody>
                </table>
            </div><!-- table-wrapper -->
        </div>
    </div>
</div>



<!-- CREAR PRODUCTOS X CONVENIO -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-success pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold"><?= $title ?></h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formCreate" class="formCreate" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Productos que pertecen a un convenio</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">CATEGORÍA DEL PRODUCTO: <span class="tx-danger">*</span></label>
                                        <select class="form-control categoria" name="categoria" id="categoria" required>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE DEL PRODUCTO: 
                                            <span class="tx-danger">*</span>
                                        </label>
                                        <input minlength="5" maxlength="60" type="text" id="autoComplete" class="form-control universidad" autocomplete="off" required style="background-color: white !important; color: rgba(0,0,0,.8) !important; border: black solid 1px !important;">
                                        <input type="hidden" name="id_product" id="id_product" class="form-control ">
                                    </div>
                                </div>

                                <div class="col-lg-6 convenios">
                                    <div class="form-group">
                                        <label class="form-control-label">CONVENIO: 
                                            <span class="tx-danger">*</span>
                                        </label>
                                        <select class="form-control convenio" id="convenio" required>
                                        </select>
                                        <input type="hidden" name="convenio" id="conven">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">PRECIO DEL PRODUCTO: 
                                            <span class="tx-danger">*</span>
                                        </label>
                                        <input id="precioConvenio" name="precio_convenio" minlength="1" maxlength="8" type="text" class="form-control" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="form-asignar" type="submit" class="btn btn-success pd-x-20">Agregar</button>
                            <button type="button" class="btn btn btn-danger pd-x-20" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div>

<!-- ACTUALIZAR PRODUCTO X CONVENIO-->
<div id="updateModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-warning pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">EDITAR <?= $title ?></h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUpdate" class="formUpdate" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Datos de la asignación del producto</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">CATEGORÍA DEL PRODUCTO: <span class="tx-danger">*</span></label>
                                        <select class="form-control categoria" name="categoria" id="categoria_update" required>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE DEL PRODUCTO: 
                                            <span class="tx-danger">*</span>
                                        </label>
                                        <input minlength="5" maxlength="60" type="text" id="autoComplete" class="form-control update_producto" autocomplete="off" required style="background-color: white !important; color: rgba(0,0,0,.8) !important; border: black solid 1px !important;">
                                        <input type="hidden" name="id_product_update" id="id_product_updadte" class="form-control ">
                                        <input type="hidden" name="id_update" id="id_update" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-6 convenios">
                                    <div class="form-group">
                                        <label class="form-control-label">CONVENIO: <span class="tx-danger">*</span></label>
                                        <select class="form-control convenio" id="convenio_update" required></select>
                                        <input type="hidden" name="convenio" id="conven_update">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">PRECIO DEL PRODUCTO: <span class="tx-danger">*</span></label>
                                        <input id="precio_convenio" name="precio_convenio" minlength="1" maxlength="8" type="text" class="form-control" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="update-btn" type="submit" class="btn btn-warning pd-x-20">ACTUALIZAR</button>
                                <button type="button" class="btn btn btn-danger pd-x-20" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div>

<!--ELIMINAR PRODUCTO X CONVENIO-->
<div id="modal_delete" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-danger pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ELIMINAR <?= $title ?></h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="formDelete" class="formDelete">
                <div class="pd-80 pd-sm-80 form-layout form-layout-4">
                    <h6 style="text-align:center;">¿Deseas continuar con esta acción?</h6>
                    <br>
                    <p style="color:red; text-align:center;">No se podrán deshacer la acción una vez realizada.</p>
                    <input type="hidden" name="id_delete" id="id_delete">
                </div>
                <div class="modal-footer justify-content-center">
                    <button id="delete-btn" type="submit" class="btn btn-danger pd-x-20"><i class="fa fa-trash mr-1"
                            aria-hidden="true"></i>Eliminar</button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i
                            class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

<!--SUBIR ARCHIVO-->
<div id="modal_archivo" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-teal pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">SUBIR ARCHIVO</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="formSubir" enctype="multipart/form-data">
                <div class="card pd-20 pd-sm-40">
                    <h6 class="card-body-title">ARCHIVO CSV</h6>
                    <p class="mg-b-20 mg-sm-b-30">Subir archvio csv para actualización de datos</p>
                    <div id="div_archivo" class="form-layout">
                        <div class="col-lg-12">
                            <label class="form-control-label">ARCHIVO CSV: <span class="tx-danger">*</span></label>
                            <div class="file-drop-area text-center">
                                <span class="choose-file-button">AÑADIR ARCHIVO</span>
                                <span id="file-msg" class="file-message">Arrastra el archivo aqui</span>
                                <input id="file_archivo" class="file-input" type="file" name="archivo" accept=".csv" required>
                                <input type="hidden" name="id_convenio" id="id_convenio">
                            </div>
                        </div>
                    </div>
                    <div id="errores" class="form-layout">
                        <div id="lista" class="col-lg-12"></div>
                    </div>
                </div>
                
                <div class="modal-footer justify-content-center">
                    <button id="subir_btn" type="submit" class="btn btn-teal pd-x-20"><i class="fa fa-upload mr-1"
                            aria-hidden="true"></i>SUBIR</button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i
                            class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

<script>
    let id_convenio = <?php echo json_encode($id_convenio); ?>;

    /*TABLA DE PRODUCTOS_X_CONVENIO*/
    var dataTable = $('#crm_producto_x_convenio').DataTable({
        processing: true, 
        serverSide: true, 
        ajax: {
            url: `${BASE_URL}Api/Catalogos/ConveniosProductos/readProductsConvenio`,
            data: {},
            type: "post",
        },
        lengthMenu: [
            [10, 25, 50, 100, 999999],
            ["10", "25", "50", "100", "Mostrar todo"],
        ],

        dom: 'Blfrtip',
        buttons: [
            'excel', 'csv'
        ],

        columns: [
            { 
                data: 'id'
            },
            {
                data: 'categoria'
            },
            { 
                data: 'convenio'
            },
            {
                data: 'id_producto'
            },
            { 
                data: 'producto'
            },
            { 
                data: 'precio_convenio',
                render: function(data, type, row, meta) { 
                    let price = data == null ? 0 : parseFloat(data)
                    return currency(price, { symbol: "$", separator: "," }).format()
                }
            },
            {
                data: "id",
                render: function(data, type, row, meta) { 
                    return '<button id="' + data + '" class="btn btn-warning update solid pd-x-20 btn-circle btn-sm mr-2" title="Editar datos"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></button>' +
                    '<button id="' + data + '"  class="btn btn-danger delete solid pd-x-20 btn-circle btn-sm mr-2" title="Eliminar regsitro"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></button>'
                }
            },


        ],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 3 ],
                "visible": false,
                "searchable": false
            },
        ],
        ordering: true,
        language: {
            searchPlaceholder: 'Buscar...',
            sSearch: '',
            lengthMenu: '_MENU_ Filas por página',
        },
        initComplete: function(settings, json) {
            /*$('#crm_producto_x_convenio thead tr')
                .clone(true)
                .addClass('filters')
                .appendTo('#crm_producto_x_convenio thead');*/
            var api = this.api();
            api
                .columns()
                .eq(0)
                .each(function(colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" class="text-center" placeholder="' + title + '" />');

                    // On every keypress in this input
                    $('input', $('.filters th').eq($(api.column(colIdx).header()).index()))
                        .off('keyup change')
                        .on('keyup change', function(e) {
                            e.stopPropagation();
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr =
                                '({search})'; //$(this).parents('th').find('select').val();
                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(

                                    this.value
                                )
                                .draw();

                            $(this)
                                .focus()[0]
                                .setSelectionRange(cursorPosition, cursorPosition);
                        });
                });
            quitaClase();
            function quitaClase() {
                $('.filters').children().removeClass("sorting").removeClass("sorting_asc").removeClass("sorting_desc");
            }

        },
    });
</script>