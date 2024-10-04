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

<div class="sl-mainpanel">
    <div class="sl-pagebody">
        <div class="card pd-20 pd-sm-40">
            <div class="sl-page-title">
                <h5 class="text-uppercase"><?=$title?></h5>
                <p><?=$description?></p>
            </div>
            <div class="">
                <table id="datatable1" class="table display table-responsive imagenes-avance">
                    <thead>
                        <tr>
                            <th class="wd-15p">FECHA</th>
                            <th class="wd-15p">EMPRESA</th>
                            <th class="wd-15p text-left">NOMBRE</th>
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