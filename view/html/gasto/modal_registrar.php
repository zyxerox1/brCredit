<form  action="index.php?c=tipo_gasto&a=save" id="formulario-crear-tipo" method="post">
  <div class="modal fade" id="agragar" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Agregar tipo de gasto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p><strong>Nota:</strong>
            <ul>
              <li type="disc">Asegúrese que no haya encontrado el tipo anteriormente.</li>
              <li type="disc">Este tipo de gasto solo será visible para usted y su coordinador.</li>
              <li type="disc">Sea coherente a la hora de escribir el tipo.</li>
            </ul>
          </p>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="tipo" class="text-color">Tipo*</label>
                <input type="text" class="form-control" id="tipo" name="tipo" required="required">
              </div>
            </div>
            <div class="row">
              <div class="col-md-10 offset-md-1">
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="aceptar" name="aceptar">
                  <label class="form-check-label" for="aceptar">Acepto mi responsibilidad y estoy de acuerdo que se elimine si el Coordinador o Administrador lo consideran.</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success guardar">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</form>