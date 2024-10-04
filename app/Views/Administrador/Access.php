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
                            <th class="wd-15p text-center">rol</th>
                            <th class="wd-15p text-center">Categoria</th>
                            <th class="wd-15p text-center">MODULO</th>
                            <th class="wd-15p text-center">CREAR</th>
                            <th class="wd-15p text-center">LEER</th>
                            <th class="wd-15p text-center">ACTUALIZAR</th>
                            <th class="wd-15p text-center">ELIMINAR</th>
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
                        <h6 class="card-body-title"><?= $title ?></h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row mg-b-25">
                                <input type="hidden" name="id_group" value="<?= $id ?>">
                                <div class="col-lg-12">
                                    <label class="form-control-label">MODULO: <span class="tx-danger">*</span></label>
                                    <select name="id_module" class="form-control modules" required>
                                    </select>
                                </div><!-- col-4 -->
                                <div class="col-lg-3 mt-4 text-center">
                                    <label class="form-control-label">CREAR</label><br>
                                    <label class="switch"><input type="checkbox" name="crear"><span class="slider round"></span></label>
                                </div>
                                <div class="col-lg-3 mt-4 text-center">
                                    <label class="form-control-label">LEER</label><br>
                                    <label class="switch"><input type="checkbox" name="read_a"><span class="slider round"></span></label>
                                </div>
                                <div class="col-lg-3 mt-4 text-center">
                                    <label class="form-control-label">ACTUALIZAR</label><br>
                                    <label class="switch"><input type="checkbox" name="update_a"><span class="slider round"></span></label>
                                </div>
                                <div class="col-lg-3 mt-4 text-center">
                                    <label class="form-control-label">ELIMINAR</label><br>
                                    <label class="switch"><input type="checkbox" name="delete_a"><span class="slider round"></span></label>
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
                        <h6 class="card-body-title"><?= $title ?></h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row mg-b-25">
                                <input type="hidden" name="id_group" value="<?= $id ?>">
                                <input id="id_module" type="hidden" name="id_module">
                              <!--   <div class="col-lg-12">
                                    <label class="form-control-label">MODULO: <span class="tx-danger">*</span></label>
                                    <select id="id_module" name="id_module" class="form-control modules" required>
                                    </select>
                                </div>-->
                                <div class="col-lg-3 mt-4 text-center">
                                    <label class="form-control-label">CREAR</label><br>
                                    <label class="switch"><input id="crear" type="checkbox" name="crear"><span class="slider round"></span></label>
                                </div>
                                <div class="col-lg-3 mt-4 text-center">
                                    <label class="form-control-label">LEER</label><br>
                                    <label class="switch"><input id="leer" type="checkbox" name="read_a"><span class="slider round"></span></label>
                                </div>
                                <div class="col-lg-3 mt-4 text-center">
                                    <label class="form-control-label">ACTUALIZAR</label><br>
                                    <label class="switch"><input id="actualizar_" type="checkbox" name="update_a"><span class="slider round"></span></label>
                                </div>
                                <div class="col-lg-3 mt-4 text-center">
                                    <label class="form-control-label">ELIMINAR</label><br>
                                    <label class="switch"><input id="eliminar_" type="checkbox" name="delete_a"><span class="slider round"></span></label>
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
                    <p class="mg-b-5">¿Desea eliminar los <?= $title ?> ? </p>
                    <input type="hidden" name="id_delete" id="id_delete">
                    <input type="hidden" name="id_group" value="<?= $id ?>">
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
    let id = <?= json_encode($id); ?>;
</script>