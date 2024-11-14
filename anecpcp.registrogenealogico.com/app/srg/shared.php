<? session_start();
require("entidad/Constantes.php");
require("comunes/lib.comun.php");
?>
<!DOCTYPE html>
<html  >  
<head>  
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-104927954-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-104927954-3');
</script>
  <meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<title>ANECPCP - REGISTRO GENEALOGICO</title>
<link  rel="stylesheet" type="text/css" href="libs/jquery-ui-1.11.4.custom.green/jquery-ui.css">
<script src="libs/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>    
<script src="libs/jquery-ui-1.11.4.custom/jquery-ui.js"></script>

<script src="script/generales/loading.js"></script>

<link rel="stylesheet" type="text/css" href="libs/alertifyjs/css/alertify.css" >
<!--<link rel="stylesheet" type="text/css" href="libs/alertifyjs/css/alertify.core.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="libs/alertifyjs/css/alertify.default.css" rel="stylesheet"/>-->
<link rel="stylesheet" type="text/css" href="libs/alertifyjs/css/themes/bootstrap.min.css" > 
<script src="libs/alertifyjs/alertify.min.js"></script>
<script src="libs/shortcut/shortcut.js"></script>

<link type="text/css" href="libs/jqGrid/css/ui.jqgrid.css" rel="stylesheet" />
<script type="text/javascript" src="libs/jqGrid/js/i18n/grid.locale-es.js"></script>
<script type="text/javascript" src="libs/jqGrid/js/jquery.jqGrid.min.js"></script>
 
 
<LINK REL=StyleSheet href="libs/bootstrap-3.3.7/css/bootstrap.min.css" TYPE="text/css" MEDIA=screen />
<script src="libs/bootstrap-3.3.7/js/bootstrap.min.js"></script> 

<link href="libs/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
<script src="libs/bootstrap-select/js/bootstrap-select.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/sgie.css" />    
<link rel="stylesheet" type="text/css" href="css/menu.css" />    
<script src="script/generales/generales.js"></script>
<script src="script/generales/dropdownlist.js"></script>
<script src="script/menu.js"></script>
 
</head>  
<body  >  
	
<? require("menu.php")    ?>
<div class=" " style="margin-top:50px;width: 100%!important;">    
    
<section>
    <?
  //  echo $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO]." ...";
    if(!validarSesion2()){
        echo "<center><br><br><br><span style='color:#000; font-weight:bold;'>".Constantes::K_SESSION_LOGOUT." --> </span><a href='login.php' style='color:gray; font-weight:bold;' >Ir a realizar login</a></center> ";
    }else{
    if(isset($_GET['obj'])){
        
        if($_GET['obj']==md5('vista/mantenimiento/pelaje.php')){
             require("vista/mantenimiento/pelaje.php");
        }else if($_GET['obj']==md5('vista/mantenimiento/ejemplares.php')){
             require("vista/mantenimiento/ejemplares.php");
        }else if($_GET['obj']==md5('vista/mantenimiento/tipoDoc.php')){
              require("vista/mantenimiento/tipoDoc.php");
        }else if($_GET['obj']==md5('vista/mantenimiento/entidad.php')){
              require("vista/mantenimiento/entidad.php");
        }else if($_GET['obj']==md5('vista/mantenimiento/ejemplar.php')){
              require("vista/mantenimiento/ejemplar.php");
        }else if($_GET['obj']==md5('vista/mantenimiento/neoEjemplar.php')){
              require("vista/mantenimiento/neoEjemplar.php");
        }else if($_GET['obj']==md5('vista/mantenimiento/registrarEjemplar.php')){
              require("vista/mantenimiento/registrarEjemplar.php");
        }else if($_GET['obj']==md5('vista/mantenimiento/transferencia.php')){
              require("vista/mantenimiento/transferencia.php");              
        }else if($_GET['obj']==md5('vista/mantenimiento/oficina.php')){
              require("vista/mantenimiento/oficina.php");
        }else if($_GET['obj']==md5('vista/consulta/ejemplar.php')){
                require("vista/consulta/ejemplar.php"); 
        }else if($_GET['obj']==md5('vista/mantenimiento/usuarios.php')){
                require("vista/mantenimiento/usuarios.php");  
        }else if($_GET['obj']==md5('vista/mantenimiento/usuarioRol.php')){
                require("vista/mantenimiento/usuarioRol.php");  
        }else if($_GET['obj']==md5('vista/mantenimiento/resena.php')){
                require("vista/mantenimiento/resena.php");         
        }else if($_GET['obj']==md5('vista/mantenimiento/departamento.php')){
                require("vista/mantenimiento/departamento.php");
        }else if($_GET['obj']==md5('vista/reporte/rptAdn.php')){
                require("vista/reporte/rptAdn.php");
        
        }else if($_GET['obj']==md5('vista/reporte/rptNumEjemXCriador.php')){
                require("vista/reporte/rptNumEjemXCriador.php");
        }else if($_GET['obj']==md5('vista/reporte/rptNumNacXTipo.php')){
                require("vista/reporte/rptNumNacXTipo.php");
        }else if($_GET['obj']==md5('vista/reporte/rptCriadorPrefijo.php')){
                require('vista/reporte/rptCriadorPrefijo.php');                
        }else if($_GET['obj']==md5('vista/reporte/rptNumServY.php')){
                require('vista/reporte/rptNumServY.php');                
        }else if($_GET['obj']==md5('vista/reporte/rptNumServP.php')){
                require('vista/reporte/rptNumServP.php');
        }else if($_GET['obj']==md5('vista/reporte/rptCriadorDpto.php')){
                require('vista/reporte/rptCriadorDpto.php');
        }else if($_GET['obj']==md5('vista/reporte/rptCierreMes.php')){
                require('vista/reporte/rptCierreMes.php');
         }else if($_GET['obj']==md5('vista/configuracion/setting.php')){
                require('vista/configuracion/setting.php');
         }else if($_GET['obj']==md5('vista/mantenimiento/setpoe.php')){
            require('vista/mantenimiento/setpoe.php');
         }else if($_GET['obj']==md5('vista/proceso/inscripcion.php')){
            require('vista/proceso/inscripcion.php');
         }else if($_GET['obj']==md5('vista/proceso/novedades.php')){
            require('vista/proceso/novedades.php');
         }else if($_GET['obj']==md5('vista/proceso/parteOcurrencia.php')){
             require('vista/proceso/parteOcurrencia.php');
        }else if($_GET['obj']==md5('vista/proceso/nacimiento.php')){
            require('vista/proceso/nacimiento.php');
        }else if($_GET['obj']==md5('vista/proceso/monta.php')){
            require('vista/proceso/monta.php');
        }else if($_GET['obj']==md5('vista/mantenimiento/concursos.php')){
                require('vista/mantenimiento/concursos.php');
        }else if($_GET['obj']==md5('vista/mantenimiento/resultados.php')){
                require('vista/mantenimiento/resultados.php');
        }else{
            echo "pagina no existe";
        }

          
    }else{
?>
 <?
 //echo "<pre>";print_r($_SESSION);
 ?>
 <style>
  body{
    color:black;
    background: url("images/logo/2.jpg")  ;   
    text-transform: uppercase !important;
     background-position: center center; 
    background-repeat: no-repeat; 
    background-attachment: fixed; 
    background-size: cover; 
}
 </style>
  <center>
 <!--<img src="images/logo/2.jpg"  width="100%"  /> -->
    <div style="width: 100%;" id="divMainText" >
    
<div class="opacity mainMessage" >
<label class="title_big" style="margin-top: 20px;">SISTEMA DE REGISTRO GENEALOGICO - SRG
</label>
<br>
&nbsp;&nbsp;&nbsp;
<div style="margin-top: -50px;">
<label class="sub_title_big" >
&nbsp;&nbsp;Software para gestionar la informaci&oacute;n del registro geneal&oacute;gico de caballos de paso. 
</label>
</div>
 <!--<br>&nbsp;&nbsp;&nbsp;
<label class="sub_title_big">
Acceso directo a las Operaciones mas comunes.
</label>
<br>

<button class="btn btn-default"><b>Gestionar Informaci&oacute;n de Ejemplar</b></button>
&nbsp;
&nbsp;
<button class="btn btn-default"><b>Gestionar Transferencias</b></button>
&nbsp;
&nbsp;
<button class="btn btn-default"><b>Gestionar Informacion de Criadores - Propietarios y Socios</b></button>
-->
</div>

</div></center>
<?

    }

  }
    ?>
 
    
</section>  
    </div>

  </body>
  </html>
    
 