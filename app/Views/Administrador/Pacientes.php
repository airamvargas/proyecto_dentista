<script src="../../../assets/lib/jquery/jquery.js"></script>

<link href="../../../assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
<link href="../../../assets/lib/select2/css/select2.min.css" rel="stylesheet">
<link href="<?= base_url() ?>/../../assets/lib/SpinKit/spinkit.css" rel="stylesheet">


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

<div class="container-fluid">
    <div class="sl-pagebody">
        <div class="card pd-20 pd-sm-40">

            <div class="sl-page-title">

                <!--  <p class="mg-b-20 mg-sm-b-30">Catálogo de productos</p> -->
            </div><!-- sl-page-title -->

            <div class="col-md-3 pl-0">
                <a id="agregar_btn"  class="btn btn-add" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"
                    aria-hidden="true"></i>Nuevo Paciente</a><br><br>
            </div>

            <div class="">
                <table id="datatable" class="table display table-responsive product_list dataTable no-footer">
                    <thead>
                        <tr>
                            <th class="wd-15p text-center">NOMBRE</th>
                            <th class="wd-15p text-center">Fecha nacimiento</th>
                            <th class="wd-15p text-center">Edad</th>
                            <th class="wd-15p text-center">TELÉFONO CASA</th>
                            <th class="wd-15p text-center">TELÉFONO CELULAR</th>
                            <th class="wd-15p text-center">DOMICILIO</th>
                            <th class="wd-15p text-center">HISTORIA CLINICA</th>
                            <th class="wd-15p text-center">Historial citas</th>
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

<!-- MODAL PARA CREAR PACIENTE -->
<div id="modal_create" class="modal fade">
    <div class="modal-dialog modal-lg modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-ingresa pd-y-20 pd-x-25">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold"> Agregar Paciente</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="pd-20">
                <div class="card pd-20 pd-sm-40">
                    <h6 class="card-body-title">Datos del paciente</h6>
                    <p class="mg-b-20 mg-sm-b-30">Llenar todos los campos</p>

                    <form id="registroPaciente" method="POST" enctype="multipart/form-data">
                        <div class="form-layout">
                            <div class="row mg-b-25">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" minlength="3" maxlength="50" name="nombre" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">SEXO: <span class="tx-danger">*</span></label>
                                        <select class='form-control sex' name='sex' autocomplete="off" required>
                                            <option value="">Selecciona una opción</option>
                                            <option value="1">Mujer</option>
                                            <option value="2">Hombre</option>
                                            <option value="3">Prefiero no decirlo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">FECHA DE NACIMIENTO: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="date" name="f_nacimiento" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">LUGAR DE NACIMIENTO: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="lugar_nac" minlength="4" maxlength="100" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">TELÉFONO CASA: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="tel_casa" pattern="[0-9]+" minlength="10" maxlength="10" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">TELÉFONO CELULAR: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="tel_celular" pattern="[0-9]+" minlength="10" maxlength="10" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">DOMICILIO: </label>
                                        <textarea class="form-control" type="text" name="direccion" minlength="10" maxlength="100" autocomplete="off"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-add pd-x-20"><i class="fa fa-plus mr-1" aria-hidden="true"></i>Agregar</button>
                            <button type="button" class="btn btn-cancelar pd-x-20" data-dismiss="modal"><i class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA EDITAR DATOS -->
<div id="modal_update" class="modal fade">
    <div class="modal-dialog modal-lg modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-edit pd-y-20 pd-x-25">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold"> ACTUALIZAR Paciente</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="pd-20">
                <div class="card pd-20 pd-sm-40">
                    <h6 class="card-body-title">Datos del paciente</h6>
                    <p class="mg-b-20 mg-sm-b-30">Llenar todos los campos</p>

                    <form id="updatePaciente" method="POST" enctype="multipart/form-data">
                        <div class="form-layout">
                            <div class="row mg-b-25">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" minlength="3" maxlength="50" id="nombre" name="nombre" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">SEXO: <span class="tx-danger">*</span></label>
                                        <select class='form-control sex' id='sex' name='sex' autocomplete="off" required>
                                            <option value="">Selecciona una opción</option>
                                            <option value="1">Mujer</option>
                                            <option value="2">Hombre</option>
                                            <option value="3">Prefiero no decirlo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">FECHA DE NACIMIENTO: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="date" id="f_nacimiento" name="f_nacimiento" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">LUGAR DE NACIMIENTO: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="lugar_nac" name="lugar_nac" minlength="4" maxlength="100" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">TELÉFONO CASA: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="tel_casa" name="tel_casa" pattern="[0-9]+" minlength="10" maxlength="10" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">TELÉFONO CELULAR: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" id="tel_celular" name="tel_celular" pattern="[0-9]+" minlength="10" maxlength="10" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">DOMICILIO: </label>
                                        <textarea class="form-control" type="text" id="direccion" name="direccion" minlength="10" maxlength="100" autocomplete="off"></textarea>
                                        <input class="form-control" type="hidden" id="id_update" name="id_update">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-edit pd-x-20"><i class="fa fa-plus mr-1" aria-hidden="true"></i>ACTUALIZAR</button>
                            <button type="button" class="btn btn-cancelar pd-x-20" data-dismiss="modal"><i class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Model eliminar paciente-->
<div id="modal_delete" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-danger pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ELIMINAR PACIENTE</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="eliminarPaciente" class="formDelete">
                <div class="pd-80 pd-sm-80 form-layout form-layout-4">
                    <h6 style="text-align:center;">¿Deseas continuar con esta acción?</h6>
                    <br>
                    <p style="color:red; text-align:center;">No se podrá deshacer la acción una vez realizada.</p>
                    <input type="hidden" name="id" id="id_delete">
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