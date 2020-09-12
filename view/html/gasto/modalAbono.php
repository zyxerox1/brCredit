<div class="modal fade modalAbono" id="modalAbono" tabindex="-1" role="dialog" data-backdrop="false">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <center><h5 class="modal-title tittle">Abonar gasto vendedor</h5></center>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="index.php?c=gasto&a=abonarGasto" id="formulario-crear-abonar" method="post">
          <br>
          <div class="row">
            <div class="col-md-12 valorManual">
              <label for="valorAbono" class="text-color">Valor de abono*</label>
              <div class="input-group form-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">$</span>
                </div>
                <input type="text" class="form-control Spinner" name="valorAbono" id="valorAbono" onkeyup="format(this)" onchange="format(this)" min="0" max="" value="1" step="1" required="required">
                <div class="input-group-append">
                  <span class="input-group-text">.00</span>
                </div>
              </div>
            </div>
          </div>
          <div class="location"></div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="Nota">Nota</label>
                <textarea class="form-control" name="notaGasto" id="Nota"></textarea>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="guardarAbono">Guardar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
      </div>
    </div> 
  </div>
</div>