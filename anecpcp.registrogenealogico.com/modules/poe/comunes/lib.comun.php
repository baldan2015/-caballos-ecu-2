<?

function listarFilasCriaProp($entidad,$origen){
 $html='';
 if(is_array($entidad)){
            foreach ($entidad as $key => $value) {
                if(!($entidad[$key]['codigo']=="" && $entidad[$key]['idEntidad']=="" && $entidad[$key]['idPropietario']=="") ){
                     $fila=$entidad[$key]['codigo'];
            		$html.="<tr >";  
            		$html.="<td align='left'><span  id='txtNombreProp".$fila."' >".$entidad[$key]['nombres']."</span>
                 							 <input type='hidden' class='cssItem'  id='hidCodigoEnt".$fila."' value='".$entidad[$key]['codigo']."'>
                			</td>";
            		$html.= "<td align='center'>";
            		 if($origen==1){
                   		$idEnte= $entidad[$key]['idEntidad'];//$entidad[$key]['idPropietario'];
                	}else{
                   		$idEnte= $entidad[$key]['idEntidad'];
                	}
            $html.="<span  ><span class='btnQuit_$origen' title='eliminar de registro' data-index='".$key."'  data-key='".$idEnte."' data-source='".$entidad[$key]['origen']."''>quitar</span></span>&nbsp;";
            $html.= "</td>";                 
            $html.= "</tr>";
        }
    }
 }   

return $html;
}

function validarSesion($retorno){
   if(!(isset($_SESSION[Constantes::K_SESSION_CODIGO_USUARIO]))){
    $retorno->result=-1;
    $retorno->message=Constantes::K_SESSION_LOGOUT;   
    $retorno->isRedirect=1;
    $retorno->redirectUrl=Constantes::K_URL_REDIRECT;
   }else{
    $retorno->result=1;
    $retorno->message=Constantes::K_SESSION_LOGIN;    
    }
    return $retorno;
}
function validarSesion2(){
    
   return isset($_SESSION[Constantes::K_SESSION_CODIGO_USUARIO]);
}
?>