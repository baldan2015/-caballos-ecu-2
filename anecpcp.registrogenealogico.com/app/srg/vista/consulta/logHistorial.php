<?php session_start(); ?>
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANECPCP - REGISTRO GENEALOGICO - IMPRESION DE LOG HISTORIAL</title>
</head>
<?
date_default_timezone_set('UTC');
include_once("../../logica/EjemplarLogicaF2.php");
include_once("../../logica/ResenaLogica.php");
include_once("../../logica/ImagenInsLogica.php");
include_once("../../entidad/Ejemplar.inc.php");
include_once("../../entidad/Constantes.php");
include_once("../../constante.php");
include_once("../../comunes/lib.comun.php");


if (!validarSesion2()) {
    echo "<center><br><br><br>" . Constantes::K_SESSION_LOGOUT . " <a href='#' onclick='return window.close();'>Cerrar esta ventana</a></center> ";
} else {

    $fechaActual = date('d/m/Y');


    $nombPadreEjemplar = "";
    $nombMadreEjemplar = "";
    $nombEjemplar = "";

    $nomNac = "";
    $nomIns = "";
    $propietario = "";
    $printLog = new EjemplarLogica();

    //$usuario_crea = $_SESSION[Constantes::K_SESSION_CODIGO_USUARIO];

    $ejemplar = $printLog->getInfoHistorialAll($_GET['idHorse']);
    $usuarioApro = $printLog->getInfoUsuarioApro($_GET['idHorse']);
    //echo "<pre>";         print_r( $ejemplar->id);          echo "</pre>";
    // echo "<pre>";print_r($propietarioOriginal);echo "</pre>";
    $nombEjemplar = $ejemplar->id . " " . $ejemplar->prefijo . " " . htmlentities($ejemplar->nombre);
    $nomNac = $ejemplar->prefijoNac . " " . htmlentities($ejemplar->nombreNac);
    $nomIns = $ejemplar->prefijoIns . " " . htmlentities($ejemplar->nombreIns);
    $nombPadreEjemplar = $ejemplar->prefijoPotro . " " . htmlentities($ejemplar->nombrePotro) . " " . $ejemplar->codPotro;
    $nombMadreEjemplar = $ejemplar->prefijoYegua . " " . htmlentities($ejemplar->nombreYegua) . " " . $ejemplar->codYegua;
}


$propietario = $ejemplar->propietario;
$origen = '';
if ($ejemplar->origenIns == "IMPORTADO") {
    $origen = '<span class="badge badge-warning">' . $ejemplar->origenIns . '</span>';
} else {
    $origen = '<span class="badge badge-success">' . $ejemplar->origenIns . '</span>';
}
//print_r($ejemplar);
$resenasNac = unserialize($ejemplar->idReseniasNac);
$resenasIns = unserialize($ejemplar->idReseniasIns);
$resenasNombresNac = "";
$resenasNombresIns = "";
if (is_array($resenasNac)) {
    $objResenaNac = new ResenaLogica();
    foreach ($resenasNac as $key => $value) {

        $itemNac = $objResenaNac->obtenerID($value);
        $resenasNombresNac = ($resenasNombresNac=="" ? "":$resenasNombresNac.", ") . " " . htmlentities($itemNac->descripcion);
    }
}else{
    $resenasNombresNac = $ejemplar->reseniaBasicaNac;
}

if (is_array($resenasIns)) {
    $objResenaIns = new ResenaLogica();
    foreach ($resenasIns as $key => $value) {

        $itemIns = $objResenaIns->obtenerID($value);
        $resenasNombresIns = ($resenasNombresIns=="" ? "":$resenasNombresIns.", ")  . htmlentities($itemIns->descripcion);
    }
}else{
    $resenasNombresIns = $ejemplar->reseniaBasicaIns;
}


$thumb_prefix           = "thumb_";
$imgNac   = new ImagenLogica();
$pdfNac   = new ImagenLogica();
$imagenesNac = $imgNac->buscarSearchNacTMP($ejemplar->idNac, 0, '');
$documentoNac = $pdfNac->buscarSearchNacTMP($ejemplar->idNac, 1, '');
$html1 = "";
$html2 = "";
$ImagenesImpresionNac = "";
$DocumentosImpresionNac = "";
//print_r($documentoIns);

if (is_array($documentoNac)) {

    foreach ($documentoNac as $key => $fila) {

        $html1 .= "
                            <span style='margin-right: 10px;' data-toggle='tooltip' data-placement='bottom' title='" . $fila->idTipoDocumento . "'><a href='" . K_PATHWEB_NAC_PDF . $fila->ruta . "' target='_blank'><img src='../../images/icono/pdf.png' alt='documento' width='50' height='60'></a></span><br>";
        $DocumentosImpresionNac .= "<li>" . $fila->idTipoDocumento . "</li>";
    }
}

if (is_array($imagenesNac)) {

    foreach ($imagenesNac as $key => $fila) {

        $html2 .= "<span  style='margin-right:-30px;' data-toggle='tooltip' data-placement='bottom' title='Ver Imagen'><a href='" . K_PATHWEB_NAC_IMG . $fila->ruta . "' target='_blank'><img src='" . K_PATHWEB_NAC_IMG . $thumb_prefix . $fila->ruta . "' alt='imagen' width='70' height='60'></a></span><br>";
        $ImagenesImpresionNac .= "<img src='" . K_PATHWEB_NAC_IMG. $fila->ruta . "' alt='imagen' width='500' height='450'> <br>";
    }
}


$imgIns   = new ImagenLogica();
$pdfIns   = new ImagenLogica();
$imagenesIns = $imgIns->buscarSearchInsTMP($ejemplar->idIns, 0, '');
$documentoIns = $pdfIns->buscarSearchInsTMP($ejemplar->idIns, 1, '');
$html3 = "";
$html4 = "";
$ImagenesImpresionIns = "";
$DocumentosImpresionIns = "";
//print_r($documentoIns);

if (is_array($documentoIns)) {

    foreach ($documentoIns as $key => $fila) {

        $html3 .= "
                            <span style='margin-right: 10px;' data-toggle='tooltip' data-placement='bottom' title='" . $fila->idTipoDocumento . "'><a href='" . K_PATHWEB_INS_PDF . $fila->ruta . "' target='_blank'><img src='../../images/icono/pdf.png' alt='documento' width='50' height='60'></a></span><br><br>";
        $DocumentosImpresionIns .= "<li>" . ($fila->idTipoDocumento=='' ? 'OTROS' : $fila->idTipoDocumento) . "</li>";
    }
}

if (is_array($imagenesIns)) {

    foreach ($imagenesIns as $key => $fila) {

        $html4 .= "<span  style='margin-right:-30px;' data-toggle='tooltip' data-placement='bottom' title='Ver Imagen'><a href='" . K_PATHWEB_INS_IMG . $fila->ruta . "' target='_blank'><img src='" . K_PATHWEB_INS_IMG . $thumb_prefix . $fila->ruta . "' alt='imagen' width='70' height='60'></a></span><br><br>";
        $ImagenesImpresionIns .= "<img src='" . K_PATHWEB_INS_IMG . $fila->ruta . "' alt='imagen' width='500' height='450' > <br><br>";
    }
}



$cabeceraImpresion = '<tr class="cabecera-impresion">'.
'<td style="width: 450px;"><img src="../../images/logo/anecpcp.jpg"></td>'.
'<td style="text-align: left;"><label>Usuario: '.$_SESSION[Constantes::K_SESSION_NOMBRE_COMPLETO] .'<br> <br>'.
   ' Fecha de Impresión:'.$fechaActual  .'</label></td>'.
'</tr>';
?>
<style type="text/css">
    body {
        font-family: Trebuchet MS;
        font-size: 12px;

    }

    .badge {
        display: inline-block;
        min-width: 10px;
        padding: 3px 7px;
        font-size: 12px;
        font-weight: 700;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        background-color: #777;
        border-radius: 10px;
    }

    .badge-success {
        background-color: #5cb85c;
    }

    .badge-warning {
        background-color: #f0ad4e;
    }

   /**/ .divimpresion {
        display: none;
    }
    .cabecera-impresion{
        display: none;
    }

    @media all {
   div.saltopagina{
      display: none;
   }
   .cabebcera-inscripcion{
       display: none;
   }
   .hr-impresion{
       display: none;
   }
}
</style>
<style media="print">
    table.documentoseimagenesIns {
        display: none;
    }

    table.documentoseimagenesNac {
        display: none;
    }

    .cabecera-impresion{
        display: block;
    }

    #btnImprimir {
        display: none;
    }

    div.saltopagina{
      display:block;
      page-break-before:always;
   }

    .divimpresion {
        display: block;
    }
    .cabebcera-inscripcion{
        display: block;
    }
    .hr-impresion{
        display: block;
    }
</style>
<br><br>
<? if ($ejemplar == null || $propietario == "") {
?>
    <table border=0 cellspacing="2" cellpadding="3" style=" padding-left: 30px; width: 100%;">
        <tr>
            <td colspan="12" style="text-align: center;"><span><img src="../../images/icono/road.png" alt="imagen" width="30" height="30" style="margin-top: 2px;">&nbsp;&nbsp;</span><label style="text-align: center;font-weight: bold;font-size: 25px;color: green;">HISTORIAL DE INSCRIPCIÓN DEL EJEMPLAR</label></td>
        </tr>
    </table>
    <br><br><br><br><br><br><br><br><br>
    <table border=0 cellspacing="2" cellpadding="3" style=" padding-left: 30px; width: 100%;">
        <tr>
            <td colspan="12"><span>
                    <center><img src="../../images/icono/warning.png" alt="aviso" width="50" height="50"></center>
                </span></td>
        </tr>
        <tr>
            <td colspan="12" style="font-size: 17px;font-family: Arial;color:#AAB1AC; font-weight:bold;"><label>
                    <center>No se encontró el historial detalle de inscripción del ejemplar: <?= $_GET['idHorse'] ?></center>
                </label></span></td>
        </tr>
    </table>

<? } else { ?>

    <table border=0 cellspacing="2" cellpadding="3" style=" padding-left: 30px; width: 100%;" class="cabebcera-inscripcion">
        <?php echo $cabeceraImpresion ?>
    </table>
    <hr class="hr-impresion">
    <table border=0 cellspacing="2" cellpadding="3" style=" padding-left: 30px; width: 100%;">
        
        <tr>
            <td colspan="11" style="text-align: center;"><span><img src="../../images/icono/road.png" alt="imagen" width="30" height="30" style="margin-top: 2px;">&nbsp;&nbsp;</span><label style="text-align: center;font-weight: bold;font-size: 25px;color: green;">HISTORIAL DE INSCRIPCION DE EJEMPLAR</label></td>
            <td><button id="btnImprimir" style="background-color: #5cb85c; color:#fff" type='button' onclick='window.print();'>Imprimir</button></td>
        </tr>

        <tr>
            <td style="padding-top: 40px;"><label style="font-weight: bold;">Ejemplar<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><?= $nombEjemplar ?></label></td>
        </tr>
        <tr>
            <td><label style="font-weight: bold;">Propietario<label>&nbsp;&nbsp;<label><?= $ejemplar->propietario ?></label></td>
        </tr>
    </table>
    <br>
    <br>
    <?php if ($ejemplar->codigoMonta != '') {  ?>
        <table style="width: 90%;border: 1px solid green;margin-left: 30px;">
            <th style="text-align: left;background-color: #A4ECB9;height: 25px;"> DATOS DE MONTA</th>
        </table>
        <table cellspacing="2" cellpadding="3" style=" padding-left: 90px; width: 90%;border: 1px solid green;margin-left:30px;">
            <tr>
                <td style="width: 38%;"><label> CODIGO MONTA</label></td>
                <td><label style="margin-left: 10px;"> <?= $ejemplar->codigoMonta ?></label></td>
            </tr>
            <tr>
                <td><label> PADRE</label></td>
                <td><label style="margin-left: 10px;"> <?= $nombPadreEjemplar ?></label></td>
            </tr>
            <tr>
                <td><label> MADRE</label></td>
                <td><label style="margin-left: 10px;"> <?= $nombMadreEjemplar ?></label></td>
            </tr>
            <tr>
                <td><label> METODO</label></td>
                <td><label style="margin-left: 10px;"> <?= $ejemplar->metodo ?></label></td>
            </tr>
            <tr>
                <td><label> FECHA MONTA</label></td>
                <td><label style="margin-left: 10px;"> <?= $ejemplar->fecMonta ?></label></td>
            </tr>
            <tr>
                <td><label> FECHA REGISTRO</label></td>
                <td><label style="margin-left: 10px;"> <?= $ejemplar->fecCrea ?></label></td>
            </tr>
            <tr>
                <td><label> RESPONSABLE DE MONTA</label></td>
                <td><label style="margin-left: 10px;"> <?= $ejemplar->responsableMonta ?></label></td>
            </tr>
            <tr>
                <td><label> FECHA DEBE PARIR</label></td>
                <td><label style="margin-left: 10px;"> <?= $ejemplar->fecParir ?></label></td>
            </tr>
            <tr>
                <td><label> ID RECEPTORA</label></td>
                <td><label style="margin-left: 10px;"> <?= $ejemplar->idReceptor ?></label></td>
            </tr>
            <tr>
                <td><label> FECHA EMBRIÓN</label></td>
                <td><label style="margin-left: 10px;"> <?= $ejemplar->fecEmbrion ?></label></td>
            </tr>
        </table>

        <br>
        <br>
    <?php } ?>
    <?php if ($ejemplar->codigoNacimiento != '') {  ?>
        <table style="width: 90%;border: 1px solid green;margin-left: 30px;">
            <th style="text-align: left;background-color: #A4ECB9;height: 25px;"> DATOS DE NACIMIENTO</th>
        </table>
        <table cellspacing="2" cellpadding="3" style="padding-left: 90px; width: 90%;border: 1px solid green;margin-left:30px;">
            <tr>
                <td><label> CODIGO NACIMIENTO</label></td>
                <td style="width: 44%;"><label> <?= $ejemplar->codigoNacimiento ?></label></td>
                <td rowspan="11">
                    <table class="documentoseimagenesNac" cellspacing="3" style="width: 90%;height:90%;">
                        <tr>
                            <td rowspan="11"><?= $html1 ?></td>
                        </tr>
                        <tr>
                            <td rowspan="11" style='margin-top:1px;'><?= $html2 ?></td>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td><label> NOMBRE</label></td>
                <td><label> <?= $nomNac ?></label></td>
            </tr>
            <tr>
                <td><label> GENERO</label></td>
                <td><label> <?= $ejemplar->generoNac ?></label></td>
            </tr>
            <tr>
                <td><label> PELAJE</label></td>
                <td><label> <?= $ejemplar->pelajeNac ?></label></td>
            </tr>
            <tr>
                <td><label> FECHA NACIMIENTO</label></td>
                <td><label> <?= $ejemplar->fecNaceNac ?></label></td>
            </tr>
            <tr>
                <td><label> ORIGEN</label></td>
                <td><label> <?= $ejemplar->origenNac ?></label></td>
            </tr>
            <tr>
                <td><label> RESEÑA</label></td>
                <td><label> <?= $resenasNombresNac ?></label></td>
            </tr>
            <tr>
                <td><label> CRIADERO</label></td>
                <td><label> <?= $ejemplar->criadorNac ?></label></td>
            </tr>
            <tr>
                <td><label> CODIGO MONTA</label></td>
                <td><label> <?= $ejemplar->codigoMonta ?></label></td>
            </tr>
            <tr>
                <td><label> RESPONSABLE DE APROBACIÓN</label></td>
                <td><label> <?= $ejemplar->responsableNac ?></label></td>
            </tr>
            <tr>
                <td><label> FECHA APROBACIÓN</label></td>
                <td><label> <?= $ejemplar->fecSol ?></label></td>
            </tr>
        </table>

        
        
        <br>
        <br>
        <div class="saltopagina"></div>
    <table border=0 cellspacing="2" cellpadding="3" style=" padding-left: 30px; width: 100%;" class="cabebcera-inscripcion">
        <?php echo $cabeceraImpresion ?>
    </table>
    <hr class="hr-impresion">
    <div style="padding-top:10px"></div>
    <?php } ?>
    
    <table style="width: 90%;border: 1px solid green;margin-left: 30px;">
        <th style="text-align: left;background-color: #A4ECB9;height: 25px;"> DATOS DE INSCRIPCION</th>
    </table>
    <table cellspacing="2" cellpadding="3" style=" padding-left: 90px; width: 90%;border: 1px solid green;margin-left:30px;">
        <tr>
            <td><label> CODIGO INSCRIPCION</label></td>
            <td style="width: 44%;"><label> <?= $ejemplar->codigoInscripcion ?></label></td>
            <td rowspan="11">
                <table class="documentoseimagenesIns" style="width: 90%;height:90%;">
                    <tr>
                        <td rowspan="11"><?= $html3 ?></td>
                    </tr>
                    <tr>
                        <td rowspan="11" style='margin-top:1px;'><?= $html4 ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php if ($ejemplar->codigoNacimiento == '') { ?>
            <tr>
                <td><label> PADRE</label></td>
                <td><label> <?= $nombPadreEjemplar ?></label></td>
            </tr>
            <tr>
                <td><label> MADRE</label></td>
                <td><label> <?= $nombMadreEjemplar ?></label></td>
            </tr>
        <?php } ?>
        <tr>
            <td><label> NOMBRE</label></td>
            <td><label> <?= $nomIns ?></label></td>
        </tr>
        <tr>
            <td><label> GENERO</label></td>
            <td><label> <?= $ejemplar->generoIns ?></label></td>
        </tr>
        <tr>
            <td><label> PELAJE</label></td>
            <td><label> <?= $ejemplar->pelajeIns ?></label></td>
        </tr>
        <tr>
            <td><label> FECHA NACIMIENTO</label></td>
            <td><label> <?= $ejemplar->fecNaceIns ?></label></td>
        </tr>
        <tr>
            <td><label> ORIGEN</label></td>
            <td><label> <? echo $origen;  ?></label></td>
        </tr>
        <tr>
            <td><label> RESEÑA</label></td>
            <td><label> <?= $resenasNombresIns ?></label></td>
        </tr>
        <tr>
            <td><label> CRIADERO</label></td>
            <td><label> <?= $ejemplar->criadorIns ?></label></td>
        </tr>
        <tr>
            <td><label> CODIGO MONTA</label></td>
            <td><label> <?= $ejemplar->codigoMonta ?></label></td>
        </tr>
        <tr>
            <td><label> RESPONSABLE DE APROBACIÓN</label></td>
            <td><label> <?= $usuarioApro->usuarioApro ?></label></td>
        </tr>
        <tr>
            <td><label> FECHA APROBACION</label></td>
            <td><label> <?= $usuarioApro->fecApro ?></label></td>
        </tr>

    </table>
<? } ?>

<br>
<br>
<div class="divimpresion">
    <?php if ($ejemplar->codigoNacimiento != '' && $ImagenesImpresionNac != null) {  ?>

        <table id="tituloImagenesNac" style="width: 90%;border: 1px solid green;margin-left: 30px; ">
            <th style="text-align: left;background-color: #A4ECB9;height: 25px;"> IMAGENES DE NACIMIENTO</th>
        </table>
        <table id="tablaImagenesNac" cellspacing="2" cellpadding="3" style=" padding-left: 90px; width: 90%;border: 1px solid green;margin-left:30px;">
            <td colspan="12">
                <center><?php echo $ImagenesImpresionNac; ?></center>
            </td>
        </table>
        <br>
        <br>
        
        <table id="tituloDocumentosNac" style="width: 90%;border: 1px solid green;margin-left: 30px;">
            <th style="text-align: left;background-color: #A4ECB9;height: 25px;"> DOCUMENTOS DE NACIMIENTO</th>
        </table>
        <table id="tablaDocumentosNac" cellspacing="2" cellpadding="3" style=" padding-left: 90px; width: 90%;border: 1px solid green;margin-left:30px;">
            <td colspan="12">
                <ul>
                    <?php echo $DocumentosImpresionNac; ?>
                </ul>
            </td>
        </table>
        <br>
        <br>
    <?php } ?>
    <div class="saltopagina"></div>
    <div style="padding-top:10px"></div>
    <table border=0 cellspacing="2" cellpadding="3" style=" padding-left: 30px; width: 100%;" class="cabebcera-inscripcion">
        <?php echo $cabeceraImpresion ?>
    </table>
    <hr class="hr-impresion">
    <div style="padding-top:10px"></div>
    <table id="tituloImagenesIns" style="width: 90%;border: 1px solid green;margin-left: 30px;">
        <th style="text-align: left;background-color: #A4ECB9;height: 25px;"> IMAGENES DE INSCRIPCION</th>
    </table>
    <table id="tablaImagenesIns" cellspacing="2" cellpadding="3" style=" padding-left: 90px; width: 90%;border: 1px solid green;margin-left:30px;">
        <td colspan="12">
            <center><?php echo $ImagenesImpresionIns; ?></center>
        </td>
    </table>
    <br>
    <br>
    <table id="tituloDocumentosIns" style="width: 90%;border: 1px solid green;margin-left: 30px;">
        <th style="text-align: left;background-color: #A4ECB9;height: 25px;"> DOCUMENTOS DE INSCRIPCION</th>
    </table>
    <table id="tablaDocumentosIns" cellspacing="2" cellpadding="3" style=" padding-left: 90px; width: 90%;border: 1px solid green;margin-left:30px;">
        <td colspan="12">
            <ul>
                <?php echo $DocumentosImpresionIns; ?>
            </ul>
        </td>
    </table>
</div>