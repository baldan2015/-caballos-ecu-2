<? function validar($clave='',$usu='')
{
$cn=new Connection();
$link=$cn->Conectar();

//$sql="select * from ".TABLE_USER." where pwd_usu='$usu' and nom_sesion_usu='$clave'";
//$sql="select id, razonSocial,flagSituacion estado from  sge_entidad where password=AES_ENCRYPT('$usu','TEON') and login='$clave'";
//$sql="select id,razonSocial,flagSituacion estado,COALESCE(p.idProp,0)idProp FROM sge_entidad e LEFT JOIN sge_propietario p on p.IdEntidad=e.id where login='$clave' and password=AES_ENCRYPT('$usu','TEON') and flgTipo!='C' ;";
 
 
$sql="
SELECT * FROM 
(
SELECT id,razonSocial,flagSituacion estado,COALESCE(p.idProp,0)idProp,'A' flgTipo 
FROM sge_entidad e 
LEFT JOIN sge_propietario p on p.IdEntidad=e.id where login='$clave' and password=AES_ENCRYPT('$usu','TEON') 
 and (flgTipo!='C'  or flgTipo is null)
union all
SELECT   DISTINCT p.idProp, SGEFN_PROPIETARIOS_X_ID(p.idProp) razonSocial,
( 
 select 
 if(count(1)>0,'A','I') Estado 
  from sge_entidad where id in(  select IdEntidad from sge_propietario where  idProp= 9178 )
 and flagSituacion='A'
 ) flagSituacion

,p.idProp ,flgTipo 
from sge_propietario p
inner join sge_entidad e on e.id=p.IdEntidad
where Idprop in(
				SELECT  idProp 
				FROM sge_entidad e 
				LEFT JOIN sge_propietario p on p.IdEntidad=e.id where login='$clave' and password=AES_ENCRYPT('$usu','TEON') 
				 and flgTipo='C' 
                 )
                 ) q
                 where id is not null 
                 and estado='A'
                 order by flgTipo asc
";

   //echo $sql;  


$rs=mysqli_query($link,$sql)or die("error al consultar usuario ".mysqli_error($link));
$n=mysqli_num_rows($rs);

//echo "numero de registro...".$n;

$usuarios=[];
if($n>0){
	while($row = mysqli_fetch_assoc($rs)){
			/*$usuario1=$row["razonSocial"];  
			$cod_doc=$row["idProp"];
			$estado=$row["estado"];*/
			//$usuario=$usuario1."/".$cod_doc."/".$estado;
			$usuario=new stdClass();
			$usuario->razonSocial=$row["razonSocial"]; ;
			$usuario->idPropietario=$row["idProp"];
			$usuario->estado=$row["estado"];
 			$usuario->flgTipo=$row["flgTipo"];
			$usuario->id=$row["id"];
			$usuarios[]=$usuario;
	}

	}


mysqli_close($link);
return $usuarios;

}	



function ValidarSession($param='')
{

if(!(isset($_SESSION['xusu'])))
	{
	$retorno=false;
	}
else
	{  
		if($_SESSION['xusu']=="Desconocido")
		{
			$retorno=false;
		}
		else
		{
			//if($_SESSION['xstatus']==1)	
			 		$retorno=true;
			//   else
		        //   $retorno=false;	   
		}
	}

return $retorno;

}






?>