<!DOCTYPE html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="<?=$description?>">
    <meta name="author" content="ThemePixels">
    <title><?=$title?></title>

    <!--favicon -->
    <link rel="icon" href="<?=base_url()?>/../../assets/img/logo.png" type="image">

    <!-- vendor css -->
    <link href="<?=base_url()?>/../../assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?=base_url()?>/../../assets/lib/icofont/icofont.css" rel="stylesheet">
    <link href="<?=base_url()?>/../../assets/lib/simple-line-icons/simple-line-icons.css" rel="stylesheet">
    <link href="<?=base_url()?>/../../assets/css/Pacientes/style.css" rel="stylesheet">

    <link href="<?=base_url()?>/../../assets/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">

    <link href="<?=base_url()?>/../../assets/lib/rickshaw/rickshaw.min.css" rel="stylesheet">

    <?php
      foreach ($styles as $key) {
        echo "<link rel=\"stylesheet\" href=\"".base_url()."/../../assets/css/$key\"> \n";
      }
    ?>

<link href="<?=base_url()?>/../../assets/css/royal_preloader.min.css" rel="stylesheet">
  </head>

  <body style="background-color: white;">