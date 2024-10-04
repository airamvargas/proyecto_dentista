<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Meta -->
  <meta name="description" content="<?= $description ?>">
  <title><?= $title ?></title>

  <!--favicon -->
  <link rel="icon" href="<?= base_url() ?>/../../assets/img/clinica_odonto.png" type="image">

  <!-- vendor css -->
  <link href="<?= base_url() ?>/../../assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="<?= base_url() ?>/../../assets/lib/Ionicons/css/ionicons.css" rel="stylesheet">
  <link href="<?= base_url() ?>/../../assets/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
  <link href="<?= base_url() ?>/../../assets/lib/rickshaw/rickshaw.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>/../../assets/lib/SpinKit/spinkit.css" rel="stylesheet">
 

  <?php

  if (isset($external_styles)) {
    foreach ($external_styles as $key) {
      
      echo  "<link rel=\"stylesheet\" type=\"text/css\" href=\"$key\"> \n";
    }
  }
  foreach ($styles as $key) {
    echo "<link rel=\"stylesheet\" href=\"" . base_url() . "/../../assets/css/$key\"> \n";
  }
  ?>

  <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script> 
  <script src="<?= base_url() ?>/../../assets/js/env.js"></script>

  <link href="<?=base_url()?>/../../assets/css/royal_preloader.min.css" rel="stylesheet">

</head>

<body>