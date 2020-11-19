<?php
//inicia variable de session
session_start();
//llama archivo necesario para llamar
require_once 'core.php';
require_once 'bd/conexion.php';
require_once 'controller/validacion_controller.php';
require_once 'controller/notificacion_controller.php';
require_once 'model/query_modelo.php';

function index($controller)
{
    require_once "controller/$controller" . "_controller.php";
    $controller = ucwords($controller) . '_controller';
    $controller = new $controller;
    $controller->index();
}

if (isset($_POST['ema']) && isset($_POST['pas'])) {
    $login = "login";
    require_once "controller/$login" . "_controller.php";
    $login = ucwords($login) . '_controller';
    $login = new $login;
    $login->validacion();
} else if (!isset($_SESSION['id_usu_credit'])) {
    index("login");
}
if (isset($_SESSION['id_usu_credit']) && isset($_REQUEST['c'])) {
    $controller = strtolower($_REQUEST['c']);
    $accion     = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'Index';
    require_once "controller/$controller" . "_controller.php";
    $controller = ucwords($controller) . '_Controller';
    $controller = new $controller;
    call_user_func(array($controller, $accion));
} else if (isset($_SESSION['id_usu_credit']) && !isset($_REQUEST['c'])) {
    index("home");
}

