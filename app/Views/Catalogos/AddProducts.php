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
                <div class="col-lg-2">
                    <button type="button" id="add-producto" href="" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"
                    aria-hidden="true"></i>ASIGNAR PRODUCTO</button>
                </div>

                <div class="col-lg-2">
                    <button type="button" id="down_csv" class="btn btn-primary"><i class="fa fa-download"
                    aria-hidden="true"></i> DESCARGAR CSV</button><br><br>
                </div>
            </div>

            <div class="">
                <table id="crm_products_x_unit" class="table display table-responsive product_list nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="wd-15p text-center">UNIDAD DE NEGOCIO</th>
                            <th class="wd-15p text-center">CATEGORÍA</th>
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
            <form id="form_add" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Productos que pertecen a la unidad de negocio</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label">CATEGORIA DEL PRODUCTO: <span class="tx-danger">*</span></label>
                                        <select class="form-control categoria" name="categoria" id="categoria" required>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE DEL PRODUCTO: 
                                            <span class="tx-danger">*</span>
                                        </label>
                                        <input minlength="5" maxlength="80" type="text" id="autoComplete" class="form-control universidad" autocomplete="off" required style="background-color: white !important; color: rgba(0,0,0,.8) !important; border: black solid 1px !important;">
                                        <input type="hidden" name="id_product" id="id_product" class="form-control">
                                        <input type="hidden" name="id_unidad" id="id_unidad" class="form-control">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label">PRECIO: 
                                            <span class="tx-danger">*</span>
                                        </label>
                                        <input  pattern="[0-9]+[0-9]+.[0-9]+" minlength="2" maxlength="10" type="text" class="form-control" name="precio" id="precio" required>
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

<!--ELIMINAR PRODUCTO-->
<div id="modal_delete" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-danger pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ELIMINAR PRODUCTO</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form_delete_product">
                <div class="pd-80 pd-sm-80 form-layout form-layout-4">
                    <h6 style="text-align:center;">¿Deseas continuar con esta acción?</h6>
                    <br>
                    <p style="color:red; text-align:center;">No se podrán deshacer la acción una vez realizada.</p>
                    <input type="hidden" name="id_delete" id="id_delete">
                </div>
                <div class="modal-footer justify-content-center">
                    <button id="delete-btn" type="submit" class="btn btn-danger btnbtn-delete pd-x-20"><i class="fa fa-trash mr-1"
                            aria-hidden="true"></i>Eliminar</button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i
                            class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

<!-- ASIGNAR PRECIO -->
<div id="modal_price" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-primary pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ASIGNAR PRECIO</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form_price">
                <div class="pd-60 pd-sm-60 form-layout form-layout-4">
                    <h6 style="text-align:center;" id="n_producto">Definir el precio de </h6>
                    <input type="hidden" name="id" id="id_price">
                    <div id="texto-precio" class="texto-precio"></div>
                    
                    <div class="form-layout mg-t-30">
                        <div id="precio_fijo" class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label">PRECIO: <span class="tx-danger">*</span></label>
                                    <input pattern="[0-9]+[0-9]+.[0-9]+" class="form-control" type="text" name="price" id="price_fij" minlength="2" maxlength="8">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                

                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-primary btnbtn-delete pd-x-20"><i class="fa fa-floppy-o" aria-hidden="true"></i> GUARDAR</button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i
                        class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div>

<script>
    let id_unidad = <?php echo json_encode($id_unidad); ?>;
</script>