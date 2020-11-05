<div class="modal fade modalPrestamo" id="modalPrestamo" tabindex="-1" role="dialog" data-backdrop="false">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <center><h5 class="modal-title tittle"></h5></center>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <center><h6 style="position: fixed;">Datos del cliente</h6></center>
            <button class="btn btn-outline-primary btn-depliegue"><i class="fas fa-chevron-down" id="desplegue-cliente"></i></button>
          </div>
        </div>
        
        <div class="row">
          <div class="card card-prestamo-usu">
            <img class="card-img-top img-cliente" alt="Card image cap">
            <div class="card-body">
              
              <div class="row">
                <div class="col-md-6">
                  <ul>
                    <li>
                      <p><strong>Cédula del cliente: </strong><label class="cc"></label></p>
                    </li>
                    <li>
                      <p><strong>Cédula de referencia: </strong><label class="ccr"></label></p>
                    </li>
                    <li>
                      <p><strong>teléfono1 del vendedor: </strong><label class="telefono1"></label></p>
                    </li>
                    
                  </ul>
                </div>
                <div class="col-md-6">
                  <ul>
                    <li>
                      <p><strong>Dirección del cobro: </strong><label class="direcion"></label></p>
                    </li>
                    <li>
                      <p><strong>Dirección del residencia: </strong><label class="direcionc"></label></p>
                    </li>
                    <li>
                      <p><strong>teléfono2 del vendedor: </strong><label class="telefono2"></label></p>
                    </li>
                  </ul>
                </div>
              </div>
              <a href="index.php?c=historial" target="_blank" class="btn btn-primary">Concultar historial de prestamo</a>
            </div>
          </div>
        </div>
        <hr>
        <form action="index.php?c=prestamo&a=save" id="formulario-crear-prestamo" method="post">
          <center><h5 class="modal-title">La forma de pago es diaria</h5></center>
          <br>
          <div class="row">
            <div class="col-md-6">
              <label for="Valor" class="text-color">Valor de prestamo*</label>
              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">$</span>
                </div>
                <input type="text" class="form-control Spinner" name="Valor" id="Valor" onkeyup="format(this)" onchange="format(this)" min="0" max="" value="" step="1" required="required">
                <div class="input-group-append">
                  <span class="input-group-text">.00</span>
                </div>
              </div>
            </div>
            <!--<div class="col-md-6 ">
              <div class="form-group">
                <label for="ncoutas" class="text-color ">Numero de coutas*</label>
                <input type="number" class="form-control" value="1" name="ncoutas" id="ncoutas" required="required">
              </div>
            </div>-->

            <div class="col-md-6 container-select2">
                <div class="form-group">
                    <label for="ncoutas" class="text-color">Numero de coutas*</label>
                    <select class="select2N form-control pmd-select2" id="ncoutas" name="ncoutas" required="required">
                        <option value="11" selected="selected">11</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="24">24</option>
                    </select>
                </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <label for="inter" class="text-color">Intereses*</label>
              <div class="input-group form-group">
                <input type="text" class="form-control Spinner" name="inter" id="inter" onkeyup="format(this)" onchange="format(this)" min="0" max="" value="10" step="1" disabled="disabled" required="required">
                <div class="input-group-append">
                  <span class="input-group-text">%</span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="FechaLimit" class="text-color ">Fecha de limite*</label>
                <input type="text" class="form-control datetimepicker" name="FechaLimit" id="FechaLimit" required="required">
              </div>
            </div>
          </div>
          <div class="location"></div>
          <div class="row">
            <div class="col-md-6 offset-md-3">
              <label for="Valorc" class="text-color">Valor de cada couta*</label>
              <div class="form-control" id="Valorc">
                
              </div>
            </div>
            
            <!--<div class="col-md-6 container-select2">
              <div class="form-group pmd-textfield pmd-textfield-floating-label">
                <label for="Formap" class="text-color bmd-label-floating">Forma de pago*</label>
                <select class="select2 form-control pmd-select2" id="Formap" name="Formap" required="required">
                  <option value="0" selected="selected">Seleciona una forma de pago</option>
                  <option value="1">Diario</option>
                  <option value="2">Dia de por medio</option>
                  <option value="3">Semanal</option>
                  <option value="4">Quincedal</option>
                  <option value="5">Mensual</option>
                </select>
              </div>
            </div>-->
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="guardarPrestamo">Guardar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
      </div>
    </div> 
  </div>
</div>