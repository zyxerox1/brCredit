<?php
class reporte_errores_modelo
{
    private $data;
    private $DB_QUERY;

    public function __construct()
    {
        $this->DB_QUERY   = new query_modelo;
        $this->DB_QUERY   = new query_modelo;
        $this->data = array();
    }

    /*///////////////////////////////consulta////////////////////////////*/

    public function obtenerReporte($params){
        $query="SELECT 
                log.text_accion_loge AS accion,
                log.text_descripcion_loge AS descripcion,
                log.text_controller_loge AS controller,
                log.text_func_accion_loge AS function,
                log.date_fecha_loge AS fecha,
                CONCAT_WS(' ',usu.primer_nombre_usu,usu.segundo_nombre_usu,usu.primer_apellido_usu,usu.segundo_apellido_usu) AS usuario,
                usu.documento_usu AS documento_suario
               
            FROM tbl_log_errores AS log
            INNER JOIN tbl_usuarios AS usu ON (log.int_id_usu=usu.id_usu)
            WHERE 1";

        if(isset($params['Nombre']) && $params['Nombre']!=0){
          $query.=" AND usu.int_id_usu = ".$params['Nombre'];
        }
        if(isset($params['Cedula']) && $params['Cedula']!=0){
            $query.=" AND usu.documento_usu = ".$params['Cedula'];
        }
        if(isset($params['Fecha_fin']) && $params['Fecha_fin']!=""){
            $query.=" AND log.date_fecha_loge <= '".$params['Fecha_fin']."'";
        }
        if(isset($params['Fecha_ini']) && $params['Fecha_ini']!=""){
            $query.=" AND log.date_fecha_loge >= '".$params['Fecha_ini']."'";
        }

        //$tablaSearch="AND int_documento_usu LIKE '%".$params['search']['value']."%'";

        $data=$this->DB_QUERY->queryDatatable($params,$query);
        return $data;
    }

    public function query_usuario(){
        $query="CALL obtenerUsuario()";
        $data=$this->DB_QUERY->query($query);
        return $data;
    }

    public function eliminarLogErrores($params){
        $query="CALL eliminarLogErrores('".$params['Fecha_ini']."','".$params['Fecha_fin']."')";
        $data=$this->DB_QUERY->save($query);
        return $data;
    }
}