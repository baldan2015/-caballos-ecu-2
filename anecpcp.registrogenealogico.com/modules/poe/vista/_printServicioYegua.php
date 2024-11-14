<?php session_start();
require('../../../Funciones/validaciones.php');
?>


<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANECPCP - REGISTRO GENEALOGICO - IMPRESION DE SERVICIO DE YEGUA</title>
</head>
<?
if (!ValidarSession()) {
    echo "<center><br><br><br>" . Constantes::K_SESSION_LOGOUT . " <a href='#' onclick='return window.close();'>Cerrar esta ventana</a></center> ";
} else {
    date_default_timezone_set('UTC');

    include_once("../logica/EjemplarLogica.php");
    //include_once ("../../../../sge.service/entidad/Resultado.inc.php");
    //include_once("../../../../sge.service/entidad/Constantes.php");
    //include_once("../../constante.php");
    include_once("../comunes/lib.comun.php");



    $print = new EjemplarLogica();
    $ejemplar = $print->obteneDatosServicioMontaPrint($_GET['codigo'], $_GET['codigoMonta'], $_GET['prop']);
    $nombrePotro = '';
    $nombreYegua = '';
    $adnPadre = '';
    foreach ($ejemplar as $key => $value) {
        $nombrePotro = $value->prefPotro . " " . $value->potro;
        $nombreYegua = $value->prefYegua . " " . $value->yegua;

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
        <table border=0 cellspacing="2" cellpadding="3" style=" padding-left: 30px; width: 100%;">
            <tr>
                <td colspan="1" style="text-align: left;width: 55%;"><label style="text-align: center;font-weight: bold;font-size: 15px;">ASOCIACIÓN NACIONAL DEL ECUADOR<br> DE CRIADORES Y PROPIETARIOS DE CABALLOS DE PASO <br>
                        REGISTRO GENEALOGICO DEL CABALLO PERUANO DE PASO</label></td>
                <td colspan="5">
                    <label style="font-weight: bold;font-size: 25px;">REPORTE DE MONTA</label>
                </td>
            </tr>

        </table>

        <br>

        <table style="width: 77%;margin-left: 30px;border-collapse: collapse;">
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;width: 15%;height: 40px;text-align: center;font-size: 20px;"><label style="font-weight: bold;">REG. ASO PASO</label></td>
                <td style="border: 1px solid black;text-align: center;width: 60%;font-size: 20px;"><label style="font-weight: bold;">PADRILLO</label></td>
                <td colspan="2" style="border: 1px solid black;text-align: center;width: 100%;font-size: 20px;"><label style="font-weight: bold;">ADN</label></td>
            </tr>
            <tr>
                <td style="border: 1px solid black;width: 15%;height: 40px;text-align: center;"><label style="font-weight: bold;"><?= $value->codPotro ?></label></td>
                <td style="border: 1px solid black;text-align: center;width: 60%;"><label style="font-weight: bold;"><?= $nombrePotro ?></label></td>
                <? if (trim($value->padreADN) == "SI") {  ?>
                    <td class="print" style="border: 1px solid black;height: 40px;text-align: center;width: 13%;background-color: #37EE1A;"><label style="font-weight: bold; ">SI</label></td>
                <? } else { ?>
                    <td style="border: 1px solid black;height: 40px;text-align: center;width: 13%;"><label style="font-weight: bold;">SI</label></td>
                <? } ?>
                <? if ($value->padreADN == null || $value->padreADN == "NO") { ?>
                    <td class="print" style="border: 1px solid black;height: 40px;text-align: center;background-color:#37EE1A; "><label style="font-weight: bold; ">NO</label></td>
                <? } else { ?>
                    <td style="border: 1px solid black;height: 40px;text-align: center;"><label style="font-weight: bold;">NO</label></td>
                <? } ?>
                <td style="padding-left: 7px;"></td>
                <td style="text-align: center;">
                    <label style="font-weight: bold;">&nbsp;&nbsp;Fecha:</label><label style="text-decoration-line: underline;font-weight: bold;"><?= $value->fecCrea ?></label>
                </td>
            </tr>

        </table>
        <br>

        <table style="width: 97%;margin-left: 30px;border-collapse: collapse;">
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;height: 40px;text-align: center;width: 128px;font-size: 20px;"><label style="font-weight: bold;">REG. ASO PASO</label></td>
                <td style="border: 1px solid black;height: 40px;text-align: center;width: 517px;font-size: 20px;"><label style="font-weight: bold;">PADRILLO</label></td>
                <td colspan="2" style="border: 1px solid black;height: 40px;text-align: center;width: 132px;font-size: 20px;"><label style="font-weight: bold;">ADN</label></td>
                <td style="border: 1px solid black;height: 40px;text-align: center;font-size: 20px;"><label style="font-weight: bold;">FECHA DE MONTA</label></td>
                <td style="border: 1px solid black;height: 40px;text-align: center;font-size: 20px;"><label style="font-weight: bold;">DEBE PARIR</label></td>
            </tr>
            <tr style="border: 1px solid black;">
                <td style="border: 1px solid black;height: 40px;text-align: center;width: 128px;"><label style="font-weight: bold;"><?= $value->codYegua ?></label></td>
                <td style="border: 1px solid black;height: 40px;text-align: center;width: 517px;"><label style="font-weight: bold;"><?= $nombreYegua ?></label></td>
                <? if ($value->madreADN == "SI") {  ?>
                    <td class="print" style="border: 1px solid black;height: 40px;text-align: center;width: 100px;background-color: #37EE1A;"><label style="font-weight: bold; ">SI</label></td>
                <? } else { ?>
                    <td style="border: 1px solid black;height: 40px;text-align: center;width: 100px;"><label style="font-weight: bold;">SI</label></td>
                <? } ?>
                <? if ($value->madreADN == null || $value->madreADN == "NO") { ?>
                    <td class="print" style="border: 1px solid black;height: 40px;text-align: center;width: 100px;background-color:#37EE1A; "><label style="font-weight: bold; ">NO</label></td>
                <? } else { ?>
                    <td style="border: 1px solid black;height: 40px;text-align: center;width: 100px;"><label style="font-weight: bold;">NO</label></td>
                <? } ?>
                <td style="border: 1px solid black;height: 40px;text-align: center;"><label style="font-weight: bold;"><?= $value->fecMonta ?></label></td>
                <td style="border: 1px solid black;height: 40px;text-align: center;"><label style="font-weight: bold;"><?= $value->fecParir ?></label></td>
            </tr>
            <tr style="border: 1px solid black;">
                <td colspan="10" style="border: 1px solid black;height: 20px;text-align: center;"><label style="font-weight: bold;">MÉTODO REPRODUCTIVO UTILIZADO</label></td>
            </tr>
            <tr style="border: 1px solid black;">
                <? if ($value->metodo == "MN") { ?>
                    <td class="print" style="border: 1px solid black;height: 50px;text-align: center;background-color: #37EE1A;"><label style="font-weight: bold;">MONTA NATURAL</label></td>
                <? } else { ?>
                    <td style="border: 1px solid black;height: 50px;text-align: center;"><label>MONTA NATURAL</label></td>
                <? } ?>
                <td colspan="4" style="border: 1px solid black;height: 50px;text-align: center;width: 70%;padding-left: 0px;"><label style="font-weight: bold;">INSEMINACIÓN CON:</label>
                    <table style="width: 100.5%;border-collapse: collapse;">
                        <tr style="border: 1px solid black;">
                            <? if ($value->metodo == "SF") { ?>
                                <td class="print" style="border: 1px solid black;height: 52px;text-align: center;background-color: #37EE1A;"><label style="font-weight: bold;">SEMEN FRESCO</label></td>
                            <? } else { ?>
                                <td style="border: 1px solid black;height: 52px;text-align: center;"><label style="font-weight: bold;">SEMEN FRESCO</label></td>
                            <? } ?>
                            <? if ($value->metodo == "SR") { ?>
                                <td class="print" style="border: 1px solid black;height: 50px;text-align: center;background-color: #37EE1A;"><label style="font-weight: bold;">SEMEN REFRIGERADO</label></td>
                            <? } else { ?>
                                <td style="border: 1px solid black;height: 50px;text-align: center;"><label style="font-weight: bold;">SEMEN REFRIGERADO</label></td>
                            <? } ?>
                            <? if ($value->metodo == "SC") { ?>
                                <td class="print" style="border: 1px solid black;height: 50px;text-align: center;background-color: #37EE1A;"><label style="font-weight: bold;">SEMEN CONGELADO</label></td>
                            <? } else { ?>
                                <td style="border: 1px solid black;height: 50px;text-align: center;"><label style="font-weight: bold;">SEMEN CONGELADO</label></td>
                            <? } ?>
                        </tr>
                    </table>
                </td>
                <? if ($value->metodo == "SC") { ?>
                    <td  style="border: 1px solid black;height: 50px;text-align: center;">
                        <label style="font-weight: bold;">TRANSFERENCIA DE EMBRION</label><br>ID. RECEPTORA: <?= $value->idReceptor ?></label>
                    </td>
                <? } else { ?>

                    <td style="height: 50px;text-align: center;font-weight: bold;">
                        <label style="font-weight: bold;">TRANSFERENCIA DE EMBRIÓN<br>
                            ID. RECEPTORA: <?= $value->idReceptor ?>
                        </label>
                        <?
                        if ($value->fechaEmbrion != "00/00/0000") {
                        ?>
                            <br><?= $value->fechaEmbrion ?>
                        <? } ?>
                    </td>


                <? } ?>


            </tr>
        </table>
        <br><br><br>
        <table style="margin-left: 25px;">
            <tr>
                <label class="space">Datos Servicio Monta Relacionado</label><br><br>
            </tr>

            <tr>
                <label class="space">Fecha Servicio: <?= $value->fecCrea ?></label><br>
            </tr>

            <tr>
                <label class="space">Fecha Impresión: <?= $value->fechaImpresion ?></label><br>
            </tr>

            <tr>
                <label class="space">Responsable del Servicio: <?= $value->usuCrea ?></label><br>
            </tr>

            <tr>
                <label class="space">Codigo Servicio: <?= $value->codigoMonta ?></label><br>
            </tr>

            <tr>
                <label class="space">Responsable de Impresión: <?= $value->usuImpresion ?></label>
            </tr>
        </table>



<?
    }
}
?>
<script type="text/javascript">
    window.print();
</script>