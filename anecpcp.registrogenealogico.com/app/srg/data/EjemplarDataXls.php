<?php  include_once ("modelo.php");
    class EjemplarDataXls extends dal{
               function __construct(){            parent::dal();                    }

           

        /*REPORTE XLS EJEMPLARES - ADDON DBS 20200305*/
         public function buscarSearchXls($id,$pref,$nom,$prop,$cria,$genero,$emin,$emax,$estado,$ente, $start , $limit,$sidx,$sord){

           if($emin=="")$emin=0;
           if($emax=="")$emax=0;
            $sql = "CALL SGESS_EJEMPLAR_JQGRID_XLS('$id','$pref','$nom','$prop','$cria','$genero','$emin','$emax','$estado','$ente','$start','$limit','$sidx','$sord')";
        //  echo $sql;
            $result = parent::ejecutar2($sql);
            $ejemplares=[];
            while($fila = mysqli_fetch_object($result)){
               $obj = new stdClass();
                  $obj->codigo = $fila->id;
                  $obj->prefijo = $fila->prefijo;
                  $obj->nombre = $fila->nombre;
                  $obj->fecNace=$fila->fecNace;
                  //$obj->fecFallece=$fila->fecFallece;
                  /*$obj->motivoFallece=$fila->motivoFallece;
                  $obj->idPadre=$fila->idPadre;
                  $obj->idMadre=$fila->idMadre;*/
                  $obj->nombrePelaje=$fila->pelaje;
                  $obj->LugarNace=$fila->LugarNace;
                 // $obj->microchip=$fila->microchip;
                  $obj->adn=$fila->adn;
                 // $obj->descripcion=$fila->descripcion;
                  $obj->estado=$fila->estado;
                  //$obj->capado=$fila->capado;
                  $obj->propietarios=$fila->propiedad;
                  $obj->criadores=$fila->criador;
                  $obj->fecReg=$fila->fecReg;

                  $obj->idMadre = $fila->idMadre;
                  $obj->prefijoMad = $fila->prefijoMad;
                  $obj->nombreMad = $fila->nombreMad;                  

                  $obj->idPadre = $fila->idPadre;
                  $obj->prefijoPad = $fila->prefijoPad;
                  $obj->nombrePad = $fila->nombrePad;                  
                  $obj->fechaIncripcion = $fila->fechaIncripcion;
                  $obj->idMetodo=$fila->idMetodo;
                  $obj->sexo = $fila->sexo;
                  $obj->codigoInscripcion = $fila->codigoInscripcion;
                  $obj->sang = $fila->sang;
                  $obj->fechaTransferencia = $fila->fechaTransferencia;
                  $obj->origen = $fila->origen;
                  if($obj->idMetodo==5 && date("Ymd")){
                    if(!(strpos($obj->nombre,"- TE")>0 || strpos($obj->nombre,"-TE")>0)){
                            $obj->nombre=$obj->nombre." - TE";
                    } 
                  }
                   //$obj->esSuperCamp=$fila->esSuperCamp;

                $ejemplares[] = $obj;
            }
            return $ejemplares;
        }
       
    }
?>
