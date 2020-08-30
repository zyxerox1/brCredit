<?php
class reporte_log_usuario_modelo
{
    private $data;
    private $DB_QUERY;

    public function __construct()
    {
        $this->DB_QUERY   = new query_modelo;
        $this->data = array();
    }

    /*///////////////////////////////consulta////////////////////////////*/

    public function obtenerReporte($params){
        $query="SELECT CASE
                WHEN log.movimiento_logu = 0 THEN 'Creaciòn'
                WHEN log.movimiento_logu = 1 THEN 'Actualizacòn'
                WHEN log.movimiento_logu = 3 THEN 'Cambiar estado'
                ELSE 'Movimiento descodocido por el sistema.'
                END as movimiento,
                log.fecha_logu AS fecha,
                CONCAT_WS(' ',usu.primer_nombre_usu,usu.segundo_nombre_usu,usu.primer_apellido_usu,usu.segundo_apellido_usu) as usuario,
                usu.documento_usu as documento_suario,
                CONCAT_WS(' ',Autor.primer_nombre_usu,Autor.segundo_nombre_usu,Autor.primer_apellido_usu,Autor.segundo_apellido_usu) AS autor,
                Autor.documento_usu as documento_autor
            FROM tbl_log_usuarios AS log
            INNER JOIN tbl_usuarios AS usu ON (log.id_usu=usu.id_usu)
            INNER JOIN tbl_usuarios as Autor ON (Autor.id_usu=log.id_autor_usu)
            WHERE 1";

        if(isset($params['Nombre']) && $params['Nombre']!=0){
          $query.=" AND usu.id_usu = ".$params['Nombre'];
        }
        if(isset($params['Cedula']) && $params['Cedula']!=0){
            $query.=" AND usu.documento_usu = ".$params['Cedula'];
        }
        if(isset($params['Nombre_au']) && $params['Nombre_au']!=0){
          $query.=" AND Autor.id_usu = ".$params['Nombre_au'];
        }
        if(isset($params['Cedula_au']) && $params['Cedula_au']!=0){
            $query.=" AND Autor.documento_usu = ".$params['Cedula'];
        }
        if(isset($params['Fecha_fin']) && $params['Fecha_fin']!=""){
            $query.=" AND log.fecha_logu <= '".$params['Fecha_fin']."'";
        }
        if(isset($params['Fecha_ini']) && $params['Fecha_ini']!=""){
            $query.=" AND log.fecha_logu >= '".$params['Fecha_ini']."'";
        }


        //$tablaSearch="AND int_documento_usu LIKE '%".$params['search']['value']."%'";

        $data=$this->DB_QUERY->queryDatatable($params,$query);
        return $data;
    }

    public function query_usuario(){
        $query="CALL obtenerUsuarioCoordinador(".$_SESSION["rol"].")";
        $data=$this->DB_QUERY->query($query);
        return $data;
    }
}