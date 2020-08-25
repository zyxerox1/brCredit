<div class="container">
<form action="index.php?c=usuario&a=crear" id="formulario-crear-usuario" method="post">
  <div class="card">
    <h5 class="card-header card-header-primary text-center">Datos usuario</h5>
    <div class="card-body card-body-primary">

      <div class="row">
        <div class="col-md-6">
          <div class="drag-drop">
            <span class="span_img">
              <h4>
                <font style="vertical-align: inherit;">
                  <font style="vertical-align: inherit;">Imagen circular</font>
                </font>
              </h4>
              <input type="file" multiple="multiple" alt="Imagen circular" name="img" id="img"/>
              <img src="./<?php echo(APP_GENERAL)?>/view/assets/imagenes_app/usuario.jpg" id="imageScan" for="file" alt="Imagen circular" class="rounded-circle img-fluid" style="height: 260px; width: 282px;">
            </span>
            <span class="desc">Pulse en la imagen para cambiarla</span>
          </div>
        </div>


        <div class="col-md-6">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group bmd-form-group">
                <label for="primernombre" class=" ">Primer nombre*</label>
                <input type="text" class="form-control" id="primernombre" name="primernombre" value="<?php if ($_SESSION["arraySocial"]["primerNombre"]!=''){echo $_SESSION["arraySocial"]["primerNombre"];} ?>" required="required">
                <span class="bmd-help">Este campo es obligatorio.</span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group bmd-form-group">
                <label for="segundonombre" class=" ">Segundo nombre</label>
                <input type="text" value="<?php if ($_SESSION["arraySocial"]["segundoNombre"]!=''){echo $_SESSION["arraySocial"]["segundoNombre"];} ?>" class="form-control" id="segundonombre" name="segundonombre">
                <span class="bmd-help">Este campo es opcional.</span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group bmd-form-group">
                <label for="primernombre" class=" ">Primer apellido*</label>
                <input type="text" class="form-control" id="primerapellido" name="primerapellido" value="<?php if ($_SESSION["arraySocial"]["primerApellido"]!=''){echo $_SESSION["arraySocial"]["primerApellido"];} ?>" required="required">
                <span class="bmd-help">Este campo es obligatorio.</span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group bmd-form-group">
                <label for="segundonombre" class=" ">Segundo apellido</label>
                <input type="text" class="form-control" id="
                segundoapellido" value="<?php if ($_SESSION["arraySocial"]["segundoApellido"]!=''){echo $_SESSION["arraySocial"]["segundoApellido"];} ?>" name="segundoapellido">
                <span class="bmd-help">Este campo es opcional.</span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group bmd-form-group">
                <label for="Celular" class=" ">Celular</label>
                <input type="number" value="<?php if ($_SESSION["arraySocial"]["telefono"]!=''){echo $_SESSION["arraySocial"]["telefono"];} ?>" class="form-control" id="Celular" name="Celular" required="required">
                 <span class="bmd-help">Este campo es opcional.</span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group bmd-form-group">
                <label for="Telefono" class=" ">Telefono</label>
                <input type="number" class="form-control" id="Telefono" name="Telefono">
                 <span class="bmd-help">Este campo es opcional.</span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group bmd-form-group">
                <label for="Documento" class=" ">Documento de indentidad*</label>
                <input type="number" class="form-control" id="Documento" name="Documento" required="required">
                <span class="bmd-help">Este campo es obligatorio.</span>
              </div>
            </div>
            <div class="col-md-6">
                <br>
               <div class="form-group label-floating">
                <label for="Genero" class=" ">Genero*</label>
                <select class="form-control contactSelect" id="Genero" name="Genero" required>
                  <option>Selecione tu genero</option>
                  <option>Hombre</option>
                  <option>Mujer</option>
                </select>
                <span class="bmd-help">Este campo es obligatorio.</span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group bmd-form-group">
                <label for="Edad" class=" ">Edad</label>
                <input type="number" class="form-control" id="Edad" name="Edad" disabled="disabled" required="required">
                <span class="bmd-help">Este campo es obligatorio.</span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group bmd-form-group is-filled">
                <label for="Fecha" class=" ">Fecha de nacimiento*</label>
                <input type="text" value="<?php if ($_SESSION["arraySocial"]["fechaNacimiento"]!=''){echo $_SESSION["arraySocial"]["fechaNacimiento"];} ?>" class="form-control datetimepicker" id="Fecha" name="Fecha" value="Seleciones tu fecha de nacimiento" required="required">
                <span class="bmd-help">Este campo es obligatorio.</span>
              </div>
            </div>
          </div>
          <br>

        </div>
      </div>

    </div>
  </div>
          
  <div class="row row-card">
    <div class="col-md-6">
      <div class="card">
        <h5 class="card-header card-header-primary text-center">Datos de localidad</h5>
        <div class="card-body card-body-primary">
          <br>
          <br>
          <div class="row">

            <div class="col-md-12">
              <div class="form-group label-floating">
                <label for="Pais" class=" ">Pais*</label>
                <select class="form-control contactSelect" id="Pais" name="Pais" required>
                  <option>Selecione un pais</option>
                  <?php foreach ($dataPaises as $dataPaises): ?>
                    <option value="<?php echo $dataPaises['PaisCodigo']; ?>"><?php echo $dataPaises['PaisNombre']; ?></option>
                  <?php endforeach;?>
                  </select>
                  <span class="bmd-help">Este campo es obligatorio.</span>
              </div>
            </div>
          
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group label-floating">
                <label for="Distrito" class=" ">Distrito O departamento*</label>
                <select class="form-control contactSelect" id="Distrito" name="Distrito" required>
                  <option>Selecione un distrito</option>
                  </select>
                  <span class="bmd-help">Este campo es obligatorio.</span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group label-floating">
                <label for="Ciudad" class=" ">Ciudad*</label>
                <select class="form-control contactSelect" id="Ciudad" name="Ciudad" required>
                  <option>Selecione un ciudad</option>
                  </select>
                  <span class="bmd-help">Este campo es obligatorio.</span>
              </div>
            </div>
            <br>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card">
        <h5 class="card-header card-header-primary text-center">Datos de cuenta</h5>
        <div class="card-body card-body-primary">
          <br>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group bmd-form-group">
                <label for="usuario" class=" ">Nombre de usuario*</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required="required">
                <span class="bmd-help">Este campo es obligatorio.</span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group bmd-form-group is-filled">
                <label for="Correo" class=" ">Correo electronico*</label>
                <input type="email" value="<?php if ($_SESSION["arraySocial"]["correo"]!=''){echo $_SESSION["arraySocial"]["correo"];} ?>" class="form-control" id="Correo" name="Correo">
                <span class="bmd-help">Este campo es obligatorio.</span>
              </div>
            </div>
          </div>
          <br>

          <div class="row">
            <div class="col-md-6">
              <label for="Correo" class=" ">Contraseña*</label>
              <div class="input-group">
                <input type="password" class="form-control" name="pas1" required="">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons" id="visualizacion2">visibility</i>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <label for="Correo" class=" ">Cofirmar contraseña*</label>
              <div class="input-group">
                <input type="password" class="form-control" name="pas2" required="">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons" id="visualizacion3">visibility</i>
                  </span>
                </div>
              </div>
            </div>
            <br>
            <br>
          </div>

        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card">
        <h5 class="card-header card-header-primary text-center">Aciones</h5>
        <div class="card-body card-body-primary">
          <br>
          <div class="row">
                  <div class="col-md-6 offset-md-4">
                    <a type="button" class="btn btn-danger btn-md btn-rounded" data-dismiss="modal" href="index.php?c=login&a=cancelar_redes">Cancelar</a>
                  </div>
                  <div class="col-md-6 offset-md-6">
                    <button type="submit" style="margin-top: -70px;" class="btn btn-primary btn-md btn-rounded">Guardar</button>
                  </div>
                </div>
        </div>
      </div>
    </div>
             
  </div>
</form>
</div>