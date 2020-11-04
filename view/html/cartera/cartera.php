<br>
<br>
<br>
<br>
<div class="container">
  <br>
  <h4 class="btn-atras"><i class="fas fa-reply-all"></i> <i class="fas fa-wallet"></i> Cartera</h4>
  <hr>
  <div class="row">
    <div class="col-md-6 container-select2">
        <div class="form-group">
            <label for="codigo" class="text-color">Codigo del ruta</label>
            <select class="select2 form-control" id="codigo" name="codigo" required="required">
                <option value="0" selected="selected">Busqueda por ruta</option>
                <?php foreach ($data_filtro as $key => $dataRuta) { ?>
                    <option value="<?php echo $dataRuta['id']; ?>"><?php echo $dataRuta['codigo'] ?></option>
                    
                <?php } ?>
            </select>
        </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 container-select2">
      <button type="button" class="btn btn-primary btn-accion " id="consultar"><i class="fas fa-search"></i> Buscar </button>
    </div>
  </div>
  
  <div class="container-result">
    <br>
    <h4 class="tittle-vendedor"></h4>
    <br>
    <div class="row">
      <div class="col-md-3">
        <h5 class="totalNroCar"></h5>
        <label class="texto-info">El numero y valor de lo que te debe tu cliente</label>
      </div>
       <div class="col-md-3">
        <h5 class="totalCartera"></h5>
      </div>
    </div>

    <div class="row">
      <div class="col-md-3">
        <h5 class="totalCarVen" style="color: red"></h5>
        <label class="texto-info">El numero y valor de la deudas pedientes que la fecha final ya paso</label>
      </div>
       <div class="col-md-3">
        <h5 class="totalCarVenNro" style="color: red"></h5>
      </div>
    </div>

     <div class="row">
      <div class="col-md-3">
        <h5 class="totalCarAtraNro"></h5>
        <label class="texto-info">El numero y valor de la dueda pendientes que presenta atraso en la coutas y que la fecha final aùn no expiro</label>
      </div>
       <div class="col-md-3">
        <h5 class="totalCarAtra"></h5>
      </div>
    </div>
    
    <hr>
    <div class="card">
      <h5 class="card-header card-header-primary text-center"><i class="fas fa-filter"></i> Filtros <i class="fas fa-chevron-down desplegue-btn"></i></h5>
      <div class="divDesplegableContainer" style="display: none;">
        <div class="card-body card-body-primary">
          <div class="row">
            <div class="col-md-6 container-select2">
                <div class="form-group">
                    <label for="Nombre" class="text-color">Nombre o cedula</label>
                    <select class="select2 form-control" id="Nombre" name="Nombre" required="required">
                        <option value="0" selected="selected">Busqueda por nombre o cedula</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 container-select2">
                <div class="form-group">
                    <label for="Estado" class="text-color">Estado</label>
                    <select class="select2N form-control" id="Estado" name="Estado" required="required">
                        <option value="0" selected="selected">Busqueda por estado</option>
                        <option value="1" >Pendiente</option>
                        <option value="2" >Atrasado</option>
                    </select>
                </div>
            </div>
          </div>

           <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nrocouta" class="text-color">Numero de cuota</label>
                <input type="number" class="form-control" id="nrocouta" name="nrocouta" required="required">
                
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="segundonombre" class="text-color">Numero de dias vencidos</label>
                <input type="number" class="form-control" id="Numdia" name="Numdia">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="Fecha" class="text-color ">Fecha de inicio</label>
                <input type="text" class="form-control datetimepicker" name="Fecha_ini" id="Fecha_ini" name="Fecha_ini">
             
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="Fecha" class="text-color ">Fecha limite</label>
                <input type="text" class="form-control datetimepicker" name="Fecha_fin" id="Fecha_fin" name="Fecha_fin">

              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="Fecha" class="text-color ">Fecha creacion</label>
                <input type="text" class="form-control datetimepicker" name="Fecha_crea" id="Fecha_crea" name="Fecha_crea">

              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 offset-md-5">
              <button type="button" class="btn btn-primary btn-accion " id="consultar2"><i class="fas fa-search"></i> Buscar </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <div class="card">
      <h5 class="card-header card-header-primary text-center"><i class="fas fa-database"></i> Datos <i class="fas fa-chevron-up desplegue-btn"></i></h5>
      <div class="divDesplegableContainer">
        <div class="card-body card-body-primary">

          <div class="container-cartera">
            <div class="table-responsive padding" >
              <table id="datacartera" class="table table-bordred table-striped table-hover compact hover nowrap stripe">
                  <thead class="heade-table">
                    <th class="text-color">Cod. Venta actual</th>
                    <th class="text-color">Cliente</th>
                    <th class="text-color">Estado</th>
                    <th class="text-color">A pagar</th>
                    <th class="text-color">Pagado</th>
                    <th class="text-color">Debe</th>
                    <th class="text-color">Nro couta</th>
                    <th class="text-color">Dias ven</th>
                    <th class="text-color">Couta reg</th>
                    <th class="text-color">Couta atra</th>
                    <th class="text-color">Fecha ini</th>
                    <th class="text-color">Fecha fin</th>
                    <th class="text-color">Fecha creacion</th>
                    <th class="text-color">Refinanciada venta Nro</th>
                  </thead>
                  <tbody>
    
              
                  </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>