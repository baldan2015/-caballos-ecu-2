<tr>
<td style='background:#d3d3d3; height:40px;'  >
<div class='div-tabla'>
		<div class='div-fila'>
			<div class='div-columna'>
				&nbsp;&nbsp;<a  href="form1.php" title='FORMULARIO 1: ACTUALIZACIÓN EJEMPLARES DE MI PROPIEDAD'>1. Mi Propiedad </a>
				&nbsp;&nbsp;
			</div>
			<div class='div-columna'>
				<a href="form2.php" title='FORMULARIO N° 2: REGISTRO DE NACIMIENTOS'>2. Nacimientos</a>
				&nbsp;&nbsp;
			</div>
			<div class='div-columna'>
				<a href="form3.php" title='FORMULARIO N° 3: RELACIÓN DE YEGUAS DE MI PROPIEDAD Y VIENTRES CEDIDOS A MI FAVOR SERVIDAS'>3. Servicios de Yeguas</a>
				&nbsp;&nbsp;
			</div>
			<div class='div-columna'>
				<a href="form4.php" title='FORMULARIO N° 4: RELACIÓN DE SERVICIOS EFECTUADOS POR MIS POTROS Y POTROS DE TERCEROS BAJO MI RESPONSABILIDAD A YEGUAS DE TERCEROS'>4. Servicios de Potros</a>
				&nbsp;&nbsp;
			</div>
			<div class='div-columna'>
				<a href="form7.php" title='FORMULARIO N° 5:   MUERTE DE EJEMPLARES'>5. Muerte de Ejemplares</a>
				&nbsp;&nbsp;
			</div>
			<div class='div-columna'>
				<a href="form6.php" title='FORMULARIO N° 6: DE CESIÓN DE VIENTRES Y PRESTAMOS DE POTROS '>6. Prestamo de Ejemplares</a>
				&nbsp;&nbsp;
			</div>
			<div class='div-columna'>
				<a href="form5.php" title='FORMULARIO N° 7: ADQUISICONES Y TRANSFERENCIAS'>7. Adquisi&oacute;n y Transferencias</a>
				&nbsp;&nbsp;
			</div>		
			<div class='div-columna'>
				<a href="form8.php" title='FORMULARIO N° 8: CASTRACIONES DE EJEMPLARES'>8. Castraciones</a>
				&nbsp;&nbsp;
			</div>			

			
		</div>
</div>
					
				<div style=" position: relative;float:right; margin-top:-60px;">
				<label id='btnFinalizarPOE'  class='cursor' title='Finalizar el registro de los formularios del parte de ocurrencias.'>
				<div style='margin-top:-20px;'>
				 
					<img src="img/btnSend.png"    /> 
				 	
				</div>
				<div style=' margin-top:-40px; marging-left:80px;color:white;font-size:14px;font-weight:bold;'>
				&nbsp;&nbsp;&nbsp;Finalizar y Enviar Formularios 
				</div>									
				</label>
				</div>
				
				

</td>
</tr>
<tr>
<td style='background:#d3d3d3;' >
	<hr/>
	</td>
</tr>

<script>
$(function(){

//$("#btnFinalizarPOE").hide();
$("#btnFinalizarPOE").on("click",function(){

	if(evaluarModoVigenciaPOE($("#hidVigencia").val(),$("#hidAnioPer").val())){
	
	alertify.confirm("Esta acción envía la información registrada de todos los formularios del parte de ocurrencias a la asociación. Posterior a esta acción ud no podrá actualizar dicha información. ¿Está seguro de enviar los datos registrados?", function (e) {
		if (e) {

			$.ajax({
				data:  {alt:'get'},
				url:   'ajaxPOE/ajaxEnvio.php',
				type:  'post',
				success:  function (response) {
			
				  if(response==1){
					alertify.alert("Ud ya finalizó y envió la información del parte de ocurrencias.");

				  }else{
							$.ajax({
								data:  {opc:'dll'},
								url:   'ajaxPOE/ajaxEnvio.php',
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

		$.ajax({
				data:  {opc:'lstView',idPoe:idPoe,idProp:idUser},
				url:   'ajaxPOE/ajaxFormulario1.php',
				type:  'post',
				success:  function (response) {
				    var reporte = window.open('','1456621267083','width=700,height=650,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');
				    reporte.document.write("<div id='xresult'></div>");
				    var result_display = reporte.document.getElementById('xresult');
    				result_display.innerHTML = response;
    				reporte.focus();
					//reporte.document.write(response);
				}
		});

		
}
if(idForm==2){
			$.ajax({
				data:  {opc:'lstView',idPoe:idPoe,idProp:idUser},
				url:   'ajaxPOE/ajaxFormulario2.php',
				type:  'post',
				success:  function (response) {
				     var reporte = window.open('','1445561267083','width=800,height=500,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');
				    reporte.document.write("<div id='xresult'></div>");
				    var result_display = reporte.document.getElementById('xresult');
    				result_display.innerHTML = response;
    				reporte.focus();   
					//reporte.document.write(response);
				     
				}
		});
}
if(idForm==3){
			$.ajax({
				data:  {opc:'lstView',idPoe:idPoe,idProp:idUser},
				url:   'ajaxPOE/ajaxFormulario3.php',
				type:  'post',
				success:  function (response) {
				     var reporte = window.open('','','width=1000,height=400,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');
				    reporte.document.write("<div id='xresult'></div>");
				    var result_display = reporte.document.getElementById('xresult');
    				result_display.innerHTML = response;
					reporte.focus();
				     
				}
		});
}
if(idForm==4){
			$.ajax({
				data:  {opc:'lstView',idPoe:idPoe,idProp:idUser},
				url:   'ajaxPOE/ajaxFormulario4.php',
				type:  'post',
				success:  function (response) {
				     var reporte = window.open('','','width=1000,height=400,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');
				    reporte.document.write("<div id='xresult'></div>");
				    var result_display = reporte.document.getElementById('xresult');
    				result_display.innerHTML = response;
					reporte.focus();
				     
				}
		});
}

if(idForm==5){
			$.ajax({
				data:  {opc:'lstView',idPoe:idPoe,idProp:idUser},
				url:   'ajaxPOE/ajaxFormulario5.php',
				type:  'post',
				success:  function (response) {
				     var reporte = window.open('','','width=1000,height=500,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');
				    reporte.document.write("<div id='xresult'></div>");
				    var result_display = reporte.document.getElementById('xresult');
    				result_display.innerHTML = response;
					reporte.focus();
				     
				}
		});
}
if(idForm==6){
			$.ajax({
				data:  {opc:'lstView',idPoe:idPoe,idProp:idUser},
				url:   'ajaxPOE/ajaxFormulario6.php',
				type:  'post',
				success:  function (response) {
				     var reporte = window.open('','','width=1000,height=500,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');
				    reporte.document.write("<div id='xresult'></div>");
				    var result_display = reporte.document.getElementById('xresult');
    				result_display.innerHTML = response;
					reporte.focus();
				     
				}
		});
}
if(idForm==7){
			$.ajax({
				data:  {opc:'lstView',idPoe:idPoe,idProp:idUser,tipo:tipo},
				url:   'ajaxPOE/ajaxFormulario7.php',
				type:  'post',
				success:  function (response) {
				     var reporte = window.open('','','width=700,height=500,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=0,left=0,top=0');
				    reporte.document.write("<div id='xresult'></div>");
				    var result_display = reporte.document.getElementById('xresult');
    				result_display.innerHTML = response;
					reporte.focus();
				     
				}
		});
}


return false; 
 
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

