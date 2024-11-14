<link href="style1.css" rel="stylesheet" type="text/css">
<form name="f1" action="search.php" method="post">
<table width=100%  border=0 style='font-size:10px;' bgcolor=white>
<tr><td style='color:red;'>Los datos para el acceso al sistema ser&aacute;n enviados a su cuenta de correo .
</td><tr>
<tr><td>Ingrese su Correo Electr&oacute;nico</td><tr>

<tr><td><input type=text name="txtcorreo" size=50 style='font-size:10px;'></td><tr>
<tr><td align=center><input type=button name="mail" onclick="validar()" value="enviar" ></td><tr>

</table>


</form>

<script>
function validar()
{
   if(document.f1.txtcorreo.value !="")
    {
	indx=document.f1.txtcorreo.value.indexOf("@");
	if(indx!=-1)
	{
		indx2=document.f1.txtcorreo.value.indexOf(".");	
		if(indx2!=-1)
		{
		document.f1.submit();
		}
		else
		{
		alert("direccion de correo no válida!");
		return false;
		}
	}
	else
	{
		alert("Dirección de correo no válida!");
		return false;
	}

   }
   else
	{alert("Ingrese correo!");}	

}
</script>
