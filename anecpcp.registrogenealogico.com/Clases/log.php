<?
class Log extends Connection
{
var $user;
var $pwd;
var $basedatos;
var $host;
var $linker;
	function Log()
	{

		$cn=new Connection();
		$this->linker=$cn->Conectar();		

	}

     function registrarLog($id_usu,$nom_ape)
	{
	   date_default_timezone_set("UTC");
	   $fecha= date("Y-m-d H:i:s"); 
	   $ipc=getenv(REMOTE_ADDR);
   	   $nom_ape=str_replace(",","",$nom_ape);
	   $sql="insert into log(idusu,nomape,ipcliente,fecini,fecfin,idSession) values('$id_usu','$nom_ape','$ipc','$fecha','$fecha','".session_id()."')";	
	   $r=mysqli_query($this->linker,$sql)or die("error ".mysqli_error($this->linker));
           //$this->link;
	}
}
?>