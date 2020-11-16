<?php

require_once 'model/balance_modelo.php';

class balance_controller
{
    private $validacion;
    private $balance;
    public function __construct()
    {

        $this->validacion  = new validaciones_controller();
        $this->balance  = new balance_modelo();
    }

    public function index()
    {
        $this->validacion->validarRol([1,2]);
        $c='balance';//variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
        $p='balance';
        $data=$this->balance->cargar();
        require_once HTML_DIR . 'overall/header.php';
        require_once HTML_DIR . 'overall/topNav.php';
        require_once HTML_DIR . 'balance/balance.php';
        require_once HTML_DIR . 'overall/footer.php';
    }
}
