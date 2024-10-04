<!-- Desarrollador: José Antonio Flores
Fecha de creacion: 
Fecha de Ultima Actualizacion: 13 - 08 - 2024
Desarrollador actualizo: Airam V. Vargas
Perfil: Back Office
Descripcion:  JS de los datos del inicio -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.min.js" integrity="sha512-asxKqQghC1oBShyhiBwA+YgotaSYKxGP1rcSYTDrB0U6DxwlJjU59B67U8+5/++uFjcuVM8Hh5cokLjZlhm3Vg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js" integrity="sha512-R/QOHLpV1Ggq22vfDAWYOaMd5RopHrJNMxi8/lJu8Oihwi4Ho4BRFeiMiCefn9rasajKjnx9/fTQ/xkWnkDACg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link href="../../../assets/lib/SpinKit/spinkit.css" rel="stylesheet">


<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<link href="../../../assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script> -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap4.min.js"></script>  -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>



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

<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">

  <div class="sl-pagebody">

    <div class="row row-sm">
      <div class="col-sm-6 col-xl-3">
        <div class="card pd-20 bg-primary">
          <div class="d-flex justify-content-between align-items-center mg-b-10">
            <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">Ventas por día</h6>
            <a href="" class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
          </div><!-- card-header -->
          <div class="d-flex align-items-center justify-content-between">
            <span class="sparkline2">5,3,9,6,5,9,7,3,5,2</span>
            <h3 class="mg-b-0 tx-white tx-lato tx-bold">
              <div id="ventas_days">$</div>
            </h3>
          </div><!-- card-body -->
          <div class="d-flex align-items-center justify-content-between mg-t-15 bd-t bd-white-2 pd-t-10">
            <div>
              <span class="tx-11 tx-white-6">Numero de pruebas</span>
              <h6 class="tx-white mg-b-0">
                <div id="num_pruebas"></div>
              </h6>
            </div>
            <div>
              <span class="tx-11 tx-white-6">Numero de pacientes</span>
              <h6 class="tx-white mg-b-0">
                <div id="num_pacientes">
              </h6>
            </div>
          </div><!-- -->
        </div><!-- card -->
      </div><!-- col-3 -->
      <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
        <div class="card pd-20 bg-info">
          <div class="d-flex justify-content-between align-items-center mg-b-10">
            <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">VENTAS POR SEMANA</h6>
            <a href="" class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
          </div><!-- card-header -->
          <div class="d-flex align-items-center justify-content-between">
            <span class="sparkline2">5,3,9,6,5,9,7,3,5,2</span>
            <h3 class="mg-b-0 tx-white tx-lato tx-bold">
              <div id="vweek_ventas">$</div>
            </h3>
          </div><!-- card-body -->
          <div class="d-flex align-items-center justify-content-between mg-t-15 bd-t bd-white-2 pd-t-10">
            <div>
              <span class="tx-11 tx-white-6">Numero de pruebas</span>
              <h6 class="tx-white mg-b-0">
                <div id="vweek_pruebas"></div>
              </h6>
            </div>
            <div>
              <span class="tx-11 tx-white-6">Numero de pacientes</span>
              <h6 class="tx-white mg-b-0">
                <div id="vweek_pacientes"></div>
              </h6>
            </div>
          </div><!-- -->
        </div><!-- card -->
      </div><!-- col-3 -->
      <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
        <div class="card pd-20 bg-purple">
          <div class="d-flex justify-content-between align-items-center mg-b-10">
            <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">VENTAS POR MES</h6>
            <a href="" class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
          </div><!-- card-header -->
          <div class="d-flex align-items-center justify-content-between">
            <span class="sparkline2">5,3,9,6,5,9,7,3,5,2</span>
            <h3 class="mg-b-0 tx-white tx-lato tx-bold">
              <div id="month_ventas">$</div>
            </h3>
          </div><!-- card-body -->
          <div class="d-flex align-items-center justify-content-between mg-t-15 bd-t bd-white-2 pd-t-10">
            <div>
              <span class="tx-11 tx-white-6">Numero de pruebas</span>
              <h6 class="tx-white mg-b-0">
                <div id="month_pruebas"></div>
              </h6>
            </div>
            <div>
              <span class="tx-11 tx-white-6">Numero de pacientes</span>
              <h6 class="tx-white mg-b-0">
                <div id="month_pacientes"></div>
              </h6>
            </div>
          </div><!-- -->
        </div><!-- card -->
      </div><!-- col-3 -->
      <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
        <div class="card pd-20 bg-sl-primary">
          <div class="d-flex justify-content-between align-items-center mg-b-10">
            <h6 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">VENTAS POR AÑO</h6>
            <a href="" class="tx-white-8 hover-white"><i class="icon ion-android-more-horizontal"></i></a>
          </div><!-- card-header -->
          <div class="d-flex align-items-center justify-content-between">
            <span class="sparkline2">5,3,9,6,5,9,7,3,5,2</span>
            <h3 class="mg-b-0 tx-white tx-lato tx-bold">
              <div id="year_ventas">$</div>
            </h3>
          </div><!-- card-body -->
          <div class="d-flex align-items-center justify-content-between mg-t-15 bd-t bd-white-2 pd-t-10">
            <div>
              <span class="tx-11 tx-white-6">Numero de pruebas</span>
              <h6 class="tx-white mg-b-0">
                <div id="year_pruebas"></div>
              </h6>
            </div>
            <div>
              <span class="tx-11 tx-white-6">Numero de paciente</span>
              <h6 class="tx-white mg-b-0">
                <div id="year_pacientes"></div>
              </h6>
            </div>
          </div><!-- -->
        </div><!-- card -->
      </div><!-- col-3 -->
    </div><!-- row -->

    <div class="row row-sm mg-t-20 justify-content-center">
      <div class="col-12 row justify-content-center">
        <div class="col-lg-3">
          <div class="form-group">
            <label class="form-control-label">VER POR: <span class="tx-danger">*</span></label>
            <select class="form-control datos" name="datos" id="datos" required>
              <option value="1">GRÁFICA</option>
              <option value="2">TABLA</option>
            </select>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="form-group">
            <label class="form-control-label">DATOS POR: <span class="tx-danger">*</span></label>
            <select class="form-control" name="tipo_dato" id="tipo_dato" required>
              <option value="1">Unidad de negocio</option>
              <option value="2">Articulos</option>
              <option value="3">Convenio</option>
              <option value="4">Recepcionista</option>
            </select>
          </div>
        </div>
        <div class="col-3">
          <label for="min">Desde:</label>
          <input class="form-control" type="date" id="min" name="min">
        </div>
        <div class="col-3">
          <label for="max">Hasta:</label>
          <input class="form-control" type="date" id="max" name="max">
        </div>
      </div>
    </div><!-- row -->
  </div><!-- sl-pagebody -->



  <!-- TABLAS DINAMICAS -->

  <div id="div_tablas" class="row col-12 justify-content-center">
    <div id="tabla_ventas" class="col-12">
      <h3>Hola aqui va una tabla</h3>
    </div>
    <div id="tabla_productos" class="col-12">
      <h3>Hola aqui va otra tabla</h3>
    </div>
  </div>

</div><!-- sl-mainpanel -->

<div id="div_graficas" class="row justify-content-center">
  <div class="card overflow-hidden">
    <div class="card-header bg-transparent pd-y-20 d-sm-flex align-items-center justify-content-between">
      <div class="mg-b-20 mg-sm-b-0">
        <h3 class="card-title  tx-uppercase tx-bold tx-spacing-1">VENTAS</h3>
        <div>
          <canvas id="myChart" width="800" height="800"></canvas>
        </div>
      </div>
    </div><!-- card-header -->

    <div class="card-body pd-0">
      <div id="rickshaw2" class="wd-100p ht-200"></div>
    </div><!-- card-body -->
  </div><!-- card -->

</div><!-- col-8 -->

<div class="row col-12 justify-content-center">
  <div class="col-xl-8 mg-t-20 mg-xl-t-0">
    <div class="card pd-20 pd-sm-25 mg-t-40">
      <canvas id="myPieGraph" height="200"></canvas>
    </div>
  </div><!-- col-3 -->
</div>

<!-- <footer class="sl-footer">
    <div class="footer-left">
      <div class="mg-b-2">Copyright &copy; 2020. Webcorp. All Rights Reserved.</div>
      <div>Solimaq S.A de C.V.</div>
    </div>
    <div class="footer-right d-flex align-items-center">
      <span class="tx-uppercase mg-r-10">Share:</span>
      <a target="_blank" class="pd-x-5" href="https://www.facebook.com/sharer/sharer.php?u=http%3A//themepixels.me/starlight"><i class="fa fa-facebook tx-20"></i></a>
      <a target="_blank" class="pd-x-5" href="https://twitter.com/home?status=Starlight,%20your%20best%20choice%20for%20premium%20quality%20admin%20template%20from%20Bootstrap.%20Get%20it%20now%20at%20http%3A//themepixels.me/starlight"><i class="fa fa-twitter tx-20"></i></a>
    </div>
  </footer> -->
<!-- ########## END: MAIN PANEL ########## -->