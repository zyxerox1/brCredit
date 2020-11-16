<div class="modal fade modalRetiro" id="modalRetiro" tabindex="1" role="dialog" data-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Hacer retiro</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
            
                <div class="modal-body">
                    <form action="index.php?c=retiro&a=retiroRegistrar" id="formulario-registrar-retiro" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label for="codigo" class="text-color">Ruta*</label>
                                  <select class="select-2 form-control" id="codigo" name="codigo" required="required">
                                      <option value="0" selected="selected">Selecione una ruta</option>
                                      <?php foreach ($data_filtro_ruta as $key => $dataRuta) { ?>
                                          <option value="<?php echo $dataRuta['id']; ?>"><?php echo $dataRuta['codigo'] ?></option>
                                          
                                      <?php } ?>
                                  </select>
                                </div>
                            </div>
                        </div>

                         <div class="row">
                            <div class="col-md-12 valorManual">
                              <label for="valorRetiro" class="text-color">Valor*</label>
                              <div class="input-group form-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control Spinner" name="valorRetiro" id="valorRetiro" onkeyup="format(this)" onchange="format(this)" min="0" max="" value="1" step="1" required="required">
                                <div class="input-group-append">
                                  <span class="input-group-text">.00</span>
                                </div>
                              </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="Descripcion">Descripcion</label>
                                <textarea class="form-control" name="descripcion" id="Descripcion"></textarea>
                              </div>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success btn-ok" id="guardarRetiroConfirm">Hacer retiro</button>
                </div>
            </div>
        </div>
    </div>