<!DOCTYPE html>
<html lang="es">

	<head>
	    <meta charset="utf-8">
	    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="description" content="">
	    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1" >
	    <meta name="keywords" content="">
	    <!--Stylesheets-->
	</head>

	<style type="text/css">
		body{

			background: url(./view/assets/imagenes_app/acceso_negano.gif) no-repeat center center fixed;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
		}

		.error {
		    border: 1px solid;
		    margin: 10px 0px;
		    padding:15px 10px 15px 50px;
		    background-repeat: no-repeat;
		    background-position: 10px center;
		    font-family:Arial, Helvetica, sans-serif;
		    font-size:13px;
		    text-align:left;
		    width:auto;
		    color: #D8000C;
		    background-color: #FFBABA;
		    
		}

	</style>

	<body onclick="">
		<div class="error">
			<b>Informaciòn de error:</b>
			<br>
				<b>Error de acceso, revise tus permiso o contacte con el administrador.</b>
		</div>
		<!--jquery-->
		<script src="./<?php echo(APP_PLUGIN)?>jquery/jquery.min.js" type="text/javascript"></script>

		<script type="text/javascript">
				$(document).click(function(){
			    	window.location.href = 'index.php';
				});
		
		</script>
	</body>
</html>

