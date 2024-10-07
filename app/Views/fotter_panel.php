
  <script src="<?=base_url()?>/../../assets/lib/jquery/jquery.js"></script>
  <script src="<?=base_url()?>/../../assets/lib/popper.js/popper.js"></script>
  <script src="<?=base_url()?>/../../assets/lib/bootstrap/bootstrap.js"></script>
  <script src="<?=base_url()?>/../../assets/lib/jquery-ui/jquery-ui.js"></script>
  <script src="<?=base_url()?>/../../assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
  <script src="<?=base_url()?>/../../assets/lib/jquery.sparkline.bower/jquery.sparkline.min.js"></script>
  <script src="<?=base_url()?>/../../assets/lib/d3/d3.js"></script>
  <script src="<?=base_url()?>/../../assets/lib/rickshaw/rickshaw.min.js"></script>
  <script src="<?=base_url()?>/../../assets/lib/chart.js/Chart.js"></script>
  <script src="<?=base_url()?>/../../assets/lib/Flot/jquery.flot.js"></script>
  <script src="<?=base_url()?>/../../assets/lib/Flot/jquery.flot.pie.js"></script>
  <script src="<?=base_url()?>/../../assets/lib/Flot/jquery.flot.resize.js"></script>
  <script src="<?=base_url()?>/../../assets/lib/flot-spline/jquery.flot.spline.js"></script>
  <script src="<?=base_url()?>/../../assets/js/starlight.js"></script>
  <script src="<?=base_url()?>/../../assets/js/ResizeSensor.js"></script>

<!-- <script src="<?= base_url() ?>/../../assets/js/general.js"></script> -->

<?php
if (isset($external_scripts)) {
  foreach ($external_scripts as $key) {
    echo "<script src=\"$key\"></script> \n";
  }
}

if (isset($controlador)) {
  echo ("<p id=\"ruta\" data-my_var_1=\"$controlador\" src=\"" . base_url() . "/../../assets/js/Generales/CRUD.js\"></p> \n");
}

if (isset($scripts)) {
  foreach ($scripts as $key) {

    echo "<script src=\"" . base_url() . "/../../assets/js/$key\"></script> \n";
  }
}
?>                                                        

<script src="<?=base_url()?>/../../assets/js/royal_preloader.min.js"></script>

<script>
    window.jQuery = window.$ = jQuery;  
    (function($) { "use strict";
        //Preloader
        Royal_Preloader.config({
            mode           : 'logo',
            logo           : '<?=base_url()?>/../../assets/img/logo_medicinae.png',
            logo_size      : [180, 145],
            text_colour: '#000000',
            background: '#ffffff'
        });
    })(jQuery);
  
    
</script>  


</body>

</html>