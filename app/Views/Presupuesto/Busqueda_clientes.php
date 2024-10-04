<!-- Desarrollador: Airam Vargas
Fecha de creacion:
Fecha de Ultima Actualizacion: 06 - 09 -2023 por Airam Vargas
Perfil: Recepcionista
Descripcion: Busqueda de pacientes por nombre, correo y/o telefono -->

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

<div class="sl-mainpanel">
    <div class="sl-pagebody">
        <div class="card pd-20 pd-sm-40">
            <div class="sl-page-title">
                <h5 class="text-uppercase"><?= $title ?></h5>
                <p><?= $description ?></p>
            </div><!-- sl-page-title -->

            <div class="pd-20 pd-sm-20 form-layout form-layout-4">
                
                <div class="row">
                    <div class="form-group mg-b-0 col-lg-8">
                        <label class="form-control-label mg-b-10">Ingrese nombre del paciente: 
                        <span class="tx-danger">*</span>
                        </label>
                        <input type="text" name="nombre_user" id="autoComplete" class="mg-t-10 form-control universidad" autocomplete="off" required style="background-color: white !important; color: rgba(0,0,0,.8) !important; border: black solid 1px !important;">
                    </div>

                    
                </div>
            </div>
        
        </div>
        <div id="generales" class="accordion card pd-20 pd-sm-40" role="tablist" aria-multiselectable="true">
            <div class="card">
                <div class="card-header" role="tab" id="headingOne">
                    <h5><a data-toggle="collapse" data-parent="#generales" href="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne" class="tx-gray-800 transition">
                    DATOS GENERALES
                    </a></h5>
                </div>    
            </div>
            <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                <form id="form_agregar" enctype="multipart/form-data">
                    <div id="insert-datos" class="row mg-t-10">
                        <div class="col-sm-3 mg-t-10 mg-sm-t-10">
                            <label>NOMBRE:<span class="tx-danger">*</span></label>
                            <input type="text" class="form-control" name="n_cliente" id="n_cliente" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" minlength="3" maxlength="70" required>
                            <input type="hidden" name="id_user" id="id_user" class="form-control ">
                        </div>
                        <div class="col-sm-3 mg-t-10 mg-sm-t-10">
                            <label>APELLIDO PATERNO:<span class="tx-danger">*</span></label>
                            <input type="text" class="form-control" name="ap_paterno" id="ap_paterno" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" minlength="3" maxlength="50" required>
                        </div>
                        <div class="col-sm-3 mg-t-10 mg-sm-t-10">
                            <label>APELLIDO MATERNO:<span class="tx-danger">*</span></label>
                            <input type="text" class="form-control" name="ap_materno" id="ap_materno" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+" minlength="3" maxlength="50" required>
                        </div>
                        <div class="col-sm-3 mg-t-10 mg-sm-t-10">
                            <label>CORREO:</label>
                            <input type="email" class="form-control" name="correo" minlength="10" maxlength="90" id="correo">
                        </div>
                        <div class="col-sm-3 mg-t-10 mg-sm-t-10">
                            <label>TELÉFONO:<span class="tx-danger">*</span></label>
                            <input type="text" class="form-control" pattern="[0-9]{10}" minlength="10" maxlength="10" name="telefono" id="telefono" required>
                        </div>
                        <div class="col-sm-3 mg-t-10 mg-sm-t-10">
                            <label>FECHA NACIMIENTO:<span class="tx-danger">*</span></label>
                            <input type="date" class="form-control" name="f_nacimiento" id="f_nacimiento" required>
                        </div>
                        <div class="col-sm-3 mg-t-10 mg-sm-t-10">
                            <label>NACIONALIDAD:<span class="tx-danger">*</span></label>
                            <select class="form-control nacionalidad" name="nacionalidad" id="nacionalidad" required></select>
                        </div>
                        <div class="col-sm-3 mg-t-10 mg-sm-t-10">
                            <label>SEXO:<span class="tx-danger">*</span></label>
                            <select class="form-control genero" name="sexo" id="sexo" required>
                                <option label="Elige tu sexo"></option>
                                <option value="Hombre">Hombre</option>
                                <option value="Mujer">Mujer</option>
                            </select>
                        </div>
                        <div class="col-sm-3 mg-t-10 mg-sm-t-10">
                            <label>CÓDIGO POSTAL:<span class="tx-danger">*</span></label>
                            <input type="text" name="zip_code" id="cp_search" class="form-control" required placeholder="" autocomplete="off">
                            <ul id="cpResult"></ul>
                            <div class="clear"></div>
                            <input type="hidden" name="cp_id" id="cp_id">
                        </div>
                        <div class="col-sm-3 mg-t-10 mg-sm-t-10">
                            <label>
                                <i class="fa fa-user-md" aria-hidden="true"></i>
                                NOMBRE COMPLETO DEL MÉDICO EXTERNO: </label>
                            <input type="text" class="form-control" name="medico" id="medico" >
                        </div>
                        <div class="col-sm-3 mg-t-10 mg-sm-t-10">
                            <label>
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                TELÉFONO DEL MÉDICO EXTERNO: </label>
                            <input type="text" class="form-control" name="tel_medico" id="tel_medico" pattern="[0-9]{10}" minlength="10" maxlength="10">
                        </div>
                        <div class="col-sm-3 mg-t-10 mg-sm-t-10">
                            <label>
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                CORREO DEL MÉDICO EXTERNO: </label>
                            <input type="email" class="form-control" name="correo_medico" id="correo_medico" >
                        </div>
                    </div>
                    <div class="col-lg-12 mg-t-20">
                        <button type="submit" id="add_datos" class="btn btn-success pd-x-20 float-right ml-3"><i class="fa fa-arrow-right" aria-hidden="true"></i> CONTINUAR</button>
                        <button type="button" id="actualizar" class="btn btn-warning pd-x-20 float-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> ACTUALIZAR</button>
                    </div>
                </form>
                <div id="datos-info">
                    <div class="row justify-content-center text-center">
                        <div class="col-lg-3 mg-t-10 mg-sm-t-10">
                            <h6>NOMBRE </h6>
                        </div>
                        <div class="col-lg-3 mg-t-10 mg-sm-t-10">
                            <h6>CORREO </h6>
                        </div>
                        <div class="col-lg-3 mg-t-10 mg-sm-t-10">
                            <h6>TELÉFONO </h6>
                        </div>
                        <div class="col-lg-3 mg-t-10 mg-sm-t-10">
                            <h6>ELEGIR </h6>
                        </div>
                    </div>
                    <div id="datosPaciente">
                        

                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>