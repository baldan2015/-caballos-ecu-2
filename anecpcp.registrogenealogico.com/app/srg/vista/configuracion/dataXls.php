<?php session_start();
ini_set('memory_limit', '-1');
/*
require("../../entidad/Constantes.php");
require("../../comunes/lib.comun.php");*/
 if(!isset($_SESSION["UsuarioCodigo"])) 
 die("<center><br><br><br><span style='color:#000; font-weight:bold;'>La sesión ha finalizado  --> </span><a href='../../login.php' style='color:gray; font-weight:bold;' >Ir a realizar login</a></center> ");
      
   include_once ("../../logica/EjemplarLogicaXls.php");
     
   
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once   '../../libs/PHPExcel-1.8/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");


// Add some data
					           
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'N°')
            ->setCellValue('B1', 'ORIGEN')
            ->setCellValue('C1', 'REG. ASOC')
            ->setCellValue('D1', 'PREF.')
            ->setCellValue('E1', 'NOMBRE')
            ->setCellValue('F1', 'SANG.')
            ->setCellValue('G1', 'SEXO')
            ->setCellValue('H1', 'PELAJE')
            ->setCellValue('I1', 'FECHA NAC.')
            ->setCellValue('J1', 'REG. PADRE')
            ->setCellValue('K1', 'PREF.')
            ->setCellValue('L1', 'PADRE')
            ->setCellValue('M1', 'REG. MADRE')
            ->setCellValue('N1', 'PREF.')
            ->setCellValue('O1', 'MADRE')
            ->setCellValue('P1', 'CRIADOR')
            ->setCellValue('Q1', 'PROPIETARIO')
            ->setCellValue('R1', 'FECHA INS.')
            ->setCellValue('S1', 'N° SOL. INS.')
            ->setCellValue('T1', 'TRANSF.')
            ->setCellValue('U1', 'STATUS')
            ->setCellValue('V1', 'ADN');



 $styleArray = array(
 'font' => array(
 'bold' => true,
 'color' => array('rgb' => '000000'),
 'size' => 10 
 ),
 'fill' => array( 
 'type' => PHPExcel_Style_Fill::FILL_SOLID,
 'color' => array('rgb' => 'D8D2D0')) 
 );

$objPHPExcel->getActiveSheet()->getStyle('A1:V1')->applyFromArray($styleArray);



     $ejemplarServicio=new EjemplarLogicaXls();

$idEjemplar='';
$prefijo='';
$nombre='';$prop=0;
$cria=0;
$sexo='';
$edadDesde='';
$edadhasta='';
$estado='';
$ente=0;
$start=0;
$limit=10000;
$sidx='id';
$sord='asc';

 $resultado=$ejemplarServicio->buscarSearchXls($idEjemplar,$prefijo,$nombre,$prop,$cria,$sexo,$edadDesde,$edadhasta,$estado,$ente,$start,$limit,$sidx,$sord);

   $registros=0;
    $nac=0;
    $imp=0;
    $I=2;
    $numeroRegistro = 1;
  //  $resultado=["a","b","c"];
 if(is_array($resultado)){
      foreach ($resultado as $key => $value) {
         
$COL_A="A".$I;
$COL_B="B".$I;
$COL_C="C".$I;
$COL_D="D".$I;
$COL_E="E".$I;
$COL_F="F".$I;
$COL_G="G".$I;
$COL_H="H".$I;
$COL_I="I".$I;
$COL_J="J".$I;
$COL_K="K".$I;
$COL_L="L".$I;
$COL_M="M".$I;
$COL_N="N".$I;
$COL_O="O".$I;
$COL_P="P".$I;
$COL_Q="Q".$I;
$COL_R="R".$I;
$COL_S="S".$I;
$COL_T="T".$I;
$COL_U="U".$I;
$COL_V="V".$I;
$nombreEjemplar=$value->nombre;//htmlentities($value->nombre,iso-8859-1);
$nombrePadre=$value->nombrePad;//htmlentities($value->nombrePad,iso-8859-1);
$nombreMadre=$value->nombreMad;//htmlentities($value->nombreMad,iso-8859-1);
$propietarios=$value->propietarios;// htmlentities($value->propietarios,iso-8859-1);
$criadores=$value->criadores;//htmlentities($value->criadores,iso-8859-1)
$nombrePelaje=$value->nombrePelaje;//htmlentities($value->nombrePelaje,iso-8859-1)

/*
->setCellValue('A1', 'N°')
            ->setCellValue('B1', 'ORIGEN')
            ->setCellValue('C1', 'REG. ASOC')
            ->setCellValue('D1', 'PREF.')
            ->setCellValue('E1', 'NOMBRE')
            ->setCellValue('F1', 'SANG.')
            ->setCellValue('G1', 'SEXO')
            ->setCellValue('H1', 'PELAJE')
            ->setCellValue('I1', 'FECHA NAC.')
            ->setCellValue('J1', 'REG. PADRE')
            ->setCellValue('K1', 'PREF.')
            ->setCellValue('L1', 'PADRE')
            ->setCellValue('M1', 'REG. MADRE')
            ->setCellValue('N1', 'PREF.')
            ->setCellValue('O1', 'MADRE')
            ->setCellValue('P1', 'CRIADOR')
            ->setCellValue('Q1', 'PROPIETARIO')
            ->setCellValue('R1', 'FECHA INS.')
            ->setCellValue('S1', 'N° SOL. INS.')
            ->setCellValue('T1', 'TRANSF.')
            ->setCellValue('U1', 'STATUS')
            ->setCellValue('V1', 'ADN');
*/
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_A , $numeroRegistro);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_B , $value->origen);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_C , $value->codigo);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_D , $value->prefijo);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_E , $nombreEjemplar);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_F , $value->sang);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_G , $value->sexo);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_H , $nombrePelaje); 
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_I , $value->fecNace);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_J , $value->idPadre);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_K , $value->prefijoPad);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_L , $nombrePadre);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_M , $value->idMadre);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_N , $value->prefijoMad);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_O , $nombreMadre);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_P , $criadores);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_Q , $propietarios);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_R , $value->fecReg);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_S , $value->codigoInscripcion);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_T , $value->fechaTransferencia);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_U , $value->estado);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_V , $value->adn);

$numeroRegistro ++;
$I++;
          
    }
    
  }else
  {
     $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2' , ' NO HAY EJEMPLARES');
  }
 

 $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
 $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$fechaActual = date("d-m-Y");

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ANCEPCP-'.$fechaActual.'.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

 