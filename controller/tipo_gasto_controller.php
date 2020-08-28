<?php
require_once 'model/tipo_gasto_modelo.php';

class tipo_gasto_controller
{
    private $tipo;
    private $validacion;

    public function __construct()
    {
        $this->tipo  = new tipo_gasto_modelo();
        $this->validacion  = new validaciones_controller();
    }

    public function save()
    {   
        $this->validacion->validarRol(2);
        $errores=[];
        if(!isset($_POST['aceptar'])){
           $errores[] = array('control' =>"aceptar" ,'error' =>"Para crear un nuevo tipo tiene que aceptar la codiciones.<br>"  );
        }

        if(count($errores)==0){
            $result=  $this->tipo->crear_tipo($_POST['tipo']);
            if($result!=3){
                $errores=array('control' =>0 ,'error' => 0);
            }else{
                $errores=array('control' =>0 ,'error' => 3);
            }
            
        }
        echo json_encode($errores);  
    }

    public function obtener()
    {   
        $this->validacion->validarRol(2);
        $data = $this->tipo->obtener();
        $data=array('error' => 0, 'data' => $data);
        echo json_encode($data);
    }
}