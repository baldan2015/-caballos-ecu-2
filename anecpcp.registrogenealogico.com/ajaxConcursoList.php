<?php //header('Content-type: application/json; charset=utf-8'); 
require("constante.php");
require(DIR_FUNCTION."conectar.php");
require(DIR_FUNCTION."queries.php");
require(DIR_FUNCTION."general.php");

require("Clases/resultado.php");
$jsondata = array();
$data=ConcursoItems($link);
//$data2=ConcursoInscripcion($link);
//echo "<pre>";print_r($data);
$retorno= new Resultado();
$retorno->data = $data;
$retorno->result = 1;

  echo json_encode($retorno);
    //exit(); 
?>