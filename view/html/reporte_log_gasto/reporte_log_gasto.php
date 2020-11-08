<br>
<br>
<br>
<br>
<div class="container">
	<br>
  <div class="card">
      <h5 class="card-header card-header-primary text-center"><i class="fas fa-filter"></i> Filtros <i class="fas fa-chevron-down desplegue-btn"></i></h5>
      <div class="divDesplegableContainer" style="display: none;">
        <div class="card-body card-body-primary">
          <div class="row">
            <div class="col-md-6 container-select2">
                <div class="form-group pmd-textfield pmd-textfield-floating-label">
                    <label for="Nombre" class="text-color bmd-label-floating">Nombre del usuario</label>
                    <select class="select2 form-control pmd-select2" id="Nombre" name="Nombre" required="required">
                        <option value="0" selected="selected">Busqueda por nombre</option>
                        <?php foreach ($data_filtro_vendedores as $key => $Nombrevalue) { ?>
                          <option value="<?php echo $Nombrevalue['id_usu']; ?>"><?php echo $Nombrevalue['primer_nombre_usu']." ".$Nombrevalue['segundo_nombre_usu']." ".$Nombrevalue['primer_apellido_usu']." ".$Nombrevalue['segundo_apellido_usu'] ?></option>
                          
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6 container-select2">
                <div class="form-group pmd-textfield pmd-textfield-floating-label">
                    <label for="Cedula" class="text-color bmd-label-floating">Cédula del usuario</label>
                    <select class="select2 form-control pmd-select2" id="Cedula" name="Cedula" required="required">
                        <option value="0" selected="selected">Búsqueda por documento</option>
                        <?php foreach ($data_filtro_vendedores as $key => $Nombrevaluec) { ?>
                          <option value="<?php echo $Nombrevaluec['documento_usu']; ?>"><?php echo $Nombrevaluec['documento_usu'] ?></option>
                          
                        <?php } ?>
                    </select>
                </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="Fecha" class="text-color ">Fecha de inicio</label>
                <input type="text" class="form-control datetimepicker" name="Fecha_ini" id="Fecha_ini" name="Fecha">
             
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="Fecha" class="text-color ">Fecha de final</label>
                <input type="text" class="form-control datetimepicker" name="Fecha_fin" id="Fecha_fin" name="Fecha">

              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 offset-md-3 container-select2">
              <div class="form-group pmd-textfield pmd-textfield-floating-label">
                <label for="Movimiento" class="text-color bmd-label-floating">Movimiento</label>
                <select class="select2 form-control pmd-select2" id="Movimiento" name="Movimiento" required="required">
                  <option value="999" selected="selected">Buscar por movimiento</option>
                  <option value="0">Gasto del vendedor</option>
                  <option value="1">Cancelado</option>
                  <option value="2">Abono</option>
                  <option value="3">Anulado</option>
                </select>
              </div>
            </div>
          </div>
          <center>
                <button type="button" id="buscar" class="btn btn-primary btn-confirmar">Buscar</button>
          </center>
        </div>
      </div>
  </div>
  <hr>
  <div class="card">
    <h5 class="card-header card-header-primary text-center"><i class="fas fa-database"></i> Datos <i class="fas fa-chevron-up desplegue-btn"></i></h5>
      <div class="divDesplegableContainer">
        <div class="card-body card-body-primary">
          <div class="card-body card-body-primary">
            <br>
            <div class="table-responsive padding" >
                <table id="datausuarios" class="table table-bordred table-striped table-striped table-hover">
                    <thead class="heade-table">
                      <th class="text-color all">Movimiento</th>
                      <th class="text-color all">Fecha</th>
                      <th class="text-color">Usuario</th>
                      <th class="text-color">Documento del usuario</th>
                      <th class="text-color">Valor neto</th>
                      <th class="text-color">Debe</th>
                      <th class="text-color">Pagò</th>
                      <th class="text-color">Tipo</th>
                      <th class="text-color">Nota</th>
                      <th class="text-color">Ver mapa</th>
                  </thead>
                    <tbody>
        
                  
                    </tbody>
               </table>
            </div>

          </div>
        </div>
    </div>
  </div>
  <br>
  <br>
</div>