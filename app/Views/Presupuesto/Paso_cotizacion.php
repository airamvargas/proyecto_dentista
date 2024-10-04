<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>


<div id="loader" class="modal fade show" style=" padding-left: 0px; z-index: 999999999999;">
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
        <div class="sl-page-title pd-sm-20">
            <div class="pd-20 pd-sm-20">
                <div class="sl-page-title">
                    <h4 class="text-uppercase" style="color:black;"><?= $title ?></h4>
                    <p><?= $description ?></p>
                </div><!-- sl-page-title -->

                <div class="paciente">
                    <h5 id="cliente" class="text-uppercase">Cliente: </h5>
                </div><!-- sl-page-title -->

                <div class="pd-20 pd-sm-20 form-layout form-layout-4 px-0">
                    <div class="row ">
                        <div class="form-group mg-b-0 col-lg-6 mg-b-20">
                            <label class="form-control-label mg-b-10">Beneficios:</label>
                            <select class="form-control bd-radius convenio" name="beneficio" id="beneficio">
                            </select>
                        </div>

                        <div id="div_unit" class="form-group mg-b-0 col-lg-6 mg-b-20">
                            <label class="form-control-label mg-b-10">Unidad de negocio:</label>
                            <select class="form-control bd-radius unidad" name="unidad" id="unidad">
                            </select>
                        </div>
                    </div>

                    <form method="POST" id="insert_cotization">
                        <div class="row mg-b-20">
                            <div class="form-group mg-b-0 col-lg-5 col-xl-4 mg-t-10">
                                <label class="form-control-label mg-b-10">Categoría:</label>
                                <select class="form-control bd-radius categoria" name="categoria" required id="categoria">
                                </select>
                            </div>
                            <div class="form-group mg-b-0 col-lg-5 col-xl-6 mg-t-10">
                                <label class="form-control-label mg-b-10">Nombre del producto y/o servicio:</label>
                                <input type="text" name="estudio" id="autoComplete" class="form-control universidad" autocomplete="off" required style="background-color: white !important; color: rgba(0,0,0,.8) !important; border: black solid 1px !important;">
                                <input type="hidden" name="id_product" id="id_product">
                            </div>

                            <div class="form-group mg-b-0 col-lg-2 col-xl-1 mg-t-10">
                                <label class="form-control-label mg-b-10">Cantidad:</label>
                                <select class="form-control bd-radius" name="cantidad" requiered id="cantidad">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mg-b-20 justify-content-center">
                            <div class="col-8 col-md-12 col-sm-12 row justify-content-center px-0">
                                <div class="form-group mg-b-0 col-xl-3 col-lg-6 col-md-6 mg-t-10">
                                    <label class="form-control-label mg-b-10">Precio producto</label>
                                    <input type="text" required name="precio" id="precio" class="form-control bd-radius" readonly>
                                </div>

                                <div class="form-group mg-b-0 col-xl-3 col-lg-6 col-md-6 mg-t-10">
                                    <label class="form-control-label mg-b-10">Precio o descuento</label>
                                    <input type="text" required name="precio_convenio" id="precio_convenio" class="form-control bd-radius" readonly>
                                </div>

                                <div class="form-group mg-b-0 col-xl-3 col-lg-6 col-md-6 mg-t-10">
                                    <label class="form-control-label mg-b-10">Precio final</label>
                                    <input type="text" name="precio_final" id="precio_final" class="form-control bd-radius" readonly>
                                </div>

                                <div class="form-group mg-b-0 col-xl-3 col-lg-6 col-md-6 mg-t-30">
                                    <button id="agregar" type="submit" class="btn btn-purple"><i class="fa fa-plus-circle" aria-hidden="true"></i> AGREGAR PRODUCTO</button>
                                </div>
                                <input type="hidden" name="id_cotization" id="id_cotization" readonly>
                            </div>
                            <div class="col-12 row">
                                <div id="incluye" class="col-6 mg-t-20"></div>
                                
                            </div>
                        </div>
                    </form>

                </div>

            </div>
            <div id="estudios" class="pd-20 pd-sm-20">
                <div class="mg-b-20">
                    <h5 class="ml-lg-3">SERVICIOS COTIZADOS</h5>
                </div>

                <div class="col-12">
                    <table id="crm_estudios" class="table display table-responsive product_list" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="wd-15p text-center">NOMBRE</th>
                                <th class="wd-15p text-center">PREPARACIÓN</th>
                                <th class="wd-10 text-center">PRECIO</th>
                                <th class="wd-10 text-center">CANTIDAD</th>
                                <th class="wd-10 text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody class="text-center"></tbody>
                    </table>
                </div><!-- table-wrapper -->

                <div class="mg-t-20 text-right">
                    <h4 class="mr-lg-3" id="total">TOTAL: </h4>
                    <input type="hidden" id="total_precio">
                </div>

                <div class="mg-t-40">
                    <div class="justify-content-center">
                        <button id="continuar" type="button" class="btn btn-success pd-x-20 ml-2 float-right"><i class="fa fa-arrow-right" aria-hidden="true"></i> SIGUIENTE</button>
                        <button id="imprimir" type="button" class="btn btn-primary pd-x-20 ml-2 float-right"><i class="fa fa-print" aria-hidden="true"></i> IMPRIMIR</button>
                        <button id="enviar" type="button" class="btn btn-teal pd-x-20 ml-2 float-right"><i class="fa fa-paper-plane" aria-hidden="true"></i> ENVIAR</button>
                        <button id="cancelar" type="button" class="btn btn-secondary pd-x-20 ml-2 float-right"><i class="fa fa-times" aria-hidden="true"></i> TERMINAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--ELIMINAR COTIZACION X PRODUCTO-->
<div id="modal_delete" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-danger pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ELIMINAR <?= $title ?></h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="formDelete">
                <div class="pd-80 pd-sm-80 form-layout form-layout-4">
                    <h6 style="text-align:center;">¿Deseas continuar con esta acción?</h6>
                    <br>
                    <p style="color:red; text-align:center;">No se podrán deshacer la acción una vez realizada.</p>
                    <input type="hidden" name="id_delete" id="id_delete">
                </div>
                <div class="modal-footer justify-content-center">
                    <button id="delete-btn" type="submit" class="btn btn-danger btnbtn-delete pd-x-20"><i class="fa fa-trash mr-1" aria-hidden="true"></i>Eliminar</button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

<!--ELIMINAR TODOS LOS PRODUCTOS-->
<div id="delete_productos" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-danger pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ELIMINAR PRODUCTOS</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="formDelete_productos">
                <div class="pd-80 pd-sm-80 form-layout form-layout-4">
                    <h6 style="text-align:center;">¿Deseas continuar con esta acción?</h6>
                    <br>
                    <p style="color:red; text-align:center;">No se podrán deshacer la acción una vez realizada.</p>
                    <input type="hidden" name="id_delete_all" id="id_delete_all">
                </div>
                <div class="modal-footer justify-content-center">
                    <button id="delete-btn" type="submit" class="btn btn-danger btnbtn-delete pd-x-20"><i class="fa fa-trash mr-1" aria-hidden="true"></i>Eliminar</button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

<!--MODAL CORREO ELECTRONICO-->
<div id="modal_correo" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-teal pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ENVIAR COTIZACION</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="formCorreo">
                <div class="pd-60 pd-sm-60 form-layout form-layout-4">
                    <h6 style="text-align:center;">Ingresa el correo electrónico al que desea enviar la cotización</h6>
                    <div class="mg-t-30">
                        <label class="form-control-label">Correo electrónico: </label>
                        <div class="mg-sm-t-0">
                            <input id="correo" class="form-control" type="email" name="correo" required>
                        </div>
                    </div>
                    <input type="hidden" name="id" id="id_correo">
                </div>
                <div class="modal-footer justify-content-center">
                    <button id="sendCorreo" type="submit" class="btn btn-teal pd-x-20"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Enviar</button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->


<!-- form de imprimir -->
<form  target="_blank" method="POST" id="propiedad_id">
    <input class="id_propiedad" type="hidden" name="id_cotizacion" value=<?php echo($id_cotizacion); ?>>
</form>

<script>
    let id_group = <?php echo json_encode($id_group); ?>;
    let id_cotizacion = <?php echo json_encode($id_cotizacion); ?>;
    let id_convenio = <?php echo json_encode($id_convenio); ?>;
    let name_user = <?php echo json_encode($name_user); ?>;
</script>