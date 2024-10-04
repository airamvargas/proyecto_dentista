<!-- Desarrollador: Airam Vargas
Fecha de creacion:
Fecha de Ultima Actualizacion: 22 - 08 -2023 por Airam Vargas
Perfil: Administrador
Descripcion: Se agrego tipo de muestra, contenedor y volumen en las datos del estudio-->

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
            <div class="col-md-3 col-lg-12 pl-0">
                <a href="" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1"
                    aria-hidden="true"></i>Nuevo estudio</a><br><br>
            </div>
            <div>
                <table id="crm_studies" class="table display table-responsive tablas_reportes" style="display: block; width: 100%; background-color: transparent; ">
                    <thead>
                        <tr>
                            <th class="wd-15p text-center">ESTUDIOS</th>
                            <th class="wd-10 text-center">GRUPO O ÁREA</th>
                            <th class="wd-10 text-center">DURACIÓN CITA</th>
                            <th class="wd-10 text-center">TIPO MUESTRA</th>
                            <th class="wd-10 text-center">CONTENEDOR</th>
                            <th class="wd-10 text-center">VOLUMEN</th>
                            <th class="wd-35 text-center">PREPARACIóN</th>
                            <th class="wd-35 text-center">DÍAS DE ENTREGA</th>
                            <th class="wd-35 text-center">DÍAS DE PROCESO</th>
                            <th class="wd-35 text-center">TIEMPO DE ENTREGA (EN DÍAS)</th>
                            <th class="wd-35 text-center">COSTO DE PROCESO</th>
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

<!-- CREAR ESTUDIO -->
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
                        <h6 class="card-body-title">Datos del estudio</h6>
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
                                    <label class="form-control-label">GRUPO O ÁREA: <span class="tx-danger">*</span></label>
                                        <select class="form-control grupos" name="id_category" required>
                                        </select>
                                    </div>
                                </div>

                                <div id="nombre" class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" minlength="5" maxlength="120" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                    <label class="form-control-label">TIPO DE MUESTRA: <span class="tx-danger">*</span></label>
                                        <select class="form-control muestras" name="id_type_sample">
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                    <label class="form-control-label">TIPO DE CONTENEDOR: <span class="tx-danger">*</span></label>
                                        <select class="form-control contenedores" name="id_container" required>
                                        </select>
                                    </div>
                                </div>

                                <div id="volumen" class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">VOLUMEN: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="volumen" pattern="[0-9]+" minlength="1" maxlength="5" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label"># ETIQUETAS A UTILIZAR: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="n_labels" pattern="[0-9]+" minlength="1" maxlength="5" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">DÍAS DE ENTREGA: <span class="tx-danger">*</span> <small>(Escribir días)</small></label>
                                        <input class="form-control" type="text" name="dias_entrega" minlength="1" maxlength="150" required>
                                    </div>
                                </div>

                                <div class="col-lg-4 recons">
                                    <div class="form-group">
                                        <label class="form-control-label">DÍAS DE PROCESO: <span class="tx-danger">*</span> <small>(Escribir días)</small></label>
                                        <input class="form-control" type="text" name="dias_proceso" minlength="1" maxlength="150" required>
                                    </div>
                                </div>

                                <div class="col-lg-4 recons">
                                    <div class="form-group">
                                        <label class="form-control-label">TIEMPO DE ENTREGA <span class="tx-danger">*</span> <small>(En días)</small></label>
                                        <input class="form-control" type="number" name="tiempo_entrega" pattern="[0-9]+" minlength="1" maxlength="3" required>
                                    </div>
                                </div>

                                <div id="costo" class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">COSTO DE PROCESO <span class="tx-danger">*</span></label>
                                        <input id="costo_proceso" class="form-control" type="number" name="costo_proceso" pattern="[0-9]+" minlength="1" maxlength="10" required>
                                    </div>
                                </div>

                                <div id="div_cita" class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">¿SE REQUIERE AGENDAR CITA? <span class="tx-danger">*</span></label>
                                        <select class="form-control" name="cita" id="cita" required>
                                            <option value="">Selecciona una opción</option>
                                            <option value="1">SI</option>
                                            <option value="0">NO</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="div_duracion" class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">DURACIÓN DE LA CITA: <span class="tx-danger">*</span></label>
                                        <select class="form-control" name="duracion" id="duracion" required>
                                            <option value="">Selecciona una opción</option>    
                                            <option value="15">15 minutos</option>
                                            <option value="30">30 minutos</option>
                                            <option value="45">45 minutos</option>
                                            <option value="60">1 hora</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">PRECIO LISTAS: <span class="tx-danger">*</span></label>
                                        <input id="precio" class="form-control" type="text" name="price"  minlength="3" maxlength="8" required>
                                    </div>
                                </div> -->
                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">PREPARACIÓN: <span class="tx-danger">*</span></label>
                                        <textarea rows="5" class="form-control"  name="description" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="5" maxlength="800" required></textarea>
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

<!-- ACTUALIZAR ESTUDIO-->
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
                        <h6 class="card-body-title">Datos del estudio</h6>
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
                                    <label class="form-control-label">GRUPO O ÁREA: <span class="tx-danger">*</span></label>
                                        <select class="form-control grupos" name="id_category" id="category" required>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" id="name" minlength="5" maxlength="120" required>
                                        <input type="hidden" id="id_update" name="id">
                                        <input type="hidden" id="id_insumup" name="id_insumo">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                    <label class="form-control-label">TIPO DE MUESTRA: <span class="tx-danger">*</span></label>
                                        <select class="form-control muestras" name="id_type_sample" id="id_type_sample">
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                    <label class="form-control-label">TIPO DE CONTENEDOR: <span class="tx-danger">*</span></label>
                                        <select class="form-control contenedores" name="id_container" id="id_container" required>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">VOLUMEN: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="volumen" id="updateVolumen" pattern="[0-9]+" minlength="1" maxlength="5" required>
                                    </div>
                                </div>

                                <div id="volumen" class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label"># ETIQUETAS A UTILIZAR: <span class="tx-danger">*</span></label>
                                        <input id="updateLabels" class="form-control" type="text" name="n_labels" pattern="[0-9]+" minlength="1" maxlength="5" required>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">DÍAS DE ENTREGA: <span class="tx-danger">*</span> <small>(Escribir días)</small></label>
                                        <input id="dias_entrega" class="form-control" type="text" name="dias_entrega" minlength="1" maxlength="150" required>
                                    </div>
                                </div>

                                <div class="col-lg-4 recons">
                                    <div class="form-group">
                                        <label class="form-control-label">DÍAS DE PROCESO: <span class="tx-danger">*</span> <small>(Escribir días)</small></label>
                                        <input id="dias_proceso" class="form-control" type="text" name="dias_proceso" minlength="1" maxlength="150" required>
                                    </div>
                                </div>

                                <div class="col-lg-4 recons">
                                    <div class="form-group ">
                                        <label class="form-control-label">TIEMPO DE ENTREGA <span class="tx-danger">*</span> <small>(En días)</small></label>
                                        <input id="tiempo_entrega" class="form-control" type="number" name="tiempo_entrega" pattern="[0-9]+" minlength="1" maxlength="3" required>
                                    </div>
                                </div>

                                <div id="costoUpdate" class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">COSTO DE PROCESO <span class="tx-danger">*</span></label>
                                        <input id="costoProceso_update" class="form-control" type="number" name="costo_proceso" pattern="[0-9]+" minlength="1" maxlength="10" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">¿SE REQUIERE AGENDAR CITA? <span class="tx-danger">*</span></label>
                                        <select class="form-control" name="cita" id="updateCita" required>
                                            <option value="">Selecciona una opción</option>
                                            <option value="1">SI</option>
                                            <option value="0">NO</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="div_update" class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">DURACIÓN DE LA CITA: <span class="tx-danger">*</span></label>
                                        <select class="form-control" name="duracion" id="duracion_update" required>
                                            <option value="">Selecciona una opción</option>    
                                            <option value="15">15 minutos</option>
                                            <option value="30">30 minutos</option>
                                            <option value="45">45 minutos</option>
                                            <option value="60">1 hora</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">PRECIO LISTAS: <span class="tx-danger">*</span></label>
                                        <input class="form-control" type="text" name="price" id="price" minlength="3" maxlength="8" required>
                                    </div>
                                </div> -->
                                
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label">PREPARACIÓN: <span class="tx-danger">*</span></label>
                                        <textarea rows="5" class="form-control"  name="description" id="prescription" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" minlength="5" maxlength="800" required></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12 text-right">
                                    <div class="form-group">
                                    <a id="ver-examenes" class="ver-estudios">Ver examenes</a>
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
                    <input type="hidden" name="id_insumo" id="id_insumodel">
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

<script>
    let id_group = <?php echo json_encode($id_group); ?>;
</script>

