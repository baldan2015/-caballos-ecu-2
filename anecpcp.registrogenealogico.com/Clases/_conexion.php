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
 		
$this->user="root";
	
$this->pwd="rootroot";
	
$this->basedatos="ecu_registro_sge";
	
$this->host="localhost";
 
		
	}
	function Conectar()
	{
	/*$this->link=mysql_connect($this->host,$this->user,$this->pwd) or die("error en la conexion ".mysql_error());
    //mysql_query('SET NAMES iso-8859-1');
	//mysql_query('SET CHARACTER_SET iso-8859-1');
		mysql_query('SET NAMES utf8');
		 mysql_query('SET CHARACTER_SET utf8');	
   	mysql_select_db($this->basedatos,$this->link)or die("error de seleccion de db ".mysql_error($this->link));
	if(!($valor))
		{
		return $this->link;
		}
       else
		{	return -1;		}
*/


	$this->link = new mysqli($this->host, $this->user, $this->pwd, $this->basedatos);
		mysqli_query($this->link,'SET NAMES utf8');
		mysqli_query($this->link,'SET CHARACTER_SET utf8');	
       if (mysqli_connect_errno()) {
            echo "Connection Failed: " . mysqli_connect_errno();
            exit();
        }
        return $this->link;
	
	}
	function Conectar2()
	{
	$this->link=mysql_connect($this->host,$this->user,$this->pwd) or die("error en la conexion ".mysql_error());
    //mysql_query('SET NAMES iso-8859-1');
	//mysql_query('SET CHARACTER_SET iso-8859-1');
		mysql_query('SET NAMES utf8');
		 mysql_query('SET CHARACTER_SET utf8');	
   	mysql_select_db($this->basedatos,$this->link)or die("error de seleccion de db ".mysql_error($this->link));
	if(!($valor))
		{
		return $this->link;
		}
       else
		{	return -1;		}
	
	}
	function ConectarMysqli()
	{
		// mysqli_query('SET NAMES utf8');
		// mysqli_query('SET CHARACTER_SET utf8');	
		$this->link = new mysqli($this->host, $this->user, $this->pwd, $this->basedatos);
       if (mysqli_connect_errno()) {
            echo "Connection Failed: " . mysqli_connect_errno();
            exit();
        }
        return $this->link;
	}
	 public function ejecutar2($sql,$param='') {

	 	 
        $db = $this->ConectarMysqli();
        $db->query('SET NAMES UTF8');
		$db->query('SET CHARACTER_SET UTF8');
		$db->query('SET SESSION sql_mode = "" '); 
        $resultado= $db->query($sql);
         if(strlen($param)>0){
               $output=" SELECT $param ";
                return $db->query($output);
         }else{
             return $resultado;
         }
    }

}
 



?>
