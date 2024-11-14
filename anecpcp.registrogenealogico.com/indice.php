<?PHP session_start();
require("constante.php");
require(DIR_CABECERA);
require(DIR_VALIDAR);

if(ValidarSession())
	{?>
 
<link href="styles/menu2.css" rel="stylesheet">
<link rel="stylesheet" href="styles/styles.css">
<!--<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>-->
  
<link href="scripts/jquery-ui-1.11.4.custom.green/jquery-ui.css" rel="stylesheet">
<script src="scripts/jquery-ui-1.11.4.custom.green/external/jquery/jquery.js"></script>
<script src="scripts/jquery-ui-1.11.4.custom.green/jquery-ui.js"></script>

<link href="admin/scripts/alerts/themes/alertify.core.css" rel="stylesheet"/>
<link href="admin/scripts/alerts/themes/alertify.bootstrap.css" rel="stylesheet"/>
<script src="admin/scripts/alerts/lib/alertify.min.js"></script>
<link rel="stylesheet" type="text/css" href="modules/poe/libs/datatables-1.10.23/datatables.min.css" />
	<script type="text/javascript" src="modules/poe/libs/datatables-1.10.23/datatables.min.js"></script>



 <script src="scripts/script.js"></script>

<script src="scripts/proceso.js"></script>
 <script src="libs/bootstrap-3.3.7/js/bootstrap.js"></script>
  <link href="libs/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet"/> 
<?
	echo"<tr><td colspan=2 valign=top >";
	echo "<div class='non-printable'>";
 	require(DIR_REGGENEALOGICO);
	echo "<div>";
	echo"</td></tr>";
	}
else
	{
  	if(isset($_SESSION['xstatus']))
	{
		if($_SESSION['xstatus']==0)
		{
		$message="Su Cuenta esta Desactivada !&nbsp;&nbsp;<img src='img/s_status.png'>";
		}
		else
		{
		
		if($_SESSION['xstatus']==-1)
		{$message="Error ! Usuario no existe !&nbsp;&nbsp;<img src='img/b_usrdrop.png'>";	}
		
		}
	}
?>
<tr ROWSPAN=0>
<td align=center colspan=2   height=50>
 
</td>
</TR>
<?

require(DIR_LOGIN);
 
}
if(!isset($_SESSION['cc'])){
$_SESSION['cc']=0;
}else{
$_SESSION['cc']=$_SESSION['cc']+1;
}
  
?>
 
<?PHP //require DIR_PIEPAGINA;?>
</table>
<script>
function datos(){
var vent;
vent=open("restaura.php","vent","menubar=0,height=130,width=300,top=240,left=250,status=1");
}

//alertify.alert("<img src='images/banner/nuevaOpcion.png' style='width:100%;' />");
$(function(){

<?
//if($_SESSION['cc']==0){
	?>
/*alertify.confirm("<img src='images/banner/nuevaOpcion.png' style='width:100%;' />", function (e) {
    if (e) {
        window.location.href="reporteGenPer.php";
    } else {
        // user clicked "cancel"
    }

}); 
$("#alertify-ok").html("IR AL SIMULADOR");
$("#alertify-cancel").html("CERRAR");*/
<?
//}
?>
});

</script>
<style>

.paginador{

 cursor: pointer; cursor: hand; 
}
.alertify-button-ok, .alertify-button-ok:hover, .alertify-button-ok:focus, .alertify-button-ok:active {
    text-shadow: 0 -1px 0 rgba(0,0,0,.25);
    background-color: #5cb85c;
    border: 1px solid #4cae4c;
    border-color: #4cae4c #4cae4c #002A80;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #FFF;
    font-weight: bold;
}
#gridConcurso tbody tr td{
			text-transform:uppercase;
		}
</style>