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
                      <div class="form-group">
                        <label for="Valor" class="text-color ">Valor minimo</label>
                        <input type="text" class="form-control" name="Valor_mini" id="Valor" onkeyup="format(this)" onchange="format(this)">
                     
                      </div>
                    </div>
                     <div class="col-md-6">
                      <div class="form-group">
                        <label for="Valor" class="text-color ">Valor maximo</label>
                        <input type="text" class="form-control" name="Valor_max" id="Valor" onkeyup="format(this)" onchange="format(this)">
                     
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
	            	<div class="row">
						<div class="col-md-6">
							<button type="button" id="buscar" onclick="window.location.href = 'index.php?c=usuario&a=crear'" class="btn btn-primary btn-confirmar">Calculador</button>
						</div>
					</div>
					<br>
	        		<div class="table-responsive padding" >
			            <table id="datausuarios" class="table table-bordred table-striped table-striped table-hover dt-responsive">
			              <thead class="heade-table">
			                
			                <?php if($_SESSION["rol"]==1){ ?>
			                	<th class="text-color all">CC</th>
			                	<th class="text-color all">Nombres</th>
				                <th class="text-color">Telefonos</th>
				                <th class="text-color">Correo</th>
				                <th class="text-color">Valor</th>
				                <th class="text-color">Tipo</th>
				                <th class="text-color">Detalle</th>
				                <th class="text-color">Fecha</th>
				                <th class="text-color all">Evidencia</th>
				                <th class="text-color all">Opciones</th>
			                <?php } ?>
			                <?php if($_SESSION["rol"]==2){ ?>
			                	<th class="text-color all">Editar</th>
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