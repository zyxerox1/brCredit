<br>
<br>
<br>
<br>
<div class="container">
  <br>

    <div class="card">
            <h5 class="card-header card-header-primary text-center">Historial</h5>
            <br>
            <br>
            <div class="container">
              <br>
              <div class="row">
                    <div class="col-md-6 container-select2">
                        <div class="form-group">
                            <label for="Nombre" class="text-color">Nombre</label>
                            <select class="select2 form-control pmd-select2" id="Nombre" name="Nombre" required="required">
                                <option value="0" selected="selected">Busqueda por nombre</option>
                                <?php foreach ($data_filtro as $key => $Nombrevalue) { ?>
                                  <option value="<?php echo $Nombrevalue['id_clie']; ?>"><?php echo $Nombrevalue['primer_nombre_clie']." ".$Nombrevalue['segundo_nombre_clie']." ".$Nombrevalue['primer_apellido_clie']." ".$Nombrevalue['segundo_apellido_clie'] ?></option>
                                  
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
                                  <option value="<?php echo $Nombrevaluec['documento_clie']; ?>"><?php echo $Nombrevaluec['documento_clie'] ?></option>
                                  
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
  
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
                  <table id="datahistoria" class="table table-bordred table-striped table-striped table-hover dt-responsive cards">
                    <thead class="heade-table">
                      <th class="text-color all">Nombre completo</th>
                      <th class="text-color">Couta</th>
                      <th class="text-color">Total de venta</th>
                      <th class="text-color">Dias vencidos</th>
                    </thead>
                      <tbody>
          
                    
                      </tbody>
                 </table>
              </div>
             
        </div>
      </div>
    </div>

</div>