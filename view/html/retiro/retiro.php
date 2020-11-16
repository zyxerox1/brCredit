<br>
<br>
<br>
<br>
<div class="container">
	<br>
  <h4 class="btn-atras"><i class="fas fa-reply-all"></i> <i class="fas fa-people-arrows"></i> Retiro</h4>
  <hr>
  <div class="card">
      <h5 class="card-header card-header-primary text-center"><i class="fas fa-filter"></i> Filtros <i class="fas fa-chevron-down desplegue-btn"></i></h5>
      <div class="divDesplegableContainer" style="display: none;">
          <div class="card-body card-body-primary">
            <button type="button" id="btnModalRetiro" class="btn btn-primary btn-confirmar">Hacer retiros</button>
            <hr>
            <div class="row">
              <div class="col-md-6 container-select2">
                  <div class="form-group pmd-textfield pmd-textfield-floating-label">
                      <label for="Nombre" class="text-color bmd-label-floating">Vendedor</label>
                      <select class="select2 form-control pmd-select2" id="Nombre" name="Nombre" required="required">
                          <option value="0" selected="selected">Busqueda por nombre</option>
                          <?php foreach ($data_filtro as $key => $Nombrevalue) { ?>
                            <option value="<?php echo $Nombrevalue['id_usu']; ?>"><?php echo $Nombrevalue['primer_nombre_usu']." ".$Nombrevalue['segundo_nombre_usu']." ".$Nombrevalue['primer_apellido_usu']." ".$Nombrevalue['segundo_apellido_usu'] ?>-<?php echo $Nombrevaluec['documento_usu'] ?></option>
                            
                          <?php } ?>
                      </select>
                  </div>
              </div>
              <div class="col-md-6">
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

            <br>
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
        <div class="table-responsive padding" >
          <table id="dataretiro" class="table table-bordred table-striped table-striped table-hover dt-responsive">
            <thead class="heade-table">
              <th class="text-color">Retiro</th>
              <th class="text-color">Fecha</th>
              <th class="text-color">Descripcion</th>
              <th class="text-color">Valor</th>
              <th class="text-color">Autor</th>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <br>
  <br>
</div>

