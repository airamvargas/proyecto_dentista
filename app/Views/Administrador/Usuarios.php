<!-- ########## START: MAIN PANEL ########## -->


<!-- CREAR USUARIO -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-success pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">AGREGAR NUEVO USUARIO</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formCreate" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Datos del Usuario</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="col-lg- mg-b-10">
                                <div class="form-group">
                                    <label class="form-control-label">TIPO DE USUARIO: <span><span class="tx-danger">*</span></label>
                                    <select id="tipo_usuario" class="form-control" required>
                                        <option value="">Selecciona una opción</option>
                                        <option value="1"  title="Back Office, Supervisor, Recepcionista, Call center, Gerente, Recolección, Capturista">Personal</option>
                                        <option value="2" title="Médico, Tomador de muestra, Analista Laboratorio">Médico</option>
                                        <option value="3" title="Empresas recolectoras de muestras">Empresa recolectora</option>
                                    </select>
                                </div>
                            </div>
                            <div id="datosUsuarios" class="row mg-b-25">
                                
                                <div class="col-lg-12">
                                    <div class="form-group text-center">
                                        <img id="file" style="width: 20%; !important" src="<?= base_url() . '../../../assets/img/default.png' ?>" class="img-thumbnail">
                                    </div>
                                </div>
                                <div class="col-sm-12 mg-t-10 mg-sm-t-0">
                                    <div class="file-drop-area">
                                        <span class="choose-file-button">Subir Archivo</span>
                                        <span id="name-file" class="file-message">Arrastra el archivo aqui</span>
                                        <input title="Solo aceptan formatos de imagen" id="file-user" class="file-input" type="file" name="image" accept=".jpg, .png, .jpeg">
                                    </div>
                                </div>
                                <div class="col-lg-4 mt-4">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE: <span><span class="tx-danger">*</span></label>
                                        <input class="form-control" title="solo se aceptan letras" type="text" name="nombre" pattern="^[a-zA-Z0-9 ]*$" minlength="5" maxlength="25" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 mt-4">
                                    <div class="form-group">
                                        <label class="form-control-label">APELLIDO PATERNO: <span><span class="tx-danger">*</span></label>
                                        <input class="form-control" title="solo se aceptan letras" type="text" name="apellido_ap" pattern="^[a-zA-Z0-9 ]*$" minlength="5" maxlength="25" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 mt-4">
                                    <div class="form-group">
                                        <label class="form-control-label">APELLIDO MATERNO: <span><span class="tx-danger">*</span></label>
                                        <input class="form-control" title="solo se aceptan letras" type="text" name="apellido_am" pattern="^[a-zA-Z0-9 ]*$" minlength="5" maxlength="25" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-4  mt-2">
                                    <div class="form-group">
                                        <label class="form-control-label">TELÉFONO: <span class="tx-danger">*</span></label>
                                        <input class="form-control" title="solo se adminten numeros del 0 al 9" pattern="^[0-9]*$" type="text" name="telefono" minlength="10" maxlength="10" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-4  mt-2">
                                    <div class="form-group">
                                        <label class="form-control-label">EMAIL: <span><span class="tx-danger">*</span></label>
                                        <input class="form-control" type="email" name="email" required>
                                    </div>
                                </div>
                                <div class="col-lg-4  mt-2">
                                    <div class="form-group">
                                        <label class="form-control-label">CONTRASEÑA: <span class="tx-danger">*</span></label>
                                        <div class="col-sm-12 mg-t-10 mg-sm-t-0 input-group" id="show_hide_password" style="padding-left: 0 !important; padding-right: 0 !important;">
                                            <input placeholder=" " title="La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula, 
                                            al menos una mayúscula y al menos un caracter no alfanumérico" type="password" class="form-control" name="password" id="update_password" pattern="^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{8,16}$" required>
                                            <div class="input-group-addon" style="border-radius: 10px;">
                                                <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6  mt-2">
                                    <div class="form-group">
                                        <label class="form-control-label">GRUPO: <span class="tx-danger">*</span></label>
                                        <select class="form-control id_group" name="grupo" id="id_group" required></select>
                                    </div>
                                </div>
                                <div class="col-lg-6  mt-2 unit_div">
                                    <div class="form-group">
                                        <label class="form-control-label">UNIDAD DE NEGOCIO: <span class="tx-danger">*</span></label>
                                        <select class="form-control id_cat_business_unit" name="id_cat_business_unit" required></select>
                                    </div>
                                </div>

                                <div  class="modal-footer">
                                    <button type="submit" class="btn btn-success pd-x-20">Agregar</button>
                                    <button type="button" class="btn btn btn-danger pd-x-20 btn-cancelar" data-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="recolectora" class="row justify-content-center mg-b-30 d-none">
                    <a href = "<?= base_url().'/Recolectoras/Empresas'?>"><button type="button" class="btn btn-primary pd-x-20"><i class="fa fa-plus" aria-hidden="true"></i> AGREGAR EMPRESA RECOLECTORA</button></a>
                </div>
                <div id="medicos" class="row justify-content-center mg-b-30 d-none">
                    <a href = "<?= base_url().'/HCV/Administrativo/Ficha_Identificacion_Operativo'?>"><button type="button" class="btn btn-primary pd-x-20"><i class="fa fa-plus" aria-hidden="true"></i> AGREGAR MÉDICO</button></a>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div>

<!-- ACTUALIZAR USUARIO-->

<div id="updateModal" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-warning pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ACTUALIZAR USUARIO</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUpdate" enctype="multipart/form-data">
                <div class="pd-20">
                    <div class="card pd-20 pd-sm-40">
                        <h6 class="card-body-title">Datos del Usuario</h6>
                        <p class="mg-b-20 mg-sm-b-30">Rellena todos los campos</p>
                        <div class="form-layout">
                            <div class="row mg-b-25">
                                <div class="col-lg-12 ">
                                    <div id="imagen" class="text-center" style="margin-bottom: 50px;">
                                    </div>
                                </div>

                                <div class="col-sm-12 mg-t-10 mg-sm-t-0">
                                    <div class="file-drop-area">
                                        <span class="choose-file-button">Subir Archivo</span>
                                        <span class="file-message">Arrastra el archivo aqui</span>
                                        <input  title="Solo aceptan formatos de imagen" id="update-file-user" class="file-input" type="file" name="image" accept=".jpg, .png, .jpeg">
                                    </div>
                                </div>

                                <div class="col-lg-4 mt-4">
                                    <div class="form-group">
                                        <label class="form-control-label">NOMBRE: <span><span class="tx-danger">*</span></label>
                                        <input  title="solo se aceptan letras" id="nombre" class="form-control" type="text" name="nombre" pattern="^[a-zA-Z0-9 ]*$" minlength="5" maxlength="25" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-4 mt-4">
                                    <div class="form-group">
                                        <label class="form-control-label">APELLIDO PATERNO: <span><span class="tx-danger">*</span></label>
                                        <input  title="solo se aceptan letras" id="ap-paterno" class="form-control" type="text" name="apellido_ap" pattern="^[a-zA-Z0-9 ]*$" minlength="5" maxlength="25" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 mt-4">
                                    <div class="form-group">
                                        <label class="form-control-label">APELLIDO MATERNO: <span><span class="tx-danger">*</span></label>
                                        <input  title="solo se aceptan letras" id="ap-materno" class="form-control" type="text" name="apellido_am" pattern="^[a-zA-Z0-9 ]*$" minlength="5" maxlength="25" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-4  mt-2">
                                    <div class="form-group">
                                        <label class="form-control-label">TELEFONO: <span class="tx-danger">*</span></label>
                                        <input id="telefono" class="form-control" type="text" name="telefono" pattern="^[0-9]*$"  minlength="10" maxlength="10" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-lg-4  mt-2">
                                    <div class="form-group">
                                        <label class="form-control-label">EMAIL: <span><span class="tx-danger">*</span></label>
                                        <input id="email-upd" class="form-control" type="email" name="email" required>
                                    </div>
                                </div>

                                <div class="col-lg-4  mt-2">
                                    <div class="form-group">
                                        <label class="form-control-label">NUEVA CONTRASEÑA: <span class="tx-danger">*</span></label>
                                        <div class="col-sm-12 mg-t-10 mg-sm-t-0 input-group" id="show_hide_password" style="padding-left: 0 !important; padding-right: 0 !important;">
                                            <input placeholder=" " title="La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula, 
                                            al menos una mayúscula y al menos un caracter no alfanumérico" type="password" class="form-control" name="password" id="update_password" pattern="^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{8,16}$">
                                            <div class="input-group-addon" style="border-radius: 10px;">
                                                <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6  mt-2">
                                    <div class="form-group">
                                        <label class="form-control-label">GRUPO: <span class="tx-danger">*</span></label>
                                        <select id="user-grupo" class="form-control id_group" name="grupo" id="id_group"></select>
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-2 unit_div">
                                    <div class="form-group">
                                        <label id="unilab" class="form-control-label">UNIDAD DE NEGOCIO: <span class="tx-danger">*</span></label>
                                        <select id="unidad" class="form-control id_cat_business_unit" name="id_cat_business_unit"></select>
                                    </div>
                                </div>

                                <input id="password_upd" class="form-control" type="hidden" name="password_upd" required>
                                <input id="id_user" class="form-control" type="hidden" name="id_user" required>
                                <input id="id_identity" class="form-control" type="hidden" name="id_identity" required>
                                <input id="upd-id" class="form-control" type="hidden" name="id" required>
                                <input id="upd-name-foto" class="form-control" type="hidden" name="name_foto" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning pd-x-20">Actualizar</button>
                    <button type="button" class="btn btn btn-danger pd-x-20" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div>

<!--Modal delete-->
<div id="modal_delete" class="modal fade">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-danger pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Eliminar Usuario</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="formDelete">
                <div class=" pd-20">
                    <p class="mg-b-5">¿Desea eliminar este usuario? </p>
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




<div class="sl-mainpanel">
    <div class="sl-pagebody">
        <div class="card pd-20 pd-sm-40">

            <div class="sl-page-title">
                <h5 class="text-uppercase"><?= $title ?></h5>
                <p><?= $description ?></p>
                <!--  <p class="mg-b-20 mg-sm-b-30">Catálogo de productos</p> -->
            </div><!-- sl-page-title -->

            <div class="col-md-12 pl-0">
                <a href="" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus mr-1" aria-hidden="true"></i>Nuevo USUARIO</a><br><br>
            </div>
            <div class="">
                <table id="datatable" class="table display responsive nowrap">
                    <thead>
                        <tr>
                            <th class="wd-15p text-center">ID</th>
                            <th class="wd-15p text-center">FOTO</th>
                            <th class="wd-15p text-center">NOMBRE</th>
                            <th class="wd-15p text-center">CORREO</th>
                            <th class="wd-15p text-center">GRUPO</th>
                            <th class="wd-15p text-center">TELÉFONO</th>
                            <th class="wd-15p text-center">UNIDAD DE NEGOCIO</th>
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