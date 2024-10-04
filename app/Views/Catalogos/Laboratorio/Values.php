<!-- Desarrollador: Airam Vargas
Fecha de creacion: 11 - 09 - 2023
Fecha de Ultima Actualizacion: 
Perfil: Administrador
Descripcion: Cátalogo de valores de un analito, según genero y edad -->

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
                <table id="crm_ranges_exam" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th class="wd-15p text-center">ID</th>
                            <th class="wd-15p text-center">GÉNERO</th>
                            <!-- <th class="wd-15p text-center">RANGO DE EDAD</th> -->
                            <th class="wd-15p text-center">EDAD MÍNIMA</th>
                            <th class="wd-15p text-center">EDAD MÁXIMA</th> 
                            <th class="wd-15p text-center">OPERADOR</th>
                            <th class="wd-15p text-center">MÍNIMO</th>
                            <th class="wd-15p text-center">MÁXIMO</th>
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
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">AGREGAR VALORES</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formCreateRange" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Datos de los valores</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <small style="color: black;"> Representación de operadores
                            <ul>
                                <li><strong> mayor: > </strong></li>
                                <li><strong> menor: < </strong>
                                </li>
                                <li><strong> mayor o igual : >= </strong></li>
                                <li><strong> menor o igual : <= </strong>
                                </li>
                            </ul>
                        </small>
                        <small style="color: black;">
                            El valor mínimo y máximo depende del tipo de resultado escogido en el analito, si es de tipo numérico y el resultado tiene que ser evaluado solo con un operador entonces el mínimo y máximo llevan el mismo valor, de lo contrario si es por rango no lleva operador. Si es de tipo texto se pone el mismo texto en ambos valores, si es cerrado este debe ponerse en ambos positivo o negativo. </small>

                            <?php echo ("<h6 class='text-center mt-4'>Resultado $resultado</h6>"); ?>
                        <br>
                        <br>
                        <div class="form-layout mt-4">
                            <div class="row mg-b-25">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">GÉNERO: <span class="tx-danger">*</span></label>
                                        <select class="form-control genero" name="id_gender" required></select>
                                    </div>
                                </div>
                                <!-- <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">RANGO DE EDADES: <span class="tx-danger">*</span></label>
                                        <select class="form-control rangos" name="id_age_range" required></select>
                                    </div>
                                </div> -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label">EDAD MÍNIMA: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" step="any" name="edad_minima" minlength="1" maxlength="5" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label">EDAD MÁXIMA: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" step="any" name="edad_maxima" minlength="1" maxlength="5" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">VALOR MÍNIMO: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" step="any" name="min" minlength="1" maxlength="15" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">VALOR MÁXIMO: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" step="any" name="max" minlength="1" maxlength="15" autocomplete="off" required>
                                        <input id="id_exam" type="hidden" class="form-control genero" name="id_exam" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">OPERADOR: <span class="tx-danger"></span></label>
                                        <select class="form-control select2" name="operator">
                                            <option value="">Sin operador</option>
                                            <option value=">"> > </option>
                                            <option value="<"> < </option>
                                            <option value=">="> >= </option>
                                            <option value="<="> <= </option>
                                        </select>
                                        <!-- <input class="form-control" type="text" name="operator" minlength="1" maxlength="2" autocomplete="off"> -->
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
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">EDITAR VALORES</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUpdateRange" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Datos del los valores</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <small style="color: black;"> Representación de operadores
                            <ul>
                                <li><strong> mayor: > </strong></li>
                                <li><strong> menor: < </strong>
                                </li>
                                <li><strong> mayor o igual : >= </strong></li>
                                <li><strong> menor o igual : <= </strong>
                                </li>
                            </ul>
                        </small>
                        <small style="color: black;">
                            El valor mínimo y máximo depende del tipo de resultado escogido en el analito, si es de tipo numérico y el resultado tiene que ser evaluado solo con un operador entonces el mínimo y máximo llevan el mismo valor, de lo contrario si es por rango no lleva operador. Si es de tipo texto se pone el mismo texto en ambos valores, si es cerrado este debe ponerse en ambos positivo o negativo. </small>

                           <?php echo ("<h6 class='text-center mt-4'>Resultado $resultado</h6>"); ?>

                        <div class="row mg-b-25 mt-4">
                            <div class="row mg-b-25">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">GÉNERO: <span class="tx-danger">*</span></label>
                                        <select id="id_gender" class="form-control genero" name="id_gender" required></select>
                                    </div>
                                </div>
                               <!--  <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">RANGO DE EDADES: <span class="tx-danger">*</span></label>
                                        <select id="id_age_range" class="form-control rangos" name="id_age_range" required></select>
                                    </div>
                                </div> -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label">EDAD MÍNIMA: <span class="tx-danger">*</span></label>
                                        <input id="edad_minima" class="form-control" type="text" step="any" name="edad_minima" minlength="1" maxlength="5" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-control-label">EDAD MÁXIMA: <span class="tx-danger">*</span></label>
                                        <input id="edad_maxima" class="form-control" type="text" step="any" name="edad_maxima" minlength="1" maxlength="5" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">VALOR MÍNIMO: <span class="tx-danger">*</span></label>
                                        <input id="min" class="form-control" type="text" name="min" minlength="1" maxlength="5" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">VALOR MÁXIMO: <span class="tx-danger">*</span></label>
                                        <input id="max" class="form-control" type="text" name="max" minlength="1" maxlength="5" autocomplete="off" required>
                                        <input id="id_update" type="hidden" name="id">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">OPERADOR: <span class="tx-danger"></span></label>
                                        <select class="form-control select2" name="operator" id="operator">
                                            <option value="">Sin operador</option>
                                            <option value=">">></option>
                                            <option value="<"> < </option>
                                            <option value=">="> >= </option>
                                            <option value="<="> <= </option>
                                        </select>
                                        <!-- <input id="operator" class="form-control" type="text" name="operator" minlength="1" maxlength="2" autocomplete="off"> -->
                                        <input id="id_exam" type="hidden" class="form-control genero" name="id_exam" required>
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
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ELIMINAR VALORES</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="formDeleteRange" class="formDelete">
                <div class="pd-80 pd-sm-80 form-layout form-layout-4">
                    <h6 style="text-align:center;">¿Deseas continuar con esta acción?</h6>
                    <br>
                    <p style="color:red; text-align:center;">No se podrá deshacer la acción una vez realizada.</p>
                    <input type="hidden" name="id" id="id_delete">
                </div>
                <div class="modal-footer justify-content-center">
                    <button id="delete-btn" type="submit" class="btn btn-danger btnbtn-delete pd-x-20"><i class="fa fa-trash mr-1" aria-hidden="true"></i>Eliminar</button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

<script>
    let id_exam = <?php echo json_encode($id_exam); ?>;
</script>