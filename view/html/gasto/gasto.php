<br>
<br>
<br>
<br>
<div class="container">
	<br>
		<div class="card">
            <h5 class="card-header card-header-primary text-center">Gastos</h5>
            <br>
            <br>
            <div class="container">
            	<button type="button" id="crear" onclick="window.location.href = 'index.php?c=gasto&a=registrar'" class="btn btn-primary btn-confirmar">Registrar gasto propio</button>
        		<hr>
            	<?php if($_SESSION["rol"]==1){ ?>
            	<div class="row">
                    <div class="col-md-6 container-select2">
                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                            <label for="Nombre" class="text-color bmd-label-floating">Nombre</label>
                            <select class="select2 form-control pmd-select2" id="Nombre" name="Nombre" required="required">
                                <option value="0" selected="selected">Busqueda por nombre</option>
                               	<?php foreach ($data_filtro as $key => $Nombrevalue) { ?>
                               		<option value="<?php echo $Nombrevalue['id_usu']; ?>"><?php echo $Nombrevalue['primer_nombre_usu']." ".$Nombrevalue['segundo_nombre_usu']." ".$Nombrevalue['primer_apellido_usu']." ".$Nombrevalue['segundo_apellido_usu']." - ".$Nombrevalue['documento_usu'] ?></option>
                                	
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
			    <?php } ?>
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
			        <div class="col-md-6">
			        	<label for="Valor_mini" class="text-color">Valor minimo</label>
	              		<div class="input-group form-group">
						  	<div class="input-group-prepend">
						    	<span class="input-group-text">$</span>
						  	</div>
						  	<input type="text" class="form-control Spinner" name="Valor_mini" id="Valor_mini" onkeyup="format(this)" onchange="format(this)" min="0" max="" step="1" required="required">
						  	<div class="input-group-append">
						    	<span class="input-group-text">.00</span>
						  	</div>
						</div>
                    </div>
                     <div class="col-md-6">
                     	<label for="Valor_max" class="text-color">Valor maximo</label>
	              		<div class="input-group form-group">
						  	<div class="input-group-prepend">
						    	<span class="input-group-text">$</span>
						  	</div>
						  	<input type="text" class="form-control Spinner" name="Valor_max" id="Valor_max" onkeyup="format(this)" onchange="format(this)" min="0" max="" step="1" required="required">
						  	<div class="input-group-append">
						    	<span class="input-group-text">.00</span>
						  	</div>
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
				
	            <div class="card-body card-body-primary">
					<br>
	        		<div class="table-responsive padding" >
			            <table id="dataGasto" class="table table-bordred table-striped table-striped table-hover nowrap">
			              <thead class="heade-table">
			                
			                <?php if($_SESSION["rol"]==1){ ?>
			                	<th class="text-color all">CC</th>
			                	<th class="text-color all">Hecho por</th>
				                <th class="text-color">Ruta</th>
				                <th class="text-color">Teléfonos</th>
				                <th class="text-color">Correo</th>
				                <th class="text-color">Valor</th>
				                <th class="text-color">Tipo</th>
				                <th class="text-color">Detalle</th>
				                <th class="text-color">Fecha</th>
				                <th class="text-color all">Evidencia</th>
				                <th class="text-color all">Opciones</th>
			                <?php } ?>
			                <?php if($_SESSION["rol"]==2){ ?>
				                <th class="text-color">Valor</th>
				                <th class="text-color">Tipo</th>
				                <th class="text-color">Detalle</th>
				                <th class="text-color">Fecha</th>
				                <th class="text-color all">Evidencia</th>
				                <th class="text-color all">Opciones</th>
			            	<?php } ?>
			              </thead>
			                <tbody>
			    
			              
			                </tbody>
			           </table>
			        </div>
	           
				</div>
			</div>
		</div>

</div>