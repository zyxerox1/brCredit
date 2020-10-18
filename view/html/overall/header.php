<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>

    <!--icon-->
    <link rel="icon" sizes="76x76" href="./<?php echo(APP_ICON)?>?v=1" type="image/png" />

    <!--iconos-->
    <link rel="stylesheet" type="text/css" href="./<?php echo(APP_PLUGIN)?>icon/css/all.css"  />

    <!--bootstrap-->
    <link rel="stylesheet" type="text/css" href="./<?php echo(APP_PLUGIN)?>bootstrap/bootstrap.css" />
   
     <!--file-boostrap-->
    <link href="./<?php echo(APP_PLUGIN)?>file-boostrap/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="./<?php echo(APP_PLUGIN)?>file-boostrap/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>

    <!--select 2-->
    <link rel="stylesheet" type="text/css" href="./<?php echo(APP_PLUGIN)?>select2/select2.min.css" />
    <link rel="stylesheet" type="text/css" href="./<?php echo(APP_PLUGIN)?>select2/select2-bootstrap4-theme.css" />

    <!--datetimepickern-->
    <link rel="stylesheet" type="text/css" href="./<?php echo(APP_PLUGIN)?>bootstrap-datetimepicker.min.css" />

    <!--datatable-->
    <link rel="stylesheet" type="text/css" href="./<?php echo(APP_PLUGIN)?>DataTables/datatables.css" />
    <link rel="stylesheet" type="text/css" href="./<?php echo(APP_PLUGIN)?>DataTables/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="./<?php echo(APP_PLUGIN)?>DataTables/responsive.bootstrap4.min.css" />

    <!--toggle-->
    <link href="./<?php echo(APP_PLUGIN)?>toggle/bootstrap4-toggle.min.css" rel="stylesheet"/>
    
    <!--boostrapDialog-->
    <link href="./<?php echo(APP_PLUGIN)?>bootstrap4-dialog-bootstrap4-dev/css/bootstrap-dialog.min.css" rel="stylesheet"/>
    
    <!-- Archivos necesarios de style -->
    <link rel="stylesheet" type="text/css" href="./view/assets/css/style.css" />

    <!-- Archivos necesarios de la vista -->
    <?php if(isset($c)){  ?>
    <link rel="stylesheet" type="text/css" href="./view/html/<?php echo $c; ?>/style.css?v=<?php echo(rand()); ?>"/>
    <?php } ?>

    <!--titulo-->
    <title><?php echo APP_TITTLE ?></title>
</head>

<body>
<div class="loader"></div>
<div id="ohsnap"></div> 

