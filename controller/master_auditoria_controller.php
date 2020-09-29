<?php
class master_auditoria_controller
{
    private $model;

    public function __construct()
    {
        //$this->model  = new home_modelo();
    }

    public function index()
    {
        //variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
        $c='master_auditoria'; //carpeta;
        $p='master_auditoria';//nombre del archivo js
        require_once HTML_DIR . 'overall/header.php';
        require_once HTML_DIR . 'overall/topNav.php';
        require_once HTML_DIR . 'master_auditoria/master_auditoria.php';
        require_once HTML_DIR . 'overall/footer.php';
    }
}
