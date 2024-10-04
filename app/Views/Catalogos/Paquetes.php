<!--LOADER-->
<div id="loader" class="modal fade show" style="display: none; padding-left: 0px;">
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
                <p><?= $description ?> </p>
            </div><!-- sl-page-title -->
            <div class="col-md-3 pl-0">
                <a href="" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"
                        aria-hidden="true"></i>Nuevo paquete</a><br><br>
            </div>
            <div class="">
                <table id="crm_packets" class="table display table-responsive product_list nowrap dataTable no-footer" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="wd-15p text-center">PAQUETE</th>
                            <th class="wd-10 text-center">CANTIDAD DE ESTUDIOS</th>
                            <!-- <th class="wd-10 text-center">PRECIO</th> -->
                            <th class="wd-35 text-center">PREPARACIÓN</th>
                            <th class="wd-15p text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div><!-- table-wrapper -->
        </div>
    </div>
</div>

<!-- CREAR PAQUETE -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-success pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">AGREGAR <?= $title ?></h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formCreate" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Datos del paquete</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row mg-b-25">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">CATEGORÍA DEL PRODUCTO: <span class="tx-danger">*</span></label>
                                        <select class="form-control categoria" name="categoria" required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="5" maxlength="70" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">OBSERVACIONES: <span class="tx-danger">*</span></label>
                                        <textarea rows="4" class="form-control"  name="description" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="5" maxlength="500" required></textarea>
                                    </div>
                                </div>
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

<!-- ACTUALIZAR PAQUETE-->
<div id="updateModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-warning pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">EDITAR <?= $title ?></h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUpdate" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Datos del paquete</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">CATEGORÍA DEL PRODUCTO: <span class="tx-danger">*</span></label>
                                        <select class="form-control categoria" name="categoria" id="update_Categoria" required>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" id="name" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="5" maxlength="50" required>
                                        <input type="hidden" id="id_update" name="id">
                                        <input type="hidden" id="id_insumoup" name="id_insumo">
                                    </div>
                                </div>
                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">OBSERVACIONES: <span class="tx-danger">*</span></label>
                                        <textarea rows="4" class="form-control"  name="description" id="prescription" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="5" maxlength="500" required></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12 text-right">
                                    <div class="form-group">
                                    <a id="ver-estudios" class="ver-estudios">Ver estudios</a>
                                    </div>
                                </div>
                   
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning pd-x-20">ACTUALIZAR</button>
                    <button type="button" class="btn btn btn-danger pd-x-20" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div>

<!--Modal delete-->
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
                    <input type="hidden" name="id" id="id_delete">
                    <input type="hidden" id="id_insumodel" name="id_insumo">
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
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ASIGNAR PRECIO A <?= $title ?></h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form_price">
                <div class="pd-60 pd-sm-60 form-layout form-layout-4">
                    <h6 style="text-align:center;">Si deseas definir manualmente el precio del paquete desactiva la opción <strong>"SUMAR PRECIOS DE ESTUDIOS"</strong>. Si quieres continuar con la suma, solo ingresa un monto de descuento si lo deseas</h6>
                    <input type="hidden" name="id" id="id_price">
                    <div id="texto-precio" class="texto-precio"></div>
                    

                    <div class="form-layout mg-t-30">
                        <div id="precio_fijo" class="row justify-content-center">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">PRECIO FIJO: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="price" id="price_fij" minlength="3" maxlength="8">
                                </div>
                            </div>
                        </div>

                        <div class="mg-t-20">
                            <div class="row align-items-center mg-t-30">
                                <p class="text-right " style="width:53%;">SUMAR PRECIOS</p>
                                <div class="ml-3 mg-t-10 mg-sm-t-0" style="width:38%;">
                                    <label class="switch">
                                        <input id="suma" name="suma" type="checkbox" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="suma_precios" class="row mg-t-20">
                        <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">TOTAL: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="total" id="total_sum" minlength="3" maxlength="8" readonly>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">DESCUENTO:</label>
                                    <input class="form-control" type="text" name="descuento" id="descuento" maxlength="3">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label">PRECIO FINAL: <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="price_total" id="price_total" minlength="3" maxlength="8" readonly>
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