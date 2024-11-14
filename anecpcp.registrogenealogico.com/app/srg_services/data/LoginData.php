<?php
    include_once ("modelo.php");
    include_once ("../entidad/Login.php");
    include_once ("../entidad/personaUsuario.php");
     
    
    class LoginData extends dal{
        
        public function LoginData(){
            parent::dal();
        }
        
        public function ValidarLogin($entity){
            $sql = "CALL SGESS_LOGIN('$entity->usuario','$entity->contrasenia')";
         //echo $sql;
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new personaUsuario();
                $obj->idUsu = $fila->id;//$fila->idUsu;
                $obj->idEntidad  =$fila->idEntidad;// $fila->idEntidad ;
                $obj->Nombre  = $fila->nombres;//$fila->Nombre ;
                $obj->ApellidoPat  = $fila->apePaterno;//$fila->Apellido ;
                $obj->ApellidoMat  = $fila->apeMaterno;//$fila->Apellido ;
                $obj->razonSocial  = $fila->razonSocial;//$fila->DNI ;
                $obj->DNI  = $fila->numDoc;//$fila->DNI ;
                $obj->Telefono  = $fila->telefono1;//$fila->Telefono ;
                $obj->correo  = $fila->correo;//$fila->correo ;
                $obj->rol  = $fila->descripcion;//$fila->correo ;
                $obj->login  = $fila->Usuario;
                $obj->idRol=$fila->idRol;//$fila->correo ;
                //$obj->estado = "1";//$fila->estado;
                //$obj->desc_estado = "Activo";
                /*if($fila->estado == 1){
                    $obj->desc_estado = Activo;
                }else{
                    $obj->desc_estado = Inactivo;
                }*/
            }
            return $obj;

        }
    }
?>
