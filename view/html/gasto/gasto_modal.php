<div class="modal fade" id="gastoModal" tabindex="-1" role="dialog" data-backdrop="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titleGasto"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-mb-6">
            <ul>
              <li>
                <p><strong>Detalle del vendedor: </strong></p><p class="detalle"></p>
              </li>
              <li>
                <p><strong>Fecha exacta donde se registró el gasto: </strong><label class="fecha_d"></label></p>
              </li>
              <li>
                <p><strong>Estado actual del gasto: </strong><label class="estado"></label></p>
              </li>
              <li>
                <p><strong>Valor del gasto: </strong><label class="valor"></label></p>
              </li>
            </ul>
          </div>
        </div>
        <hr>
        <div class="row">
          <h4 class="form-control"><strong>Detalle global del usuario: </strong></h4>
          <div class="col-mb-6">
            <ul>
              <li>
                <p><strong>Nombre(s) del vendedor: </strong><label class="nombre"></label></p>
              </li>
              <li>
                <p><strong>Apellido(s) del vendedor: </strong><label class="apellido"></label></p>
              </li>
              <li>
                <p><strong>teléfono1 del vendedor: </strong><label class="telefono1"></label></p>
              </li>
              <li>
                <p><strong>teléfono2 del vendedor: </strong><label class="telefono2"></label></p>
              </li>
            </ul>
          </div>
          <div class="col-mb-6">
            <ul>
              <li>
                <p><strong>Cédula del vendedor: </strong><label class="cc"></label></p>
              </li>
              <li>
                <p><strong>Correo del vendedor: </strong><label class="correo"></label></p>
              </li>
              <li>
                <p><strong>Dirección del vendedor: </strong><label class="direcion"></label></p>
              </li>
              <li>
                <p><strong>Fecha de nacimiento del vendedor: </strong><label class="fecha"></label></p>
              </li>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="col-mb-6">
            <ul>
              </li>
                <p><strong>Suma total de pendientes: </strong><label class="pendientes"></label></p>
              </li>
            </ul>
            
          </div>
          <div class="col-mb-6">
             <ul>
              </li>
                <p><strong>Suma total de abonos de coordinador al vendedor: </strong><label class="abonos"></label></p>
              </li>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="col-mb-6">
             <ul>
              </li>
            <p><strong>Suma total de cancelador: </strong><label class="cancelador"></label></p>
            </li>
            </ul>
          </div>
          <div class="col-mb-6">
             <ul>
              </li>
            <p><strong>Suma total de anulados: </strong><label class="anulado"></label></p>
            </li>
            </ul>
        </div>
      </div>
    </div>
      <div class="modal-footer">
        <a type="button" class="btn btn-primary">Abonar</a>
        <a type="button" href="" class="btn btn-success cancelar">Cancelar</a>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>