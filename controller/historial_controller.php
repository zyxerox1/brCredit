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
        require_once HTML_DIR . 'historial/modalEditarAbono.php';
        require_once HTML_DIR . 'historial/modal_confirmacion.php';
        require_once HTML_DIR . 'historial/historial.php';
        require_once HTML_DIR . 'overall/footer.php';
    }

    public function ver()
    {
        $this->validacion->validarRol(2);
        $data=$this->historial->ver($_REQUEST);
        echo json_encode($data);
    }

     public function obtenerDataCliente(){
        $this->validacion->validarRol(2);
        $data=$this->historial->DataCliente($_POST);
        echo json_encode($data);
    }

    public function abonarPago(){
      $errores=array();
      if($_POST['idPres']==""){
        $errores[] = array('error' => 1,"mensaje"=>"Error a completa el pago." );
      }

      if(count($errores)==0){
          if ($_POST['valorAbono']=="") {
              return array('control' =>"valorAbono" ,'error' => "Tiene que ingresar un valor"  );
          }else{
              $_POST['valorAbono'] = preg_replace('/[.,]/', '', $_POST['valorAbono']);
          }

          $errores=$this->historial->abonar($_POST['idPres'],$_POST['notaPago'],$_POST['valorAbono'],$_POST['latitud'],$_POST['longitud']);
      }
      echo json_encode($errores);
    }

}