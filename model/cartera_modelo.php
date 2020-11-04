<?php
class cliente_modelo
{
    private $DB;
    private $user;

    public function __construct()
    {
        $this->DB   = conexion::getConnection();
        $this->DB_QUERY   = new query_modelo;
        $this->DB_QUERY1   = new query_modelo;
        $this->DB_QUERY2   = new query_modelo;
        $this->DB_QUERY3   = new query_modelo;
        $this->user = array();
    }

    /*/////////////////////////////////////////////guardar///////////////////////////////////*/

    /*////////////////////////////////consulta//////////////////////////////////////////////////*/

    public function obtenerFiltroRuta(){
      $query="CALL FiltroRuta()";
      $data=$this->DB_QUERY->query($query);
      return $data;
    }

    public function obtener_filtro_cliente($params){
        $query="CALL obtenerFiltroCliente(".$params["id_usu"].")";
        $data=$this->DB_QUERY->query($query);
        return $data;
    }

    public function obtenerDatosTotalCartera($params){
        $query="SELECT COUNT(pres.id_pres) AS totalNroCar, SUM(pres.valor_pres) AS totalCartera,
                SUM(IF(DATE_FORMAT(pres.fecha_limite_pres, '%Y-%c-%d')>DATE_FORMAT(now(), '%Y-%c-%d'),pres.valor_pres,0)) AS totalCarVen,
                SUM(IF(DATE_FORMAT(pres.fecha_limite_pres, '%Y-%c-%d')>DATE_FORMAT(now(), '%Y-%c-%d'),1,0)) AS totalCarVenNro,
                SUM(IF(pres.atraso_pres>0,pres.valor_pres,0)) AS totalCarAtra,
                SUM(IF(pres.atraso_pres>0,1,0)) AS totalCarAtraNro
                FROM tbl_prestamo AS pres
                INNER JOIN tbl_cliente AS clien ON (pres.id_clie=clien.id_clie)
                WHERE pres.valor_pres>0 AND clien.id_usu=".$params['usu'];
        $data=$this->DB_QUERY->query($query);
        return $data;
    }

    public function obtener_cliente($params){

        $query="SELECT clien.id_clie as id, 
                       clien.documento_clie as CC, 
                      CONCAT_WS (' ',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,
                      clien.telefono_1_clie as t1, 
                      clien.telefono_2_clie as t2,
                      clien.correo_clie as Correo,
                      clien.documento_clie as Direcionr,
                      clien.documento_ref_clie as Direcionc, 
                      clien.fecha_nacimineto_clie as fecha_cobro,
                      if(pres.valor_pres IS NOT NULL,pres.valor_pres,0) as valorDeuda,
                      if(pres.id_pres IS NOT NULL,pres.id_pres,0) as id_cobro,
                      clien.orden_ruta_clie as orden
                      FROM tbl_cliente as clien 
                      LEFT JOIN tbl_prestamo as pres on (pres.id_clie=clien.id_clie AND (pres.valor_pres>0)) 
                      WHERE clien.id_usu = ".$_SESSION["id_usu_credit"];
        if(isset($params['Nombre']) && $params['Nombre']!=0){
          $query.=" AND clien.id_clie = ".$params['Nombre'];
        }
        if(isset($params['Cedula']) && $params['Cedula']!=0){
            $query.=" AND clien.documento_clie = ".$params['Cedula'];
        }

        $query.=" ORDER BY clien.orden_ruta_clie ASC";

        //$tablaSearch="AND int_documento_usu LIKE '%".$params['search']['value']."%'";

        $data=$this->DB_QUERY->queryDatatable($params,$query);
        return $data;
    }

    public function obtener_cliente_todos($params){
         $query="SELECT LPAD(pres.id_pres, 8, '0') AS Cod,
         CONCAT_WS (' ', clien.primer_nombre_clie, clien.segundo_nombre_clie, clien.primer_apellido_clie, clien.segundo_apellido_clie) AS Cliente,
         if(pres.atraso_pres=0,'Pediente','Vencidas') AS Estado,
         logpres.valor_pres_logp AS Apagar,
         logpres.valor_pres_logp - pres.valor_pres AS Pagado,
         pres.valor_pres AS Debe,
         pres.numero_cuota_pres AS Nrocouta,
         pres.atraso_pres AS Diasven,
         '-' AS Coutareg,
         IF(DATE_FORMAT(pres.fecha_limite_pres, '%Y-%c-%d')>DATE_FORMAT(now(), '%Y-%c-%d'),pres.valor_pres,0) AS Coutaatra,
         DATE_FORMAT(logpres.fecha_logp, '%Y-%c-%d') AS Fechacreacion,
         DATE_FORMAT(DATE_ADD(logpres.fecha_logp,INTERVAL 1 DAY), '%Y-%c-%d') AS Fechaini,
         DATE_FORMAT(pres.fecha_limite_pres, '%Y-%c-%d') AS Fechafin,
         '-' AS Refinanciada
        FROM tbl_cliente as clien 
        INNER JOIN tbl_prestamo as pres on (pres.id_clie=clien.id_clie AND (pres.valor_pres>0))
        INNER JOIN tbl_log_prestamo as logpres ON (logpres.id_pres=pres.id_pres AND logpres.movimiento_logp=0)
        WHERE clien.id_usu=".$params['usu'];

        if(isset($params['Nombre']) && $params['Nombre']!=0){
          $query.=" AND clien.id_clie = ".$params['Nombre'];
        }

        if(isset($params['Estado']) && $params['Estado']!=0){
            if($params['Estado']==1){
              $query.=" AND pres.atraso_pres = 0 ";
            }else{
              $query.=" AND pres.atraso_pres <> 0 ";
            }  
        }

        if(isset($params['nrocouta']) && $params['nrocouta']!=0){
            $query.=" AND pres.numero_cuota_pres = ".$params['nrocouta'];
        }

        if(isset($params['Numdia']) && $params['Numdia']!=0){
            $query.=" AND pres.atraso_pres = ".$params['Numdia'];
        }

        if(isset($params['Fecha_fin']) && $params['Fecha_fin']!=""){
            $query.=" AND logpres.fecha_logp <= '".$params['Fecha_fin']."'";
        }
        if(isset($params['Fecha_ini']) && $params['Fecha_ini']!=""){
            $query.=" AND pres.fecha_limite_pres >= '".$params['Fecha_ini']."'";
        }

        if(isset($params['Fecha_crea']) && $params['Fecha_crea']!=""){
            $query.=" AND logpres.fecha_logp = '".$params['Fecha_crea']."'";
        }

        //$tablaSearch="AND int_documento_usu LIKE '%".$params['search']['value']."%'";

        $data=$this->DB_QUERY->queryDatatable($params,$query);
        return $data;
    }


    public function query_cliente($params){
        $query="CALL buscarCliente(".$params['i'].")";
        $data=$this->DB_QUERY->query($query);
        return $data;
    }

    public function DataCliente($params){
        $query="SELECT CONCAT_WS(' ',client.primer_nombre_clie,client.segundo_nombre_clie,client.primer_apellido_clie,client.segundo_apellido_clie) as nombre,client.foto_clie as foto,
            client.documento_clie as cc,
            client.documento_ref_clie as ccr,
            client.telefono_1_clie as telefono1,
            client.telefono_2_clie as telefono2,
            client.direcion_cobro_clie as direcionc,
            client.direcion_clie as direcion,
            client.correo_clie as correo,
            client.fecha_nacimineto_clie as fecha,
            if(pres.valor_pres IS NOT NULL,pres.valor_pres,0) as valorDeuda,
            client.prestamo_minimo_client as prestamo_minimo,
            client.prestamo_maximo_client as prestamo_maximo
        FROM tbl_cliente as client 
        LEFT JOIN tbl_prestamo as pres on (pres.id_clie=client.id_clie AND (pres.valor_pres>0)) 
        WHERE client.id_clie=".$params['id'];
        $data=$this->DB_QUERY->query($query);
        return array('error' => 0,'data'=>$data);
    }

    /*////////////////////////////////atualizar//////////////////////////////////////////////////*/
    
}