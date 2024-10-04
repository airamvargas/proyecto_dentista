<script src="../../../assets/lib/jquery/jquery.js"></script>

<link href="../../../assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
<link href="../../../assets/lib/select2/css/select2.min.css" rel="stylesheet">
<script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script src="https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<style>
    #datatable1 tbody td,
    th {
        text-align: center;
    }
</style>

<!--Modal delete-->
<div id="modal_delete" class="modal fade">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-danger pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Elimianr producto</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="delete_form">
                <div class=" pd-20">
                    <p class="mg-b-5">¿Desea eliminar este cliente? </p>
                    <input type="hidden" name="id_delete" id="id_delete">
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger pd-x-20 btnbtn-delete"><i class="fa fa-trash mr-1" aria-hidden="true"></i>Eliminar</button>
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
                <h5 class="text-uppercase"><?=$title?></h5>
                <p><?=$description?></p>
            </div>
            <div class="">
                <table id="datatable1" class="table display table-responsive clientes">
                    <thead>
                        <tr>
                            <th class="wd-15p"></th>
                            <th class="wd-15p">FECHA</th>
                            <th class="wd-15p">EMPRESA</th>
                            <th class="wd-15p">NOMBRE</th>
                            <th class="wd-15p">MAQUINA</th>
                            <th class="wd-15p">SERIE</th>
                            <th class="wd-15p">MODELO</th>
                            <th class="wd-15p">CAPACIDAD</th>
                            <th class="wd-15p">PRECIO DE VENTA</th>
                            <th class="wd-15p">ACCIONES</th> 
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div><!-- table-wrapper -->
        </div>
    </div>
</div>





<script src="../../../assets/lib/datatables/jquery.dataTables.js"></script>
<script src="../../../assets/lib/datatables-responsive/dataTables.responsive.js"></script>
<script src="../../../assets/lib/select2/js/select2.min.js"></script>