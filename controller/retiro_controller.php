<?php
require_once 'model/retiro_modelo.php';

class retiro_controller
{
    private $retiro;

    public function __construct()
    {
        $this->retiro  = new retiro_modelo();
        $this->validacion  = new validaciones_controller();
    }

    public function index()
    {
        $this->validacion->validarRol(1);
       
        //variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
        $c='retiro'; //carpeta;
        $p='retiro';//nombre del archivo js

        $data_filtro=$this->retiro->query_usuario();
        $data_filtro_ruta=$this->retiro->query_vendedor();

        require_once HTML_DIR . 'overall/header.php';
        require_once HTML_DIR . 'overall/topNav.php';
        require_once HTML_DIR . 'retiro/retiro.php';
        require_once HTML_DIR . 'retiro/modalRetiro.php';
        require_once HTML_DIR . 'overall/footer.php'; 
    }

    public function cargar_reporte(){
        $this->validacion->validarRol(1);
        $data=$this->retiro->obtenerReporte($_REQUEST);
        echo json_encode($data);
    }

    public function retiroRegistrar(){
        $errores=array();
        if($_POST['codigo']==0){
            $errores[] = array('control' =>"codigo" ,'error' => "Tiene que ingresar una ruta" );
        }

        if($_POST['valorRetiro']==""){
            $errores[] = array('control' =>"valorRetiro" ,'error' => "Tiene que ingresar un valor" );
        }else{
            $_POST['valorRetiro'] = preg_replace('/[.,]/', '', $_POST['valorRetiro']);

        }
        if(count($errores)==0){
            $errores=$this->retiro->Registrar($_POST['codigo'],$_POST['valorRetiro'],$_POST['descripcion'],$_POST['latitud'],$_POST['longitud']);
        }
      echo json_encode($errores);
    }
}