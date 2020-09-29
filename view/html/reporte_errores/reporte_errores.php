<br>
<br>
<br>
<br>
<div class="container">
	<br>
		<div class="card">
            <h5 class="card-header card-header-primary text-center">Reporte de errores</h5>
            <br>
            <br>
            <div class="container">
            	<br>
            	
            	<div class="row">
                    <div class="col-md-6 container-select2">
                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                            <label for="Nombre" class="text-color bmd-label-floating">Nombre</label>
                            <select class="select2 form-control pmd-select2" id="Nombre" name="Nombre" required="required">
                                <option value="0" selected="selected">Busqueda por nombre</option>
                               	<?php foreach ($data_filtro as $key => $Nombrevalue) { ?>
                               		<option value="<?php echo $Nombrevalue['id_usu']; ?>"><?php echo $Nombrevalue['primer_nombre_usu']." ".$Nombrevalue['segundo_nombre_usu']." ".$Nombrevalue['primer_apellido_usu']." ".$Nombrevalue['segundo_apellido_usu'] ?></option>
                                	
                               	<?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 container-select2">
                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                            <label for="Cedula" class="text-color bmd-label-floating">Cédula</label>
                            <select class="select2 form-control pmd-select2" id="Cedula" name="Cedula" required="required">
                                <option value="0" selected="selected">Búsqueda por documento</option>
                               	<?php foreach ($data_filtro as $key => $Nombrevaluec) { ?>
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
                        <input type="text" class="form-control datetimepicker" name="Fecha_ini" id="Fecha_ini" name="Fecha_ini">
                     
                      </div>
                    </div>
			        <div class="col-md-6">
                      <div class="form-group">
                        <label for="Fecha" class="text-color ">Fecha de final</label>
                        <input type="text" class="form-control datetimepicker" name="Fecha_fin" id="Fecha_fin" name="Fecha_fin">

                      </div>
                    </div>
			    </div>
				<br>
        		 <center>
			          <button type="button" id="buscar" class="btn btn-primary btn-confirmar">Buscar</button>
                <button type="button" id="Eliminar" class="btn btn-danger">Eliminar</button>
			    </center>
            	<hr>
	       <div class="row">
					<div class="col-md-3">
						<button type="button" class="btn btn-success csv"> <i class="fas fa-file-csv"> </i> Csv</button>
					</div>
				</div>
				
	       <div class="card-body card-body-primary">
					   <br>
	        		<div class="table-responsive padding" >
			            <table id="dataerrores" class="table table-bordred table-striped table-striped table-hover dt-responsive">
			              	<thead class="heade-table">
			                	<th class="text-color all">Fecha</th>
			                	<th class="text-color all">Documento</th>
				                <th class="text-color">Usuario</th>
				                <th class="text-color">accion</th>
				                <th class="text-color">descripcion</th>
				                <th class="text-color">controller</th>
                        <th class="text-color">function</th>
			             	</thead>
			                <tbody>
			    
			              
			                </tbody>
			           </table>
			        </div>
	           
				</div>
			</div>
		</div>

</div>