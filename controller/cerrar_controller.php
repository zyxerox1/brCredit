<?php

require_once 'model/cerrar_modelo.php';

class cerrar_controller
{
  private $validacion;
  private $cerrar;

  public function __construct()
  {
    $this->validacion  = new validaciones_controller();
    $this->cerrar  = new cerrar_modelo();
  }

  public function index()
  {
    $this->validacion->validarRol(1);
    $c='cerrar';//variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
    $p='cerrar';
    $data_filtro=$this->cerrar->obtener_filtro_vendedor();
    require_once HTML_DIR . 'overall/header.php';
    require_once HTML_DIR . 'overall/topNav.php';
    require_once HTML_DIR . 'cerrar/cerrar.php';
    require_once HTML_DIR . 'overall/footer.php';
  }

  public function cargar_reporte(){
    $this->validacion->validarRol(1);
    $data=$this->cerrar->obtenerDatos($_GET);
    echo json_encode($data);
  }

  public function detalle(){
    $this->validacion->validarRol(1);
    $data=$this->cerrar->obtenerDetalle($_POST);
    echo json_encode($data);
  }

  public function notaVentas(){
    $this->validacion->validarRol(1);
    $data=$this->cerrar->notaVentas($_GET);
    echo json_encode($data);
  }

  public function ventas(){
    $this->validacion->validarRol(1);
    $data=$this->cerrar->obtenerVenta($_GET);
    echo json_encode($data);
  }

  public function recaudo(){
    $this->validacion->validarRol(1);
    $data=$this->cerrar->obtenerRecaudo($_GET);
    echo json_encode($data);
  }

  public function gasto(){
    $this->validacion->validarRol(1);
    $data=$this->cerrar->obtenerGasto($_GET);
    echo json_encode($data);
  }

  public function resumen(){
    $this->validacion->validarRol(1);
    $data=$this->cerrar->obtenerResumen($_POST);
    echo json_encode($data);
  }
  
  public function cerrarTodo(){
    $this->validacion->validarRol(1);
    $data=$this->cerrar->cerrarTodo($_POST);
    echo json_encode($data);
  }

  public function rechazar(){
    $this->validacion->validarRol(1);
    $data=$this->cerrar->rechazar($_POST);
    echo json_encode($data);
  }
}