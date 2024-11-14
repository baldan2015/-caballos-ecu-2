<?
global $link;
//require(DIR_DATABASE);
if (file_exists(DIR_DATABASE)) include_once(DIR_DATABASE);
if (file_exists(DIR_LEVEL_MOD_POE.DIR_DATABASE)) include_once(DIR_LEVEL_MOD_POE.DIR_DATABASE);

 

$cn=new Connection();
$link=$cn->Conectar();


?>