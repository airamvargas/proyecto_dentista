<script src="../../../assets/lib/jquery/jquery.js"></script>

<link href="../../../assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
<link href="../../../assets/lib/select2/css/select2.min.css" rel="stylesheet">
<script src="https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js"></script>
<link href="<?= base_url() ?>../../../assets/lib/SpinKit/spinkit.css" rel="stylesheet">


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<!--CHAR JS-->
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.15/dist/js/splide.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/helpers.esm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.esm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.15/dist/css/themes/splide-skyblue.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.15/dist/css/themes/splide-sea-green.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.15/dist/css/themes/splide-default.min.css">


<!-- ########## START: MAIN PANEL ########## -->

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
                <h5 class="text-uppercase"><?=$title?></h5>
                <p><?=$description?></p>
                <!--  <p class="mg-b-20 mg-sm-b-30">Catálogo de productos</p> -->
            </div><!-- sl-page-title -->
            <div class="col-12 row">
                <div class="col-9 row">
                    <canvas id="myChart"></canvas>
                </div>
                <div class="col-3" style="  margin-top: 30px;">
                    <div class="card bd-0">
                        <div class="card-header card-header-default bg-primary">
                            ETAPAS DE VENTA
                        </div><!-- card-header -->
                        <div class="card-body bd bd-t-0 rounded-bottom">
                            <ul id="stages" style="color: black;">
                            </ul>

                        </div><!-- card-body -->
                    </div><!-- card -->
                </div>

            </div>

            <div class="col-8 row mt-6" style="margin-top: 67px;">
                <button id="anterior" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> anterior </button>
                <button id="siguiente" class="btn btn-primary" style="left: 50px; position: relative;">siguiente <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
</div>


<script>
    offset = 5;
    getGrafica();
    gatDetalle();

    function gatDetalle() {
        const url = `${BASE_URL}/Administrador/Seguimiento/geEtapas`;
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $(data).each(function(i, v) {
                    $('#stages').append('<li type="square">' + v.id + " " + v.name + '</li>')
                });
            },
            error: function(error) {
                //alert('hubo un error al enviar los datos');
            }
        });

    }




    function getGrafica() {
        $('#loader').toggle();
        const url = `${BASE_URL}/Administrador/Seguimiento/getGrafica/`;
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#loader').toggle();
                var labels = [];
                var valores = [];
                $(data).each(function(i, v) {
                    labels.push(v.razon_social);
                    if (v.id_status == null) {
                        valores.push(0);

                    } else {
                        valores.push(parseInt(v.id_status));

                    }

                });

                var ctx = document.getElementById('myChart').getContext('2d');
                myChart = new Chart(ctx, {
                    type: 'bar',

                    data: {
                        labels: labels,
                        datasets: [{
                            axis: 'y',
                            label: 'ETAPAS DE VENTA',
                            data: valores,
                            fill: true,
                            backgroundColor: [
                                'rgba(51, 51, 255, 0.2)',
                                'rgba( 37, 187, 60 , 0.2)',
                                'rgba(245, 118, 5, 0.2)',
                                'rgba( 249, 11, 3 , 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                               /*  'rgba(153, 102, 255, 0.2)',
                                'rgba(201, 203, 207, 0.2)',
                                'rgba(201, 203, 207, 0.2)',
                                'rgba(201, 203, 207, 0.2)',
                                'rgba(54, 162, 235, 0.2)' */

                            ],
                            borderColor: [
                                'rgb(51, 51, 255)',
                                'rgb( 37, 187, 60 )',
                                'rgb(245, 118, 5)',
                                'rgb( 249, 11, 3 )',
                                'rgb(54, 162, 235)',
                                /* 'rgb(153, 102, 255)',
                                'rgb(201, 203, 207)',
                                'rgb(255, 99, 132)',
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)' */
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        scales: {
                            x: {
                                min: 0,
                                max: 7
                            }
                        }
                    }
                });


            },
            error: function(error) {
                //alert('hubo un error al enviar los datos');
            }
        });
    }

    //SIGUIENTES DATOS DE LA TABLA //

    $(document).on('click', '#siguiente', function() {
        $('#loader').toggle();
        const url = `${BASE_URL}/Administrador/Seguimiento/getGraficalimit`;
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                offset: offset
            },
            dataType: 'json',
            success: function(data) {
                //$('#loader').toggle();
                console.log(data);

                var labels = [];
                var valores = [];

                offset = data['offset'];
                $(data['grafica']).each(function(i, v) {
                    labels.push(v.razon_social);
                    if (v.id_status == null) {
                        valores.push(0);

                    } else {
                        valores.push(parseInt(v.id_status));

                    }

                });

                var ctx = document.getElementById('myChart').getContext('2d');


                myChart.clear();
                myChart.destroy();
              


                myChart = new Chart(ctx, {
                    type: 'bar',

                    data: {
                        labels: labels,
                        datasets: [{
                            axis: 'y',
                            label: 'ETAPAS DE VENTA',
                            data: valores,
                            fill: true,
                            backgroundColor: [
                                'rgba(51, 51, 255, 0.2)',
                                'rgba( 37, 187, 60 , 0.2)',
                                'rgba(245, 118, 5, 0.2)',
                                'rgba( 249, 11, 3 , 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                               /*  'rgba(153, 102, 255, 0.2)',
                                'rgba(201, 203, 207, 0.2)',
                                'rgba(201, 203, 207, 0.2)',
                                'rgba(201, 203, 207, 0.2)',
                                'rgba(54, 162, 235, 0.2)' */

                            ],
                            borderColor: [
                                'rgb(51, 51, 255)',
                                'rgb( 37, 187, 60 )',
                                'rgb(245, 118, 5)',
                                'rgb( 249, 11, 3 )',
                                'rgb(54, 162, 235)',
                                /* 'rgb(153, 102, 255)',
                                'rgb(201, 203, 207)',
                                'rgb(255, 99, 132)',
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)' */
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        scales: {
                            x: {
                               min: 0,
                               max: 7
                            }
                        }
                    }
                });

                $('#loader').toggle();


            },
            error: function(error) {
                //alert('hubo un error al enviar los datos');
            }
        });

    });

    //ANTERIOR
    $(document).on('click', '#anterior', function() {
        $('#loader').toggle();
        const url = `${BASE_URL}/Administrador/Seguimiento/getBack`;
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                offset: offset
            },
            dataType: 'json',
            success: function(data) {

                console.log(data);

                var labels = [];
                var valores = [];

                offset = data['offset'];
                $(data['grafica']).each(function(i, v) {
                    labels.push(v.razon_social);
                    if (v.id_status == null) {
                        valores.push(0);

                    } else {
                        valores.push(parseInt(v.id_status));

                    }

                });

                var ctx = document.getElementById('myChart').getContext('2d');


                myChart.clear();
                myChart.destroy();


                myChart = new Chart(ctx, {
                    type: 'bar',

                    data: {
                        labels: labels,
                        datasets: [{
                            axis: 'y',
                            label: 'ETAPAS DE VENTA',
                            data: valores,
                            fill: true,
                            backgroundColor: [
                                'rgba(51, 51, 255, 0.2)',
                                'rgba( 37, 187, 60 , 0.2)',
                                'rgba(245, 118, 5, 0.2)',
                                'rgba( 249, 11, 3 , 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                               /*  'rgba(153, 102, 255, 0.2)',
                                'rgba(201, 203, 207, 0.2)',
                                'rgba(201, 203, 207, 0.2)',
                                'rgba(201, 203, 207, 0.2)',
                                'rgba(54, 162, 235, 0.2)' */

                            ],
                            borderColor: [
                                'rgb(51, 51, 255)',
                                'rgb( 37, 187, 60 )',
                                'rgb(245, 118, 5)',
                                'rgb( 249, 11, 3 )',
                                'rgb(54, 162, 235)',
                                /* 'rgb(153, 102, 255)',
                                'rgb(201, 203, 207)',
                                'rgb(255, 99, 132)',
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)' */
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        scales: {
                            x: {
                                min: 0,
                                max: 7
                            }
                        }
                    }
                });

                $('#loader').toggle();


            },
            error: function(error) {
                //alert('hubo un error al enviar los datos');
            }
        });

    });
</script>