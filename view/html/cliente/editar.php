<br>
<br>
<br>
<br>
<br>
<div class="container">
	<div class="card">
	  <div class="card-body">
	    <center><h5 class="card-title">Editar cliente.</h5>
	    <h6 class="card-subtitle mb-2 text-muted">Ingrese nuevos datos del cliente <?php echo $data[0]['primer_nombre_clie'].' '.$data[0]['primer_apellido_clie']; ?>.</h6>
      <h6 class="card-subtitle mb-2 text-muted">CC: <?php echo $data[0]['documento_clie']; ?>.</h6>
      </center>
	    <hr>
	    <form action="index.php?c=cliente&a=update" id="formulario-editar-cliente" method="post" enctype="multipart/form-data">
	    	<div class="row">
                <div class="col-sm-5 contenedor-img-registro">
                   <div class="kv-avatar rounded-circle ">
                      <div class="file-loading">
                          <input id="avatar-2" name="avatar-2" type="file" data-src="./view/assets/imagenes_cliente/<?php echo $data[0]['foto_clie']; ?>">
                      </div>
                    </div>
                    <div class="kv-avatar-hint">
                        <small><strong>Notas:</strong> Si seleciona un archivo con extecion diferente a "jpg", "png", "gif" no se gurdara, Archivo menores de 1500 KB. </small>
                    </div>
                     <div id="kv-avatar-errors-2" class="center-block"></div>
                </div>

                        <div class="col-sm-7 contenedor-data-registro" >
       
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="primernombre" class="text-color">Primer nombre*</label>
                                <input type="text" class="form-control" id="primernombre" name="primernombre" value="<?php echo $data[0]['primer_nombre_clie']; ?>" required="required">
                                
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="segundonombre" class="text-color">Segundo nombre</label>
                                <input type="text" class="form-control" id="segundonombre" name="segundonombre" value="<?php echo $data[0]['segundo_nombre_clie']; ?>" >
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="primernombre" class=" text-color ">Primer apellido*</label>
                                <input type="text" class="form-control" id="primerapellido" name="primerapellido" required="required" value="<?php echo $data[0]['primer_apellido_clie']; ?>" >
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="segundonombre" class="text-color ">Segundo apellido</label>
                                <input type="text" class="form-control" id="
                                segundoapellido" name="segundoapellido" value="<?php echo $data[0]['segundo_apellido_clie']; ?>" >
                              </div>
                            </div>
                          </div>
                          
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="Celular" class="text-color">Telefono 1</label>
                                <input type="number" class="form-control" id="Telefono_1" name="Telefono_1" required="required" value="<?php echo $data[0]['telefono_1_clie']; ?>" >
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="Telefono" class="text-color">Telefono 2</label>
                                <input type="number" class="form-control" id="Telefono_2" name="Telefono_2" value="<?php echo $data[0]['telefono_2_clie']; ?>">
                              </div>
                            </div>
                            <div class="col-md-4 container-select2">
                              <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                <label for="Genero" class="text-color bmd-label-floating">Genero*</label>
                                <select class="select2 form-control pmd-select2" id="Genero" name="Genero" required="required">
                                    <option></option>
                                    <?php if ($data[0]['sexo_clie']=="Hombre") { ?>
                                     <option selected="selected">Hombre</option>
                                     <option>Mujer</option>
                                    <?php } else { ?>
                                      <option >Hombre</option>
                                      <option selected="selected">Mujer</option>
                                     <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="Edad" class="text-color ">Edad</label>
                                <input type="number" class="form-control" id="Edad" name="Edad" disabled="disabled" required="required">
                                <span class="bmd-help">Este campo es obligatorio.</span>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group is-filled">
                                <label for="Fecha" class="text-color ">Fecha de nacimiento*</label>
                                <input type="text" class="form-control datetimepicker" id="Fecha" name="Fecha" required="required" value="<?php echo $data[0]['fecha_nacimineto_clie']; ?>">
                                <span class="bmd-help">Este campo es obligatorio.</span>
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
                            <select class="select2 form-control" id="estados" name="estados" required="required" data-id="<?php echo $data[0]['estado_localidad_clie']; ?>">
                                <option value="0">Selecione un estado...</option>
                               
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6 container-select2">
                              <div class="form-group">
                                <label for="ciudades" class="text-color">Ciudades*</label>
                                <select class="select2 form-control" id="ciudades" name="ciudades" required="required"  data-id="<?php echo $data[0]['ciudad_localidad_clie']; ?>">
                                    <option>Selecione un ciudad...</option>
                                </select>
                              </div>
                            </div>
                    
                    </div>
                      <div class="row">
                     
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="Direcion" class="text-color">Direcion de la residenta*</label>
                            <input type="text" class="form-control" id="Direcion" name="Direcion" required="required" value="<?php echo $data[0]['direcion_clie']; ?>">
                          </div>
                        </div>
                         <div class="col-md-6">
                          <div class="form-group">
                            <label for="Direcioncobro" class="text-color">Direcion de cobro*</label>
                            <input type="text" class="form-control" id="Direcioncobro" name="Direcioncobro" required="required" value="<?php echo $data[0]['direcion_cobro_clie']; ?>">
                          </div>
                        </div>
                    </div>
                  <div class="row">
                     <div class="col-md-6">
                          <div class="form-group">
                            <label for="Correo" class="bmd-label-floating text-color">Correo electronico*</label>
                            <input type="email" class="form-control" id="Correo" name="Correo" required="required" value="<?php echo $data[0]['correo_clie']; ?>">
                          </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                              <label for="ccr" class="text-color">Documento de referencia</label>
                              <input type="number" class="form-control" id="ccr" name="ccr" value="<?php echo $data[0]['documento_ref_clie']; ?>">
                            </div>
                          </div>
                  </div>
                <button type="button" class="btn btn-danger btn-md cerrar-modal posicion-flotante-derecho" data-dismiss="modal" onClick="history.back()" >Atras</button>
                <button type="submit" class="btn btn-primary btn-md posicion-flotante-derecho">Guardar</button>
      
            </form>
	          
	  </div>
	</div>
  <br>
  <br>
</div>