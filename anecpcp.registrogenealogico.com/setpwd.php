</tr><tr><td height=50 colspan=2 valign=middle><b>
<center>Cambios de Datos para el Usuario en el  Inicio de sesi&oacute;n </center>
</td></tr>

<tr><td colspan=2 align=center>
<table border=0 width=60% style='font-size:10px;'>
<th colspan=2   style='background-image:url(img/tbl_header.png);color:white'>Edici&oacute;n de datos.</th>
<tr><td align=right colspan=2 style='font-size:10px;color:red;'>M&aacute;ximo  10 caracteres</td></tr>
<tr><td align=left>
Ingrese su Contrase&ntilde;a actual 
</td>
<td>
<input type=password name="txtpwd1" value=''>
</td></tr>

<tr>
  <td align=left>Nuevo nombre de inicio de sesi&oacute;n </td>
<td>
  <input name="txtsesion" type="text" id="txtsesion">
</td></tr>
<tr>
  <td align=left> Ingrese su Nueva contrase&ntilde;a </td>
  <td><input type=password name="txtpwd2" value=''></td>
</tr>

<tr><td align=left>
Confirme su Nueva Contrase&ntilde;a 
</td>
<td>
<input type=password name="txtpwd3" value=''>
</td></tr>


<tr><td align=center colspan=2 height=50><hr>

<input type=button  name="b3" value="Aceptar" class="b1" onclick="validar()">

<input type=reset  name="b2" value='Cancelar' class="b1">

</td></tr>
<tr><td align=center colspan=2 height=50>
<span style='color:darkred;font-size:10px;'>Su nueva contrase&ntilde;a tendra efecto cuando cierre esta sesi&oacute;n e inicie una nueva ! 
</td></tr>
</table>
</td></tr>
</table>
</form>



<script language="javascript">
function validar()
{
sesion=document.Form1.txtsesion.value;
pwdactual=document.Form1.txtpwd1.value;
pwdneo=document.Form1.txtpwd2.value;
pwdneo2=document.Form1.txtpwd3.value;
if(pwdactual!="" || pwdneo!="" || pwdneo2!="" || sesion!="")
{
n1=parseInt(pwdactual.length);
n2=parseInt(pwdneo.length);
n3=parseInt(pwdneo2.length);
n4=parseInt(sesion.length);

  if(n1 <=10 && n2 <=10 && n3<=10 && n4<=10)
	{	
	 if(document.Form1.txtpwd2.value==document.Form1.txtpwd3.value)
	 {
	 document.Form1.submit();
	 }
	else
	{	alert("Error ! \n La confimación de la nueva contraseña no coincide con la nueva contraseña. ");}
   }
   else
   {alert("Máximo número de caracteres 10 !")}
}
else
{
alert("Todos los campos son obligatorios !\nIngrese datos necesarios. ");
}
}
</script>