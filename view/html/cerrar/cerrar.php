<br>
<br>
<br>
<br>
<div class="container">
	<br>
	<h4><i class="fas fa-times-circle"></i> Cierres</h4>
	<hr>
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
            <div class="form-group">
                <label for="codigo" class="text-color">Codigo del vendedor</label>
                <select class="select2 form-control" id="codigo" name="codigo" required="required">
                    <option value="0" selected="selected">Busqueda por ruta</option>
                    <?php foreach ($data_filtro as $key => $dataRuta) { ?>
                        <option value="<?php echo $dataRuta['id']; ?>"><?php echo $dataRuta['codigo'] ?></option>
                        
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    
   	<hr>
    <div class="row">
        <div class="col-md-12 offset-md-3 container-select2">
            <button type="button" class="btn btn-primary btn-accion " id="consultar">Buscar <i class="fas fa-search"></i></i></button>
            <button type="button" class="btn btn-success btn-accion " id="csv">Cerrar todo automaticos <i class="fas fa-calendar-alt"></i> </i></button>
        </div>
    </div>
    <br>
    <h4 class="tittle-vendedor"></h4>
    <hr>
	<div class="container-cerrar">
		<div class="table-responsive padding" >
            <table id="datahistoria" class="table table-bordred table-striped table-striped table-hover dt-responsive cardss">
                <thead class="heade-table">
                  <th class="text-color all campoNombre">Nombre completo</th>
                  <th class="text-color all">Fecha</th>
                  <th class="text-color all">Detalle</th>
                </thead>
                <tbody>
  
            
                </tbody>
            </table>
        </div>
	</div>
</div>