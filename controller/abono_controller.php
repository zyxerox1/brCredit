<?php

require_once 'model/abono_modelo.php';

class abono_controller
{
    private $validacion;
    private $abono;
    public function __construct()
    {

        $this->validacion  = new validaciones_controller();
        $this->abono  = new abono_modelo();
    }

    public function index()
    {
        $this->validacion->validarRol(2);
        $c='abono';//variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
        $p='abono';
        $data_filtro=$this->abono->obtener_filtro_cliente();
        require_once HTML_DIR . 'overall/header.php';
        require_once HTML_DIR . 'overall/topNav.php';
        require_once HTML_DIR . 'abono/modal_abono.php';
        require_once HTML_DIR . 'abono/abono.php';
        require_once HTML_DIR . 'overall/footer.php';
    }

      public function cargar(){
        $this->validacion->validarRol(2);
        $data=$this->abono->obtener_cliente($_REQUEST);
        echo json_encode($data);
    }

     public function obtenerDataCliente(){
        $this->validacion->validarRol(2);
        $data=$this->abono->DataCliente($_POST);
        echo json_encode($data);
    }

    public function abonarPago(){
      $errores=array();
      if($_POST['tipo']==""){
        $errores[] = array('error' => 1,"mensaje"=>"Error a completa el pago.");
      }
      if($_POST['idPres']==""){
        $errores[] = array('error' => 1,"mensaje"=>"Error a completa el pago." );
      }

      if($_POST['notaPago']==""){
        $errores[] = array('error' => "El campo nota no puede estar vacio","control"=>"notaPago" );
      }

      if(count($errores)==0){
        if($_POST['tipo']==1){
          if ($_POST['valorAbono']=="") {
              return array('control' =>"valorAbono" ,'error' => "Tiene que ingresar un valor"  );
          }else{
              $_POST['valorAbono'] = preg_replace('/[.,]/', '', $_POST['valorAbono']);
          }
          $errores=$this->abono->abonar($_POST['tipo'],$_POST['idPres'],$_POST['notaPago'],$_POST['valorAbono']);
        }else if($_POST['tipo']==0){
          $errores=$this->abono->abonar($_POST['tipo'],$_POST['idPres'],$_POST['notaPago'],0);
        }
      }
      
      echo json_encode($errores);
    }
}
