<br>
<br>
<br>
<br>
<div class="container">
  <br>
  <h4 class="btn-atras"><i class="fas fa-reply-all"></i> <i class="fas fa-user-friends"></i> Clientes</h4>
  <hr>  

  <div class="card">
    <h5 class="card-header card-header-primary text-center"><i class="fas fa-filter"></i> Filtros <i class="fas fa-chevron-up desplegue-btn"></i></h5>
    <div class="divDesplegableContainer">
      <div class="card-body card-body-primary">

        <button type="button" id="crear" onclick="window.location.href = 'index.php?c=cliente&a=crear'" class="btn btn-primary btn-confirmar">Crear cliente</button>

        <button type="button" id="historial" onclick="window.location.href = 'index.php?c=historial'" class="btn btn-primary">Ver historial de los clientes</button>

        <button type="button" id="abono" onclick="window.location.href = 'index.php?c=abono'" class="btn btn-primary">Registrar abono</button>
        <hr>
        <?php if($_SESSION["rol"]==1): ?>
        <div class="row">
          <div class="col-md-6 offset-md-3">
              <div class="form-group">
                  <label for="codigo" class="text-color">Codigo del ruta</label>
                  <select class="select-2 form-control" id="codigo" name="codigo" required="required">
                      <option value="0" selected="selected">Busqueda por ruta</option>
                      <?php foreach ($data_filtro_ruta as $key => $dataRuta) { ?>
                          <option value="<?php echo $dataRuta['id']; ?>"><?php echo $dataRuta['codigo'] ?></option>
                          
                      <?php } ?>
                  </select>
              </div>
          </div>
        </div>
        <?php endif ?>
        <div class="row container-filtro-cliente" <?php if($_SESSION["rol"]==1): ?>
          style="display: none;"
          <?php endif ?>>
          <div class="col-md-6">
            <div class="form-group">
              <label for="Nombre" class="text-color">Nombre</label>
              <select class="select-2 form-control" id="Nombre" name="Nombre" required="required">
                  <option value="0" selected="selected">Busqueda por nombre</option>
                  <?php if($_SESSION["rol"]==2): ?>
                    <?php foreach ($data_filtro as $key => $Nombrevalue) { ?>
                      <option value="<?php echo $Nombrevalue['id']; ?>"><?php echo $Nombrevalue['cliente'] ?></option>
                    <?php } ?>
                  <?php endif ?>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group pmd-textfield pmd-textfield-floating-label">
              <label for="Cedula" class="text-color bmd-label-floating">Cedula</label>
              <select class="select-2 form-control" id="Cedula" name="Cedula" required="required">
                  <option value="0" selected="selected">Busqueda por documento</option>
                  <?php if($_SESSION["rol"]==2): ?>
                    <?php foreach ($data_filtro as $key => $Nombrevaluec) { ?>
                      <option value="<?php echo $Nombrevaluec['documento']; ?>"><?php echo $Nombrevaluec['documento'] ?></option>
                    <?php } ?>
                  <?php endif ?>
              </select>
            </div>
          </div>
        
          <div class="col-md-12 offset-md-5">
            <button type="button" class="btn btn-primary btn-accion " id="buscar"><i class="fas fa-search"></i> Buscar </button>
          </div>
         
        </div>

      </div>
    </div>
  </div>
  <hr>
  <div class="card">
    <h5 class="card-header card-header-primary text-center"><i class="fas fa-database"></i> Datos <i class="fas fa-chevron-up desplegue-btn"></i></h5>
    <div class="divDesplegableContainer">
      <div class="card-body card-body-primary">
        
        <div class="table-responsive padding" >
          <table id="datacliente" class="table table-bordred table-striped table-hover nowrap">
            <thead class="heade-table">
              <?php if($_SESSION["rol"]==2): ?>
                <th class="text-color all">CC</th>
                <th class="text-color all">Nombre completo</th>
                <th class="text-color">Nro cuotas</th>
                <th class="text-color">Total prestamo</th>
                <th class="text-color">Dias vencidos</th>
                <th class="text-color all">Prestamos</th>
                <th class="text-color all">Editar</th>
                <th class="text-color all">Orden</th>
              <?php endif ?>
              <?php if($_SESSION["rol"]==1): ?>
                <th class="text-color all">Nombres</th>
                <th class="text-color all">Apellidos</th>
                <th class="text-color">Telefono</th>
                <th class="text-color">Moroso</th>
                <th class="text-color">Disa vencidos</th>
                <th class="text-color all">Direcion</th>
                <th class="text-color all">Nro ventas</th>
                <th class="text-color all">Total vendido</th>
                <th class="text-color all">Total pagado</th>
                <th class="text-color all">Limites de ventas</th>
                <th class="text-color all">Referencia</th>
                <th class="text-color all">Editar</th>
              <?php endif ?>
            </thead>
            <tbody>

          
            </tbody>
         </table>
        </div>
      </div>
    </div>
  </div>

</div>
