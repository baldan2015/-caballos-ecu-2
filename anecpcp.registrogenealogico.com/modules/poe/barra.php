<?
require_once(DIR_LEVEL_MOD_POE.DIR_FUNCTION."conectar.php");
require_once(DIR_LEVEL_MOD_POE.DIR_FUNCTION."queries.php");
require("editarDatos.php");
//$datoPoe=obtenerPoeActivo($link);
$periodoActual="0";
/* foreach ($datoPoe as $key => $value) {
   if( $key==(count($datoPoe)-1)){
      $periodoActual= $value["periodo"];
   }
 }*/
 $_SESSION["periodoActual"]= $periodoActual;

//echo "<pre>";print_r($_SESSION);echo "</pre>";?>

<nav class="navbar navbar-inverse" style="margin-top: -35px;">
  <div class="container-fluid" >
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header" style=' background: #459e00 !important;'>
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand"  style=' background: #459e00 !important;' href="#">
      <img src='<?=DIR_LEVEL_MOD_POE?>img/logo2.jpg' heigth=25 style="margin-top: -15px; margin-left: -17px;" /></a>
    </div>
 
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      <li class='active'><a href='<?=DIR_LEVEL_MOD_POE?>socio.php'><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;&nbsp;&nbsp;MIS TR&Aacute;MITES</a></li>
   <li  class='active'><a href='<?=DIR_LEVEL_MOD_POE?>indice.php'><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;&nbsp;B&Uacute;SQUEDAS</a></li>
   <li  class='active'><a href='<?=DIR_LEVEL_MOD_POE?>reporteGenPer.php'><span class="glyphicon glyphicon-random"></span>&nbsp;&nbsp;&nbsp;ELABORAR GENEALOG&Iacute;A</a></li>
   <!--<li class="dropdown active">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">CONSULTAS
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
        <li><a href='<?=DIR_LEVEL_MOD_POE?>reporte1.php'>Ejemplar Nacido x Criador</a>         </li>
         <li><a href='<?=DIR_LEVEL_MOD_POE?>reporte2.php'>Ejemplar Inscrito x Propietario</a>         </li>
          <li><a href='<?=DIR_LEVEL_MOD_POE?>reportePrefijo.php'>Criador - Prefijo</a>      </li> 
        </ul>
      </li>
        -->
      </ul>
 
      <ul class="nav navbar-nav navbar-right">
        <li  class='active' > 
     <li class="dropdown active">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-bottom"></span>
         
           
       
      
           <?
                    if($_SESSION['usuarios'][$i]->flgTipo=="C"){
                      ?><span  class="glyphicon glyphicon-user"></span>&nbsp;<span class="glyphicon glyphicon-user"></span> &nbsp;<?
                    }else{
                      ?><span class="glyphicon glyphicon-user"></span>&nbsp;<?
                    }
                   



     if(isset($_SESSION['xusu']) && isset($_SESSION['xid']))
          {
          if($_SESSION['xusu']=="Desconocido")
          { echo "".$_SESSION['xusu'];}
          else
          {
             echo " ".$_SESSION['xusu'];
          }
          }
          else
          {
          echo "Usuario no ha iniciado session !";
          } 
          
           ?> <span class=" caret"></span></a><?
          if(isset($_SESSION['usuarios'])){
            if(is_array($_SESSION['usuarios']) && sizeof($_SESSION['usuarios']>1)){?>
              <ul class="dropdown-menu"><?
              $tooltip="";
              for($i=0;$i<sizeof($_SESSION['usuarios']);$i++){ 

                    if($_SESSION['usuarios'][$i]->flgTipo=="C"){
                        $tooltip="cambiar a cuenta coopropiedad";
                    }else{
                        $tooltip="cambiar a cuenta socio";
                    }


               ?>
                  <li> <a title="<?=$tooltip?>" href='<?=DIR_LEVEL_MOD_POE?>socio.php?prfl=<?=base64_encode('0000'.$_SESSION['usuarios'][$i]->idPropietario)?>'>
                   <?
                    if($_SESSION['usuarios'][$i]->flgTipo=="C"){
                      ?><span class="glyphicon glyphicon-user"></span>&nbsp;<span class="glyphicon glyphicon-user"></span> &nbsp;<?
                    }else{
                      ?><span class="glyphicon glyphicon-user"></span>&nbsp;<?
                    }
                    ?>
                    
                    <?=$_SESSION['usuarios'][$i]->razonSocial?></a>         </li>
              <? 
              }
              ?></ul><?
           }
          }
          ?>
      
      
       </a></li>
       
     <!-- <li><a  style='color:#ffc107!important;' title='FINALIZAR SESION DE USUARIO'  href="<?=DIR_LEVEL_MOD_POE?>logoff.php"><span class="      glyphicon glyphicon-log-in"></span> Cerrar sesión</a></li>-->
      

      <li>
    <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#fff">
     
      <span class="glyphicon glyphicon-cog" style=' font-size: 16px;'></span> Configuración
        </a>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        <li>
            <a style="border-style: none;" data-toggle="modal" data-target="#modalEditarDatos">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
            &nbsp;Mis datos
            </a>
        </li> 
        <!--<li>
          <a title='FINALIZAR SESION DE USUARIO'  href="<?=DIR_LEVEL_MOD_POE?>logoff.php">
            <span class="glyphicon glyphicon-log-in"></span>
             &nbsp;Cerrar sesión
          </a>
        </li>-->
     </ul>
    </li>  
    <li>
    <a title='FINALIZAR SESION DE USUARIO'  href="<?=DIR_LEVEL_MOD_POE?>logoff.php"><span class="glyphicon glyphicon-log-in"></span> &nbsp;Cerrar sesión</a>
      </li>
    </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

 




<!--<div id="divMenu">-->
   
<?// require_once("barraSub.php");?>

 
<style>
  .title_big {
    font-size: 20px;
    line-height: 56px;
    letter-spacing: -1;
    margin-bottom: 20px;
    }
    .sub_title_big {
    position: relative;
    font-size: 18px;
    line-height: 28px;
    margin: 0 0 30px;
    text-shadow: 1px 1px rgba(255,255,255,0.25);
    font-family: 'Open Sans', sans-serif;
    font-weight:bold;
    color: #000;
}
</style>
