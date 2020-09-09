<div class="modal fade modalAbono" id="modalAbono" tabindex="-1" role="dialog" data-backdrop="false">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <center><h5 class="modal-title tittle"></h5></center>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <center><h4>Detalle de la venta: </h4></center>
        <br>
        <form action="index.php?c=abono&a=abonarPago" id="formulario-crear-abonar" method="post">
          <div class="row">
             <div class="col-md-4">
              <center><h5 class="modal-title">Numero del prestamo: <label class="nPres"></label></h5></center>
            </div>
            <div class="col-md-4">
              <center><h5 class="modal-title">Numero de esta couta: <label class="numeroCouta"></label></h5></center>
            </div>
            <div class="col-md-4">
              <center><h5 class="modal-title">Valor a pagar: <label class="valor"></label></h5></center>
            </div>
          </div>
          <hr>
          <center><h5 class="modal-title">Totales: </h5></center>
          <br>
          <div class="row">
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title text-color card-title-detalles">Total de venta:</h5>
                  <p class="card-text totalV"></p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title text-color card-title-detalles">Total de pagado:</h5>
                  <p class="card-text totalP"></p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title text-color card-title-detalles">Total de debe:</h5>
                  <p class="card-text totalD"></p>
                </div>
              </div>
            </div>
          </div>
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

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="Nota">Nota</label>
                <textarea class="form-control" name="notaPago" id="Nota"></textarea>
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