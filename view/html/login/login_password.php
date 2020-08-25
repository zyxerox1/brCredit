<div class="col-md-12" id="pass_redes">
  <div class="card">
    <h5 class="card-header card-header-primary text-center">Ingrese contraseña para iniciar session</h5>
    <div class="card-body card-body-primary">
      <form class="form-signin" action="index.php?c=login&a=validatePassword" id="formulario-login" method="post">
      <br>
      <div class="row">
        <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="material-icons">lock_outline</i>
              </span>
            </div>
            <input type="password" class="form-control"  value="<?php if(isset($_COOKIE['pas'])){echo $_COOKIE['pas'];} ?>" placeholder="Contraseña..." name="pas" required="">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="material-icons" id="visualizacion">visibility</i>
              </span>
            </div>
          </div>
      </div>
      <br>
      <hr>
      <br>
      <div class="row">
        <div class="col-md-12 offset-md-5">
          <button type="submit" class="btn btn-primary btn-md btn-rounded">Enviar</button>
        </div>
      </div>
    </form>
    </div>
  </div>
</div>