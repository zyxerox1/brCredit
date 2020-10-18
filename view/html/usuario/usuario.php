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
	        	<br>
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
	                        <label for="Cedula" class="text-color bmd-label-floating">Cedula</label>
	                        <select class="select2 form-control pmd-select2" id="Cedula" name="Cedula" required="required">
	                            <option value="0" selected="selected">Busqueda por documento</option>
	                           	<?php foreach ($data_filtro as $key => $Nombrevaluec) { ?>
	                           		<option value="<?php echo $Nombrevaluec['documento_usu']; ?>"><?php echo $Nombrevaluec['documento_usu'] ?></option>
	                            	
	                           	<?php } ?>
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
        <h5 class="card-header card-header-primary text-center"><i class="fas fa-database"></i> Datos de usuarios<i class="fas fa-chevron-up desplegue-btn"></i></h5>
	    <div class="divDesplegableContainer" >
        	<div class="card-body card-body-primary">
        		<div class="row">
						<div class="col-md-6">
							<button type="button" id="buscar" onclick="window.location.href = 'index.php?c=usuario&a=crear'" class="btn btn-primary btn-confirmar">Crear usuario</button>
						</div>
					</div>
					<br>
	        		<div class="table-responsive padding" >
			            <table id="datausuarios" class="table table-bordred table-striped table-striped table-hover dt-responsive">
			              <thead class="heade-table">
			                <th class="text-color">CC</th>
			                <th class="text-color all">Nombre(s)</th>
			                <th class="text-color">Apellido(s)</th>
			                <th class="text-color">Telefono 1</th>
			                <th class="text-color">Telefono 2</th>
			                <th class="text-color">Correo</th>
			                <th class="text-color">Feacha de nacimiento</th>
			                <th class="text-color all">Estado</th>
			                <th class="text-color all">Editar</th>
			              </thead>
			                <tbody>
			    
			              
			                </tbody>
			           </table>
			        </div>
        	</div>
        </div>
    </div>
</div>
