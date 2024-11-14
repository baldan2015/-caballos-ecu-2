<?php
include_once "../logica/LogLogica.php";
$servicioLog=new LogLogica();
$validate=$servicioLog->ExisteSessionId($key);
$retorno= new stdClass();
$retorno->result=0;
$retorno->token='';
$retorno->mensaje="No se pudo generar el token de acceso. Intente nuevamente o comuníquese con el administrador del sistema.";
if($validate){
   	$tokenGenerator= Auth::SignIn(['id' => $key]);
	$retorno->result=1;
	$retorno->token=$tokenGenerator;
	$retorno->mensaje='OK';
}
echo json_encode($retorno);