<?

class Connection
{
var $user;
var $pwd;
var $basedatos;
var $host;
var $link;
	function Connection()
	{
$this->user="dbalviss_test";
	
$this->pwd="Caballos2021F2";
	
$this->basedatos="dbalviss_registro_fase_2";
	
$this->host="localhost";

	
	
		
	}
	function Conectar()
	{
	$this->link=mysql_connect($this->host,$this->user,$this->pwd) or die("error en la conexion ".mysql_error());
 //mysql_query('SET NAMES iso-8859-1');
	//mysql_query('SET CHARACTER_SET iso-8859-1');
   	mysql_select_db($this->basedatos,$this->link)or die("error de seleccion de db ".mysql_error($this->link));
	if(!($valor))
		{
		return $this->link;
		}
       else
		{	return -1;		}
	
	}

}






?>