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
<div class="container-fluid mt-5">
    <div class="container-xxl">
        <div class="card pd-20 pd-sm-40">
            <div class="sl-page-title">
                <h5 class="text-uppercase title-text"><?= $title ?></h5>
                <p><?= $description ?> </p>
            </div><!-- sl-page-title -->
            <div class="col-md-3 pl-0">
                <a id="new_proc" href="" class="btn btn-add" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"
                        aria-hidden="true"></i>Nuevo tratamiento</a><br><br>
            </div>
            <div class="">
                <table id="procedimientos" class="table display table-responsive product_list" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="wd-15p text-center">NOMBRE</th>
                            <th class="wd-15p text-center">DESCRIPCION</th>
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

<!-- CREAR PROCEDIMIENTO -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-ingresa pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">AGREGAR PROCEDIMIENTO</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formProcedimiento" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Datos del procedimiento</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row mg-b-25">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE DEL PROCEDIMIENTO: <span class="tx-danger">*</span></label>
                                        <input type="text" name="nombre_proc" class="form-control" required pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="5" maxlength="60">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">PRECIO: 
                                            <span class="tx-danger">*</span>
                                        </label>
                                        <input type="text"  name="precio" class="form-control" required minlength="2" maxlength="6">
                                    </div>
                                </div>
                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">OBSERVACIONES: 
                                            <span class="tx-danger">*</span>
                                        </label>
                                        <textarea class="form-control" type="text" name="observacion" minlength="10" maxlength="5000" autocomplete="off" required></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-add pd-x-20">Agregar</button>
                    <button type="button" class="btn btn btn-cancelar pd-x-20" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div>

<!-- ACTUALIZAR CATEGORIA-->
<div id="updateModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-warning pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">EDITAR PROCEDIMIENTO</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUpdate" enctype="multipart/form-data">
            <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Datos del procedimiento</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row mg-b-25">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE DEL PROCEDIMIENTO: <span class="tx-danger">*</span></label>
                                        <input type="text" id="nombre_proc" name="nombre_proc" class="form-control" required minlength="5" maxlength="60">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">PRECIO: 
                                            <span class="tx-danger">*</span>
                                        </label>
                                        <input type="text" id="precio" name="precio" class="form-control" required minlength="2" maxlength="6">
                                    </div>
                                </div>
                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">OBSERVACIONES: 
                                            <span class="tx-danger">*</span>
                                        </label>
                                        <textarea class="form-control" type="text" id="observacion" name="observacion" rows="4" minlength="10" maxlength="5000" autocomplete="off" required></textarea>
                                        <input type="hidden" id="id_update" name="id_update" class="form-control" required>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-edit pd-x-20">GUARDAR</button>
                    <button type="button" class="btn btn btn-cancelar pd-x-20" data-dismiss="modal">Cancelar</button>
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
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ELIMINAR PROCEDIMIENTO</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="formDelete" class="formDelete">
                <div class="pd-80 pd-sm-80 form-layout form-layout-4">
                    <h6 style="text-align:center; font-size: 1.2rem;">¿Deseas continuar con esta acción?</h6>
                    <br>
                    <p style="color:red; text-align:center; font-size: 1.2rem;">No se podrá deshacer la acción una vez realizada.</p>
                    <input type="hidden" name="id" id="id_delete">
                </div>
                <div class="modal-footer justify-content-center">
                    <button id="delete-btn" type="submit" class="btn btn-danger btnbtn-delete pd-x-20"> Eliminar</button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i
                            class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->