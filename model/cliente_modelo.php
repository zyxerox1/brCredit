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
    public function log_cliente($movimiento="",$id="",$nota=""){
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

        $query = "CALL logCliente('$movimiento','$id',".$_SESSION["id_usu_credit"].",'$accion_func','$controller')";

        $this->DB_QUERY->save($query);
    }

    public function crear_usuario($primernombre, $segundonombre, $primerapellido, $segundoapellido, $Documento, $Genero, $Telefono_1, $Telefono_2, $Fecha, $Direcion, $Correo, $img_name,$estados,$ciudades,$ccr,$Direcionc,$valormin=200,$valormax=300,$ruta=0){

      if($ruta==0){
         $ruta=$_SESSION["id_usu_credit"];
      }
      $valoresPrestamo="";


        $user = array();

        if($img_name==1){
            $img_name=date("YmdHis")."_".rand(0, 9).$_SESSION["id_usu_credit"].".png";
            $user["text_img_perfil_usu"]=$img_name;
        }else{
            $img_name='usuario.jpg';
            $user["text_img_perfil_usu"]=1;
        }
        $this->DB_QUERY->begin();
        $query = "SELECT max(orden_ruta_clie) AS orden_ruta_clie FROM tbl_cliente WHERE id_usu=".$ruta;
        $data=$this->DB_QUERY->query($query);
        $data[0]["orden_ruta_clie"]+=1;
    	  $query = "INSERT INTO tbl_cliente (id_clie, documento_clie, documento_ref_clie, primer_nombre_clie, segundo_nombre_clie, primer_apellido_clie, segundo_apellido_clie, telefono_1_clie, telefono_2_clie, direcion_clie, direcion_cobro_clie, sexo_clie, correo_clie, fecha_nacimineto_clie, foto_clie, estado_localidad_clie, ciudad_localidad_clie, id_usu,prestamo_minimo_client,prestamo_maximo_client, orden_ruta_clie) VALUES (NULL, $Documento, $ccr,'$primernombre', '$segundonombre', '$primerapellido', '$segundoapellido', $Telefono_1, $Telefono_2, '$Direcion', '$Direcionc','$Genero', '$Correo', '$Fecha','$img_name',$estados,$ciudades,$ruta,$valormin,$valormax,".$data[0]["orden_ruta_clie"].");";
        $id=$this->DB_QUERY->save($query,'creacion de cliente.');
        $this->log_cliente(0,$id);
        $this->DB_QUERY->commit();
        return array('control' =>$user["text_img_perfil_usu"] ,'error' => 0,'resp'=>$id);
    }

    /*////////////////////////////////consulta//////////////////////////////////////////////////*/
    /*consulta de filtro*/
    public function obtener_filtro_cliente($id=0){
      $query="";
      if ($id==0) {
        $query="CALL obtenerFiltroCliente(".$_SESSION["id_usu_credit"].")";
      }else{
        $query="CALL obtenerFiltroCliente(".$id.")";
      }
      $data=$this->DB_QUERY->query($query);
      return $data;
    }

    public function obtenerFiltroRuta(){
      $query="CALL FiltroRuta()";
      $data=$this->DB_QUERY1->query($query);
      return $data;
    }


    public function query_cliente($params){
        $query="CALL buscarCliente(".$params['i'].")";
        $data=$this->DB_QUERY->query($query);
        return $data;
    }

    public function obtener_cliente($params){

        $query="SELECT clien.id_clie as id, 
                       clien.documento_clie as CC, 
                      CONCAT_WS (' ',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,
                      pres.numero_cuota_pres as cuota,
                      clien.correo_clie as Correo,
                      logpres.valor_pres_logp as valor, 
                      IF(DATE_FORMAT(pres.fecha_limite_pres, '%Y-%c-%d')<DATE_FORMAT(now(), '%Y-%c-%d'),DATEDIFF(DATE_FORMAT(now(), '%Y-%c-%d'), DATE_FORMAT(pres.fecha_limite_pres, '%Y-%c-%d')),0) AS totalCarVenNro,
                      if(pres.valor_pres IS NOT NULL,pres.valor_pres,0) as valorDeuda,
                      if(pres.id_pres IS NOT NULL,pres.id_pres,0) as id_cobro,
                      clien.orden_ruta_clie as orden
                      FROM tbl_cliente as clien 
                      LEFT JOIN tbl_prestamo as pres on (pres.id_clie=clien.id_clie AND (pres.valor_pres>0)) 
                      LEFT JOIN tbl_log_prestamo as logpres on (pres.id_pres=logpres.id_pres AND logpres.movimiento_logp=0) 
                      WHERE clien.id_usu = ".$_SESSION["id_usu_credit"];
        if(isset($params['Nombre']) && $params['Nombre']!=0){
          $query.=" AND clien.id_clie = ".$params['Nombre'];
        }
        if(isset($params['Cedula']) && $params['Cedula']!=0){
            $query.=" AND clien.documento_clie = ".$params['Cedula'];
        }

        $query.=" GROUP BY clien.id_clie ORDER BY clien.orden_ruta_clie ASC";

        //$tablaSearch="AND int_documento_usu LIKE '%".$params['search']['value']."%'";

        $data=$this->DB_QUERY->queryDatatable($params,$query);
        return $data;
    }

    public function obtener_cliente_todos($params){
      if($params['ruta']==""){
        $data=$this->DB_QUERY->queryDatatable($params,'');
        return $data; 
      }
       $query="SELECT CONCAT_WS(' ',clien.primer_nombre_clie,clien.segundo_nombre_clie) AS Nombres,
       CONCAT_WS(' ',clien.primer_apellido_clie,clien.segundo_apellido_clie) AS Apellidos,
                        clien.telefono_1_clie AS Telefono,
                        if(pres.atraso_pres>0,'Si','No') AS Moroso,
                        clien.estado_clie AS Estado,
                        IF(DATE_FORMAT(pres.fecha_limite_pres, '%Y-%c-%d')<DATE_FORMAT(now(), '%Y-%c-%d'),DATEDIFF(DATE_FORMAT(now(), '%Y-%c-%d'), DATE_FORMAT(pres.fecha_limite_pres, '%Y-%c-%d')),0) AS totalCarVenNro,
                        clien.direcion_clie AS Direcion,
                        COUNT(pres.id_pres) AS ventas,
                        SUM(logPress.valor_pres_logp) AS vendido,
                        SUM(logPress.valor_pres_logp-pres.valor_pres) AS pagado,
                        CONCAT_WS(' - ',clien.prestamo_minimo_client,clien.prestamo_maximo_client) AS Limite,
                        clien.documento_ref_clie AS Referencia,
                        clien.id_clie AS id,
                        clien.autorizarMaxMin_clie as autorizar,
                        CONCAT(clien.min_auto_clie,' - ',clien.max_auto_clie) as valoresAutoriazar
                FROM tbl_cliente as clien
                LEFT JOIN tbl_prestamo AS pres ON (pres.id_clie=clien.id_clie)
                LEFT JOIN tbl_log_prestamo AS logPress ON (logPress.id_pres=pres.id_pres AND logPress.movimiento_logp=0)
                WHERE clien.id_usu=".$params['ruta'];

        if(isset($params['Nombre']) && $params['Nombre']!=0){
          $query.=" AND clien.id_clie = ".$params['Nombre'];
        }
        if(isset($params['Cedula']) && $params['Cedula']!=0){
            $query.=" AND clien.documento_clie = ".$params['Cedula'];
        }
        
        $query.=" GROUP BY clien.id_clie ORDER BY clien.orden_ruta_clie ASC";

        //$tablaSearch="AND int_documento_usu LIKE '%".$params['search']['value']."%'";

        $data=$this->DB_QUERY->queryDatatable($params,$query);
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
    
    public function cambiar_estado($params){
      $this->DB_QUERY->begin();
      $query="UPDATE tbl_cliente SET estado_clie = ".$params['estado']." WHERE tbl_cliente.id_clie = '".$params['id']."'";
      $id=$this->DB_QUERY->save($query,'cambiar estado del cliente.');
      $this->log_cliente(6,$params['id']);
      $this->DB_QUERY->commit();
      return array('control' =>0 ,'error' => 0);
    }

    public function atualizar_cliente($primernombre, $segundonombre, $primerapellido, $segundoapellido,$Genero, $Telefono_1, $Telefono_2, $Fecha, $Direcion, $Correo, $img_name,$id,$estados,$ciudad,$ccr,$Direcioncobro,$valormin=0,$valormax=0,$ruta=0){

        $user = array();
        $this->DB_QUERY->begin();
        $img="";
        $correo="";
        $datosAdmin="";
        $datosVende="";

        $autorizarMaxMin_clie=0;
        $max_auto_clie=0;
        $min_auto_clie=0;

        if($_SESSION["rol"]==2){
           $query = "SELECT prestamo_minimo_client,prestamo_maximo_client FROM tbl_cliente WHERE id_clie=".$id;
          $dataVendedor=$this->DB_QUERY->query($query);
          if($dataVendedor[0]['prestamo_minimo_client']!=$valormin || $dataVendedor[0]['prestamo_minimo_client']!=$valormax){
            $datosVende=",autorizarMaxMin_clie=1
                       ,max_auto_clie='$valormax',
                       min_auto_clie='$valormin'";
            
          }
        }

        if($_SESSION['rol']==1){
          $datosAdmin=",prestamo_minimo_client='$valormin',
                       prestamo_maximo_client='$valormax',
                       id_usu='$ruta'";

                      $query = "SELECT id_usu FROM tbl_cliente WHERE id_clie=".$id;
                      $dataAdmin=$this->DB_QUERY->query($query);
                      if($dataAdmin[0]['id_usu']!=$ruta){

                        $query = "SELECT max(orden_ruta_clie) AS orden_ruta_clie FROM tbl_cliente WHERE id_usu=".$ruta;
                        $data=$this->DB_QUERY->query($query);
                        $data[0]["orden_ruta_clie"]+=1;
                        $datosAdmin.=",orden_ruta_clie='".$data[0]["orden_ruta_clie"]."'";
                      }
        

        }
        if($img_name==1){
            $query="SELECT foto_clie FROM tbl_cliente WHERE id_clie=".$id;
            $data=$this->DB_QUERY->query($query);
            if($data[0]['foto_clie']=='usuario.jpg'){
               $user["control"]=date("YmdHis")."_".$id.".png";
               $img=",foto_clie='".$user["control"]."'";
            }else{
                $user["control"]=$data[0]['foto_clie'];
            }
            
        }else{
            $img_name='usuario.jpg';
            $user["control"]=1;
        }

        $query = "UPDATE tbl_cliente 
                  SET 
                    primer_nombre_clie='$primernombre',
                    segundo_nombre_clie='$segundonombre',
                    primer_apellido_clie='$primerapellido',
                    segundo_apellido_clie='$segundoapellido',
                    telefono_1_clie=$Telefono_1,
                    telefono_2_clie=$Telefono_2,
                    direcion_clie='$Direcion',
                    sexo_clie='$Genero',
                    fecha_nacimineto_clie='$Fecha',
                    estado_localidad_clie='$estados',
                    ciudad_localidad_clie='$ciudad',
                    documento_ref_clie='$ccr',
                    direcion_cobro_clie='$Direcioncobro',
                    correo_clie='$Correo'
                    $datosAdmin
                    $datosVende
                    $img
                  WHERE tbl_cliente.id_clie =".$id;

        $this->DB_QUERY->save($query,'atualizar cliente.');
        $this->log_cliente(1,$id);
        $this->DB_QUERY->commit();
        return $user;
    }

    public function cambiarOrdenRutero($params){
        $this->DB_QUERY->begin();
        $DataClienteModifica=0;
        $query="SELECT orden_ruta_clie FROM tbl_cliente WHERE id_clie=".$params['id'];
        $DataCliente=$this->DB_QUERY->query($query);

        if($params["pos"]==0){
            $DataClienteModifica=$DataCliente[0]['orden_ruta_clie']+1;
        }else if($params["pos"]==1){
            $DataClienteModifica=$DataCliente[0]['orden_ruta_clie']-1;
        }

        $query="SELECT id_clie,orden_ruta_clie FROM tbl_cliente WHERE orden_ruta_clie=".$DataClienteModifica." AND id_usu=".$_SESSION["id_usu_credit"];
        $DataClienteModifica=$this->DB_QUERY1->query($query);

        if(count($DataClienteModifica)==0){
            return array('error' => 1);
        }
        
        $query = "UPDATE tbl_cliente 
                  SET 
                    orden_ruta_clie=".$DataCliente[0]['orden_ruta_clie']."
                  WHERE tbl_cliente.id_clie =".$DataClienteModifica[0]['id_clie'];

        $this->DB_QUERY2->save($query,'cambiar orden cliente.');
        $this->log_cliente(2,$DataClienteModifica[0]['id_clie']);

        $query = "UPDATE tbl_cliente 
                  SET 
                    orden_ruta_clie=".$DataClienteModifica[0]['orden_ruta_clie']."
                  WHERE tbl_cliente.id_clie =".$params['id'];
        $this->DB_QUERY3->save($query,'cambiar orden cliente.');
        $this->log_cliente(2,$params['id']);
        $this->DB_QUERY->commit();
        return array('error' => 0);
    }


    public function autrizarCambioSaldo($params){ 
      $this->DB_QUERY->begin();
      $queryUpdate="";
      $query = "SELECT min_auto_clie,max_auto_clie FROM tbl_cliente WHERE id_clie=".$params['id'];
      $dataVendedor=$this->DB_QUERY->query($query);

      if($dataVendedor[0]['min_auto_clie']==0 && $dataVendedor[0]['max_auto_clie']==0){
        return array('error' => 1,'mensaje'=>"Hubo un problema con los saldo, parece que ambos estan en cero.");
      }
      $queryUpdate = "UPDATE tbl_cliente 
                  SET 
                    prestamo_minimo_client=".$dataVendedor[0]['min_auto_clie'].",
                    prestamo_maximo_client=".$dataVendedor[0]['max_auto_clie'].",
                    max_auto_clie=0,
                    min_auto_clie=0,
                    autorizarMaxMin_clie=0
                  WHERE tbl_cliente.id_clie =".$params['id'];
      $this->DB_QUERY3->save($queryUpdate,'autorizar cambio de saldo.');
      $this->log_cliente(7,$params['id']);
      $this->DB_QUERY->commit();
      return array('error' => 0);
    }
    
}