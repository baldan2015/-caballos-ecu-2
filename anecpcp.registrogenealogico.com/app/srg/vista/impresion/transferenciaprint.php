<?php  session_start();
    include_once("../../logica/ImagenLogica.php");
    include_once ("../../logica/TransferenciaLogica.php");
    include_once ("../../entidad/Transferencia.inc.php");
    include_once ("../../entidad/TransferenciaDTO.inc.php");
    include_once ("../../entidad/Resultado.inc.php");   
    include_once("../../constante.php");
     include_once("../../comunes/lib.comun.php");
 	

    if(!validarSesion2()){
        echo "<center><br><br><br>".Constantes::K_SESSION_LOGOUT." <a href='#' onclick='return window.close();'>Cerrar esta ventana</a></center> ";
    }else{	 
    $get = new TransferenciaLogica();        
    $img = new ImagenLogica();
        
    $thumb_prefix           = "thumb_"; 

   
    $idEjemplar="";
   if(isset($_GET['idHorse'])){
        $idEjemplar=$_GET['idHorse'];
        $imagen = $img->buscarSearch($_GET['idHorse']);
   }else{
        $result = $get->obtenerID1($_GET['id']);
        $idEjemplar = $result->idEjemplar;
        $imagen = $img->buscarSearch($idEjemplar);

   }

    $resultTrans = $get->getTransferenciaByEjemplar($idEjemplar);
 

$imagenes="";
$i=0;
            $imagenes.="<table style='width:100%;' >";
            $imagenes.="<tr>";
              if(is_array($imagen)){
                foreach ($imagen as $key => $value) {
                    if($value->esPrincipal==1){
                        
                        $imagenes.="<td style='width:48%;'><center>";
                        $imagenes=$imagenes."<img src='".K_PATHWEB."$value->ruta' width='400px;'/>";
                        $imagenes.="</center></td>";
                        
                        if($i<sizeof($imagenes)){
                            $imagenes.="<td style='width:4%'></td>";    
                        }else{
                             
                        }
                        $i++;
                    }
                }
            
            }
            $imagenes.="</tr>";
            $imagenes.="</table>";

  //  print_r($resultTrans);
    echo nl2br("\n");
     $i = 1;  
     ?> 
<style type="text/css">
    
    body{
        font-size: 10px;
        text-transform: uppercase;
    }
    table tr td{
font-weight: bold;
        font-size: 12px;
    }
</style>
    <table style="  width: 100%; " border=0 >
    <tr>
    <td style=" height: 270px;" valign="top"><br><br><br><br><br><br>
    <?
    if (count($resultTrans)>0){
        echo ' <table style=" width: 100%;" border=0>';
        foreach ($resultTrans as $key => $value) {
            # code...

            ?> <tr>
            <td style="width: 10px"></td> 
            <td style="width: 410px"> <?=$value->nuevoProp?> </td>
            <td style="width: 150px"> <?=$value->fechaTransferencia=='00/00/0000'?null:$value->fechaTransferencia?> </td> 
            <td> <?=$value->id?> </td> </tr>  <?
            $i++;
        }
        
        echo ' </table >';
    }
  ?>

    </td>
    </tr>
 
<tr>
    <td  style=" height: 200px;">
    <?= $imagenes?>
    </td>
    </tr>
 
        </table><?
       

?>
<script type="text/javascript">
    
    window.print();
</script>

<?
}
?>