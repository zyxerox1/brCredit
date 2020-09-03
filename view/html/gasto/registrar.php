<br>
<br>
<br>
<br>
<div class="container">
	<br>
	<div class="card">
        <h5 class="card-header card-header-primary text-center">Registrar datos</h5>
        <br>
        <br>
        <div class="container">
        	<form  action="index.php?c=gasto&a=save" id="formulario-crear-gasto" method="post" enctype="multipart/form-data">
	        	<div class="row">
	        		<div class="col-md-5 container-select2">
		              	<div class="form-group pmd-textfield pmd-textfield-floating-label">
		                	<label for="Tipo" class="text-color">Tipo de gasto*</label>
		                	<select class="select2 form-control pmd-select2" id="Tipo" name="Tipo" required="required">

		                    	<option>Seleccione un tipo</option>
		               
		                	</select>
		              	</div>
		             </div>
		             <div class="col-md-3">
		             	<div class="form-group">
						   <label for="add" class="text-color">No encuentro el tipo.</label>
		             		<button type="button" id="add" class="btn btn-warning"><i class="fas fa-plus"></i> Agregar tipo</button>
		             	</div>
		             </div>
	              	<div class="col-md-4">
	              		<label for="valor" class="text-color">Valor*</label>
	              		<div class="input-group form-group">
						  	<div class="input-group-prepend">
						    	<span class="input-group-text">$</span>
						  	</div>
						  	<input type="text" class="form-control Spinner" id="valor" name="valor" onkeyup="format(this)" onchange="format(this)" value="1" min="0" max="" step="1" required="required">
						  	<div class="input-group-append">
						    	<span class="input-group-text">.00</span>
						  	</div>
						</div>
	                </div>
	        	</div>
	            <div class="row">
	                <div class="col-md-12">
	                  	<div class="form-group">
						  <label for="nota">Detalle:</label>
						  <textarea class="form-control" id="nota" name="nota"></textarea>
						</div>
	                </div>
	            </div>
	            <br>
	            <div class="row">
	                <div class="col-md-12 ">
		              	<div class="form-group">
						    <label class="control-label" style="text-align: center;">Subir evidencia sobre el gasto.</label>
							<input id="input-b5" name="input-b5[]" type="file" capture="camera" multiple>
						</div>
	                </div>
	            </div>
	            <hr>
	            <br>
	            <center><button type="button" class="btn btn-danger" onClick="history.back()">Atrás</button>
                <button type="submit" class="btn btn-success btn-md">Guardar</button></center>
                <br>
                <br>
            </form>
		</div>	
	</div>
	<br>
	<br>
</div>