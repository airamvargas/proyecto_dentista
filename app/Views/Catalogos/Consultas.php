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

            <div class="col-md-3 pl-0">
                <a href="" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"
                        aria-hidden="true"></i>AGREGAR CONSULTA</a><br><br>
            </div>


            <div class="">
                <table id="crm_productos" class="table display table-responsive product_list" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="wd-15p text-center">CATEGORÍA</th>
                            <th class="wd-15p text-center">PRODUCTO</th>
                            <th class="wd-15p text-center">DESCRIPCIÓN</th>
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

<!-- CREAR PRODUCTO -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-success pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">AGREGAR NUEVA CONSULTA</h6>
                <button type="button" class="close text-white cancelar" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formProducto" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Datos de la consulta</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row mg-b-25">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">CATEGORÍA DEL PRODUCTO: <span class="tx-danger">*</span></label>
                                        <select class="form-control categoria" name="categoria" id="categoria" required>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE: <span class="tx-danger">*</span></label>
                                        <input id="nombre" class="form-control" type="text" name="nombre" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="3" maxlength="50" required>
                                    </div>
                                </div>

                                <div id="disciplina" class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">DISCIPLINA: <span class="tx-danger">*</span></label>
                                        <select id="disciplina" class="form-control disciplina" name="disciplina" required>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12"> 
                                    <div class="form-group">
                                        <label class="form-control-label">DESCRIPCIÓN: <span class="tx-danger">*</span></label>
                                        <textarea id="descripcion" rows="3" name="descripcion" class="form-control" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="5" maxlength="500" required></textarea>
                                    </div>
                                </div>

                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success pd-x-20">Agregar</button>
                    <button type="button" class="btn btn btn-danger pd-x-20 cancelar" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div>

<!-- ACTUALIZAR PRODUCTO-->
<div id="updateModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-warning pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ACTUALIZAR CONSULTA</h6>
                <button type="button" class="close text-white cancelar" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUpdate" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Datos del Producto</h6>
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
                                        <input class="form-control" id="update_nombre" type="text" name="nombre" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="3" maxlength="50" required>
                                    </div>
                                </div>

                                <div id="disciplina_up" class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">DISCIPLINA: <span class="tx-danger">*</span></label>
                                        <select class="form-control disciplina" name="disciplina" id="update_disciplina" required>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">DESCRIPCIÓN: <span class="tx-danger">*</span></label>
                                        <textarea rows="3" id="update_descripcion" name="descripcion" class="form-control" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="5" maxlength="250" required></textarea>
                                        <input id="id_producto" type="hidden" name="id_producto" required>
                                        <input id="id_insumo" type="hidden" name="id_insumo" required>
                                    </div>
                                </div>

                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning pd-x-20">ACTUALIZAR</button>
                    <button type="button" class="btn btn btn-danger pd-x-20 cancelar" data-dismiss="modal">Cancelar</button>
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
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ELIMINAR CATEGORÍA DE CONSULTA</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="delete_form">
                <div class="pd-50 pd-sm-50 form-layout form-layout-4">
                    <h6 style="text-align:center;">¿Deseas continuar con esta acción?</h6>
                    <br>
                    <p style="color:red; text-align:center;">No se podrán deshacer la acción una vez realizada.</p>
                    <input type="hidden" name="id_delete" id="id_delete">
                    <input type="hidden" name="id_insumo" id="id_delete_insumo">
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger btn btn-delete pd-x-20"><i class="fa fa-trash mr-1"
                            aria-hidden="true"></i>Eliminar</button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i
                            class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->