<br>
<br>
<br>
<br>
<div class="container-fluid">
	<br>
	<h3 class="title"><strong> Bienvedido <?php if($_SESSION["rol"]==1){echo "coordinador(a) ";}else{echo "vendedor(a) ";} ?> </strong> <?php echo $_SESSION["nombre"];  ?></h3>
	<hr>
	<h5 class="title-text"><?php echo "C.C ".$_SESSION["documento"]; ?><h5>
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
		<h5 class="card-header card-header-primary text-center">Menus</h5> 
		<div class="card-body card-body-primary">
	        <div class="row containe-card">
	        	<div class="col-md-3">
	        		<a class="btn btn-home btn-auditoria" href="index.php?c=master_auditoria">
	        			<div class="row">
	        				<i class="fab fa-audible icon-btn"></i>
	        			</div>
	        			<div class="row">
	        				<label class="mensaje-btn">Auditorias</label>
	        			</div>
	        		</a>
	        	</div>

	        	<div class="col-md-3">
	        		<a class="btn btn-home">
	        			<div class="row">
	        				<i class="fas fa-route icon-btn"></i>
	        			</div>
	        			<div class="row">
	        				<label class="mensaje-btn">Rutas</label>
	        			</div>
	        		</a>
	        	</div>

	        	<div class="col-md-3">
	        		<a class="btn btn-home">
	        			<div class="row">
	        				<i class="fas fa-times-circle icon-btn"></i>
	        			</div>
	        			<div class="row">
	        				<label class="mensaje-btn">Cerrar</label>
	        			</div>
	        		</a>
	        	</div>

	        	<div class="col-md-3">
	        		<a class="btn btn-home">
	        			<div class="row">
	        				<i class="fas fa-wallet icon-btn"></i>
	        			</div>
	        			<div class="row">
	        				<label class="mensaje-btn">Cartera</label>
	        			</div>
	        		</a>
	        	</div>
	        </div>

	        <div class="row containe-card">

	        	<div class="col-md-3">
	        		<a class="btn btn-home">
	        			<div class="row">
	        				<i class="fas fa-users-cog icon-btn"></i>
	        			</div>
	        			<div class="row">
	        				<label class="mensaje-btn">Gestor de usuario</label>
	        			</div>
	        		</a>
	        	</div>

	        	<div class="col-md-3">
	        		<a class="btn btn-home">
	        			<div class="row">
	        				<i class="fas fa-user-friends icon-btn"></i>
	        			</div>
	        			<div class="row">
	        				<label class="mensaje-btn">Clientes</label>
	        			</div>
	        		</a>
	        	</div>

	        	<div class="col-md-3">
	        		<a class="btn btn-home">
	        			<div class="row">
	        				<i class="fas fa-receipt icon-btn"></i>
	        			</div>
	        			<div class="row">
	        				<label class="mensaje-btn">Gastos</label>
	        			</div>
	        		</a>
	        	</div>

	        	<div class="col-md-3">
	        		<a class="btn btn-home">
	        			<div class="row">
	        				<i class="fab fa-users-cog icon-btn"></i>
	        			</div>
	        			<div class="row">
	        				<label class="mensaje-btn">Gestor de usuario</label>
	        			</div>
	        		</a>
	        	</div>
	        </div>

   		</div>
	</div>
</div>