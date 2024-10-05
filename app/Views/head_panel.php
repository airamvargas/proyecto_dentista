<?php $session = session(); ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary row">
  <div class="container-fluid col-12">
    <!-- <button class="navbar-toggler col-lg-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"><i class="fa fa-bars" aria-hidden="true"></i></span>
    </button> -->
    <div class="collapse navbar-collapse col-10" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?=base_url()."/Principal"?>">INICIO</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?=base_url()."/Administrador/Pacientes"?>">PACIENTES</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">AGENDAR CITA</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?=base_url()."/Presupuesto/Cotizacion"?>">PRESUPUESTO</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            CATALOGOS
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="<?=base_url()."/Catalogos/Tratamientos"?>">Tratamientos</a>
            <!-- <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a> -->
          </div>
        </li>
      </ul>
    </div>
    <div class="col-1 row justify-content-end">
      <a href="<?=base_url()."/login/sign_out"?>"><button type="button" id="cerrar_sesion" data-bs-toggle="collapse" title="Cerrar Sesión">
        <i class="fa fa-sign-out" aria-hidden="true"></i>
      </button></a>
    </div>
  </div>
</nav>