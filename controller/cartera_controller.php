<?php

require_once 'model/cartera_modelo.php';

class cartera_controller
{
    private $validacion;
    private $cartera;
    public function __construct()
    {

        $this->validacion  = new validaciones_controller();
        $this->cartera  = new cliente_modelo();
    }

    public function index()
    {
        $this->validacion->validarRol([1,2]);
        $c='cartera';//variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
        $p='cartera';
        $data_filtro=$this->cartera->obtenerFiltroRuta();
        require_once HTML_DIR . 'overall/header.php';
        require_once HTML_DIR . 'overall/topNav.php';
        require_once HTML_DIR . 'cartera/cartera.php';
        require_once HTML_DIR . 'overall/footer.php';
    }

    public function obtenerDatosTotalCartera(){
      $this->validacion->validarRol([1,2]);
      $data=$this->cartera->obtenerDatosTotalCartera($_POST);
      echo json_encode($data);
    }

    public function obtener_filtro_cliente(){
      $this->validacion->validarRol([1,2]);
      $data_cliente=$this->cartera->obtener_filtro_cliente($_POST);
      echo json_encode($data_cliente);
    }

    public function cargar(){
        $this->validacion->validarRol([1,2]);
        if($_SESSION["rol"]==1){
          $data=$this->cartera->obtener_cliente_todos($_REQUEST);
        }else{
          $data=$this->cartera->obtener_cliente($_REQUEST);
        }
        echo json_encode($data);
    }

    public function obtenerDataCliente(){
        $this->validacion->validarRol(2);
        $data=$this->cartera->DataCliente($_POST);
        echo json_encode($data);
    }
}
