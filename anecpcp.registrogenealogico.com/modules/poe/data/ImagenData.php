<?php
    include_once ("modelo.php");
    if (file_exists("../../entidad/Ejemplar.inc.php")) include_once("../../entidad/Ejemplar.inc.php");
    if (file_exists("../../entidad/Resultado.inc.php")) include_once("../../entidad/Resultado.inc.php");

    if (file_exists("../entidad/Ejemplar.inc.php")) include_once("../entidad/Ejemplar.inc.php");
    if (file_exists("../entidad/Resultado.inc.php")) include_once("../entidad/Resultado.inc.php");

  
    
    class ImagenData extends dal{

        public $retorno;
          function __construct(){
            parent::dal();
            $retorno=new Resultado();
        }

        /*
        autor: dbs - 20160725
        nombre function
            insertar
        parametro entrada
            $nombre: nombre del pelaje obligatorio y no debe repetirse
        parametro de retorno
            $retorno->result: [0 1 2]
            0=error en el ejecucion del store
            1=inserto ok
            2=no inserto. Ya existe el parametro nombre como data/
        */
        
        
        //funcion para eliminar un registro
        public function eliminar($codigo){
             $retorno=new Resultado();
            $sql = "CALL SGESD_IMAGEN('$codigo')";
            //echo $sql;
            $result = parent::ejecutar2($sql);
            if($result){
                return true;
            }else{
                return false;
            }
        }
        public function eliminarDocumentosINS($codigo,$esPdf){
            $retorno=new Resultado();
           $sql = "CALL SGESD_DOCUMENTOS_INS_X_PROP('$codigo',$esPdf)";
           //echo $sql;
           $result = parent::ejecutar2($sql);
           if($result){
               return true;
           }else{
               return false;
           }
       }
       public function eliminarDocumentosNAC($codigo,$esPdf){
        $retorno=new Resultado();
       $sql = "CALL SGESD_DOCUMENTOS_NAC_X_PROP('$codigo',$esPdf)";
       //echo $sql;
       $result = parent::ejecutar2($sql);
       if($result){
           return true;
       }else{
           return false;
       }}
        //function para obtener turno
        public function obtenerID($codigo){
             $retorno=new Resultado();
            $sql = "CALL SGESS_EJEMPLAR_X_ID('$codigo')";
            //echo $sql;
            $result = parent::ejecutar2($sql);
            if($fila = mysqli_fetch_object($result)){
                  $obj = new Ejemplar();
		          $obj->codigo = $fila->id;
		          $obj->prefijo = $fila->prefijo;
                  $obj->nombre = $fila->nombre;
                  $obj->fecNace=$fila->fecNace;
                  $obj->fecFallece=$fila->fecFallece;
                  $obj->motivoFallece=$fila->motivoFallece;
                  $obj->idPadre=$fila->idPadre;
                  $obj->idMadre=$fila->idMadre;
                  $obj->idPelaje=$fila->idPelaje;
                  $obj->LugarNace=$fila->LugarNace;
                  $obj->microchip=$fila->microchip;
                  $obj->adn=$fila->adn;
                  $obj->descripcion=$fila->descripcion;
                  $obj->genero=$fila->genero;
                  $obj->fecCapado=$fila->fecCapado;
                  $obj->idProvincia=$fila->idProvincia;
                  $obj->idResenias=$fila->idResenias;
                  $obj->fecNaceString=$fila->fecNaceString;
                  $obj->fecReg=$fila->fecReg;
                  $obj->nroLibro=$fila->nroLibro;
                  $obj->nroFolio=$fila->nroFolio;
            }
            return $obj;
	}
        //function para buscar
        public function buscar(){
             $retorno=new Resultado();
            $sql = "CALL SGESS_EJEMPLAR('')";
            $result = parent::ejecutar2($sql);
            while($fila = mysqli_fetch_object($result)){
                $obj = new Entidad();
                $obj->codigo = $fila->id;
                //$obj->nombreCorto = $fila->nombreCorto;
                //$obj->nombreLargo = $fila->nombreLargo;
                $turno[] = $obj;
            }
            return $turno;
        }
         public function editar($codigo,$main,$idHorse){

             $retorno=new Resultado();
        $sql = "CALL SGESU_IMAGEN('$codigo','$main','$idHorse',@vresultado)";
        //echo $sql ; 
            $result = parent::ejecutar2($sql,'@vresultado');
            //echo "1";
            if($result){
               // echo "2";
                if($fila = mysqli_fetch_array($result)){
                   // echo "3";
                   //print_r($fila);
                   if($fila[0]==1){
                    //echo "4";
                     $retorno->result=1;
                    }
                    if($fila[0]==2) {
                      $retorno->result=2;
                    }
               }
            }else{
                     $retorno->result=0; 
            }
            return  $retorno;
        }

       public function insertar($idHorse,$new_file_name,$esPrincipal,$activo){
             $retorno=new Resultado();

            $sql = "CALL SGESI_IMAGEN('$idHorse','$new_file_name','$esPrincipal','$activo',@vresultado)";
            //echo $sql;
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){
                   if($fila[0]==1){
                     $retorno->result=1;
                    }else{
                     $retorno->result=2;
                    }
               }
            }else{
                     $retorno->result=0; 
            }

            return  $retorno;
        }

          public function buscarSearch($id){
            $sql = "CALL SGESS_LIST_IMAGEN('$id')";
            // echo $sql;
            $result = parent::ejecutar2($sql);
            $imagenes=[];
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();
                  $obj->id = $fila->idImagen;
                  $obj->idNacimiento = $fila->idNacimiento;
                  $obj->ruta = $fila->ruta;
                  $obj->fecha = $fila->fecha;
                  $obj->activo = $fila->activo;
                  $obj->esPrincipal = $fila->esPrincipal;
                  $imagenes[] = $obj;
            }
            return $imagenes;
        }



          public function eliminarNacTMP($codigo){
             $retorno=new Resultado();
            $sql = "CALL SGESD_DOCUMENTO_NAC('$codigo',@vresultado)";
            //echo $sql;
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                 if($fila = mysqli_fetch_array($result)){
                  //print_r($fila[0]);
                   if($fila[0]==1){
                     $retorno->result=1;
                    }else if($fila[0]==999){
                     $retorno->result=999;
                    }else if($fila[0]==998){
                     $retorno->result=998;
                    }else if($fila[0]==997){
                     $retorno->result=997;
                    }
               }
            }else{
                $retorno->result=0; 
            }
            return  $retorno;
        }
         public function buscarSearchNacTMP($id,$esPdf,$codigoGenerado){
            $sql = "CALL SGESS_LIST_DOCUMENTO_NAC('$id','$esPdf','$codigoGenerado')";
             //echo $sql;
            $result = parent::ejecutar2($sql);
            $imagenes=[];
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();
                  $obj->id = $fila->idImagen;
                  $obj->idNacimiento = $fila->idNacimiento;
                  $obj->ruta = $fila->ruta;
                  $obj->fecha = $fila->fecha;
                  $obj->activo = $fila->activo;
                  $obj->esPrincipal = $fila->esPrincipal;
                  $obj->idTipoDocumento = $fila->descripcion;
                  $imagenes[] = $obj;
            }
            return $imagenes;
        }
         public function insertarNacTMP($idHorse,$new_file_name,$esPrincipal,$activo,$esPdf,$idTipoDocumento,$codigoGenerado){
             $retorno=new Resultado();

            $sql = "CALL SGESI_DOCUMENTO_NAC('$idHorse','$new_file_name','$esPrincipal','$activo','$esPdf','$idTipoDocumento','$codigoGenerado',@vresultado)";
           //echo $sql;
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){
                   if($fila[0]==1){
                     $retorno->result=1;
                    }else if($fila[0]==999){
                     $retorno->result=999;
                    }else{
                     $retorno->result=2;
                    }
               }
            }else{
                     $retorno->result=0; 
            }

            return  $retorno;
        }

           public function eliminarInsTMP($codigo){
             $retorno=new Resultado();
            $sql = "CALL SGESD_DOCUMENTO_INS('$codigo',@vresultado)";
           // echo $sql;
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                 if($fila = mysqli_fetch_array($result)){
                  //print_r($fila[0]);
                   if($fila[0]==1){
                     $retorno->result=1;
                    }else if($fila[0]==998){
                     $retorno->result=998;
                    }else if($fila[0]==997){
                     $retorno->result=997;
                    }
               }
            }else{
                $retorno->result=0; 
            }

            return $retorno;
        }
         public function buscarSearchInsTMP($id,$esPdf,$codigoGenerado){
            $sql = "CALL SGESS_LIST_DOCUMENTO_INS('$id','$esPdf','$codigoGenerado')";
           // echo $sql;
            $result = parent::ejecutar2($sql);
            $imagenes=[];
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();
                  $obj->id = $fila->idImagen;
                  $obj->idInscripcion = $fila->idInscripcion;
                  $obj->ruta = $fila->ruta;
                  $obj->fecha = $fila->fecha;
                  $obj->activo = $fila->activo;
                  $obj->esPrincipal = $fila->esPrincipal;
                  $obj->idTipoDocumento = $fila->descripcion;
                  $obj->codigoGenerado = $fila->codigoGenerado;
                  $imagenes[] = $obj;
            }
            return $imagenes;
        }
         public function insertarInsTMP($idHorse,$new_file_name,$esPrincipal,$activo,$esPdf,$idTipoDocumento,$codigoGenerado,$flag){
             $retorno=new Resultado();

            $sql = "CALL SGESI_DOCUMENTO_INS('$idHorse','$new_file_name','$esPrincipal','$activo','$esPdf','$idTipoDocumento','$codigoGenerado','$flag',@vresultado)";
         //  echo $sql;
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){
                   if($fila[0]==1){
                     $retorno->result=1;
                    }else if($fila[0]==999){
                     $retorno->result=999;
                    }else{
                     $retorno->result=2;
                    }
               }
            }else{
                     $retorno->result=0; 
            }

            return  $retorno;
        }

        public function insertarTraTMP($idHorse,$new_file_name,$esPrincipal,$activo,$esPdf,$idTipoDocumento){
             $retorno=new Resultado();

            $sql = "CALL SGESI_DOCUMENTO_TRANS('$idHorse','$new_file_name','$esPrincipal','$activo','$esPdf','$idTipoDocumento',@vresultado)";
           //echo $sql;
            $result = parent::ejecutar2($sql,'@vresultado');
            if($result){
                if($fila = mysqli_fetch_array($result)){

                    $retorno->result=$fila[0];
                   /*if($fila[0]==1){
                     $retorno->result=1;
                    }else if($fila[0]==999){
                     $retorno->result=999;
                    }else{
                     $retorno->result=2;
                    }*/
               }
            }else{
                     $retorno->result=0; 
            }

            return  $retorno;
        }
        public function insertarMontaDocumento($idMonta,$new_file_name,$activo,$esPadre){
            $retorno=new Resultado();

           $sql = "CALL SGESI_DOCUMENTO_MONTA('$idMonta','$new_file_name','$activo','$esPadre',@vresultado)";
        //  echo $sql;
           $result = parent::ejecutar2($sql,'@vresultado');
           if($result){
               if($fila = mysqli_fetch_array($result)){
                  if($fila[0]==1){
                    $retorno->result=1;
                   }else{
                    $retorno->result=2;
                   }
              }
           }else{
                    $retorno->result=0; 
           }

           return  $retorno;
       }
       public function listarDocumentosMonta($idMonta,$esPadre){
        $sql = "CALL SGESS_DOCUMENTOS_MONTA('$idMonta','$esPadre')";
        // echo $sql;
         $result = parent::ejecutar2($sql);
         $documentos=[];
         while($fila = mysqli_fetch_object($result)){
            $obj = new stdClass();
               $obj->id = $fila->idDocumento;
               $obj->idMonta = $fila->idServicioY;
               $obj->ruta = $fila->ruta;
               $obj->fecha = $fila->fecha;
               $obj->esPadre = $fila->esPadre;
               $documentos[] = $obj;
         }
         return $documentos;
       }
       public function eliminarDocumentoMonta($id,$esPadre){
           $retorno=new Resultado();
           $sql = "CALL SGESU_ELIMINAR_DOCUMENTO_MONTA($id,$esPadre,@vresultado)";
           $result = parent::ejecutar2($sql,'@vresultado');
           if($result){
               if($fila = mysqli_fetch_array($result)){
                  if($fila[0]==1){
                    $retorno->result=1;
                   }else{
                    $retorno->result=2;
                   }
              }
           }else{
                    $retorno->result=0; 
           }

           return  $retorno;
       }
    }
?>
