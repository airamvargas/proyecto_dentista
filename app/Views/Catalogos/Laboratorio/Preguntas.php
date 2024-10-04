<!--
* Desarrollador: Jesus Esteban Sanchez Alcantara
* Fecha Creacion: 16-agosto-2023
* Fecha de Ultima Actualizacion: 17-agosto-2023
* Perfil: Administracion
* Descripcion: Catalogo de preguntas
-->

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
            </div>
            <div class="col-md-3 pl-0">
                <a href="" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1" aria-hidden="true"></i>NUEVA PREGUNTA</a><br><br>
            </div>
            <div class="">
                <table id="tb_preguntas" class="table display table-responsive table-hover table-striped nowrap" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="wd-5p text-center">PREGUNTA</th>
                            <th class="wd-15p text-center">TIPO DE RESPUESTA</th>
                            <th class="wd-15p text-center">VALORES</th>
                            <th class="wd-10p text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- CREAR PREGUNTA -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-success pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">AGREGAR NUEVA PREGUNTA</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formCreate" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Datos de la pregunta</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row mg-b-25">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">PREGUNTA: <span class="tx-danger">*</span></label>
                                        <input minlength="5" maxlength="80" autocomplete="off" class="form-control" type="text" name="pregunta" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">TIPO : <span class="tx-danger">*</span></label>
                                        <select class="form-control" id="opcion" name="respuesta">
                                            <option value="" disabled selected>Selecciona una opción</option>
                                            <option value="1|Abierto">Abierto</option>
                                            <option value="2|Selección">Selección</option>
                                            <option value="3|Checkbox">Checkbox</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 d-none" id="checkbox">
                                    <div class="cloneContainer">
                                        <div class="col-12 row justify-content-between pr-0">
                                            <label  class="form-control-label text-uppercase">Valor del <span id="app"></span>:</label>
                                            <button type="button" id="clone-add" class="btn btn-success btn-circle btn-md" title="Agregar respuesta" style="position: relative; left: 22px;">
                                                <i class="fa fa-plus fa-lg" aria-hidden="true"></i>
                                            </button>
                                        </div> 
                                        <div class="clone">
                                            <div class="row align-items-center">
                                                <div class="form-group col-11">
                                                    <input class="form-control name" id="name" name="value_checkbox[]">
                                                </div>
                                                <div class="col-1 pl-0">
                                                    <button type="button" class="clone-remove btn btn-danger btn-circle btn-md" title="Borrar valor">
                                                        <i class="fa fa-trash-o fa-lg" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
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
    </div>
</div>

<!-- ACTUALIZAR PREGUNTA-->
<div id="updateModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-warning pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">DETALLES DE LA PREGUNTA</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formQuestions" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Datos de la pregunta</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">PREGUNTA: <span class="tx-danger">*</span></label>
                                        <input minlength="5" maxlength="80" autocomplete="off" class="form-control" type="text" id="question" name="upd_pregunta" required>
                                        <!-- <input class="form-control" type="text" id="id_question" name="id" required> -->
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input class="form-control" type="hidden" id="checkbox_question" name="id" required>
                                        <label class="form-control-label">TIPO: <span class="tx-danger">*</span></label>
                                        <select class="form-control" name="upd_respuesta" id="type">
                                            <option value="" disabled>Selecciona una opción</option>
                                            <option value="1|Abierto">Abierto</option>
                                            <option value="2|Selección">Selección</option>
                                            <option value="3|Checkbox">Checkbox</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 d-none" id="checkbox_update">
                                    <div class="containerCkeckbox">
                                        <div class="col-12 row justify-content-between pr-0 mb-1">
                                            <label for="tipo" class="form-control-label text-uppercase">Valores:</label>
                                            <button type="button" id="clone-add-checkbox" class="btn btn-success btn-circle btn-md" title="Agregar" style="position: relative; left: 35px;">
                                                <i class="fa fa-plus fa-lg" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                        <div id="updateClone" class="clone-checkbox add-clone-check">
                                        <div class="row align-items-center">
                                                <div class="form-group col-11">
                                                    <input class="form-control name" id="name" name="add_value_checkbox[]">
                                                </div>
                                                <div class="col-1">
                                                    <button type="button" class="clone-remove btn btn-danger btn-circle btn-md" title="Borrar unidad de negocio">
                                                        <i class="fa fa-trash-o fa-lg" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
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
    </div>
</div>

<!--ELIMINAR PREGUNTA-->
<div id="modal_delete" class="modal fade">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-danger pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Eliminar pregunta</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="formDelete">
                <div class=" pd-20">
                    <p class="mg-b-5">¿Deseas eliminar este valor? </p>
                    <input type="hidden" name="id_delete" id="id_delete">
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger btnbtn-delete pd-x-20"><i class="fa fa-trash mr-1" aria-hidden="true"></i>Eliminar</button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!--ELIMINAR CHEKBOX DE LA PREGUNTA-->
<div id="modal_checkbox" class="modal fade">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-danger pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Eliminar opción</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="formValues">
                <div class=" pd-20">
                    <p class="mg-b-5">¿Desea eliminar este dato? </p>
                    <input type="hidden" name="id" id="delete_check">
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger del_check pd-x-20"><i class="fa fa-trash mr-1" aria-hidden="true"></i>Eliminar</button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
