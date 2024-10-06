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
                <p><?= $description ?></p>
            </div><!-- sl-page-title -->
            <div class="col-md-3 pl-0">
                <a href="" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1" aria-hidden="true"></i>Agregar <?= $title ?></a><br><br>
            </div>
            <div class="">
                <table id="datatable" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th class="wd-15p text-center">ID</th>
                            <th class="wd-15p text-center">GRUPO</th>
                            <th class="wd-15p text-center">NOMBRE</th>
                            <th class="wd-15p text-center">DESCRIPCION</th>
                            <th class="wd-15p text-center">CONTROLADOR</th>
                            <th class="wd-15p text-center">ACTIVO</th>
                            <th class="wd-15p text-center">FASE</th>
                            <th class="wd-15p text-center">MOSTRAR EN MENÚ</th>
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

<!-- MODAL CREATE -->
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
                        <h6 class="card-body-title">Datos de la <?= $title ?></h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row mg-b-25">
                                <input name="id_group_module" type="hidden" value="<?=$data[0]['id']?>" >
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" pattern="^[a-zA-Z0-9 ]*$" minlength="5" maxlength="30" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">CONTROLADOR: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="controller" minlength="5" maxlength="30" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-control-label">ACTIVADO: <span class="tx-danger">*</span></label>
                                    <select name="active" class="form-control select2" data-placeholder="Choose one">
                                        <option label="Selecciona una opción"></option>
                                        <option value="1">Activado</option>
                                        <option value="0">Desactivado</option>
                                    </select>
                                </div><!-- col-4 -->
                                <div class="col-lg-6">
                                    <label class="form-control-label">PHASE: <span class="tx-danger">*</span></label>
                                    <select name="phase" class="form-control select2" data-placeholder="Choose one">
                                        <option label="Selecciona una opción"></option>
                                        <option value="1">Activado</option>
                                        <option value="0">Desactivado</option>
                                    </select>
                                </div><!-- col-4 -->
                                <div class="col-lg-6 mt-4">
                                    <label class="form-control-label">ACTIVO EN MENÚ: <span class="tx-danger">*</span></label>
                                    <select name="show_in_menu" class="form-control select2" data-placeholder="Choose one">
                                        <option label="Selecciona una opción"></option>
                                        <option value="1">SÍ</option>
                                        <option value="0">No</option>
                                    </select>
                                </div><!-- col-4 -->
                                <div class="col-lg-12 mt-4">
                                    <div class="form-group">
                                        <label class="form-control-label">DESCRIPCION: <span class="tx-danger">*</span></label>
                                        <textarea rows="2" class="form-control" name="description" pattern="^[a-zA-Z0-9 ]*$+" minlength="5" maxlength="50" required></textarea>
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

<!--MODAL UPDATE-->
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
                        <h6 class="card-body-title">Datos de la <?= $title ?></h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row">
                            <input id="id_group_module" name="id_group_module" type="hidden" >
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="name" name="name" pattern="^[a-zA-Z0-9 ]*$" minlength="5" maxlength="30" autocomplete="off" required>
                                        <input class="form-control" type="hidden" id="id" name="id" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">CONTROLADOR: <span class="tx-danger">*</span></label>
                                        <input id="controller" class="form-control" type="text" name="controller" minlength="5" maxlength="30" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-control-label">ACTIVADO: <span class="tx-danger">*</span></label>
                                    <select id="active" name="active" class="form-control select2" data-placeholder="Choose one">
                                        <option label="Selecciona una opción"></option>
                                        <option value="1">Activado</option>
                                        <option value="0">Desactivado</option>
                                    </select>
                                </div><!-- col-4 -->
                                <div class="col-lg-6">
                                    <label class="form-control-label">PHASE: <span class="tx-danger">*</span></label>
                                    <select id="phase" name="phase" class="form-control select2" data-placeholder="Choose one">
                                        <option label="Selecciona una opción"></option>
                                        <option value="1">Activado</option>
                                        <option value="0">Desactivado</option>
                                    </select>
                                </div><!-- col-4 -->
                                <div class="col-lg-6 mt-4">
                                    <label class="form-control-label">ACTIVO EN MENÚ: <span class="tx-danger">*</span></label>
                                    <select id="show_in_menu" name="show_in_menu" class="form-control select2" data-placeholder="Choose one">
                                        <option label="Selecciona una opción"></option>
                                        <option value="1">SÍ</option>
                                        <option value="0">No</option>
                                    </select>
                                </div><!-- col-4 -->
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">DESCRIPCION: <span class="tx-danger">*</span></label>
                                        <textarea rows="2" class="form-control" id="description" name="description" required></textarea>
                                        <!-- <input class="form-control" type="text" name="description" required> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning pd-x-20">GUARDAR</button>
                    <button type="button" class="btn btn btn-danger pd-x-20" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div>

<!--MODAL DELETE-->
<div id="modal_delete" class="modal fade">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-danger pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Eliminar <?= $title ?></h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="formDelete">
                <div class=" pd-20">
                    <p class="mg-b-5">¿ Desea eliminar este Modulo ? </p>
                    <input type="hidden" name="id_delete" id="id_delete">
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger btnbtn-delete pd-x-20"><i class="fa fa-trash mr-1" aria-hidden="true"></i>Eliminar</button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

<script>
    let datos = <?php echo json_encode($data); ?>;
</script>