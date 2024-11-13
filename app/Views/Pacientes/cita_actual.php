<div id="loader" class="modal fade show">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="d-flex ht-300 pos-relative align-items-center">
            <div class="sk-chasing-dots">
                <div class="sk-child sk-dot1 bg-red-800"></div>
                <div class="sk-child sk-dot2 bg-green-800"></div>
            </div>
        </div>
    </div>
</div>

<div class="container-xxl">
    <div class="row col-12 justify-content-center">
        <div id="n_paciente" class="col-8 mt-5"></div>
        <div id="div_folio" class="col-4 mt-5"></div>
    </div>

    <div class="pd-20 pd-sm-20 form-layout form-layout-4"> 
        <form method="POST" id="insertTratamiento">  
            <div class="row">
                <div class="form-group mg-b-0 col-lg-6">
                    <label class="form-control-label mg-b-10">Tratamiento realizado: 
                    <span class="tx-danger">*</span>
                    </label>
                    <input type="text" name="n_trat" id="autoComplete" class="mg-t-10 form-control universidad" autocomplete="off" required style="background-color: white !important; color: rgba(0,0,0,.8) !important; border: black solid 1px !important;">
                </div>

                <div class="form-group mg-b-0 col-xl-2 col-lg-2 col-md-6 mg-t-10">
                    <label class="form-control-label mg-b-10">Precio</label>
                    <input type="text" required name="precio" id="precio" class="form-control bd-radius" style="height:40px !important; border: black solid 1px !important;">
                    <input type="hidden" required name="id_tratamiento" id="id_tratamiento" class="form-control bd-radius">
                    <input type="hidden" required name="id_paciente" id="id_paciente" class="form-control bd-radius">
                    <input type="hidden" required name="id_cita" id="folio" class="form-control bd-radius">
                </div>

                <div class="form-group mg-b-0 col-lg-2 col-xl-1 mg-t-10">
                    <label class="form-control-label mg-b-10">Cantidad:</label>
                    <select class="form-control bd-radius" name="cantidad" requiered id="cantidad" style="height:40px !important; border: black solid 1px !important;">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                
                <div class="form-group mg-b-0 col-xl-3 col-lg-3 col-md-6 mg-t-35">
                    <button id="agregar" type="submit" class="btn btn-otro d-flex justify-content-center"><i class="fa fa-plus-circle mr-1" aria-hidden="true"></i> AGREGAR TRATAMIENTO</button>
                </div>
            </div>
        </form>
    </div>

    <div id="div_trat" class="pd-20 pd-sm-20">
        <div class="mg-b-20">
            <h5 class="ml-lg-3">SERVICIOS REALIZADOS</h5>
        </div>

        <div class="col-12">
            <table id="tratamientos" class="table display table-responsive product_list" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="wd-15p text-center">NOMBRE</th>
                        <th class="wd-15p text-center">PREPARACIÓN</th>
                        <th class="wd-10 text-center">CANTIDAD</th>
                        <th class="wd-10 text-center">PRECIO</th>
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
                <!--  <button id="imprimir" type="button" class="btn btn-primary pd-x-20 ml-2 float-right"><i class="fa fa-print" aria-hidden="true"></i> IMPRIMIR</button> -->
                <!-- <button id="enviar" type="button" class="btn btn-teal pd-x-20 ml-2 float-right"><i class="fa fa-paper-plane" aria-hidden="true"></i> ENVIAR</button> -->
                <!--  <button id="terminar" type="button" class="btn btn-secondary pd-x-20 ml-2 float-right"><i class="fa fa-times" aria-hidden="true"></i> TERMINAR</button>  -->
            </div>
        </div>
    </div>
</div>

<!--Modal delete-->
<div id="modal_delete" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-danger pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">ELIMINAR TRATAMIENTO</h6>
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

<script>
    let id_paciente = <?php echo json_encode($id_paciente); ?>;
    let id_cita = <?php echo json_encode($id_cita); ?>;
</script>