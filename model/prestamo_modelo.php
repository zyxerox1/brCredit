<?php
class prestamo_modelo
{
    private $LOG;
    private $data;
    private $DB_QUERY;

    public function __construct()
    {
        $this->DB_QUERY   = new query_modelo;
        $this->LOG   = new log_controller();
        $this->data = array();
    }

    /*/////////////////////////////////////////////guardar///////////////////////////////////*/

        public function log_prestamo($movimiento="",$id="",$id_clie="",$nota="",$valor,$tipo){

        /*movimineto 0-crear,1-editar,3-cambiar estado,2-orden*/
        /*parametro de errores{*/
        $controller="";
        $accion_func="";
        if(isset($_REQUEST['c'])){
            $controller=$_REQUEST['c'];
        }
        if(isset($_REQUEST['a'])){
            $accion_func=$_REQUEST['a'];
        }

        $query = "CALL logPrestamo('$movimiento','$id','$controller',".$_SESSION["id_usu_credit"].",'$accion_func','$id_clie','$nota','$valor','$tipo')";

        $this->DB_QUERY->save($query);
    }

    public function crear_prestamo($FechaLimit,$Formap,$Valor,$ncoutas,$Valorc,$inter,$idClient,$valorInteres){
        $query = "INSERT INTO tbl_prestamo (id_pres, id_clie, fecha_limite_pres, valor_pres, forma_pago_pres, numero_cuota_pres, valor_cuotas_pres, intereses_press,valor_neto_clie) VALUES (NULL, $idClient, '$FechaLimit', $valorInteres, $Formap, $ncoutas,$Valorc,$inter,$Valor)";
        $id=$this->DB_QUERY->save($query,'Registrar prestamo');
        $this->log_prestamo(0,$id,$idClient,"Creao prestamo",$valorInteres,99);
        return array('control' =>0 ,'error' => 0);
    }
}