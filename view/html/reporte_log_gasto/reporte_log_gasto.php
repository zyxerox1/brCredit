<br>
<br>
<br>
<br>
<div class="container">
	<br>
		<div class="card">
            <h5 class="card-header card-header-primary text-center">Reporte de gasto</h5>
            <br>
            <br>
            <div class="container">
            	<br>
            	
            	<div class="row">
                    <div class="col-md-6 container-select2">
                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                            <label for="Nombre" class="text-color bmd-label-floating">Nombre del vendedor</label>
                            <select class="select2 form-control pmd-select2" id="Nombre" name="Nombre" required="required">
                                <option value="0" selected="selected">Busqueda por vendedor</option>
                               	<?php foreach ($data_filtro_vendedores as $key => $Nombrevalue) { ?>
                               		<option value="<?php echo $Nombrevalue['id_usu']; ?>"><?php echo $Nombrevalue['primer_nombre_usu']." ".$Nombrevalue['segundo_nombre_usu']." ".$Nombrevalue['primer_apellido_usu']." ".$Nombrevalue['segundo_apellido_usu'] ?></option>
                                	
                               	<?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 container-select2">
                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                            <label for="Cedula" class="text-color bmd-label-floating">Cédula del vendedor</label>
                            <select class="select2 form-control pmd-select2" id="Cedula" name="Cedula" required="required">
                                <option value="0" selected="selected">Búsqueda por documento del vendedor</option>
                               	<?php foreach ($data_filtro_vendedores as $key => $Nombrevaluec) { ?>
                               		<option value="<?php echo $Nombrevaluec['documento_usu']; ?>"><?php echo $Nombrevaluec['documento_usu'] ?></option>
                                	
                               	<?php } ?>
                            </select>
                        </div>
                    </div>
			    </div>

			    <div class="row">
                    <div class="col-md-6 container-select2">
                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                            <label for="Nombre_au" class="text-color bmd-label-floating">Nombre del coordinador</label>
                            <select class="select2 form-control pmd-select2" id="Nombre_au" name="Nombre_au" required="required">
                                <option value="0" selected="selected">Busqueda por nombre del coordinador</option>
                               	<?php foreach ($data_filtro_coordinadores as $key => $NombrevalueAutor) { ?>
                               		<option value="<?php echo $NombrevalueAutor['id_usu']; ?>"><?php echo $NombrevalueAutor['primer_nombre_usu']." ".$NombrevalueAutor['segundo_nombre_usu']." ".$NombrevalueAutor['primer_apellido_usu']." ".$NombrevalueAutor['segundo_apellido_usu'] ?></option>
                                	
                               	<?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 container-select2">
                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                            <label for="Cedula_au" class="text-color bmd-label-floating">Cédula del autor</label>
                            <select class="select2 form-control pmd-select2" id="Cedula_au" name="Cedula_au" required="required">
                                <option value="0" selected="selected">Búsqueda por documento del coordinador</option>
                               	<?php foreach ($data_filtro_coordinadores as $key => $CCvalueAutor) { ?>
                               		<option value="<?php echo $CCvalueAutor['documento_usu']; ?>"><?php echo $CCvalueAutor['documento_usu'] ?></option>
                                	
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
				<br>
        		 <center>
			          <button type="button" id="buscar" class="btn btn-primary btn-confirmar">Buscar</button>
			    </center>
            	<hr>
	            <!--<div class="row">
					<div class="col-md-3">
						<button type="button" class="btn btn-outline-primary cambiar-vista-list"><i class="fas fa-tasks"></i></button>
						<button type="button" class="btn btn-outline-primary cambiar-vista-cuad"><i class="fas fa-th-large"></i></button>
					</div>
				</div>-->
				<div class="row">
          <div class="col-md-3">
            <button type="button" class="btn btn-success csv"> <i class="fas fa-file-csv"> </i> Csv</button>
          </div>
        </div>
	            <div class="card-body card-body-primary">
					<br>
	        		<div class="table-responsive padding" >
			            <table id="datausuarios" class="table table-bordred table-striped table-striped table-hover dt-responsive">
			              	<thead class="heade-table">
			                	<th class="text-color all">Movimiento</th>
			                	<th class="text-color all">Fecha</th>
				                <th class="text-color">Usuario</th>
				                <th class="text-color">Documento del usuario</th>
				                <th class="text-color">Valor</th>
				                <th class="text-color">Tipo</th>
			             	</thead>
			                <tbody>
			    
			              
			                </tbody>
			           </table>
			        </div>
	           
				</div>
			</div>
		</div>

</div>