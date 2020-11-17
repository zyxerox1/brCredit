<?php
class ruta_modelo
{
    private $DB;
    private $user;

    public function __construct()
    {
        $this->DB   = conexion::getConnection();
        $this->DB_QUERY   = new query_modelo;
        $this->user = array();
    }

    /*/////////////////////////////////////////////guardar///////////////////////////////////*/
    public function log_usuario($movimiento="",$id="",$nota=""){
        /*parametro de errores{*/
        $controller="";
        $accion_func="";
        if(isset($_REQUEST['c'])){
            $controller=$_REQUEST['c'];
        }
        if(isset($_REQUEST['a'])){
            $accion_func=$_REQUEST['a'];
        }

        $query = "CALL logUsuarios('$movimiento','$id',".$_SESSION["id_usu_credit"].",'$accion_func','$controller')";

        $this->DB_QUERY->save($query);
    }

    public function crear_usuario($primernombre, $segundonombre, $primerapellido, $segundoapellido, $Documento, $Genero, $Telefono_1, $Telefono_2, $Fecha, $Direcion, $Correo, $pas1, $img_name_name, $img_name,$perfil,$estados,$ciudades,$codigo,$valorCaja){

        $user = array();
        $this->DB_QUERY->begin();
        if($img_name==1){
            $img_name=date("YmdHis")."_".$_SESSION["id_usu_credit"].".png";
            $user["text_img_perfil_usu"]=$img_name;
        }else{
            $img_name='usuario.jpg';
            $user["text_img_perfil_usu"]=1;
        }

    	$query = "INSERT INTO tbl_usuarios (id_usu, documento_usu, primer_nombre_usu,segundo_nombre_usu, primer_apellido_usu, segundo_apellido_usu, telefono_1_usu, telefono_2_usu, direcion_usu, sexo_usu, correo_usu, contrasena_usu, fecha_nacimineto_usu, foto_usu,rol_usu,estado_localidad_usu,ciudad_localidad_usu,codigo_ruta) VALUES (NULL, $Documento,'$primernombre','$segundonombre','$primerapellido','$segundoapellido', $Telefono_1, $Telefono_2, '$Direcion', '$Genero', '$Correo', '$pas1', '$Fecha', '$img_name',$perfil,$estados,$ciudades,'$codigo')";

        $id=$this->DB_QUERY->save($query,'creacion de usuarios.');
        $queryCaja = "INSERT INTO tbl_caja (id_caja, saldo_caja, id_usu) VALUES (null, '$valorCaja', '$id')";
        $this->DB_QUERY->save($queryCaja,'creacion de caja.');
        $this->log_usuario(0,$id);
        $this->DB_QUERY->commit();
        return array('control' =>$user["text_img_perfil_usu"] ,'error' => 0,'resp'=>$id);
    }

    /*////////////////////////////////consulta//////////////////////////////////////////////////*/
    public function obtener_usuarios($params){

        $query="
        SELECT usu.id_usu as id, 
        usu.estado_usu as Estado, 
        usu.ciudad_localidad_usu as Ciudad, 
        CONCAT_WS (' ',usu.primer_nombre_usu,usu.segundo_nombre_usu,usu.primer_apellido_usu,usu.segundo_apellido_usu) as Cobrador, 
        if(caja.saldo_caja IS NULL,0,caja.saldo_caja) as Saldo,
        if(press.valor_pres IS NULL,0,SUM(press.valor_pres)) as Cartera,
        SUM(IF(DATE_FORMAT(press.fecha_limite_pres, '%Y-%c-%d')<DATE_FORMAT(now(), '%Y-%c-%d'),press.valor_pres,0))  as Cartera_vencidas,
        COUNT(clie.id_clie) as Nro_clientes,
        COUNT(press.id_pres) as Nro_ventas,
        SUM(IF(press.valor_cuotas_pres IS NULL,0,press.valor_cuotas_pres)) as Dias
        FROM tbl_usuarios AS usu
        LEFT JOIN tbl_caja AS caja ON (caja.id_usu=usu.id_usu)
        LEFT JOIN tbl_cliente AS clie ON (clie.id_usu=usu.id_usu)
        LEFT JOIN tbl_prestamo AS press ON (press.id_clie=clie.id_clie)
        WHERE usu.rol_usu=2";

     
        if(isset($params['Nombre']) && $params['Nombre']!=0){
          $query.=" AND usu.id_usu = ".$params['Nombre'];
        }
        if(isset($params['Cedula']) && $params['Cedula']!=0){
            $query.=" AND usu.documento_usu = ".$params['Cedula'];
        }

        $query.=" GROUP BY usu.id_usu";
        //$tablaSearch="AND int_documento_usu LIKE '%".$params['search']['value']."%'";

        $data=$this->DB_QUERY->queryDatatable($params,$query);
        return $data;
    }

    public function obtener_filtro_usuario(){
        $query="CALL obtenerUsuario()";
        $data=$this->DB_QUERY->query($query);
        return $data;
    }


    public function query_usuario($params){
        $query="CALL buscarUsuario(".$params['i'].")";
        $data=$this->DB_QUERY->query($query);
        return $data;
    }

    /*////////////////////////////////atualizar//////////////////////////////////////////////////*/
    public function cambiar_estado($params){
        $query="UPDATE `tbl_usuarios` SET `estado_usu` = ".$params['estado']." WHERE `tbl_usuarios`.`id_usu` = '".$params['id']."'";
        $id=$this->DB_QUERY->save($query,'cambiar estado de usuarios.');
        $this->log_usuario(3,$params['id']);
        return array('control' =>0 ,'error' => 0);
    }

    public function atualizar_usuario($primernombre, $segundonombre, $primerapellido, $segundoapellido,$Genero, $Telefono_1, $Telefono_2, $Fecha, $Direcion, $Correo, $img_name,$id,$estados,$ciudad){

        $user = array();

        $text_img_perfil_usu="";
        if($img_name==1){
            $query="SELECT foto_usu FROM tbl_usuarios WHERE id_usu=".$id;
            $data=$this->DB_QUERY->query($query);
            if($data[0]['foto_usu']=='usuario.jpg'){
               $user["text_img_perfil_usu"]=date("YmdHis")."_".$id.".png";
               $text_img_perfil_usu=",foto_usu='".$user["text_img_perfil_usu"]."'";
            }else{
                $user["text_img_perfil_usu"]=$data[0]['foto_usu'];
            }
            
        }else{
            $img_name='usuario.jpg';
            $user["text_img_perfil_usu"]=1;
        }

        $query = "UPDATE `tbl_usuarios` 
                  SET 
                    primer_nombre_usu='$primernombre',
                    segundo_nombre_usu='$segundonombre',
                    primer_apellido_usu='$primerapellido',
                    segundo_apellido_usu='$segundoapellido',
                    telefono_1_usu=$Telefono_1,
                    telefono_2_usu=$Telefono_2,
                    direcion_usu='$Direcion',
                    sexo_usu='$Genero',
                    correo_usu='$Correo',
                    fecha_nacimineto_usu='$Fecha',
                    estado_localidad_usu='$estados',
                    ciudad_localidad_usu='$ciudad'
                    $text_img_perfil_usu
                  WHERE `tbl_usuarios`.`id_usu` =".$id;

        $this->DB_QUERY->save($query,'atualizar usuarios.');
        $this->log_usuario(1,$id);
        return $user;
    }
}