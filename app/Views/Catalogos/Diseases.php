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
    <div class="sl-pagebody" style="background-color: #fff;">
        <div class="card pd-20 pd-sm-40">
            <div class="sl-page-title">
                <h5 class="text-uppercase"><?= $title ?></h5>
                <p><?= $description ?></p>
            </div><!-- sl-page-title -->
            <div class="col-md-3 pl-0">
                <a id="btn-add" href="" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1" aria-hidden="true"></i>Agregar <?= $title ?></a><br><br>
            </div>
            <div class="">
                <table id="datatable" class="table display table-responsive product_list nowrap table table-hover table-striped" style="width: 100%;">
                    <thead>
                        <tr class="text-center">
                            <th class="wd-15p text-center">ID</th>
                            <th class="wd-15p text-center">NOMBRE CIENTÍFICO</th>
                            <th class="wd-15p text-center">NOMBRE COMÚN</th>
                            <th class="wd-15p text-center">TIPO DE ENFERMEDAD</th>
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
                                <div class="col-lg-12">
                                    <label class="form-control-label">BÚSQUEDA DE ENFERMEDAD: <span class="tx-danger">*</span></label>
                                    <div class="autoComplete_wrapper" style="width: 100% !important;">
                                        <input class="create-searup"  style="width: 680px !important;" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" autocapitalize="off" maxlength="2048" tabindex="1">
                                    </div>
                                    <input type="hidden" class="id_c10" name="id_c10" require>
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE COMÚN: <span class="tx-danger">*</span></label>
                                        <input class="form-control common" type="text" id="name" name="common_name"  minlength="5" maxlength="150" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">TIPO DE ENFERMEDAD: <span class="tx-danger">*</span></label>
                                        <select name="id_cat_illness_type" class="form-control select2 tipo" required></select>
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
                            <div class="col-lg-12">
                                    <label class="form-control-label">BÚSQUEDA DE ENFERMEDAD: <span class="tx-danger">*</span></label>
                                    <div class="autoComplete_wrapper"  style="width: 100% !important;">
                                        <input class="form-control search-create create-searup" style="width: 680px !important;" type="text" tabindex="1">
                                    </div>
                                    <input type="hidden" class="id_c10" name="id_c10">
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE COMÚN: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="common_name" name="common_name" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" minlength="5" maxlength="50" autocomplete="off" required>
                                        <input class="form-control" type="hidden" id="id" name="id" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">TIPO DE ENFERMEDAD: <span class="tx-danger">*</span></label>
                                        <select name="id_cat_illness_type" class="form-control select2 tipo" required></select>
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
                    <p class="mg-b-5">¿Desea eliminar esta <?= $title ?> ? </p>
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
}