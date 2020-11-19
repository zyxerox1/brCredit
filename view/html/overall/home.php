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
		<h5 class="card-header card-header-primary text-center"><i class="fas fa-bars"></i> Menus</h5> 
		<div class="card-body card-body-primary">
	        <div class="row containe-card">
	        	<?php if ($_SESSION['rol']==1): ?>
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
		        		<a class="btn btn-home btn-rutas" href="index.php?c=ruta">
		        			<div class="row">
		        				<i class="fas fa-route icon-btn"></i>
		        			</div>
		        			<div class="row">
		        				<label class="mensaje-btn">Rutas</label>
		        			</div>
		        		</a>
		        	</div>

		        	<div class="col-md-3">
		        		<a class="btn btn-home btn-cierre" href="index.php?c=cerrar">
		        			<div class="row">
		        				<i class="fas fa-times-circle icon-btn "></i>
		        			</div>
		        			<div class="row">
		        				<label class="mensaje-btn">Cierres</label>
		        			</div>
		        		</a>
		        	</div>

		        	<div class="col-md-3">
		        		<a class="btn btn-home btn-Cartera" href="index.php?c=cartera">
		        			<div class="row">
		        				<i class="fas fa-wallet icon-btn"></i>
		        			</div>
		        			<div class="row">
		        				<label class="mensaje-btn">Cartera</label>
		        			</div>
		        		</a>
		        	</div>
	        	<?php endif ?>
	
	        </div>

	        <div class="row containe-card">
	        	<?php if ($_SESSION['rol']==1): ?>
	        	<div class="col-md-3">
	        		<a class="btn btn-home btn-usuario" href="index.php?c=usuario">
	        			<div class="row">
	        				<i class="fas fa-users-cog icon-btn"></i>
	        			</div>
	        			<div class="row">
	        				<label class="mensaje-btn">Gestor de usuario</label>
	        			</div>
	        		</a>
	        	</div>
	        	<?php endif ?>
	        	<div class="col-md-3">
	        		<a class="btn btn-home btn-cliente" href="index.php?c=cliente">
	        			<div class="row">
	        				<i class="fas fa-user-friends icon-btn"></i>
	        			</div>
	        			<div class="row">
	        				<?php if ($_SESSION['rol']==1): ?>
	        					<label class="mensaje-btn">Lista clientes</label>
	        				<?php endif ?>
	        				<?php if ($_SESSION['rol']==2): ?>
	        					<label class="mensaje-btn">Mis clientes</label>
	        				<?php endif ?>
	        			</div>
	        		</a>
	        	</div>

	        	<div class="col-md-3">
	        		<a class="btn btn-home btn-gasto" href="index.php?c=gasto">
	        			<div class="row">
	        				<i class="fas fa-receipt icon-btn"></i>
	        			</div>
	        			<div class="row">
	        				<?php if ($_SESSION['rol']==1): ?>
	        					<label class="mensaje-btn">Gastos</label>
	        				<?php endif ?>
	        				<?php if ($_SESSION['rol']==2): ?>
	        					<label class="mensaje-btn">Mis gastos</label>
	        				<?php endif ?>
	        			</div>
	        		</a>
	        	</div>
	        	<?php if ($_SESSION['rol']==2): ?>
	        		<div class="col-md-3">
		        		<a class="btn btn-home btn-Cartera" href="index.php?c=balance">
		        			<div class="row">
		        				<i class="fas fa-wallet icon-btn"></i>
		        			</div>
		        			<div class="row">
		        				<label class="mensaje-btn">Balance</label>
		        			</div>
		        		</a>
		        	</div>

		        	<div class="col-md-3">
		        		<a class="btn btn-home btn-abono" href="index.php?c=abono">
		        			<div class="row">
		        				<i class="fas fa-money-bill-alt icon-btn"></i>
		        			</div>
		        			<div class="row">
		        				<label class="mensaje-btn">Registrar abono</label>
		        			</div>
		        		</a>
		        	</div>
	        	<?php endif ?>
	        	<?php if ($_SESSION['rol']==1): ?>
	        	<div class="col-md-3">
	        		<a class="btn btn-home btn-retiro" href="index.php?c=retiro">
	        			<div class="row">
	        				<i class="fas fa-people-arrows icon-btn"></i>
	        			</div>
	        			<div class="row">
	        				<label class="mensaje-btn">Retiro</label>
	        			</div>
	        		</a>
	        	</div>
	        	<?php endif ?>
	        </div>

	    	<hr>

	  

   		</div>
	</div>
</div>