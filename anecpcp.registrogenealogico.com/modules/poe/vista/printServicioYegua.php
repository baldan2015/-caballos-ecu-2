<?php
session_start();
include_once("../comunes/lib.comun.php");
require('../../../Funciones/validaciones.php');
if (!ValidarSession()) {

    echo "<center><br><br><br>" . Constantes::K_SESSION_LOGOUT . " <a href='#' onclick='return window.close();'>Cerrar esta ventana</a></center> ";
} else {

    define('FPDF_FONTPATH', '../libs/fpdf/pdftable/font/');
    require('../libs/fpdf/pdftable/lib/pdftable.inc.php');

    include_once("../logica/EjemplarLogica.php");


    $print = new EjemplarLogica();

    $ejemplar = $print->obteneDatosServicioMontaPrint(
        $_GET['codigo'],
        $_GET['codigoMonta'],
        $_GET['prop'],1);


    $nombrePotro = '';
    $nombreYegua = '';
    $codigoPotro = '';
    $codigoYegua = '';
    $adnPotro = '';
    $fechaRegistro = '';
    $fechaMonta = '';
    $fechaParir = '';
    $metodo = '';
    $receptor = '';
    $fechaEmbrion = '';
    $usuarioCrea = '';
    $codigoMonta = '';
    $usuImpresion = '';

    foreach ($ejemplar as $key => $value) {

        $nombrePotro = $value->prefPotro . " " . $value->potro;
        $nombreYegua = $value->prefYegua . " " . $value->yegua;
        $codigoPotro = $value->codPotro;
        $codigoYegua = $value->codYegua;
        $adnPotro = (trim($value->padreADN)!="" && $value->padreADN!=null ? $value->padreADN : "NO");
        $adnYegua = (trim($value->madreADN) !="" && $value->madreADN!=null ? $value->madreADN : "NO");
        $fechaRegistro = $value->fecCrea;
        $fechaMonta = $value->fecMonta;
        $fechaParir = $value->fecParir;
        $metodo = '<tr><td ' . ($value->metodo == "MN" ? ' bgcolor="#B4E51D" style="bold" ' : '') . ' >MONTA NATURAL</td>' .
        '<td ' . ($value->metodo == "SR" ? ' bgcolor="#B4E51D"  style="bold" ' : '') . '>SEMEN REFRIGERADO</td>' .
        '<td ' . ($value->metodo == "SF" ? ' bgcolor="#B4E51D" style="bold" ' : '') . '>SEMEN FRESCO</td>' .
        '<td ' . ($value->metodo == "SC" ? ' bgcolor="#B4E51D" style="bold" ' : '') . '>SEMEN CONGELADO</td></tr>';

        $receptor = $value->idReceptor;
        $fechaEmbrion = ($value->fechaEmbrion != "00/00/0000" ? $value->fechaEmbrion : "");
        $fechaImpresion = $value->fechaImpresion;
        $usuarioCrea = $value->usuCrea;
        $codigoMonta = $value->codigoMonta;
        $usuImpresion = $value->usuImpresion;
        $isTE = $value->isTE;
    }


    $espacio = '<table border="0" align="center">
    <tr>
        <td  valign="middle" align="center"></td>
    </tr>
    </table>';

    if($isTE==1){
        $headerTranferencia = '<td style="bold" bgcolor="#cccccc" colspan="2" valign="middle" align="center">
        <b>TRANSFERENCIA DE EMBRION</b>
        </td>';
        $bodyTranferencia = '<td style="bold" align="center" valign="middle">
        <b>ID. RECEPTORA: '.$receptor.'</b>
        </td>
        <td style="bold" align="center" valign="middle">
        <b>FECHA: '.$fechaEmbrion.'</b>
        </td>
        ';
    }else{
        $headerTranferencia = '';
        $bodyTranferencia ='';
    }
   


    $tabla =   '<table valign="middle" align="center">
    <tr>
        <td style=bold size=12 valign="middle" align="center">
        ASOCIACIÓN NACIONAL DEL ECUADOR DE CRIADORES Y PROPIETARIOS DE CABALLOS DE PASO
GUAYAQUIL - ECUADOR <br>
REGISTRO GENEALOGICO DEL CABALLO PERUANO DE PASO
        </td>
    </tr>
    ' . $espacio . '
      </table>
      <table border="1" >
        <tr>
          <td style="bold" bgcolor="#cccccc" valign="middle" align="center">
            <b>REG. ASO PASO</b>
          </td>
          <td style="bold" bgcolor="#cccccc" valign="middle" align="center">
            <b>PADRILLO</b>
          </td>
          <td style="bold" bgcolor="#cccccc" valign="middle" align="center">
            <b>ADN</b>
          </td>
        </tr>
        <tr>
          <td  valign="middle" align="center">
            <b>'.$codigoPotro.'</b>
          </td>
          <td  valign="middle" align="center">
            <b>'.html_entity_decode($nombrePotro).'</b>
          </td>
          <td  valign="middle" align="center">
            <b>'.$adnPotro.'</b>
          </td>
        </tr>
      </table>
      ' . $espacio . '
      <table border="1" >
        <tr>
          <td style="bold" bgcolor="#cccccc" valign="middle" align="center">
            <b>REG. ASO PASO</b>
          </td>
          <td style="bold" bgcolor="#cccccc" valign="middle" align="center">
            <b>YEGUA</b>
          </td>
          <td style="bold" bgcolor="#cccccc" valign="middle" align="center">
            <b>ADN</b>
          </td>
          <td style="bold" bgcolor="#cccccc" valign="middle" align="center">
            <b>FECHA DE MONTA</b>
          </td>
          <td style="bold" bgcolor="#cccccc" valign="middle" align="center">
            <b>DEBE PARIR</b>
          </td>
        </tr>
        <tr>
          <td  valign="middle" align="center">
            <b>'.$codigoYegua.'</b>
          </td>
          <td  valign="middle" align="center">
            <b>'.html_entity_decode($nombreYegua).'</b>
          </td>
          <td  valign="middle" align="center">
            <b>'.$adnYegua.'</b>
          </td>
          <td  valign="middle" align="center">
            <b>'.$fechaMonta.'</b>
          </td>
          <td  valign="middle" align="center">
          <b>'.$fechaParir.'</b>
          </td>
        </tr>
      </table>
      ' . $espacio . '
      <table border="1">
        <tr>
          <td style="bold" colspan=4 bgcolor="#cccccc" valign="middle" align="center">
            MÉTODO REPRODUCTIVO UTILIZADO
          </td>
          
          ' . $headerTranferencia . '
        </tr>
        <tr>
          '.$metodo.'
          ' . $bodyTranferencia . '
        </tr>
      </table>
      ' . $espacio . '
      ' . $espacio . '
      <table border="0">
        <tr>
            <td style="bold">DATOS SERVICIO DE MONTA RELACIONADO</td>
        </tr>
      </table>
      <table border="0" >
        <tr>
          <td style="bold" valign="middle">
            <b>Fecha de Servicio:</b>
          </td>
          <td  valign="middle">
            '.$fechaMonta.'
          </td>
        </tr>
        <tr>
          <td style="bold" valign="middle">
            <b>Responsable de Servicio: </b>
          </td>
          <td  valign="middle">
            '.html_entity_decode($usuarioCrea).'
          </td>
        </tr>
        <tr>
          <td style="bold" valign="middle">
            <b>Fecha de Impresión:  </b>
          </td>
          <td  valign="middle">
            '.$fechaImpresion.'
          </td>
        </tr>
        <tr>
          <td style="bold" valign="middle">
            <b>Responsable de Impresión:</b>
          </td>
          <td  valign="middle">
            '.html_entity_decode($usuImpresion).'
          </td>
        </tr>
        <tr>
          <td style="bold" valign="middle">
            <b>Fecha de registro:</b>
          </td>
          <td  valign="middle">
            '.$fechaRegistro.'
          </td>
        </tr>
      </table>
      
      ';



$html = <<<MYTABLE
$tabla
MYTABLE;

$header='REPORTE DE MONTA: '.$codigoMonta;
    $p = new PDFTable();
    $p->SetMargins(10, 2,10,20);
    
    $p->SetTitle($header);
    $p->SetHeaderFooter($header);
    $p->SetFont('Helvetica', '', 11);
    $p->AddPage();
    
   
    //$p->Image("images/Logo_pdf.jpeg", NULL, NULL, 65, 20, "JPEG");
    $p->htmltable(utf8_decode($html));
    $p->output('Reporte de monta '.$codigoMonta.'.pdf', 'D');
}

?>  