<div class="section section-signup page-header">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-10 ml-auto mr-auto">
        <div class="card card-login">
          <form class="form-signin" action="index.php" id="formulario-login" method="post">
            <div class="card-header card-header-primary text-center">
              <img class="icon-login" src="./<?php echo(APP_ICON)?>">
              <h4 class="card-title">Inicio de sesiòn</h4>
            </div>
            <br>
            <p class="description text-center text-color">ingrese tus datos (Correo o documento de identidad).</p>
   

            <div class="card-body">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-id-card" id="usuario_icon"></i>
                  </span>
                </div>
                <input type="text" name="ema" class="form-control" id="user" placeholder="Correo o nombre de usuario." required="">
              </div>
              <br>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-lock"></i>
                  </span>
                </div>
                <input type="password" class="form-control" placeholder="Contraseña..." autocomplete="off" name="pas" required="">
                <div class="input-group-prepend" id="visualizacion">
                  <span class="input-group-text">
                    <i class="fas fa-eye" id="visualizacion3"></i>
                  </span>
                </div>
              </div>
            </div>
            <center>
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="recordarme">
                Recordarme
                <span class="form-check-sign">
                  <span class="check"></span>
                </span>
              </label>
            </div>
            </center>
            <br>
            <div class="footer text-center">
              <button class="btn btn-primary" type="submit">Iniciar sesiòn<div class="ripple-container"></div></button>
            </div>

            <br>
         
            <div class="col-md-12 text-center">
              <a class="text-color" data-toggle="modal" data-target="#registrarse_modal">Olvide la contraseña.<div class="ripple-container"></div></a>
            </div>


            <br>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
