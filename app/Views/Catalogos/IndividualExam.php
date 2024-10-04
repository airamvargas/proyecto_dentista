<!-- Desarrollador: Airam Vargas
Fecha de creacion:
Fecha de Ultima Actualizacion: 12 - 10 -2023 por Jesus Sanchez
Perfil: Administrador
Descripcion: Cátalogo de tipos de analitos-->

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
                        aria-hidden="true"></i>Nuevo <?= $title ?></a><br><br>
            </div>
            <div class="">
                <table id="crm_exams" class="table display table-responsive product_list" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="wd-15p text-center"></th>
                            <th class="wd-15p text-center">NOMBRE</th>
                            <th class="wd-15p text-center">DESCRIPCIÓN</th>
                            <th class="wd-15p text-center">MÉTODO</th>
                            <th class="wd-15p text-center">UNIDAD DE MEDIDA</th>
                            <th class="wd-15p text-center">VALOR DE REFERENCIA</th>
                            <th class="wd-15p text-center">RESULTADO</th>
                            <th class="wd-15p text-center">AGRUPADOR</th>
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

<!-- CREAR EXAMEN -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-success pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">AGREGAR ANALITO</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formCreate" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Datos del analito</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row mg-b-25">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" minlength="5" maxlength="100" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">MÉTODO: <span class="tx-danger">*</span></label>
                                        <select class="form-control metodo" name="id_crm_cat_methods" required></select>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">UNIDAD DE MEDIDA: <span class="tx-danger">*</span></label>
                                        <select class="form-control unidad" name="id_crm_cat_measurement_units" required></select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">VALOR DE REFERENCIA: </label>
                                        <input class="form-control" type="text" name="reference_value" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="5" maxlength="30">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">RESULTADO: <span class="tx-danger">*</span></label>
                                        <select class="form-control" name="result" >
                                            <option value="Selecciona una opción" selected disabled>SELECCIONA UN RESULTADO</option>
                                            <option value="1">NÚMERICO</option>
                                            <option value="2">TEXTO</option>
                                            <option value="3">CERRADO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">AGRUPADOR: </label>
                                        <select class="form-control agrupador" name="id_agrupador"></select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">DESCRIPCIÓN: <span class="tx-danger">*</span></label>
                                        <textarea rows="2" class="form-control"  name="description" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="5" maxlength="850" required></textarea>
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

<!-- ACTUALIZAR EXAMEN-->
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
                        <h6 class="card-body-title">Datos del analito</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE: <span class="tx-danger">*</span></label>
                                        <input id="nameCategory" class="form-control" type="text" name="name" minlength="5" maxlength="100" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">MÉTODO: <span class="tx-danger">*</span></label>
                                        <select id="id_crm_cat_methods" class="form-control metodo" name="id_crm_cat_methods" required></select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">UNIDAD DE MEDIDA: <span class="tx-danger">*</span></label>
                                        <select id="id_crm_cat_measurement_units" class="form-control unidad" name="id_crm_cat_measurement_units" required></select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">VALOR DE REFERENCIA:</label>
                                        <input id="reference_value" class="form-control" type="text" name="reference_value" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="5" maxlength="30">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">RESULTADO: <span class="tx-danger">*</span></label>
                                        <select class="form-control" name="result" id="result">
                                            <option value="SELECCIONA UN RESULTADO" selected disabled>Selecciona una opción</option>
                                            <option value="1">NÚMERICO</option>
                                            <option value="2">TEXTO</option>
                                            <option value="3">CERRADO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">AGRUPADOR: </label>
                                        <select id="id_agrupador" class="form-control agrupador" name="id_agrupador"></select>
                                        <input id="id_update" class="form-control" type="hidden" name="id">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">DESCRIPCIÓN: <span class="tx-danger">*</span></label>
                                        <textarea rows="2" class="form-control" id="description" name="description" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="5" maxlength="850" required></textarea>
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
                    <p style="color:red; text-align:center;">No se podrá deshacer la acción una vez realizada.</p>
                    <input type="hidden" name="id" id="id_delete">
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