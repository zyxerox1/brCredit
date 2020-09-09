<?php

require_once 'model/historial_modelo.php';

class historial_controller
{
    private $validacion;
    private $historial;
    public function __construct()
    {

        $this->validacion  = new validaciones_controller();
        $this->historial  = new historial_modelo();
    }

    public function index()
    {
        $this->validacion->validarRol(2);
        $c='historial';//variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
        $p='historial';
        $data_filtro=$this->historial->obtener_filtro_cliente();
        require_once HTML_DIR . 'overall/header.php';
        require_once HTML_DIR . 'overall/topNav.php';
        require_once HTML_DIR . 'historial/historial.php';
        require_once HTML_DIR . 'overall/footer.php';
    }

    public function ver()
    {
        $this->validacion->validarRol(2);
        $data=$this->historial->ver($_POST);
        echo json_encode($data);
    }
}