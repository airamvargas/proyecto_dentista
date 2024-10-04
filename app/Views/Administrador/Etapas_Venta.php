<script src="../../../assets/lib/jquery/jquery.js"></script>

<link href="../../../assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
<link href="../../../assets/lib/select2/css/select2.min.css" rel="stylesheet">
<script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script src="https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<style>
    table.dataTable thead th, 
    table.dataTable thead td,
    #datatable1 tbody th, 
    table.dataTable tbody td {
        text-align: center !important;
    }
</style>

<!--Modal delete-->
<div id="modal_delete" class="modal fade">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header bg-danger pd-x-20">
                <h6 class="tx-14 mg-b-0 tx-uppercase text-white tx-bold">Eliminar producto</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>/solimaq/public/index.php
                </button>
            </div>
            <form method="POST" id="delete_form">
                <div class=" pd-20">
                    <p class="mg-b-5">¿Desea eliminar este producto? </p>
                    <input type="hidden" name="id_delete" id="id_delete">
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger pd-x-20"><i class="fa fa-trash mr-1" aria-hidden="true"></i>Eliminar</button>
                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal"><i class="fa fa-times mr-1" aria-hidden="true"></i>Cancelar</button>
                </div>
            </form>
        </div>
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div id="modaldemo2" class="modal fade">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header pd-x-20 bg-warning ">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">ACTUALIZAR STATUS</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formUpdate" enctype="multipart/form-data">
                <div class="col-lg-12 mt-5">
                    <div class="form-group">
                        <label class="form-control-label">ACTUALIZAR STATUS: <span><span class="tx-danger">*</span></label>
                        <select class="form-control empresas" name="id_status" id="upd-empresa" required>
                        </select>
                    </div>
                </div>

                <input type="hidden" name="id" id="id_cot">
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-warning pd-x-20">ACTUALIZAR</button>
                    <button type="button" class="btn btn btn-danger pd-x-20" data-dismiss="modal">Cancelar</button>
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
                <table id="datatable1" class="table display table-responsive" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="wd-15p">ID</th>
                            <th class="wd-15p">FECHA</th>
                            <th class="wd-15p">EMPRESA</th>
                            <th class="wd-15p" style="text-align: left !important;">NOMBRE</th>
                            <th class="wd-15p">MAQUINA</th>
                            <th class="wd-15p">SERIE</th>
                            <th class="wd-15p">MODELO</th>
                            <!-- <th class="wd-15p">CAPACIDAD</th> -->
                           <!--  <th class="wd-15p">PRECIO DE VENTA</th> -->
                            <th class="wd-15p" style="color: red;">STATUS ACTUAL</th>
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