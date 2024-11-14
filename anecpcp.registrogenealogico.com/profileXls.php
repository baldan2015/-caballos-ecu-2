<?php  session_start();
   require("Clases/conexion.php");
  

  $cn=new Connection();
  $link=$cn->Conectar();
/*
require("../../entidad/Constantes.php");
require("../../comunes/lib.comun.php");*/
 if(!isset($_SESSION['xid'])) 
 die("<center><br><br><br><span style='color:#000; font-weight:bold;'>La sesión ha finalizado  --> </span><a href='../../login.php' style='color:gray; font-weight:bold;' >Ir a realizar login</a></center> ");
      

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
require_once   'libs/PHPExcel-1.8/Classes/PHPExcel.php';

   
      
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
            ->setCellValue('D1', 'PELAJE')
            ->setCellValue('E1', 'FEC. NAC.')
            ->setCellValue('F1', 'ESTADO')
            ->setCellValue('G1', 'CRIADOR')
            ->setCellValue('H1', 'ID. PADRE')
            ->setCellValue('I1', 'PREF. PADRE.')
            ->setCellValue('J1', 'PADRE')
            ->setCellValue('K1', 'ID. MADRE')
            ->setCellValue('L1', 'PREF. MADRE')
            ->setCellValue('M1', 'MADRE')
            ->setCellValue('N1', 'ADN');
 
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

$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->applyFromArray($styleArray);

      $idEntidad=$_SESSION['xid'];
       $sql = " 
          SELECT 0 as id, a.codigo  AS codigo, a.prefij  AS prefijo, a.nombre  as nombre,pelaje,
          DATE_FORMAT(fecnac, '%d/%m/%Y') fecnac,fallec,criador,
          codpad,prefpa,nompad,
          codmad,prefma,nommad,
          genero,fecnac xfecnac,adn_horse

           FROM datos220206 a
              WHERE 
              a.cod_propie  =(SELECT idProp FROM sge_propietario WHERE idEntidad=$idEntidad AND flgTipo!='C' limit 0,1)  
              order by codigo
          ";  
       
    mysqli_query($link,'SET NAMES iso-8859-1');
    mysqli_query($link,'SET CHARACTER_SET iso-8859-1');
    $result = mysqli_query($link,$sql);
    $fila=1;
     $I=2;
 
    while($res = mysqli_fetch_array($result)){
        if( $res['fallec']==1) $status="Fallecido"; else $status="Vivo";

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
 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_A ,$res['codigo']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_B ,$res['prefijo'] );
        $ejemplar=$res['nombre'];// htmlentities($res['nombre'],iso-8859-1) 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_C ,$ejemplar);
        $pelaje=$res['pelaje'];// htmlentities($res['pelaje'],iso-8859-1) 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_D ,$pelaje);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_E ,$res['fecnac'] );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_F ,$status );
        $criador=$res['criador'];//htmlentities($res['criador'],iso-8859-1) 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_G , $criador);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_H ,$res['codpad'] );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_I ,$res['prefpa'] );
        $papa=$res['nompad'];//htmlentities($res['nompad'],iso-8859-1) 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_J ,$papa);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_K ,$res['codmad'] );
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_L ,$res['prefma'] );
        $madre=$res['nommad'];//htmlentities($res['nommad'],iso-8859-1) 
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_M ,$madre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($COL_N ,$res['adn_horse']);

        $I++;
      
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
 

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$fechaActual = date("d-m-Y");

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="MISEJEMPLARES-'.$fechaActual.'.xls"');
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

 