<br>
<br>
<br>
<br>
<div class="container-fluid">
	 <br>
  <h4 class="btn-atras"><i class="fas fa-reply-all"></i> <i class="fas fa-wallet"></i> Balance</h4>
  <hr>
	<h6 class="title-text">
		<?php switch (date("N")) {
			case 1:
				echo "Lunes ";
			break;
			case 2:
				echo "Martes ";
			break;
			case 3:
				echo "Miércoles ";
			break;
			case 4:
				echo "Jueves ";
			break;
			case 5:
				echo "viernes ";
			break;
			case 6:
				echo "Sábado ";
			break;
			case 7:
				echo "Domingo ";
			break;
		}
		echo date("j")." de ";
		switch (date("m")) {
			case 1:
				echo "enero ";
			break;
			case 2:
				echo "febrero ";
			break;
			case 3:
				echo "marzo ";
			break;
			case 4:
				echo "abril ";
			break;
			case 5:
				echo "mayo ";
			break;
			case 6:
				echo "junio	";
			break;
			case 7:
				echo "julio ";
			break;
			case 8:
				echo "agosto ";
			break;
			case 9:
				echo "septiembre ";
			break;
			case 10:
				echo "octubre ";
			break;
			case 11:
				echo "noviembre ";
			break;
			case 12:
				echo "diciembre	";
			break;
		} ?></h6>
		<hr>
	<div class="card card-container">   
		<h5 class="card-header card-header-primary text-center"> Datos</h5> 
		<div class="card-body card-body-primary">
	        <br>
			<div class="row">
			  <div class="col-md-4">
			    <h5 class="">El numero de cobros(<?php echo $data[0]['numeroCobros']; ?>)</h5>
			  </div>
			   <div class="col-md-4">
			    <h5 class="meta"><?php echo $data[0]['meta']; ?></h5>
			  </div>
			</div>

			<div class="row">
			  <div class="col-md-4">
			    <h5 class="" style="color: green">Cobros pagados(<?php echo $data[0]['numeroPagado']; ?>):</h5>
			  </div>
			   <div class="col-md-4">
			    <h5 class="pagados" style="color: green"><?php echo $data[0]['Pagado']; ?></h5>
			  </div>
			</div>

			<div class="row">
			  <div class="col-md-4">
			    <h5 class="" style="color: red">Cobros no pagados(<?php echo $data[0]['numeroCobros']-$data[0]['numeroPagado']; ?>):</h5>
			  </div>
			   <div class="col-md-4">
			    <h5 class="nopagados" style="color: red"><?php echo $data[0]['meta']-$data[0]['Pagado']; ?></h5>
			  </div>
			</div>

			<div class="row">
			  <div class="col-md-4">
			    <h5 class="">Total vendido:</h5>
			  </div>
			   <div class="col-md-4">
			    <h5 class="tvendido"><?php echo $data[0]['totalVendido']?></h5>
			  </div>
			</div>

			<div class="row">
			  <div class="col-md-4">
			    <h5 class="">Saldo de inicio:</h5>
			  </div>
			   <div class="col-md-4">
			    <h5 class="saldoInicial"><?php echo $data[0]['saldoInicial']?></h5>
			  </div>
			</div>

			<div class="row">
			  <div class="col-md-4">
			    <h5 class="">Ventas(<?php echo $data[0]['numVentas']?>):</h5>
			  </div>
			   <div class="col-md-4">
			    <h5 class="ventas"><?php echo $data[0]['Ventas']?></h5>
			  </div>
			</div>

			<div class="row">
			  <div class="col-md-4">
			    <h5 class="">Gastos(<?php echo $data[0]['numgasto']?>):</h5>
			  </div>
			   <div class="col-md-4">
			    <h5 class="Gastos"><?php echo $data[0]['gasto']?></h5>
			  </div>
			</div>

			<div class="row">
			  <div class="col-md-4">
			    <h5 class="">Retiros(<?php echo $data[0]['numretiros']?>):</h5>
			  </div>
			   <div class="col-md-4">
			    <h5 class="Retiros"><?php echo $data[0]['Retiros']?></h5>
			  </div>
			</div>

			<div class="row">
			  <div class="col-md-4">
			    <h5 class="">Saldo final:</h5>
			  </div>
			   <div class="col-md-4">
			    <h5 class="caja"><?php echo $data[0]['caja']?></h5>
			  </div>
			</div>
   		</div>
	</div>
</div>