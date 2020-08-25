<br>
<br>
<div class="container">
	<div class="card">
	  <div class="card-body">
	    <center><h5 class="card-title">Crear nuevo usuario.</h5>
	    <h6 class="card-subtitle mb-2 text-muted">Ingrese datos de usuario.</h6></center>
	    <hr>
	    <form action="index.php?c=usuario&a=save" id="formulario-crear-usuario" method="post" enctype="multipart/form-data">

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
                </div>

                        <div class="col-sm-7 contenedor-data-registro" >
                          <br>
                          <div class="row">
                            <div class="col-md-12">
                                <center><label for="primernombre" class="text-color">Perfil del usuario*</label></center>
                              </div>
                          </div>
                            <div class="row">
                                <div class="col-md-3 offset-md-3">
                                  <div class="form-check">
                                    <label class="form-check-label">
                                      <input class="form-check-input" type="radio" name="perfil" id="perfil1" value="1"> Coordinador
                                      <span class="circle">
                                        <span class="check"></span>
                                      </span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="form-check">
                                    <label class="form-check-label">
                                      <input class="form-check-input" type="radio" name="perfil" id="perfil2" value="2" checked> Vendedor
                                      <span class="circle">
                                        <span class="check"></span>
                                      </span>
                                    </label>
                                  </div>
                                </div>
                              </div>
                              <br>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="primernombre" class="text-color">Primer nombre*</label>
                                <input type="text" class="form-control" id="primernombre" name="primernombre" required="required">
                                
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="segundonombre" class="text-color">Segundo nombre</label>
                                <input type="text" class="form-control" id="segundonombre" name="segundonombre">
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="primernombre" class=" text-color ">Primer apellido*</label>
                                <input type="text" class="form-control" id="primerapellido" name="primerapellido" required="required">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="segundonombre" class="text-color ">Segundo apellido</label>
                                <input type="text" class="form-control" id="
                                segundoapellido" name="segundoapellido">
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="Documento" class="text-color">Documento de indentidad*</label>
                                <input type="number" class="form-control" id="Documento" name="Documento" required="required">
                              </div>
                            </div>

                            <div class="col-md-6 container-select2">
                              <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                <label for="Genero" class="text-color bmd-label-floating">Genero*</label>
                                <select class="select2 form-control pmd-select2" id="Genero" name="Genero" required="required">
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
                                <label for="Celular" class="text-color">Telefono 1</label>
                                <input type="number" class="form-control" id="Telefono_1" name="Telefono_1" required="required">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="Telefono" class="text-color">Telefono 2</label>
                                <input type="number" class="form-control" id="Telefono_2" name="Telefono_2">
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="Edad" class="text-color ">Edad</label>
                                <input type="number" class="form-control" id="Edad" name="Edad" disabled="disabled" required="required">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group is-filled">
                                <label for="Fecha" class="text-color ">Fecha de nacimiento*</label>
                                <input type="text" class="form-control datetimepicker" id="Fecha" name="Fecha" required="required">
                              </div>
                            </div>
                          </div>
                          <br>

                        </div>
                      </div>
                      <hr>  
                        <div class="row">
                     
                        <div class="col-md-6 container-select2">
                          <div class="form-group">
                            <label for="estados" class="text-color">Estados*</label>
                            <select class="select2 form-control" id="estados" name="estados" required="required">
                                <option value="0">Selecione un estado...</option>
                               
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6 container-select2">
                              <div class="form-group">
                                <label for="ciudades" class="text-color">Ciudades*</label>
                                <select class="select2 form-control" id="ciudades" name="ciudades" required="required">
                                    <option>Selecione un ciudad...</option>
                                   
                                </select>
                              </div>
                            </div>
                    
                    </div>
                      <div class="row">
                     
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="Direcion" class="text-color">Direcion de la residenta*</label>
                            <input type="text" class="form-control" id="Direcion" name="Direcion" required="required">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="Correo" class="bmd-label-floating text-color">Correo electronico*</label>
                            <input type="email" class="form-control" id="Correo" name="Correo" required="required">
                          </div>
                        </div>
                    
                    </div>
                   <div class="row">
                      <div class="col-md-6">
                        <div class="form-group bmd-form-group is-filled">
                          <label for="contra1" class="bmd-label-floating text-color">Contraseña*</label>
                          <input type="password" class="form-control" id="contra1" autocomplete="off" name="pas1" required="required">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group bmd-form-group is-filled">
                          <label for="contra2" class="bmd-label-floating text-color">Cofirmar*</label>
                          <div class="input-group">
                            <input type="password" class="form-control" id="contra2" name="pas2" autocomplete="off" required="required">
                            <div class="input-group-prepend visualizacion">
                              <span class="input-group-text">
                                <i class="fas fa-eye" id="visualizacion_crear"></i>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                <button type="button" class="btn btn-danger btn-md cerrar-modal posicion-flotante-derecho" data-dismiss="modal" onClick="history.back()">Atras</button>
                <button type="submit" class="btn btn-primary btn-md posicion-flotante-derecho">Guardar</button>
      
            </form>
	          
	  </div>
	</div>
  <br>
  <br>
</div>