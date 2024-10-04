<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Twitter -->
  <meta name="twitter:site" content="@themepixels">
  <meta name="twitter:creator" content="@themepixels">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Starlight">
  <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
  <meta name="twitter:image" content="http://themepixels.me/starlight/img/starlight-social.png">

  <!-- Facebook -->
  <meta property="og:url" content="http://themepixels.me/starlight">
  <meta property="og:title" content="Starlight">
  <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

  <meta property="og:image" content="http://themepixels.me/starlight/img/starlight-social.png">
  <meta property="og:image:secure_url" content="http://themepixels.me/starlight/img/starlight-social.png">
  <meta property="og:image:type" content="image/png">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="600">

  <!-- Meta -->
  <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
  <meta name="author" content="ThemePixels">

  <title>CLINICA DENTAL</title>

  <!-- vendor css -->
  <link href="<?= base_url() ?>/../../assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="<?= base_url() ?>/../../assets/lib/Ionicons/css/ionicons.css" rel="stylesheet">

  <!-- Starlight CSS -->
  <link rel="stylesheet" href="<?= base_url() ?>/../../assets/css/starlight.css">
  <link rel="stylesheet" href="<?= base_url() ?>/../../assets/css/clinica_dental.css">
  <!--favicon -->
  <link rel="icon" href="<?= base_url() ?>/../../assets/img/clinica_odonto.png" type="image">
</head>

<body>
  <div class="login-body">
    <form method="POST" action="<?php echo base_url() . '/Login/verify_login' ?>">
      <div class="login" style="border-radius: 15px;">
        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse"><img src="<?= base_url() ?>/../../assets/img/clinica_odonto.png" height="100%" width="100%"></div>
        <div class="tx-center mg-b-20">
          <?php if (isset($error)) {
            echo $error;
            } ?>
        </div>

        <div class="form-group">
          <input type="text" class="form-control" name="email" placeholder="Ingrese correo electronico">
        </div><!-- form-group -->

        <div class="form-group">
          <div class="col-sm-12 mg-t-10 mg-sm-t-0 input-group" id="show_hide_password" style="padding-right: 0px !important;
            padding-left: 0px !important;">
            <input placeholder=" " type="password" class="form-control" name="password" id="update_password" required>
            <!-- <i class="formulario__validacion-estado fas fa-times-circle"></i> -->
            <div class="input-group-addon" style="border-radius: 10px;">
              <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
            </div>
          </div>
          <!-- <input type="password" class="form-control" name="password" placeholder="Ingrese contraseña"> -->
        </div><!-- form-group -->
        <button type="submit" class="btn btn-info btn-block btn-ingresa">INGRESAR</button>
        <br>
      </div><!-- login-wrapper -->
    </form>
  </div><!-- d-flex -->

  <script src="<?= base_url() ?>/../../assets/lib/jquery/jquery.js"></script>
  <script src="<?= base_url() ?>/../../assets/lib/popper.js/popper.js"></script>
  <script src="<?= base_url() ?>/../../assets/lib/bootstrap/bootstrap.js"></script>
  <script src="<?= base_url() ?>/../../assets/lib/select2/js/select2.min.js"></script>

  <script>
    passwd();
    passwd2();

    function passwd() {
      $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") == "text") {
          $('#show_hide_password input').attr('type', 'password');
          $('#show_hide_password i').addClass("fa-eye-slash");
          $('#show_hide_password i').removeClass("fa-eye");
        } else if ($('#show_hide_password input').attr("type") == "password") {
          $('#show_hide_password input').attr('type', 'text');
          $('#show_hide_password i').removeClass("fa-eye-slash");
          $('#show_hide_password i').addClass("fa-eye");
        }
      });
    }

    function passwd2() {
      $("#show_hide_password2 a").on('click', function(event) {
        event.preventDefault();
        if ($('#show_hide_password2 input').attr("type") == "text") {
          $('#show_hide_password2 input').attr('type', 'password');
          $('#show_hide_password2 i').addClass("fa-eye-slash");
          $('#show_hide_password2 i').removeClass("fa-eye");
        } else if ($('#show_hide_password2 input').attr("type") == "password") {
          $('#show_hide_password2 input').attr('type', 'text');
          $('#show_hide_password2 i').removeClass("fa-eye-slash");
          $('#show_hide_password2 i').addClass("fa-eye");
        }
      });
    }
  </script>

</body>

</html>