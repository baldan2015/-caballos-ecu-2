<?php session_start();
//require('../../../Funciones/validaciones.php');
?>


<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANECPCP - REGISTRO GENEALOGICO - IMPRESIÓN DE NACIMIENTO</title>
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

    $print = new EjemplarLogica();
    $ejemplar = $print->obteneDatosNacimientoPrint($_GET['codigo'], $_GET['codigoNacimiento'], $_GET['prop']);
    $vpadre;
    $vmadre;
    $vnombreAbueloPadre = '';
    $vnombreAbuelaPadre = '';
    $vnombreAbueloMadre = '';
    $vnombreAbuelaMadre = '';
    foreach ($ejemplar as $key => $value) {
        $vpadre = $value->prefijoPadre . " " . $value->nombrePadre;
        $vmadre = $value->prefijoMadre . " " . $value->nombreMadre;
        $vnombreAbueloPadre = $value->prefijoAbueloPadre . " " . $value->nombreAbueloPadre;
        $vnombreAbuelaPadre = $value->prefijoAbuelaPadre . " " . $value->nombreAbuelaPadre;
        $vnombreAbueloMadre = $value->prefijoAbueloMadre . " " . $value->nombreAbueloMadre;
        $vnombreAbuelaMadre = $value->prefijoAbuelaMadre . " " . $value->nombreAbuelaMadre;

        $doc=$value->documentosPDF ;
        $array= explode(",",$doc);

        $resenas = unserialize($value->idResenias);
        $resenasNombresCA = "";
        $resenasNombresAD = "";
        $resenasNombresAI = "";
        $resenasNombresPD = "";
        $resenasNombresPI = "";
        $resenasGeneral = '';
        if (is_array($resenas)) {
            $objResena = new ResenaLogica();
            $i=1;
            foreach ($resenas as $key => $valor) {

                $item = $objResena->obtenerID($valor);
                if($i<sizeof($resenas)){
                    $resenasGeneral =  $resenasGeneral.''.htmlentities($item->descripcion).', ';
                }else {
                    $resenasGeneral =  $resenasGeneral.''.htmlentities($item->descripcion).'. ';
                }
                $i++;
                /*if ($item->tipo == "CA") {
                    //print_r($item);
                    $resenasNombresCA = $resenasNombresCA . " " . htmlentities($item->descripcion);
                } else if ($item->tipo == "AD") {
                    $resenasNombresAD = $resenasNombresAD . " " . htmlentities($item->descripcion);
                } else if ($item->tipo == "AI") {
                    $resenasNombresAI = $resenasNombresAI . " " . htmlentities($item->descripcion);
                } else if ($item->tipo == "PD") {
                    $resenasNombresPD = $resenasNombresPD . " " . htmlentities($item->descripcion);
                } else if ($item->tipo == "PI") {
                    $resenasNombresPI = $resenasNombresPI . " " . htmlentities($item->descripcion);
                }*/
            }
        }else{
            $resenasGeneral=$value->reseniaBasica;
        }

        // print_r($value);

?>
        <style type="text/css">
            body {
                font-family: Arial;

            }


            @media print {
                .print {
                    background-color: #37EE1A !important;
                    -webkit-print-color-adjust: exact;
                }
            }

            .space {
                margin-left: 27px;
            }
        </style>
        <br><br>
        <table border=0 cellspacing="2" cellpadding="3" style=" padding-left: 15px; width: 100%;">
            <tr>
                <td colspan="1" style="text-align: center;width: 55%;"><label style="text-align: center;font-weight: bold;font-size: 30px;">REPORTE DE NACIMIENTO</label></td>

            </tr>
            <tr>
                <td colspan="1" style="text-align: center;width: 55%;"><label style="text-align: center;font-weight: bold;font-size: 15px;">ASOCIACIÓN NACIONAL DEL ECUADOR DE CRIADORES Y PROPIETARIOS DE CABALLOS DE PASO<br>GUAYAQUIL - ECUADOR <br>
                        REGISTRO GENEALOGICO DEL CABALLO PERUANO DE PASO</label></td>
            </tr>
        </table>

        <br>

        <table border=0 cellspacing="2" cellpadding="3" style=" padding-left: 15px; width: 100%;font-size: 12px !important;">
            <tr>
                <td><label>NOMBRE:&nbsp;&nbsp;</label><label style="text-decoration-line: underline;"><?= $value->prefijo ?>  <?= $value->nombre ?></label></td>
                <td><label>FECHA:&nbsp;&nbsp;</label><label style="text-decoration-line: underline;"><?= $value->fecCrea ?></label></td>
            </tr>
            <tr>
                <? if ($value->genero == "P") { ?>
                    <td><label>SEXO:&nbsp;&nbsp;</label><label style="text-decoration-line: underline;">POTRO</label></td>
                <? } else { ?>
                    <td><label>SEXO:&nbsp;&nbsp;</label><label style="text-decoration-line: underline;">YEGUA</label></td>
                <? } ?>
                <td><label>PELAJE:&nbsp;&nbsp;</label><label style="text-decoration-line: underline;"><?= $value->pelaje ?></label></td>
            </tr>
            <tr>
                <td><label>FECHA DE NACIMIENTO:&nbsp;&nbsp;</label><label style="text-decoration-line: underline;"><?= $value->fecNace ?></label></td>
                <td><label>REPORTE DE MONTA N°:&nbsp;&nbsp;</label><label style="text-decoration-line: underline;"><?= $value->codigoMonta ?></label></td>
            </tr>
            <tr>
                <? if ($value->foto == 0) { ?>
                    <td><label>FOTO:&nbsp;&nbsp;</label><input type="text" style="width: 5%;" id="txtFotoPrint" disabled="true" value="" /></label></td>
                <? } else { ?>
                    <td><label>FOTO:&nbsp;&nbsp;</label><input type="text" style="width: 5%;" id="txtFotoPrint" disabled="true" value="X" /></label></td>
                <? } ?>
                <td><label>CESIÓN DE VIENTRE N°:&nbsp;&nbsp;</label><label style="text-decoration-line: underline;"></label></td>
            </tr>
            <tr>
                <td><label>PROPIETARIO:&nbsp;&nbsp;</label><label style="text-decoration-line: underline;"><?= $value->propietario ?></label></td>
                <td><label>REGISTRO DE CRIADOR N°:&nbsp;&nbsp;</label><label style="text-decoration-line: underline;"><?= $value->idCriador ?></label></td>
            </tr>
            <tr>
                <td><label>CRIADOR:&nbsp;&nbsp;</label><label style="text-decoration-line: underline;"><?= $value->criador ?></label></td>
                <td><label>SOCIO N°:&nbsp;&nbsp;</label><label style="text-decoration-line: underline;"></label></td>
            </tr>
            <tr>
                <td><label>DIRECCION:&nbsp;&nbsp;</label><label style="text-decoration-line: underline;"></label></td>
                <td><label>LOCALIDAD:&nbsp;&nbsp;</label><label style="text-decoration-line: underline;"><?= $value->LugarNace ?></label></td>
            </tr>
        </table>
        <table style=" padding-left: 15px; width: 100%;">
            <tr style="border: 1px solid black;width: 100%;">
                <td style="border: 1px solid black;" height="150">
                    <h5 style="text-align: center;">IMAGEN</h5>
                </td>
            </tr>
        </table>
        <br>
        <table border=0 cellspacing="2" cellpadding="3" style=" padding-left: 15px; width: 100%;font-size: 12px !important;">
            <tr>
                <td style="width: 50%;">
                    <label>PADRE:&nbsp;&nbsp;</label>
                    <label style="text-decoration-line: underline;"><?= $vpadre ?>&nbsp;&nbsp;</label>
                    <label>#REG.&nbsp;&nbsp;</label>
                    <input type="text" disabled="true" value="<?= $value->idPadre ?>">
                </td>
                <td>
                    <label>PADRE:&nbsp;&nbsp;</label>
                    <label style="text-decoration-line: underline;"><?= $vnombreAbueloPadre ?></label>
                    <label>#REG.&nbsp;&nbsp;</label>
                    <input type="text" disabled="true" value="<?= $value->idAbueloPadre ?>">
                </td>
            </tr>
            <tr>
                <td style="width: 50%;">
                    <label>PELAJE:&nbsp;&nbsp;</label>
                    <label style="text-decoration-line: underline;"><?= $value->pelajePadre ?></label>
                </td>
                <td>
                    <label>MADRE:&nbsp;&nbsp;</label>
                    <label style="text-decoration-line: underline;"><?= $vnombreAbuelaPadre ?></label>
                    <label>#REG.&nbsp;&nbsp;</label>
                    <input type="text" disabled="true" value="<?= $value->idAbuelaPadre ?>">
                </td>
            </tr>

            <tr>
                <td style="width: 50%;">
                    <label>MADRE:&nbsp;&nbsp;</label>
                    <label style="text-decoration-line: underline;"><?= $vmadre ?>&nbsp;&nbsp;</label>
                    <label>#REG.&nbsp;&nbsp;</label>
                    <input type="text" disabled="true" value="<?= $value->idMadre ?>">
                </td>
                <td>
                    <label>PADRE:&nbsp;&nbsp;</label>
                    <label style="text-decoration-line: underline;"><?= $vnombreAbueloMadre ?></label>
                    <label>#REG.&nbsp;&nbsp;</label>
                    <input type="text" disabled="true" value="<?= $value->idAbueloMadre ?>">
                </td>
            </tr>
            <tr>
                <td style="width: 50%;">
                    <label>PELAJE:&nbsp;&nbsp;</label>
                    <label style="text-decoration-line: underline;"><?= $value->pelajeMadre ?></label>
                </td>
                <td>
                    <label>MADRE:&nbsp;&nbsp;</label>
                    <label style="text-decoration-line: underline;"><?= $vnombreAbuelaMadre ?></label>
                    <label>#REG.&nbsp;&nbsp;</label>
                    <input type="text" disabled="true" value="<?= $value->idAbuelaMadre ?>">
                </td>
            </tr>
        </table>
        <br>

        <table border=0 cellspacing="2" cellpadding="3" style=" padding-left: 15px; width: 100%;border-collapse: collapse;">
            <tr style="width: 100%;">
                <td style="width: 100%;"><label style="margin-left: 15px;">DIAS DE GESTACIÓN : &nbsp;&nbsp;<span><?= $value->diasGestacion ?></span></label></td>
            </tr>
        </table>
        <table border=0 cellspacing="2" cellpadding="3" style=" padding-left: 15px; width: 100%;">
            <tr>
                <td><label>RESEÑAS:&nbsp;&nbsp;</label><label style="text-decoration-line: underline;"><?= $resenasGeneral ?></label></td>
            </tr>
        </table>
        <!--<table style="width: 100%;margin-left: 15px;border-collapse: collapse;">

            <tr style="width: 100%;">
                <td style="border: 1px solid black;width: 5%;text-align: center;"><label>AD</label></td>
                <td style="border: 1px solid black;width: 40%;text-align: left;"><label>&nbsp;<?= $resenasNombresAD ?></label></td>
                <td style="border: 1px solid black;width: 5%;text-align: center;"><label>PD</label></td>
                <td style="border: 1px solid black;width: 40%;text-align: left;"><label>&nbsp;<?= $resenasNombresPD ?></label></td>
            </tr>
            <tr style="width: 100%;">
                <td style="border: 1px solid black;width: 5%;text-align: center;"><label>AI</label></td>
                <td style="border: 1px solid black;width: 40%;text-align: left;"><label>&nbsp;<?= $resenasNombresAI ?></label></td>
                <td style="border: 1px solid black;width: 5%;text-align: center;"><label>PI</label></td>
                <td style="border: 1px solid black;width: 40%;text-align: left;"><label>&nbsp;<?= $resenasNombresPI ?></label></td>
            </tr>
        </table>-->
        <br>
        <table style="width: 100%;margin-left: 15px;border-collapse: collapse;font-size: 12px !important;">
            <tr style="border: 1px solid black;">
                <td colspan="10" style="border: 1px solid black;height: 20px;text-align: center;"><label>MÉTODO REPRODUCTIVO UTILIZADO</label></td>
            </tr>
            <tr style="border: 1px solid black;">
                <? if ($value->metodo == "MN") { ?>
                    <td class="print" style="border: 1px solid black;height: 50px;text-align: center;background-color: #37EE1A;"><label style="font-weight: bold;">MONTA NATURAL</label></td>
                <? } else { ?>
                    <td style="border: 1px solid black;height: 50px;text-align: center;"><label>MONTA NATURAL</label></td>
                <? } ?>
                <td colspan="4" style="border: 1px solid black;height: 50px;text-align: center;width: 70%;padding-left: 0px;"><label>INSEMINACIÓN CON:</label>
                    <table style="width: 100.3%;border-collapse: collapse;font-size: 12px !important;">
                        <tr style="border: 1px solid black;">
                            <? if ($value->metodo == "SF") { ?>
                                <td class="print" style="border: 1px solid black;height: 50px;text-align: center;background-color: #37EE1A;"><label style="font-weight: bold;">SEMEN FRESCO</label></td>
                            <? } else { ?>
                                <td style="border: 1px solid black;height: 50px;text-align: center;"><label>SEMEN FRESCO</label></td>
                            <? } ?>
                            <? if ($value->metodo == "SR") { ?>
                                <td class="print" style="border: 1px solid black;height: 50px;text-align: center;background-color: #37EE1A;"><label style="font-weight: bold;">SEMEN REFRIGERADO</label></td>
                            <? } else { ?>
                                <td style="border: 1px solid black;height: 50px;text-align: center;"><label>SEMEN REFRIGERADO</label></td>
                            <? } ?>
                            <? if ($value->metodo == "SC") { ?>
                                <td class="print" style="border: 1px solid black;height: 50px;text-align: center;background-color: #37EE1A;"><label style="font-weight: bold;">SEMEN CONGELADO</label></td>
                            <? } else { ?>
                                <td style="border: 1px solid black;height: 50px;text-align: center;"><label>SEMEN CONGELADO</label></td>
                            <? } ?>
                        </tr>
                    </table>
                </td>
                <? if ($value->metodo == "SC") { ?>
                    <td class="print" style="border: 1px solid black;height: 50px;text-align: center;background-color: #37EE1A;"><label style="font-weight: bold;">TRANSFERENCIA DE EMBRION</label><br>ID. RECEPTORA: <?= $value->idReceptor ?></label></td>
                <? } else { ?>
                    <td style="border: 1px solid black;height: 50px;text-align: center;"><label>TRANSFERENCIA DE EMBRION</label><br>ID. RECEPTORA: <?= $value->idReceptor ?> <br> <?= $value->fecEmbrion ?></label></td>
                <? } ?>
            </tr>

        </table>
        <? if ($doc != '') {

        ?>
            <br>
            <table style="width: 100%;margin-left: 15px;border-collapse: collapse;font-size: 12px !important;">
                <tr style="border: 1px solid black;">
                    <td>DOCUMENTOS PDF ADJUNTADOS:
                        <ul>
                            <?
                            foreach ($array as $documentos) {   ?>
                                <li><? echo $documentos . '' ?></li>
                            <? }
                            ?>
                        </ul>
                    </td>
                </tr>
            </table>
        <?
        }
        ?>
    <?
    }
    ?>

    <?
    $img   = new ImagenLogica();
    $imagenes = $img->buscarSearchNacTMP($_GET['codigo'], 0,'');
    //K_PATH
    //K_PATHWEB_NAC_IMG
    $html = "";
    if (is_array($imagenes)) {
        foreach ($imagenes as $key => $fila) {

            //$html= 'http://goldclean.pe/anecpcp/f2/sge.documentos/imgins/'.$fila->ruta;
            $html = K_PATHWEB_NAC_IMG . $fila->ruta;
            //$html= K_PATHWEB.$fila->ruta;
            // $html= 'http://localhost/imagenes_sge/'.$fila->ruta;

    ?>
            <div style="margin-left: 10%;margin-top: 30px;">
                <img src='<?= $html ?>' width="500" height="430" />
            </div>
    <?
        }
    }
    ?>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <table style="margin-left: 25px;">
        <tr>
            <label class="space">Datos de Nacimiento</label><br><br>
        </tr>

        <tr>
            <label class="space">Fecha Nacimiento: <?= $value->fecNace ?></label><br>
        </tr>

        <tr>
            <label class="space">Fecha Impresión: <?= $value->fechaImpresion ?></label><br>
        </tr>

        <tr>
            <label class="space">Responsable del Registro: <?= $value->usuCreaNac ?></label><br>
        </tr>

        <tr>
            <label class="space">Codigo Nacimiento: <?= $value->codigoNacimiento ?></label><br>
        </tr>

    </table>
    <br>
    <table style="margin-left: 25px;">
        <tr>
            <label class="space">Datos Servicio Monta Relacionado</label><br><br>
        </tr>

        <tr>
            <label class="space">Fecha Servicio: <?= $value->fecCreaMonta ?></label><br>
        </tr>

        <tr>
            <label class="space">Responsable del Servicio: <?= $value->usuCreaMonta ?></label><br>
        </tr>

        <tr>
            <label class="space">Codigo Servicio: <?= $value->codigoMonta ?></label><br>
        </tr>

        <tr>
            <label class="space">Responsable de Impresión: <?= $value->usuImpresion ?></label>
        </tr>
    </table>
    <br>
    <table style="margin-left: 25px;">
        <tr>
            <label class="space">Situación del Nacimiento: <b><?= $value->estadoSolTexto ?></b></label>
        </tr>
    </table>
<?
}
?>
<script type="text/javascript">
    window.print();
</script>