<?




function sp_affected_rows($cadena,$link)
{
$rs=mysql_query($cadena,$link)or die("error al Actualizar".mysql_error($link));
return $rs;
}


function sp_insert_row($cadena,$link)
{
$rs=mysql_query($cadena,$link)or die("error al insertar ".mysql_error($link));
return $rs;
}

function sp_query_fetch_array($cadena,$link)
{
$rs=mysql_query($cadena,$link)or die("error al consultar ".mysql_error($link));
$n=mysql_num_rows($rs);
	if($n>0)
	{
	$rs_array=mysqli_fetch_array($rs);
	}
	else
	{
	$rs_array="0";
	}

return $rs_array;
}

function sp_query_result($cadena,$link)
{
$rs=mysql_query($cadena,$link)or die("error al insertar ".mysql_error($link));

return $rs;
}
function sp_num_rows($rs)
{
$n=mysql_num_rows($rs);
return $n; }

?>