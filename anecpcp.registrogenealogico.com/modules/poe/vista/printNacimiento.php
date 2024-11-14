<?php session_start();
require('../../../Funciones/validaciones.php');
include_once("../logica/EjemplarLogica.php");
include_once("../logica/ResenaLogica.php");
include_once("../logica/ImagenLogica.php");
include_once("../comunes/lib.comun.php");
include_once("../../../constante.php");

$espacio = '<table border="0" align="center">
        <tr>
            <td  valign="middle" align="center"></td>
        </tr>
        </table>';

if (!ValidarSession()) {
    echo "<center><br><br><br>" . Constantes::K_SESSION_LOGOUT . " <a href='#' onclick='return window.close();'>Cerrar esta ventana</a></center> ";
} else {

    define('FPDF_FONTPATH', '../libs/fpdf/pdftable/font/');
    require('../libs/fpdf/PDF.php');
    require('../libs/fpdf/pdftable/lib/pdftable.inc.php');
    $print = new EjemplarLogica();
    $ejemplar = $print->obteneDatosNacimientoPrint($_GET['codigo'], $_GET['codigoNacimiento'], $_GET['prop'],1);

    $vpadre;
    $vmadre;
    $vnombreAbueloPadre = '';
    $vnombreAbuelaPadre = '';
    $vnombreAbueloMadre = '';
    $vnombreAbuelaMadre = '';
    //print_r($ejemplar);

    foreach ($ejemplar as $key => $value) {

        $nombre = $value->prefijo . ' ' . $value->nombre;
        $fecha = $value->fecCrea;
        $genero = ($value->genero == "P" ? "POTRO" : "YEGUA");
        $pelaje = $value->pelaje;
        $codigoMonta = $value->codigoMonta;
        $fechaNacimiento = $value->fecNace;
        $foto = ($value->foto == 0 ? "X" : "-");
        $propietario = $value->propietario;
        $codigoCriador = $value->idCriador;
        $criador = $value->criador;
        $localidad = $value->LugarNace;

        $codigoPadre = $value->idPadre;
        $codigoMadre = $value->idMadre;

        $vpadre = $value->prefijoPadre . " " . $value->nombrePadre;
        $pelajePadre = $value->pelajePadre;

        $vmadre = $value->prefijoMadre . " " . $value->nombreMadre;
        $pelajeMadre = $value->pelajeMadre;
        $codigoAbueloPadre = ($value->idAbueloPadre=='' ? "-" : $value->idAbueloPadre) ;
        $vnombreAbueloPadre = $value->prefijoAbueloPadre . " " . $value->nombreAbueloPadre;
        $codigoAbuelaPadre = ($value->idAbuelaPadre=='' ? "-"  : $value->idAbuelaPadre);
        $vnombreAbuelaPadre = $value->prefijoAbuelaPadre . " " . $value->nombreAbuelaPadre;

        $codigoAbueloMadre = ($value->idAbueloMadre=="" ? "-" : $value->idAbueloMadre);
        $vnombreAbueloMadre = $value->prefijoAbueloMadre . " " . $value->nombreAbueloMadre;
        $codigoAbuelaMadre = ($value->idAbuelaMadre=="" ? "-": $value->idAbuelaMadre);
        $vnombreAbuelaMadre = $value->prefijoAbuelaMadre . " " . $value->nombreAbuelaMadre;

        $diasGestacion = $value->diasGestacion;

        $metodo = '<tr><td ' . ($value->metodo == "MN" ? ' bgcolor="#B4E51D" style="bold" ' : '') . ' >MONTA NATURAL</td>' .
            '<td ' . ($value->metodo == "SR" ? ' bgcolor="#B4E51D" style="bold" ' : '') . '>SEMEN REFRIGERADO</td>' .
            '<td ' . ($value->metodo == "SF" ? ' bgcolor="#B4E51D" style="bold" ' : '') . '>SEMEN FRESCO</td>' .
            '<td ' . ($value->metodo == "SC" ? ' bgcolor="#B4E51D" style="bold" ' : '') . '>SEMEN CONGELADO</td></tr>';


        $fechaImpresion = $value->fechaImpresion;
        $usuImpresion = $value->usuImpresion;
        $usuarioCrea = $value->usuCreaNac;
        $codigoNacimiento = $value->codigoNacimiento;

        $fechaMonta = $value->fecCreaMonta;
        $usuCreaMonta = $value->usuCreaMonta;
        $estado = $value->estadoSolTexto;
        $isTE = $value->isTE;
        $receptor = $value->idReceptor;
        $fechaEmbrion = ($value->fecEmbrion != "00/00/0000" ? $value->fecEmbrion : "");


        $doc = $value->documentosPDF;
        $arrayDoc = explode(",", $doc);

        $resenas = unserialize($value->idResenias);
        $resenasNombresCA = "";
        $resenasNombresAD = "";
        $resenasNombresAI = "";
        $resenasNombresPD = "";
        $resenasNombresPI = "";

        $resenasGeneral = '';
        if (is_array($resenas)) {
            $objResena = new ResenaLogica();
            $i = 1;
            foreach ($resenas as $key => $valor) {

                $item = $objResena->obtenerID($valor);

                if ($i < sizeof($resenas)) {
                    $resenasGeneral =  $resenasGeneral . '' . htmlentities($item->descripcion) . ', ';
                } else {
                    $resenasGeneral =  $resenasGeneral . '' . htmlentities($item->descripcion) . '. ';
                }
                $i++;
            }
        }
        if($resenasGeneral==""){
          $reseniaBasica = $print->obtenerNAC($_GET['codigo']);
          $resenasGeneral=$reseniaBasica->reseniaBasica;
        }
    }

    $espacio = '<table border="0" align="center">
    <tr>
        <td  valign="middle" align="center"></td>
    </tr>
    </table>';

    if ($doc == "") {
        $documentosAdjuntados='';
    } else {
        $documentosAdjuntados = '<tr><td style="bold" bgcolor="#cccccc">DOCUMENTOS PDF ADJUNTADOS</td></tr>';
        foreach ($arrayDoc as $documento) {
            $documentosAdjuntados .= '<tr><td>' . $documento . '</td></tr>';
        }
    }


    $img   = new ImagenLogica();
    $imagenes = $img->buscarSearchNacTMP($_GET['codigo'], 0, '');
    $imagenesCaballo = "";
    if (is_array($imagenes)) {
        foreach ($imagenes as $key => $fila) {
            if(file_exists(K_PATH_NAC_IMG . $fila->ruta)){
              if(substr($fila->ruta,-3) == "png"){
                $imagenesCaballo .= '<table align="center" valign="middle"><tr><td><img src="' . K_PATH_NAC_IMG . $fila->ruta . '" height=450 width=500></td></tr></table>' . $espacio;
              }else{
                $imagenesCaballo .= '<table align="center" valign="middle"><tr><td><img src="' . K_PATH_NAC_IMG . $fila->ruta . '" height=117 width=147></td></tr></table>' . $espacio;
              }
                
            }else{
                $imagenesCaballo .= '<table align="center" valign="middle"><tr><td><img src="images/image_not_found.jpeg" height=650 width=650></td></tr></table>' . $espacio;
            }
            
        }
    }


    if ($isTE == 1) {
        $headerTranferencia = '<td style=bold bgcolor="#cccccc" colspan="2" valign="middle" align="center">
        <b>TRANSFERENCIA DE EMBRION</b>
        </td>';
        $bodyTranferencia = '<td style=bold align="center" valign="middle">
        <b>ID. RECEPTORA: ' . $receptor . '</b>
        </td>
        <td style=bold align="center" valign="middle">
        <b>FECHA: ' . $fechaEmbrion . '</b>
        </td>
        ';
    } else {
        $headerTranferencia = '';
        $bodyTranferencia = '';
    }

    


    $tabla = '
    <table valign="middle" align="center">
      <tr>
          <td style=bold size=13 valign="middle" align="center">
          ASOCIACIÓN NACIONAL DEL ECUADOR DE CRIADORES Y PROPIETARIOS DE CABALLOS DE PASO
  GUAYAQUIL - ECUADOR <br>
  REGISTRO GENEALOGICO DEL CABALLO PERUANO DE PASO
          </td>
      </tr>
      ' . $espacio . '
     </table>
            <table>
              <tr>
                <td style=bold valign="top" >
                  NOMBRE:
                </td>
                <td valign="top">
                  ' . $nombre . '
                </td>
                <td style=bold valign="top">
                FECHA:
                </td>
                <td valign="top">
                  ' . $fecha . '
                </td>
              </tr>
              <tr>
                <td style=bold  valign="top">
                  SEXO:
                </td>
                <td  valign="top">
                 ' . $genero . '
                </td>
                <td style=bold valign="top">
                  PELAJE:
                </td>
                <td  valign="top">
                 ' . $pelaje . '
                </td>
              </tr>
              <tr>
                <td style=bold valign="top">
                FECHA DE NACIMIENTO:
                </td>
                <td  valign="top">
                 ' . $fechaNacimiento . '
                </td>
                <td style=bold valign="top">
                  REPORTE DE MONTA:
                </td>
                <td  valign="top">
                 ' . $codigoMonta . '
                </td>
              </tr>
              <tr>
              <td style=bold valign="top">
              LOCALIDAD: 
              </td>
              <td  valign="top">
               ' . $localidad . '
              </td>
                <td style=bold valign="top">
                REG DE CRIADOR N°: 
                </td>
                <td  valign="top">
                 ' . $codigoCriador . '
                </td>
              </tr>
              </table>
              ' . $espacio . '
              <table>
              <tr>
              <td style=bold valign="top">
              PROPIETARIO: 
              </td>
              <td colspan=3 valign="top">
               ' . $propietario . '
              </td>
              
              </tr>
              <tr>
               <td style=bold valign="top">
                CRIADOR:
                </td>
                <td colspan=3 valign="top">
                 ' . $criador . '
                </td>
              </tr>
            </table>
            ' . $espacio . '
            ' . $espacio . '
            <table>
            <tr>
            <td  valign="top" height=8>
            </td>
            <td style=bold valign="top">
                PADRE:
                  ' . $vnombreAbueloPadre . ' ' . $codigoAbueloPadre . '
                </td>
            </tr>
              <tr>
                <td style=bold width=105 valign="top">
                  PADRE: ' . $vpadre . ' ' . $codigoPadre . '
                <br>
                  PELAJE:  ' . $pelajePadre . '
                  </td>
                <td valign="top" height=8>
                </td>
              </tr>
              <tr>
                  <td  valign="top" height=8>
                  </td>
                  <td  style=bold valign="middle">
                  MADRE: ' . $vnombreAbuelaPadre . ' ' . $codigoAbuelaPadre . '
                  </td>
              </tr>
              </table>
              ' . $espacio . '
              <table>
              <tr>
                <td valign="top" height=8>
                </td>
                <td style=bold valign="middle">
                PADRE: ' . $vnombreAbueloMadre . ' ' . $codigoAbueloMadre . '
                </td>
              </tr>
              <tr>
                <td style=bold width=105 valign="middle">
                  MADRE: ' . $vmadre . ' ' . $codigoMadre . '
                 <br>
                  PELAJE: ' . $pelajeMadre . '
                  </td>
                <td  valign="top" height=8>
                </td>
              </tr>
              <tr>
                  <td  valign="top" height=8>
                  </td>
                  <td style=bold valign="middle">
                  MADRE: ' . $vnombreAbuelaMadre . ' ' . $codigoAbuelaMadre . '
                  </td>
              </tr>
            </table>
            ' . $espacio . '
            <table>
            <tr>
              <td style=bold valign="middle"> DIAS DE GESTACIÓN :
              </td>
              <td valign="middle"> ' . $diasGestacion . '
              </td>
              </tr>
              </table>
              <table>
            <tr>
              <td style=bold valign="top" width="25"> RESEÑAS:  
              </td>
              <td valign="middle"> ' . html_entity_decode($resenasGeneral) . '
              </td>
              </tr>
            </table>
            ' . $espacio . '
        <table border="1" align="center">
          <tr>
            <td style=bold colspan=4 bgcolor="#cccccc" valign="middle" align="center">
              MÉTODO REPRODUCTIVO UTILIZADO
            </td>
            
            ' . $headerTranferencia . '
          </tr>
          <tr>
            ' . $metodo . '
            ' . $bodyTranferencia . '
          </tr>
        </table>' . $espacio . '
        <table border=1 align="center">' . $documentosAdjuntados . '
        </table>' . $espacio . '
        ' . $imagenesCaballo . '' . $espacio . '
        <table>
          <tr>
            <td style=bold colspan=2>DATOS DE NACIMIENTO</td>
          </tr>
          <tr>
            <td style=bold>Fecha Nacimiento:</td>
            <td>' . $fechaNacimiento . '</td>
          </tr>
          <tr>
            <td style=bold>Fecha Impresión:</td>
            <td>' . $fechaImpresion . '</td>
          </tr>
          <tr>
            <td style=bold>Responsable del Registro:</td>
            <td>' . $usuarioCrea . '</td>
          </tr>
          <tr>
            <td style=bold>Codigo Nacimiento: </td>
            <td>' . $codigoNacimiento . '</td>
          </tr>
        </table>' . $espacio . '
        <table>
          <tr>
            <td style=bold colspan=2>DATOS SERVICIO MONTA RELACIONADO</td>
          </tr>
          <tr>
            <td style=bold>Fecha Servicio:</td>
            <td>' . $fechaMonta . '</td>
          </tr>
          <tr>
            <td style=bold>Responsable del Servicio:</td>
            <td>' . $usuCreaMonta . '</td>
          </tr>
          <tr>
            <td style=bold>Codigo Servicio:</td>
            <td>' . $codigoMonta . '</td>
          </tr>
          <tr>
            <td style=bold>Responsable de Impresión: </td>
            <td>' . $usuImpresion . '</td>
          </tr>
        </table>' . $espacio . '
        <table>
          <tr>
            <td style=bold>
              Situación del Nacimiento:
            </td>
            <td>
              ' . $estado . '
            </td>
          </tr>
        </table>
            ';
    $html = <<<MYTABLE
$tabla
MYTABLE;


    $p = new PDFTable();
    //$p = new PDF_HTML();

    $header = 'REPORTE DE NACIMIENTO: ' . $codigoNacimiento;
    $p = new PDFTable();
    $p->SetMargins(10, 2, 10, 20);

    $p->SetTitle($header);
    $p->SetHeaderFooter($header);
    $p->SetFont('Helvetica', '', 10);
    $p->AddPage();
    //$p->WriteHTML(utf8_decode($html));
    $p->htmltable(utf8_decode($html));



    $p->output('Reporte de nacimiento ' . $codigoNacimiento . '.pdf', 'D');
}
?>