<?php
require_once 'model/home_modelo.php';

class home_controller
{
    private $model;

    public function __construct()
    {
        $this->model  = new home_modelo();
    }

    public function index()
    {
        //variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
        $c='overall'; //carpeta;
        $p='script';//nombre del archivo js
        require_once HTML_DIR . 'overall/header.php';
        require_once HTML_DIR . 'overall/topNav.php';
        require_once HTML_DIR . 'overall/home.php';
        require_once HTML_DIR . 'overall/footer.php';
    }

    public function cerrar(){
        session_destroy();
        header('location:index.php?c=home');
    }
}

