<nav class="navbar navbar-default">
  <div class="container-fluid">
   <div class="navbar-header">
      <a class="navbar-brand" href="#" style=" font-size: 12px;"><b>REPORTES OCURRENCIA: PERIODO <?=$periodo?> </b></a>
    </div>
    <ul class="nav navbar-nav">
 <li class="<?=$activo1?>"> <a href="form1.php"  title='FORMULARIO: ACTUALIZACIÓN EJEMPLARES DE MI PROPIEDAD'><span class="glyphicon glyphicon-knight"></span> Mi Propiedad </a></li>
 <li class="<?=$activo2?>"><a href="form2.php"   title='FORMULARIO: REGISTRO DE NACIMIENTOS'>Nacimientos</a></li>
 <li class="<?=$activo7?>"><a href="form7.php"  title='FORMULARIO:   MUERTE DE EJEMPLARES'> Muertes</a></li>
 <li class="<?=$activo8?>"><a href="form8.php"   title='FORMULARIO: CASTRACIONES DE EJEMPLARES'>Castraciones</a></li>
 <li class="<?=$activo5?>"><a href="form5.php"   title='FORMULARIO:TRANSFERENCIAS'> Transferencias </a></li>

 <li class="<?=$activo3?>"><a href="form3.php"  title='FORMULARIO N° 3: RELACIÓN DE YEGUAS DE MI PROPIEDAD Y VIENTRES CEDIDOS A MI FAVOR SERVIDAS'>Servicios de Yeguas</a></li>
 <li class="<?=$activo4?>"><a href="form4.php"  title='FORMULARIO N° 4: RELACIÓN DE SERVICIOS EFECTUADOS POR MIS POTROS Y POTROS DE TERCEROS BAJO MI RESPONSABILIDAD A YEGUAS DE TERCEROS'>Servicios de Potros</a></li>

   <!--<li><a href="form6.php" title='FORMULARIO N° 6: DE CESIÓN DE VIENTRES Y PRESTAMOS DE POTROS '>6. Prestamo de Ejemplares</a> </li>
 
  <li class="<?=$activo9?>"><a href="form9.php"   title='INSCRIPCIÓN DE NUEVOS EJEMPLARES'>INSCRIPCIÓN </a></li>
background-color: #7FBF00;

-->


    </ul>

    <ul class="nav navbar-nav navbar-right  bg-danger">
      
        <li class="dropdown   ">
          <a href="#"   class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
          	<span class="glyphicon glyphicon-ok"></span>
          	PROCESAR <span class="caret"></span></a>
          <ul class="dropdown-menu bg-danger">
            <li><a href="#" id='btnFinalizarPOE' class="bg-danger"><B>FINALIZAR Y ENVIAR FORMULARIOS</B></a></li>
            
          </ul>
        </li>
      </ul>
  </div>
</nav>
<!--
<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-1'>
				&nbsp;&nbsp;<a  href="form1.php" title='FORMULARIO 1: ACTUALIZACIÓN EJEMPLARES DE MI PROPIEDAD'>1. Mi Propiedad </a>
				&nbsp;&nbsp;
			</div>
			<div class='col-md-1'>
				<a href="form2.php" title='FORMULARIO N° 2: REGISTRO DE NACIMIENTOS'>2. Nacimientos</a>
				&nbsp;&nbsp;
			</div>
			<div class='col-md-2'>
				<a href="form3.php" title='FORMULARIO N° 3: RELACIÓN DE YEGUAS DE MI PROPIEDAD Y VIENTRES CEDIDOS A MI FAVOR SERVIDAS'>3. Servicios de Yeguas</a>
				&nbsp;&nbsp;
			</div>
			<div class='col-md-2'>
				<a href="form4.php" title='FORMULARIO N° 4: RELACIÓN DE SERVICIOS EFECTUADOS POR MIS POTROS Y POTROS DE TERCEROS BAJO MI RESPONSABILIDAD A YEGUAS DE TERCEROS'>4. Servicios de Potros</a>
				&nbsp;&nbsp;
			</div>
			<div class='col-md-2'>
				<a href="form7.php" title='FORMULARIO N° 5:   MUERTE DE EJEMPLARES'>5. Muerte de Ejemplares</a>
				&nbsp;&nbsp;
			</div>
			 <div class='div-columna'>
				<a href="form6.php" title='FORMULARIO N° 6: DE CESIÓN DE VIENTRES Y PRESTAMOS DE POTROS '>6. Prestamo de Ejemplares</a>
				&nbsp;&nbsp;
			</div> 
			<div class='col-md-2'>
				<a href="form5.php" title='FORMULARIO N° 7: ADQUISICONES Y TRANSFERENCIAS'>7. Adquisi&oacute;n y Transferencias</a>
				&nbsp;&nbsp;
			</div>		
			<div class='col-md-2'>
				<a href="form8.php" title='FORMULARIO N° 8: CASTRACIONES DE EJEMPLARES'>8. Castraciones</a>
				&nbsp;&nbsp;
			</div>			

			
		</div>
</div>-->
				<!--	
				<div style=" position: relative;float:right; margin-top:-100px;">
				<label id='btnFinalizarPOE'  class='cursor' title='Finalizar el registro de los formularios del parte de ocurrencias.'>
				<div style='margin-top:-20px;'>
				 
					<img src="<?=DIR_LEVEL_MOD_POE?>img/btnSend.png"    /> 
				 	
				</div>
				<div style=' margin-top:-40px; marging-left:80px;color:white;font-size:14px;font-weight:bold;'>
				&nbsp;&nbsp;&nbsp;Finalizar y Enviar Formularios 
				</div>									
				</label>
				</div>
			-->
				
		
		<!--		

</td>
</tr>
<tr>
<td style='background:#d3d3d3;' >
	<hr/>
	</td>
</tr>
-->
<script>
$(function(){

//$("#btnFinalizarPOE").hide();
$("#btnFinalizarPOE").on("click",function(){

	if(evaluarModoVigenciaPOE($("#hidVigencia").val(),$("#hidAnioPer").val())){
	
	alertify.confirm("Esta acción envía la información registrada de todos los formularios del parte de ocurrencias a la asociación. Posterior a esta acción ud no podrá actualizar dicha información. ¿Está seguro de enviar los datos registrados?", function (e) {
		if (e) {

			$.ajax({
				data:  {alt:'get'},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxEnvio.php',
				type:  'post',
				success:  function (response) {
			
				  if(response==1){
					alertify.alert("Ud ya finalizó y envió la información del parte de ocurrencias.");

				  }else{
							$.ajax({
								data:  {opc:'dll'},
								url:   K_PATH_ROOT+'ajaxPOE/ajaxEnvio.php',
								type:  'post',
								success:  function (response) {
								     
										if(response==1){
											alertify.alert("Parte de ocurrencias finalizado y enviado correctamente.");
											setTimeout(function(){location.reload();},3000);//location.href="form1.php";
										}     
									}
							});
				  }
				}
			});
		}
	});
 }
});



});
function viewForm(idForm,idUser,idPoe,tipo){

var response="";
if(idForm==1){
//K_PATH_ROOT+'ajaxPOE/ajaxFormulario1.php?opc=lstView&idPoe='+idPoe+'&idProp='+idUser
		$.ajax({
				data:  {opc:'lstView',idPoe:idPoe,idProp:idUser},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario1.php',
				type:  'post',
				success:  function (response) {
					printRpt(response,700,650);
				}
		});

		
}
if(idForm==2){
			$.ajax({
				data:  {opc:'lstView',idPoe:idPoe,idProp:idUser},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario2.php',
				type:  'post',
				success:  function (response) {
					printRpt(response,800,500);
				     
				     
				}
		});
}
if(idForm==3){
			$.ajax({
				data:  {opc:'lstView',idPoe:idPoe,idProp:idUser},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario3.php',
				type:  'post',
				success:  function (response) {
					printRpt(response,1000,400);
				     
				     
				}
		});
}
if(idForm==4){
			$.ajax({
				data:  {opc:'lstView',idPoe:idPoe,idProp:idUser},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario4.php',
				type:  'post',
				success:  function (response) {
					printRpt(response,1000,400);
				     
				     
				}
		});
}

if(idForm==5){
			$.ajax({
				data:  {opc:'lstView',idPoe:idPoe,idProp:idUser},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario5.php',
				type:  'post',
				success:  function (response) {
					printRpt(response,1000,500);
				}
		});
}
if(idForm==6){
			$.ajax({
				data:  {opc:'lstView',idPoe:idPoe,idProp:idUser},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario6.php',
				type:  'post',
				success:  function (response) {
				    printRpt(response,1000,500);
				     
				}
		});
}
if(idForm==7){
			$.ajax({
				data:  {opc:'lstView',idPoe:idPoe,idProp:idUser,tipo:tipo},
				url:   K_PATH_ROOT+'ajaxPOE/ajaxFormulario7.php',
				type:  'post',
				success:  function (response) {
					printRpt(response,700,500);
				     
				     
				}
		});
}


return false; 
 
} 
function printRpt(response,iwidth,iheight){
	  var reporte = window.open('vista/formRpt.php','1456621267083','width='+iwidth+',height='+iheight+',toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');
				    reporte.document.write("<div id='xresult'>"+response+"</div>");
				    var lnk=reporte.document.getElementById("lnkPrint");
				    if(lnk!=null) lnk.style.display='none';
					reporte.print();
    				reporte.focus();
}
function evaluarModoVigenciaPOE_Grilla(obj,vigencia,periodo){

	if(vigencia=="1"){
				if($("#hidModoLectura").val()=="S"){
     	 				$(obj).on("click",function(){
     							 alertify.error("Parte de Ocurrencia "+periodo+"  es sólo de lectura.");
     						 });
     	 				return false;
			}else{
				     return true;		 
			}
	}else{
		$(obj).on("click",function(){
     							 alertify.error("Parte de Ocurrencia "+periodo+"  no se encuentra vigente.");
     						 });
		return false;
	}
}
function evaluarModoVigenciaPOE(vigencia,periodo){

	if(vigencia=="1"){
				if($("#hidModoLectura").val()=="S"){
						alertify.error("Parte de Ocurrencia "+periodo+"  es sólo de lectura.");
    	 				return false;
			}else{
				     return true;		 
			}
	}else{
					 alertify.error("Parte de Ocurrencia "+periodo+"  no se encuentra vigente.");
					return false;
	}
}
</script>

