<div class="modal fade" id="gastoModal" tabindex="-1" role="dialog" data-backdrop="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title text-color" id="titleGasto"></h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <center><h5 class="text-color">Estado actual del gasto : </h5><h5 class="estado text-color"></h5></center>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title text-color card-title-detalles">Detalle del vendedor</h5>
                <p class="card-text detalle"></p>
              </div>
            </div>
          </div>

           <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title text-color card-title-detalles">Fecha exacta donde se registró el gasto</h5>
                <p class="card-text fecha_d"></p>
              </div>
            </div>
          </div>

           <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title text-color card-title-detalles">Valor del gasto</h5>
                <p class="card-text valor"></p>
              </div>
            </div>
          </div>
        </div>

        <hr>
        <?php if($_SESSION["rol"]==1){ ?>
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
        <?php } ?>
        <div class="row">
          <div class="col-md-12">
            <center><h5 class="text-color">Suma totales</h5></center>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-total">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Pendientes</th>
                  <th scope="col">Cancelador</th>
                  <th scope="col">Abonos de coordinador</th>
                  <th scope="col">Anulados</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <?php if($_SESSION["rol"]==1){ ?>
          <a type="button" class="btn btn-primary">Abonar</a>
          <a type="button" href="" class="btn btn-success cancelar">Cancelar</a>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <?php } ?>
        <?php if($_SESSION["rol"]==2){ ?>
          <button type="button" href="" class="btn btn-secondary anular">Anular</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <?php } ?>
      </div>
    </div>
  </div>
</div>