<?php
require_once 'model/reporte_errores_modelo.php';

class reporte_errores_controller
{
    private $reporte;

    public function __construct()
    {
        $this->reporte  = new reporte_errores_modelo();
        $this->validacion  = new validaciones_controller();
    }

    public function index()
    {
        $this->validacion->validarRol(0);
       
        //variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
        $c='reporte_errores'; //carpeta;
        $p='reporte_errores';//nombre del archivo js
        $data_filtro=$this->reporte->query_usuario();
        require_once HTML_DIR . 'overall/header.php';
        require_once HTML_DIR . 'overall/topNav.php';
        require_once HTML_DIR . 'reporte_errores/reporte_errores.php';
        require_once HTML_DIR . 'overall/footer.php'; 
    }

    public function cargar_reporte(){
        $this->validacion->validarRol(0);
        $data=$this->reporte->obtenerReporte($_REQUEST);
        echo json_encode($data);
    }

     public function eliminar_reporte(){
        $this->validacion->validarRol(0);
        $errores=[];

        if($_POST['Fecha_ini']==''){
          $errores[] = array('control' =>"Fecha_ini" ,'error' =>"No puede dejar la fecha en blanco");
        }else{
            $Fecha_ini = explode("-", $_POST["Fecha_ini"]);
            //print_r($Fecha_ini);
            if (checkdate( $Fecha_ini[1], $Fecha_ini[2], $Fecha_ini[0]) == false) {
                $errores[] = array('control' =>"Fecha_ini" ,'error' =>"Debes selecionar una fecha valida");
            }
        }

        if($_POST['Fecha_fin']==''){
          $errores[] = array('control' =>"Fecha_fin" ,'error' =>"No puede dejar la fecha en blanco");
        }else{
            $Fecha_fin = explode("-", $_POST["Fecha_fin"]);
            //print_r($Fecha_fin);
            if (checkdate($Fecha_fin[1], $Fecha_fin[2], $Fecha_fin[0]) == false) {
                $errores[] = array('control' =>"Fecha_fin" ,'error' =>"Debes selecionar una fecha valida");
            }
        }

        if(count($errores)==0){
            $data=$this->reporte->eliminarLogErrores($_POST);
            $errores=array('control' =>0 ,'error' => 0);
        }
        echo json_encode($errores); 
    }
}