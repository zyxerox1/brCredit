<div class="locationCoor"></div>
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
  <a class="navbar-brand mb-0 h1" href="index.php"><img src="./<?php echo(APP_ICON)?>?v=1" width="30" height="30" alt="" class="d-inline-block align-top" > <?php echo APP_TITTLE;?></a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <?php if($_SESSION["rol"]==1){?>
      <!--<li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Usuarios<span class="sr-only">(current)</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="index.php?c=usuario">Usuarios</a>
          <a class="dropdown-item" href="index.php?c=usuario&a=crear">Crear usuario</a>
        </div>
      </li>-->
      <!--<li class="nav-item active">
        <a class="nav-link" href="#">Lista cliente <span class="sr-only">(current)</span></a>
      </li>-->
      <!--<li class="nav-item active">
        <a class="nav-link" href="index.php?c=gasto">Autorizar pago de gasto <span class="sr-only">(current)</span></a>
      </li>-->
      <!--<li class="nav-item active">
        <a class="nav-link" href="#">Atrazo pagos <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">Lista abonos <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Reporte de auditoria<span class="sr-only">(current)</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="index.php?c=reporte_log_usuario">Reporte de auditoria de usuarios</a>
          <a class="dropdown-item" href="index.php?c=reporte_log_gasto">Reporte de auditoria de gasto</a>
          <a class="dropdown-item" href="index.php?c=reporte_errores">Reporte de auditoria de errores</a>
        </div>
      </li>-->
      <?php } ?>

      <?php if($_SESSION["rol"]==2){ ?>

      <!--<li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Clientes<span class="sr-only">(current)</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="index.php?c=cliente">Mis clientes</a>
          <a class="dropdown-item" href="index.php?c=cliente&a=crear">Crear clientes</a>
        </div>
      </li>-->

      <!--<li class="nav-item active">
        <a class="nav-link" href="index.php?c=abono">Registrar abono <span class="sr-only">(current)</span></a>
      </li>-->
      <!--<li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Gasto propio<span class="sr-only">(current)</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="index.php?c=gasto">Mi gastos</a>
          <a class="dropdown-item" href="index.php?c=gasto&a=registrar">Registrar gasto propio <span class="sr-only">(current)</span></a>
        </div>
      </li>-->
      <!--<li class="nav-item active">
        <a class="nav-link" href="index.php?c=historial">Historial de abono <span class="sr-only">(current)</span></a>
      </li>-->
      <!--<li class="nav-item active">
        <a class="nav-link" href="#">Aumenta saldo cliente <span class="sr-only">(current)</span></a>
      </li>-->
      <?php } ?>

    </ul>
    <form class="form-inline my-2 my-lg-0">
      <?php if ($_SESSION['rol']==2 && $_SESSION["cierre"]==0): ?>
        <a class="btn btn-outline-success my-2 my-sm-0 cerrraDia">Cerrar dia</a>
      <?php endif ?>
      <a class="btn btn-outline-danger my-3 my-sm-0 cerrra" href="index.php?c=home&a=cerrar">Cerrar sesiòn</a>
    </form>
  </div>
</nav>