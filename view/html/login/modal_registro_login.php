
 <!-- Modal -->
<div class="modal fade" id="registrarse_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true" >
    <div class="modal-dialog-full-width modal-dialog momodel" role="document">
        <div class="modal-content-full-width modal-content ">
            <div class=" modal-header-full-width card-header card-header-primary text-center">
                
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span style="font-size: 1.3em;" aria-hidden="true">&times;</span>
                </button>

                <h4 class="card-title h-color">Registrate</h4>
    
            </div>
            <form action="index.php?c=usuario&a=crear" id="formulario-crear-usuario" method="post" enctype="multipart/form-data">
  
              <div class="modal-body modal-body-custom">
                <div class="container">

                  <div class="card">
                    <h5 class="card-header card-header-primary text-center card-title">Datos usuario</h5>
                    <div class="card-body card-body-primary">
                      <div class="row">
                        <div class="col-sm-5 contenedor-img-registro">
                           <div class="kv-avatar rounded-circle ">
                              <div class="file-loading">
                                  <input id="avatar-2" name="avatar-2" type="file">
                              </div>
                            </div>
                            <div class="kv-avatar-hint">
                                <small><strong>Notas:</strong> Si seleciona un archivo con extecion diferente a "jpg", "png", "gif" no se gurdara, Archivo menores de 1500 KB. </small>
                            </div>
                             <div id="kv-avatar-errors-2" class="center-block"></div>


                          <!--<div class="drag-drop">
                            <span class="span_img">
                              <br>
                              <br>
                              <label for="Correo" class="text-color ">Foto de perfil</label>
                              <h4>
                                <font style="vertical-align: inherit;">
                                  <font style="vertical-align: inherit;">Imagen circular</font>
                                </font>
                              </h4>
                              <input type="file" multiple="multiple" alt="Imagen circular" name="img" id="img" class="foto_registro" />
                              <img src="./<?php //echo(APP_GENERAL)?>/view/assets/imagenes_app/usuario.jpg" id="imageScan" for="file" alt="Imagen circular" class="rounded-circle img-fluid" style="height: 260px; width: 282px;">
                            </span>
                            <span class="desc">Pulse en la imagen para cambiarla</span>
                          </div>-->

                        </div>

                        <div class="col-sm-7 contenedor-data-registro" >
       
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="primernombre" class="bmd-label-floating text-color">Primer nombre*</label>
                                <input type="text" class="form-control" id="primernombre" name="primernombre" required="required">
                                <span class="bmd-help">Este campo es obligatorio.</span>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="segundonombre" class="bmd-label-floating text-color">Segundo nombre</label>
                                <input type="text" class="form-control" id="segundonombre" name="segundonombre">
                                <span class="bmd-help">Este campo es opcional.</span>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="primernombre" class="bmd-label-floating text-color ">Primer apellido*</label>
                                <input type="text" class="form-control" id="primerapellido" name="primerapellido" required="required">
                                <span class="bmd-help">Este campo es obligatorio.</span>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="segundonombre" class="bmd-label-floating text-color ">Segundo apellido</label>
                                <input type="text" class="form-control" id="
                                segundoapellido" name="segundoapellido">
                                <span class="bmd-help">Este campo es opcional.</span>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="Documento" class="text-color bmd-label-floating">Documento de indentidad*</label>
                                <input type="number" class="form-control" id="Documento" name="Documento" required="required">
                                <span class="bmd-help">Este campo es obligatorio.</span>
                              </div>
                            </div>

                            <div class="col-md-6 container-select2">
                              <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                <label for="Genero" class="text-color bmd-label-floating">Genero*</label>
                                <select class="select2N form-control pmd-select2" id="Genero" name="Genero" required="required">
                                    <option></option>
                                    <option>Hombre</option>
                                    <option>Mujer</option>
                                </select>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="Celular" class="text-color bmd-label-floating">Celular</label>
                                <input type="number" class="form-control" id="Celular" name="Celular" required="required">
                                 <span class="bmd-help">Este campo es opcional.</span>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="Telefono" class="text-color bmd-label-floating">Telefono</label>
                                <input type="number" class="form-control" id="Telefono" name="Telefono">
                                 <span class="bmd-help">Este campo es opcional.</span>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group bmd-form-group">
                                <label for="Edad" class="text-color ">Edad</label>
                                <input type="number" class="form-control" id="Edad" name="Edad" disabled="disabled" required="required">
                                <span class="bmd-help">Este campo es obligatorio.</span>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group bmd-form-group is-filled">
                                <label for="Fecha" class="text-color ">Fecha de nacimiento*</label>
                                <input type="text" class="form-control datetimepicker" id="Fecha" name="Fecha" required="required">
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
                        <h5 class="card-header card-header-primary text-center card-title">Datos de localidad</h5>
                        <div class="card-body card-body-primary">
                          <br>
                          <div class="row">
                            <div class="col-md-12 container-select2">
                              <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                <label for="Pais" class="text-color bmd-label-floating">Pais*</label>
                                <select class="select2 form-control pmd-select2" id="Pais" name="Pais" required="required">
                                  <option></option>
                                  <?php foreach ($dataPaises as $dataPaises): ?>
                                    <option value="<?php echo $dataPaises['PaisCodigo']; ?>"><?php echo $dataPaises['PaisNombre']; ?></option>
                                  <?php endforeach;?>
                                  </select>
                                  <span class="bmd-help">Este campo es obligatorio.</span>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6 container-select2">
                              <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                <label for="Distrito" class="text-color bmd-label-floating">Distrito O departamento*</label>
                                <select class="select2 form-control pmd-select2" id="Distrito" name="Distrito" required="required" disabled="disabled">
                                  <option></option>
                                  </select>
                                  <span class="bmd-help">Este campo es obligatorio.</span>
                              </div>
                            </div>

                            <div class="col-md-6 container-select2">
                              <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                <label for="Ciudad" class="text-color bmd-label-floating">Ciudad*</label>
                                <select class="select2 form-control pmd-select2" id="Ciudad" name="Ciudad" required="required" disabled="disabled">
                                  <option></option>
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
                        <h5 class="card-header card-header-primary text-center card-title">Datos de cuenta</h5>
                        <div class="card-body card-body-primary">
                          <br>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="usuario" class="bmd-label-floating text-color">Nombre de usuario*</label>
                                <input type="text" class="form-control" id="usuario" name="usuario" required="required">
                                <span class="bmd-help">Este campo es obligatorio.</span>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group bmd-form-group is-filled">
                                <label for="Correo" class="bmd-label-floating text-color">Correo electronico*</label>
                                <input type="email" class="form-control" id="Correo" name="Correo" required="required">
                                <span class="bmd-help">Este campo es obligatorio.</span>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group bmd-form-group is-filled">
                                <label for="contra1" class="bmd-label-floating text-color">Contraseña*</label>
                                <input type="password" class="form-control" id="contra1" name="pas1" required="required">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group bmd-form-group is-filled">
                                <label for="contra2" class="bmd-label-floating text-color">Cofirmar*</label>
                                <div class="input-group">
                                  <input type="password" class="form-control" id="contra2" name="pas2" required="required">
                                  <div class="input-group-prepend visualizacion">
                                    <span class="input-group-text">
                                      <i class="material-icons" id="visualizacion_crear">visibility</i>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <button type="button" class="btn btn-danger btn-md cerrar-modal posicion-flotante-derecho" data-dismiss="modal">Cerrar</button>
                      <button type="submit" class="btn btn-primary btn-md posicion-flotante-derecho">Guardar</button>
                    </div>
                  
                  </div>
                </div>
              </div>
              <div class="modal-footer-full-width  modal-footer">
              </div>
            </form>
        </div>
    </div>
</div>