<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js" integrity="sha512-asxKqQghC1oBShyhiBwA+YgotaSYKxGP1rcSYTDrB0U6DxwlJjU59B67U8+5/++uFjcuVM8Hh5cokLjZlhm3Vg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js" integrity="sha512-R/QOHLpV1Ggq22vfDAWYOaMd5RopHrJNMxi8/lJu8Oihwi4Ho4BRFeiMiCefn9rasajKjnx9/fTQ/xkWnkDACg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link href="../../../assets/lib/SpinKit/spinkit.css" rel="stylesheet">

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

<div class="container-fluid">
    <div class="row col-12 justify-content-center">
        <div class="col-8 mt-4">
            <h1 class="text-center">CLINICA DENTAL - LA VIGA</h1>
        </div>
    </div>

    <div class="">
        <table id="datatable" class="table display responsive nowrap">
            <thead>
                <tr>
                    <th class="wd-15p text-center">NOMBRE</th>
                    <th class="wd-15p text-center">Fecha nacimiento</th>
                    <th class="wd-15p text-center">Edad</th>
                    <th class="wd-15p text-center">TELÉFONO CASA</th>
                    <th class="wd-15p text-center">TELÉFONO CELULAR</th>
                    <th class="wd-15p text-center">DOMICILIO</th>
                    <th class="wd-15p text-center">ACCIONES</th>
                </tr>
            </thead>
        </table>
    </div><!-- table-wrapper -->
</div>