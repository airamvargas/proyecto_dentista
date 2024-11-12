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

<div class="container-fluid mt-5">
    <div class="row col-12 justify-content-center">
        <div class="col-8 mt-4">
            <h2 class="text-center">Citas anteriores</h2>
        </div>
    </div>

    <div class="pd-20 pd-sm-20 form-layout form-layout-4 ml-5 mr-5">
        <div class="row col-12 justify-content-center">
            <div id="n_paciente" class="col-8 mt-5"></div>
            <div id="div_edad" class="col-4 mt-5"></div>
        </div>
    </div>

    <div id="div_trat" class="pd-20 pd-sm-20">
        <div class="mg-b-20">
            <h5 class="ml-lg-3">SERVICIOS REALIZADOS</h5>
        </div>

        <div class="col-12">
            <table id="tratamientos" class="table display table-responsive product_list" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="wd-15p text-center">Fecha</th>
                        <th class="wd-15p text-center">Hora</th>
                        <th class="wd-10 text-center">Tratamiento</th>
                        <th class="wd-10 text-center">A PAGAR</th>
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

        <!-- <div class="mg-t-40">
            <div class="justify-content-center">
                <button id="continuar" type="button" class="btn btn-success pd-x-20 ml-2 float-right"><i class="fa fa-arrow-right" aria-hidden="true"></i> SIGUIENTE</button>
                <button id="imprimir" type="button" class="btn btn-primary pd-x-20 ml-2 float-right"><i class="fa fa-print" aria-hidden="true"></i> IMPRIMIR</button>
                <button id="enviar" type="button" class="btn btn-teal pd-x-20 ml-2 float-right"><i class="fa fa-paper-plane" aria-hidden="true"></i> ENVIAR</button>
                <button id="terminar" type="button" class="btn btn-secondary pd-x-20 ml-2 float-right"><i class="fa fa-times" aria-hidden="true"></i> TERMINAR</button>
            </div>
        </div> -->
    </div>
</div>

<script>
    let id_paciente = <?php echo json_encode($id_paciente); ?>;
</script>