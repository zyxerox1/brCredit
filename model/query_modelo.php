<?php
require_once 'controller/log_controller.php';

class query_modelo
{   
    public function __construct()
    {
        $this->LOG   = new log_controller();
        $this->DB   = conexion::getConnection();
    }  

    public function queryDatatable($params=1,$sql=1,$tablaSearch=""){
        if($sql!=1){
            $columns = array();
            $data=array();
            $where = "";
            $sqlTot =  "";
            $sqlRec = "";
            if( !empty($params['search']['value']) ) {
                $where .=$tablaSearch;
            }
                
            $sqlTot .= $sql;
            $sqlRec .= $sql;
            if(isset($where) && $where != '') {
                $sqlTot .= $where;
                $sqlRec .= $where;
            }

            if(!empty($params["order"])){
                $column=$params["order"][0]["column"];
                $column=$column+1;
                    $sqlRec .=  " ORDER BY  ".$column." ".$params["order"][0]["dir"];
              
            }  
            $sqlRec .=  " LIMIT ".$params['start']." ,".$params['length'];
            /*parametro de errores{*/
            $control="";
            $accion="";
            if(isset($_REQUEST['c'])){
                $control=$_REQUEST['c'];
            }
            if(isset($_REQUEST['a'])){
                $acion=$_REQUEST['a'];
            }
            $accion='Consulta de dataTable => '.$sql;
            /*}///////////////////*/
            $queryTot = mysqli_query($this->DB, $sqlTot) or die('501,'.$this->LOG->log_errores($accion,mysqli_error($this->DB),$control,$acion));

            $totalRecords = mysqli_num_rows($queryTot);

            $queryRecords = mysqli_query($this->DB, $sqlRec) or die('501.'.$this->LOG->log_errores($accion,mysqli_error($this->DB),$control,$acion));

            while ($fila = $queryRecords->fetch_assoc()) {
                $data[] = $fila;
            }
            $dataResult = array(
                    "draw"            => intval( $params['draw'] ),
                    "recordsTotal"    => intval( $totalRecords ),
                    "recordsFiltered" => intval($totalRecords),
                    "data"            => $data   // total data array
                    );
            return $dataResult;
        }
    }

    public function query($sql="SELECT now()",$control="",$acion=""){
        /*parametro de errores{*/
        $accion='c='.$control.' a='.$acion.' /-/ consulta='.$sql;
        /*}///////////////////*/
        $query = mysqli_query($this->DB, $sql) or die('501'.$this->LOG->log_errores($accion,mysqli_error($this->DB),$control,$acion));
        while ($fila = $query->fetch_assoc()) {
            $data[] = $fila;
        }
        return $data;
    } 

    public function save($sql="",$accion=""){
        mysqli_query($this->DB, $sql) or die('501' . $this->LOG->log_errores($accion." => ".$sql,mysqli_error($this->DB)));
        $id = mysqli_insert_id($this->DB);
        if($id==""){
            $id = 0;
        }
        return $id;
    }
}