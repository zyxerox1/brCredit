<?php
class usuario_modelo
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

    public function crear_usuario($primernombre, $segundonombre, $primerapellido, $segundoapellido, $Documento, $Genero, $Telefono_1, $Telefono_2, $Fecha, $Direcion, $Correo, $pas1, $img_name_name, $img_name,$perfil,$estados,$ciudades){

        $user = array();

        if($img_name==1){
            $img_name=date("YmdHis")."_".$_SESSION["id_usu_credit"].".png";
            $user["text_img_perfil_usu"]=$img_name;
        }else{
            $img_name='usuario.jpg';
            $user["text_img_perfil_usu"]=1;
        }

    	$query = "INSERT INTO tbl_usuarios (id_usu, documento_usu, primer_nombre_usu,segundo_nombre_usu, primer_apellido_usu, segundo_apellido_usu, telefono_1_usu, telefono_2_usu, direcion_usu, sexo_usu, correo_usu, contrasena_usu, fecha_nacimineto_usu, foto_usu,rol_usu,estado_localidad_usu,ciudad_localidad_usu) VALUES (NULL, $Documento,'$primernombre','$segundonombre','$primerapellido','$segundoapellido', $Telefono_1, $Telefono_2, '$Direcion', '$Genero', '$Correo', '$pas1', '$Fecha', '$img_name',$perfil,$estados,$ciudades)";
        $id=$this->DB_QUERY->save($query,'creacion de usuarios.');
        $this->log_usuario(0,$id);
        return array('control' =>$user["text_img_perfil_usu"] ,'error' => 0,'resp'=>$id);
    }

    /*////////////////////////////////consulta//////////////////////////////////////////////////*/
    public function obtener_usuarios($params){

        $query="SELECT id_usu as id, documento_usu as CC, concat(primer_nombre_usu,' ',segundo_nombre_usu) as Nombre, concat(primer_apellido_usu,' ',segundo_apellido_usu) as Apellido, telefono_1_usu as t1, telefono_2_usu as t2,correo_usu as Correo, fecha_nacimineto_usu as fecha, estado_usu as Estado FROM tbl_usuarios WHERE 1 ";

     
        if(isset($params['Nombre']) && $params['Nombre']!=0){
          $query.=" AND id_usu = ".$params['Nombre'];
        }
        if(isset($params['Cedula']) && $params['Cedula']!=0){
            $query.=" AND documento_usu = ".$params['Cedula'];
        }

        //$tablaSearch="AND int_documento_usu LIKE '%".$params['search']['value']."%'";

        $data=$this->DB_QUERY->queryDatatable($params,$query);
        return $data;
    }

    public function obtener_filtro_usuario(){
        $query="CALL obtenerFiltroUsuario()";
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