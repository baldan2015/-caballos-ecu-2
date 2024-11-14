<?php session_start();
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
            ->setCellValue('A1', 'ID EJEMPLAR')
            ->setCellValue('B1', 'PREFIJO')
            ->setCellValue('C1', 'NOMBRE')
            ->setCellValue('D1', 'FEC. NAC.')
            ->setCellValue('E1', 'FEC. REGISTRO')
            ->setCellValue('F1', 'ID PADRE')
            ->setCellValue('G1', 'PREF. PADRE')
            ->setCellValue('H1', 'NOM. PADRE')
            ->setCellValue('I1', 'ID MADRE')
            ->setCellValue('J1', 'PREF. MADRE')
            ->setCellValue('K1', 'NOM. MADRE')
            ->setCellValue('L1', 'PROPIETARIOS')
            ->setCellValue('M1', 'CRIADOR')
            ->setCellValue('N1', 'FEC. FALLECE')
            ->setCellValue('O1', 'PELAJE')
            ->setCellValue('P1', 'LUGAR DE NAC.')
            ->setCellValue('Q1', 'MICROCHIP')
            ->setCellValue('R1', 'ADN')
            ->setCellValue('S1', 'CAPADO')
            ->setCellValue('T1', 'ESTADO');



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

$objPHPExcel->getActiveSheet()->getStyle('A1:T1')->applyFromArray($styleArray);



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
$nombreEjemplar=$value->nombre;//htmlentities($value->nombre,iso-8859-1);
$nombrePadre=$value->nombrePad;//htmlentities($value->nombrePad,iso-8859-1);
$nombreMadre=$value->nombreMad;//htmlentities($value->nombreMad,iso-8859-1);
$propietarios=$value->propietarios;// htmlentities($value->propietarios,iso-8859-1);
$criadores=$value->criadores;//htmlentities($value->criadores,iso-8859-1)
$nombrePelaje=$value->nombrePelaje;//htmlentities($value->nombrePelaje,iso-8859-1)

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_A ,$value->codigo);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_B , $value->prefijo);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_C , $nombreEjemplar);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_D , $value->fecNace);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_E , $value->fecReg);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_F , $value->idPadre);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_G , $value->prefijoPad);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_H , $nombrePadre); 
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_I , $value->idMadre);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_J , $value->prefijoMad);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_K , $nombreMadre);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_L , $propietarios);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_M , $criadores);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_N , $value->fecFallece);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_O , $nombrePelaje);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_P , $value->LugarNace);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_Q , $value->microchip);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_R , $value->adn);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_S , $value->capado);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_T , $value->estado);
 
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

 