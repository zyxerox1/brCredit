<?php
class log_controller
{   
    private $DB;
    private $LOG;
    public function __construct()
    {
        $this->DB   = conexion::getConnection();
    }

    public function log_errores($accion,$descripcion,$id=0){
        if(isset($_SESSION["id_usu_credit"])){
            $id_usu=$_SESSION["id_usu_credit"];
        }else{
            $id_usu=$id;
        }
        /*parametro de errores{*/
        $controller="";
        $accion_func="";
        if(isset($_REQUEST['c'])){
            $controller=$_REQUEST['c'];
        }
        if(isset($_REQUEST['a'])){
            $accion_func=$_REQUEST['a'];
        }

        $query = 'CALL logErrores("'.$accion.'","'.$descripcion.'","'.$id_usu.'","'.$controller.'","'.$accion_func.'")';
        mysqli_query($this->DB, $query) or die('501.f' . mysqli_error($this->DB));
    }
}
