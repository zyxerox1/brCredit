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

    public function log_prestamo($movimiento="",$id="",$nota=""){
        /*parametro de errores{*/
        $controller="";
        $accion_func="";
        if(isset($_REQUEST['c'])){
            $controller=$_REQUEST['c'];
        }
        if(isset($_REQUEST['a'])){
            $accion_func=$_REQUEST['a'];
        }

        $query = "CALL logPrestamo('$movimiento','$id','$controller',".$_SESSION["id_usu_credit"].",'$accion_func')";
        $this->DB_QUERY->save($query);
    }

    public function crear_prestamo($FechaLimit,$Formap,$Valor,$ncoutas,$Valorc,$inter,$id){
        $query = "INSERT INTO tbl_prestamo (id_pres, id_clie, fecha_limite_pres, valor_pres, forma_pago_pres, numero_cuota_pres, valor_cuotas_pres, intereses_press) VALUES (NULL, $id, '$FechaLimit', $Valor, $Formap, $ncoutas,$Valorc,$inter)";
        $id=$this->DB_QUERY->save($query,'Registrar prestamo');
        //$this->log_tipo_gasto(0,$id);
        return array('control' =>0 ,'error' => 0);
    }
}