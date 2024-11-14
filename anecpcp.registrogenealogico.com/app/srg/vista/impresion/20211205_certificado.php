<?php  session_start();?>
<head>  
  <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>ANECPCP - REGISTRO GENEALOGICO - IMPRESION DE CERTIFICADO</title>
</head>  
<?
date_default_timezone_set('UTC');
    include_once("../../logica/EjemplarLogica.php");
    include_once("../../logica/ResenaLogica.php");
    include_once("../../logica/PelajeLogica.php");
    include_once("../../logica/DepartamentoLogica.php");
    include_once("../../entidad/Ejemplar.inc.php");
    include_once("../../entidad/Constantes.php");
    include_once("../../logica/ImagenLogica.php");
    include_once("../../logica/ImpresionLogica.php");
    include_once("../../logica/PropietarioLogLogica.php");
    include_once("../../constante.php");
    include_once("../../comunes/lib.comun.php");


 if(!validarSesion2()){
        echo "<center><br><br><br>".Constantes::K_SESSION_LOGOUT." <a href='#' onclick='return window.close();'>Cerrar esta ventana</a></center> ";
    }else{
 		  
        $printLog = new ImpresionLogica();
       
        $tipo=$_GET['type'];
        if($tipo==0)$tipo='OR';//original primera vez
        if($tipo==1)$tipo='CO'; // copia como original
        if($tipo==2)$tipo='CC'; //v copia
        $usuario_crea = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];

        $printLog->insertarLog($_GET['idHorse'],$usuario_crea,$tipo);




        /* addon dbs 20200121*/
        $servProp = new PropietarioLogLogica();
        if($tipo!='CC') {
            $propietarioOriginal=$servProp->buscarPropOriginalXEjemplar($_GET['idHorse']);
            //echo "<pre>";print_r($propietarioOriginal);echo "</pre>";
        }

        $get = new EjemplarLogica();
        $img = new ImagenLogica();
        
		$thumb_prefix           = "thumb_"; 

        $ejemplar = $get->obtenerID($_GET['idHorse']);
        $imagen = $img->buscarSearch($_GET['idHorse']);
        $padres=$get->buscarPadres($ejemplar->idPadre);
        $madres=$get->buscarPadres($ejemplar->idMadre);
        $hijo=$get->buscarPadres($_GET['idHorse']);
        //echo "<pre>";         print_r( $ejemplar);          echo "</pre>";
        $textCapado="";
       //echo $ejemplar->genero."<br>";
      // echo $ejemplar->fecCapado;
        if($ejemplar->genero=="C" ){
                $textCapado=" (c) ";
        }if($ejemplar->genero=="M" || $ejemplar->genero=="P"){
                    if($ejemplar->fecCapado!='0000-00-00'){
                            $textCapado=" (c) ";
                    }else if ($ejemplar->fecCapado==null){
                            $textCapado="  ";
             }
        }

        
        $idPadreEjemplar=""; 
        $prefijoPadreEjemplar="";
        $nombPadreEjemplar="";
        $idMadreEjemplar="";
        $prefijoMadreEjemplar="";
        $nombMadreEjemplar="";
        if(is_array($padres)){
        		foreach ($padres as $key => $value) {
        			$idPadreEjemplar=$idPadreEjemplar." - ".$value->idPadre;
        			$prefijoPadreEjemplar=$prefijoPadreEjemplar." ".$value->prefijoPadre;
        			$nombPadreEjemplar=$nombPadreEjemplar." ".htmlentities($value->nombrePadre);
        			$idMadreEjemplar=$idMadreEjemplar." - ".$value->idMadre;
        			$prefijoMadreEjemplar=$prefijoMadreEjemplar." ".$value->prefijoMadre;
        			$nombMadreEjemplar=$nombMadreEjemplar." ".htmlentities($value->nombreMadre);
        		}
        }
        $nombPadreEjemplar2="";
        $idPadreEjemplar2=""; 
        $prefijoPadreEjemplar2="";
        $nombadreEjemplar2="";
        $idMadreEjemplar2="";
        $prefijoMadreEjemplar2="";
        $nombMadreEjemplar2="";
        if(is_array($madres)){
        		foreach ($madres as $key => $value) {
        			$idPadreEjemplar2=$idPadreEjemplar2." - ".$value->idPadre;
        			$prefijoPadreEjemplar2=$prefijoPadreEjemplar2." ".$value->prefijoPadre;
        			$nombPadreEjemplar2=$nombPadreEjemplar2." ".htmlentities($value->nombrePadre);
        			$idMadreEjemplar2=$idMadreEjemplar2." - ".$value->idMadre;
        			$prefijoMadreEjemplar2=$prefijoMadreEjemplar2." ".$value->prefijoMadre;
        			$nombMadreEjemplar2=$nombMadreEjemplar2." ".htmlentities($value->nombreMadre);
        		}
        }

        $nombreMadre="";
        $nombrePadre="";
        $madre="";
        $prefmadre="";
        $prefpadre="";
        $padre="";
       if(is_array($hijo) && count($hijo)>0){
            foreach ($hijo as $key => $value) {
                $prefmadre=$prefmadre." ".$value->prefijoMadre;
                $madre=$madre." ".$value->nombreMadre;
                $prefpadre=$prefpadre." ".$value->prefijoPadre; 
                $padre=$padre." ".$value->nombrePadre; 

                $nombreMadre=$prefmadre." ".htmlentities($madre);
                $nombrePadre=$prefpadre." ".htmlentities($padre);
            }
       } 
    
    
        //echo "<pre>";         print_r( $padre);          echo "</pre>";
        
        $propietarios="";
        if($tipo!='CC') {
            if(is_array($propietarioOriginal)){
                foreach ($propietarioOriginal as $key => $value) {
                    $propietarios=$propietarios." ".htmlentities($value->nombres);
        	    }
            }
        }else{
            if(is_array($ejemplar->propietarios)){
                foreach ($ejemplar->propietarios as $key => $value) {
                    $propietarios=$propietarios." ".htmlentities($value->nombres);
                }
            }
        }
        
        $criadores="";
        if(is_array($ejemplar->criadores)){
        	foreach ($ejemplar->criadores as $key => $value) {
        		$criadores=$criadores." ".htmlentities($value->nombres);
        	}
        }

        if((int)$ejemplar->fecCrea>20170603){
                $resenas=unserialize($ejemplar->idResenias);
                $resenasNombres="";
                if(is_array($resenas)){
                	$objResena=new ResenaLogica();
        			foreach ($resenas as $key => $value) {
                		 
                		 $item= $objResena->obtenerID($value);
                		 $resenasNombres=$resenasNombres." ".htmlentities($item->descripcion);
                	}
                }
        }else{
            $contador=0;
             $resenas=unserialize($ejemplar->idResenias);
                $resenasNombres="";
                if(is_array($resenas)){
                    $objResena=new ResenaLogica();
                    foreach ($resenas as $key => $value) {
                         $contador++;
                         $item= $objResena->obtenerID($value);
                         $resenasNombres=$resenasNombres." ".htmlentities($item->descripcion);
                    }
                }
             if($contador==0)  $resenasNombres=htmlentities($ejemplar->descripcion);
        }
       

	        $objPelaje=new PelajeLogica();
    		 $itemPelaje= $objPelaje->obtenerID($ejemplar->idPelaje);

    		 $pelajeNombre= htmlentities($itemPelaje->nombre);
     
             $objDepart=new DepartamentoLogica();
             $itemDepart=$objDepart->obtenerID($ejemplar->idProvincia);
             $departNombre=htmlentities($itemDepart->descripcion);

/*addon dbs 20180227*/
if($ejemplar->idMetodo==Constantes::K_TRANSFER_EMBRION && date("Ymd") >=Constantes::K_FECHA_VALIDATE_TE){
    $ejemplar->nombre=$ejemplar->nombre." - TE";
}
$ejemplar->LugarNace=htmlentities($ejemplar->LugarNace);

?>
<style type="text/css">
	
	body{
		font-size: 10px;
        font-family: Arial;         
		
	}
	table tr td{
 
		font-size: 14px;
	}
    .capitaliza:first-letter{
        text-transform: capitalize;
    }
    .uppercase{
        text-transform: uppercase;
    }

</style>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> 
<table border=0 cellspacing="2" cellpadding="3" style=" padding-left: 30px; width: 100%;">
<tr>
    <td style=" width: 45%;">
            <table>
                <tr><td  style="font-weight: bold;">Registro</td><td>:</td><td style="font-size: 18px; font-weight: bold;"><?=$ejemplar->codigo?>&nbsp;&nbsp;<?=$ejemplar->prefijo?></td></tr>
                <tr><td style="font-weight: bold;">Sexo</td><td>:</td><td><?=$ejemplar->genero=='Y'?'Hembra':'Macho'.' '.$textCapado?></td></tr>
                <tr><td style="font-weight: bold;">Fecha Nacimiento</td><td>:</td><td><?= $ejemplar->fecNaceString=='00/00/0000'?null:$ejemplar->fecNaceString?></td></tr>
                <tr><td style="font-weight: bold;">Pelaje</td><td>:</td><td><?=$pelajeNombre?></td></tr>
                <tr><td style="font-weight: bold;">Criador</td><td>:</td><td><?=$criadores?></td></tr>
                <tr><td style="font-weight: bold;">Propietario</td><td>:</td><td><?=$propietarios?></td></tr>
                <tr><td style="font-weight: bold;">Lugar de Nacimiento</td><td>:</td><td><? if($departNombre=="" && $ejemplar->LugarNace=="" || $departNombre!="" && $ejemplar->LugarNace=="" || $departNombre=="" && $ejemplar->LugarNace!=""){
            $guion=" ";
        ?>
  <span class="uppercase"><?=$departNombre?><?=$guion?><?= $ejemplar->LugarNace?></span> 
        <?} else {
            $guion=" - ";
          ?>
    <span class="uppercase"><?=$departNombre?><?=$guion?><?= $ejemplar->LugarNace?></span> 
        <?}?></td></tr>
                <tr><td style="font-weight: bold;">Fecha de registro</td><td>:</td><td><?=$ejemplar->fecRegString=='00/00/0000'?null:$ejemplar->fecRegString?></td></tr>
                <tr><td style="font-weight: bold;">A&ntilde;o</td><td>:</td><td><?=substr($ejemplar->fecNaceString,6,4)?></td></tr>
              
            </table>

    </td>

    <td>
        
      <table border="0" style=" width: 100%; " cellpadding="4" cellspacing="6">
        <tr><td style=" text-align:right; "> <?=$prefijoPadreEjemplar?>&nbsp;&nbsp;<?=$nombPadreEjemplar?>&nbsp;&nbsp;<?=$idPadreEjemplar?>  </td></tr>
        <tr><td> <center><?=$nombrePadre?> &nbsp;&nbsp;<?= $ejemplar->idPadre?>  </center><td></tr>
        <tr><td style=" text-align:right; "> <?=$prefijoMadreEjemplar?>&nbsp;&nbsp;<?=$nombMadreEjemplar?>&nbsp;&nbsp;<?=$idMadreEjemplar?></td></tr>
        <tr><td style="font-size: 18px;  text-align:left; font-weight: bold;"><?=$ejemplar->prefijo?>&nbsp;&nbsp;<?=$ejemplar->nombre?>&nbsp;&nbsp;<?=$ejemplar->codigo?></td></tr>
        <tr><td style=" text-align:right; "> <?=$prefijoPadreEjemplar2?>&nbsp;&nbsp;<?=$nombPadreEjemplar2?>&nbsp;&nbsp;<?=$idPadreEjemplar2?>  </td></tr>
        <tr><td> <center> <?=$nombreMadre?> &nbsp;&nbsp;<?= $ejemplar->idMadre?></center></td></tr>
        <tr><td style=" text-align:right; "> <?=$prefijoMadreEjemplar2?>&nbsp;&nbsp;<?=$nombMadreEjemplar2?>&nbsp;&nbsp;<?=$idMadreEjemplar2?> </td></tr>

    </table>
   
  

    </td>

</tr>
<tr>
    <td  style=" height: 250px;" colspan="2">


    </td>
    </tr>
<tr>
    <td    colspan="2"  >
<table  width="100%"><tr>
    <td width="73%"><b>Rese&ntilde;a</b>: <?= $resenasNombres?>.</td>
    <td></td>
</tr></table>

    </td>
   
    </tr>
</table>    

<? if($_GET['type']==2){?>
<style>
body:after {
  content: "COPIA"; 
  font-size: 15em;  
  color: rgba(52, 166, 214, 0.3);
  z-index: 9999;
 
  display: flex;
  align-items: center;
  justify-content: center;
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
    
  -webkit-pointer-events: none;
  -moz-pointer-events: none;
  -ms-pointer-events: none;
  -o-pointer-events: none;
  pointer-events: none;

  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  -o-user-select: none;
  user-select: none;
}
 </style>
<?}?>
<script type="text/javascript">
 window.print();
</script>
<?
}
?>