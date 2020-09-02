<?php
require_once 'model/reporte_log_usuario_modelo.php';

class reporte_log_usuario_controller
{
    private $reporte;

    public function __construct()
    {
        $this->reporte  = new reporte_log_usuario_modelo();
        $this->validacion  = new validaciones_controller();
    }

    public function index()
    {
        $this->validacion->validarRol(0);
       
        //variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
        $c='reporte_log_usuario'; //carpeta;
        $p='reporte_log_usuario';//nombre del archivo js

        $data_filtro=$this->reporte->query_usuario($_REQUEST);
        $data_filtro_autor=$this->reporte->query_usuario_autor();

        require_once HTML_DIR . 'overall/header.php';
        require_once HTML_DIR . 'overall/topNav.php';
        require_once HTML_DIR . 'reporte_log_usuario/reporte_log_usuario.php';
        require_once HTML_DIR . 'overall/footer.php'; 
    }

    public function cargar_reporte(){
        $this->validacion->validarRol(0);
        $data=$this->reporte->obtenerReporte($_REQUEST);
        echo json_encode($data);
    }
}