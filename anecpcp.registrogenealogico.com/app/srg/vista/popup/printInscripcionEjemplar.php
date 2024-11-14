

 <style type="text/css" media="screen">
  @media screen {
  #printSection {
      display: none;
  }
}
</style> 
<style type="text/css" media="print">
@media print {
  * {
    color-adjust: exact;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
    box-sizing: border-box
  }
  body * {
    background: #fff !important;
    visibility:hidden;
     -webkit-print-color-adjust:exact;
        -moz-print-color-adjust:exact;
        -ms-print-color-adjust:exact;
        print-color-adjust:exact;
  }
  #printSection, #printSection * {
    visibility:visible;
    -webkit-print-color-adjust: exact !important;
  }
  #printSection {
    -webkit-print-color-adjust: exact !important;
    position:absolute;
    left:0;
    top:0;
  }
td {
    -webkit-print-color-adjust: exact !important;
  background-color: #CD853F;
  }
}


 td {
    -webkit-print-color-adjust: exact !important;
  
  }
</style>
<div id="mvNuevoEjemplarPrintIns" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
  
  <div class="modal-dialog modal-lg">
    
    <!-- Modal Content: begins -->
    <div class="modal-content">
      
      <!-- Modal Header -->
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <button type="button" id="btnPrint" style="margin-left: 770px;" class="btn btn-primary"  onclick="imprimir()" aria-label="Close">Print</button>
         <!-- <button   type="button" id="btnPrint"  style="text-align: right;" data-dismiss="modal" class="btn btn-primary" onclick="imprimir()">Print</button>-->
          <h4 class="modal-title" id="gridSystemModalLabel">Solicitud de Inscripción</h4>
      </div>
   <!--<div id="printThis" >-->
      <!-- Modal Body -->  
      
      <div class="modal-body" >
        <div class="body-message">
          <div id="printThis" >
         <table style="width: 100%;">
           <tr >
             <td><label> <h2 style="font-weight: bold;text-align: center;padding-left: 150px;">SOLICITUD DE INSCRIPCIÓN </h2></label></td>
           </tr>
            <tr >
             <td><label> <h5 style="font-weight: bold;text-align: center;padding-left: 40px;">ASOCIACION NACIONAL DEL ECUADOR DE CRIADORES Y PROPIETARIOS DE CABALLOS DE PASO </h5>
             <h5 style="font-weight: bold;text-align: center;padding-left: 30px;">GUAYAQUIL - ECUADOR </h5>
              <h5 style="font-weight: bold;text-align: center;padding-left: 50px;">REGISTRO GENEALOGICO DEL CABALLO PERUANO DE PASO</h5></label>
             </td>
           </tr>
         </table><br>
         <table>
           <tr>
             <td><label>NOMBRE:___</label><label id="lblNombrePrint" style="text-decoration: underline;"></label><label>___________</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
             <td style="padding-left: 70px;"><label>FECHA:_____</label><label id="lblfechaCreaPrint" style="text-decoration: underline;"></label><label>_____________<label></td>
           </tr>
           <tr>
             <td><label>SEXO:______________</label><label id="lblSexoPrint"  style="text-decoration: underline;"></label><label>____</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
             <td style="padding-left: 70px;"><label>PELAJE:____________</label><label id="lblPelajePrint"  style="text-decoration: underline;"></label><label>_________</label></td>
           </tr>
           <tr>
             <td><label>FECHA DE NACIMIENTO:________</label><label id="lblFechaNacPrint" style="text-decoration: underline;"></label><label>_________</label></td>
             <td style="padding-left: 70px;"><label>REPORTE DE MONTA: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><labe>N° &nbsp;</labe><label id="lblCodigoMontaPrint" style="text-decoration: underline;"></label><label></label></td>
           </tr>
            <tr>
             <td><label>VALOR DE INSCRIPCIÓN:_______________</label><label id="lblValorInscripcion" style="text-decoration: underline;"></label><label>_________</label></td>
             <td style="padding-left: 70px;"><label>REPORTE DE NACIMIENTO: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><labe>N° &nbsp;</labe><label id="lblCodigoNacimientoPrint" style="text-decoration: underline;"></label><label></label></td>
           </tr>
            <tr>
             <td><label>PROPIETARIO:____</label><label id="lblPropPrint" style="text-decoration: underline;"></label></td>
             <td style="padding-left: 70px;"><label>REGISTRO DE CRIADOR N°:  &nbsp;</label><label id="lblIDCriadorPrint" style="text-decoration: underline;"></label>__________</td>
           </tr>
           <tr>
             <td><label>CRIADOR:____</label><label id="lblCriadorPrint" style="text-decoration: underline;"></label><label></label></td>
             <td style="padding-left: 70px;"><label>SOCIO N°:_____________</label><label id="lblSocioPrint"></label><label>____________</label></td>
           </tr>
           <tr>
             <td><label>DIRECCION:____________</label><label id="lblDireccionPrint"></label><label>___________________________</label></td>
             <td style="padding-left: 70px;"><label>LOCALIDAD:____</label><label id="lblLocalidadPrint" style="text-decoration: underline;"></label><label>_______</label></td>
           </tr>
           <tr>
             <td><label>2 FOTOS PERFIL DERECHO:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI &nbsp;</label><input type="text" style="width: 5%;" id="txtFotoPrint" disabled="true" /></td>
             <td style="padding-left: 70px;"><label>2 FOTOS PERFIL IZQUIERDO:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI &nbsp;</label><input type="text" style="width: 5%;" id="txtFotoPrint1" disabled="true" /></td>
           </tr>
         </table>
         <table style="width: 100%;">
           <tr style="border: 1px solid black;width: 100%;">
            <td style="border: 1px solid black;" height="280"> <h5 style="text-align: center;">IMAGEN</h5></td>
           </tr>
         </table>
         <table>
           <tr style="height: 20%;"> 
             <td style="padding-bottom: 15px;" ><label  >PADRE:&nbsp;</label><label id="lblPadrePrint" style="text-decoration: underline;"></label>&nbsp;<label>#Reg. &nbsp;&nbsp;</label><input type="text" name="" id="txtIdPadrePrint">&nbsp;&nbsp;</td>
             <td style="padding-bottom: 15px;padding-left: 100px;"  ><label  >PADRE:&nbsp;</label><label id="lblAbueloPadrePrint" style="text-decoration: underline;"></label>&nbsp;<label>#Reg.&nbsp;&nbsp;</label><input type="text" name="" id="txtIdAbueloPadrePrint"></td>
           </tr>
           <tr>
             <td style="padding-bottom: 15px;" ><label  >PELAJE:&nbsp;</label><label id="lblPelajePadrePrint" style="text-decoration: underline;"></label><label></label></td>
             <td  style="padding-bottom: 15px;padding-left: 100px;"><label  >MADRE:&nbsp;</label><label id="lblAbuelaPadrePrint" style="text-decoration: underline;"></label>&nbsp;<label>#Reg.&nbsp;&nbsp;</label><input type="text" name="" id="txtIdAbuelaPadrePrint"></td>
           </tr>
           <tr>
             <td  style="padding-bottom: 15px;"><label  >MADRE:&nbsp;</label><label id="lblMadrePrint" style="text-decoration: underline;"></label>&nbsp;<label>#Reg. &nbsp;&nbsp;</label><input type="text" name="" id="txtIdMadrePrint"></td>
             <td  style="padding-bottom: 15px;padding-left: 100px;"><label  >PADRE:&nbsp;</label><label id="lblAbueloMadrePrint" style="text-decoration: underline;"></label>&nbsp;<label>#Reg.&nbsp;&nbsp;</label><input type="text" name="" id="txtIdAbueloMadrePrint"></td>
           </tr>
           <tr>
             <td  style="padding-bottom: 15px;"><label  >PELAJE:&nbsp;</label><label id="lblPelajeMadrePrint" style="text-decoration: underline;"></label><label>____________________________</label></td>
             <td  style="padding-bottom: 15px;padding-left: 100px;"><label  >MADRE:&nbsp;</label><label id="lblAbuelaMadrePrint" style="text-decoration: underline;"></label>&nbsp;<label>#Reg.&nbsp;&nbsp;</label><input type="text" name="" id="txtIdAbuelaMadrePrint"></td>
           </tr>
           <tr style="width: 100%;">
             <td   colspan="2"><label  >RESEÑA:________</label><label id="lblReseñaPrint" style="text-decoration: underline;"></label><label>_____</label></td>
           </tr>
         </table>
         <table>
           <tr>
             <td  colspan="4"><label><h5 style="margin-bottom: 0px;">DIAS DE GESTACION:</h5></label></td>
           </tr>
           <tr style="width: 100%;height: 10px;">
             <td style="border: 1px solid black;width: 10%;height: 3px;" ><label  style="text-align: center;padding-left: 30PX;margin-bottom: 0px;">AD</label></td>
             <td style="border: 1px solid black;width: 40%;height: 3px;" ><label  ><h5></h5></label></td>
             <td style="border: 1px solid black;width: 10%;height: 3px;" ><label  style="text-align: center;padding-left: 30px;margin-bottom: 0px;" >PD</label></td>
             <td style="border: 1px solid black;width: 40%;height: 3px;" ><label  ><h5></h5></label></td>
           </tr>
           <tr style="width: 100%;">
             <td style="border: 1px solid black;width: 10%;height: 3px;" ><label  style="text-align: center;padding-left: 30PX;margin-bottom: 0px;">AI</label></td>
             <td style="border: 1px solid black;width: 40%;height: 3px;" ><label  ><h5></h5></label></td>
             <td style="border: 1px solid black;width: 10%;height: 3px;" ><label  style="text-align: center;padding-left: 30px;margin-bottom: 0px;" >PI</label></td>
             <td style="border: 1px solid black;width: 40%;height: 3px;" ><label  ><h5></h5></label></td>
           </tr>
         </table><br>
         <table>
           <tr>
             <td style="border: 1px solid black;width: 10%;text-align: center;" colspan="7"><label style="text-align: center;margin-bottom: 0px;">MODO REPRODUCTIVO UTILIZADO</label></td>
           </tr>
           <tr>
             <td style="border: 1px solid black;width: 3%;text-align: center;" id="tdMN"> <label style="margin-bottom: 50px; margin-bottom: 0px;" >MONTA NATURAL </label></td>
             <td style="border: 1px solid black;width: 3%;text-align: center;" colspan="4">
              <table style="width: 100%;height: 100%;">
                <tr>
                  <td style="text-align: center;" colspan="4"> <label style="text-align: center;font-weight: bold;margin-bottom: 15px;">INSEMINACION CON: </label></td>
                </tr>
                <tr >
                  <td style="border: 1px solid black;text-align: center;" id="tdSF"><label style="text-align: center;font-weight: bold;"> SEMEN FRESCO</label></td>
                  <td style="border: 1px solid black;text-align: center;" id="tdSR"><label style="text-align: center;font-weight: bold;"> SEMEN REFRIGERADO</label></td>
                  <td style="border: 1px solid black;text-align: center;" id="tdSC"><label style="text-align: center;font-weight: bold;"> SEMEN CONGELADO</label></td>
                </tr>
              </table>
             </td>
             <td style="border: 1px solid black;width: 3%;text-align: center;text-align: left;" colspan="2"> <label style="margin-bottom: 20px;">&nbsp;TRANSFERENCIA DE EMBRION <br> &nbsp;ID. RECEPTORA:&nbsp;<span id="lblIdRecep"></span><br></td>
           </tr>
         </table>
         <table>
           <tr>
            <td style="border: 1px solid black;"><label style="padding-left: 5px;"><h4>SOLO PARA USO DE LA ASOCIACION<h4></label></td>
              <td></td>
           </tr>
           <tr>
             <td><label><h4>FECHA DE RECEPCION:_____________</h4></label><label id="lblFechaRecepcion"></label><label>__________</label></td>
             <td></td>
           </tr>
           <tr>
             <td><label><h4>INSPECTOR ASIGNADO:_____________</h4></label><label id="lblInspector"></label><label>__________</label></td>
             <td>
              <table style="margin-left: 100px;">
              <tr>
                <td>____________________________</td></tr>
               <tr>
                <td style="padding-left: 20px;">FIRMA DE PROPIETARIO</td>
              </tr> 
             </table>
            </td>
           </tr>
         </table>
          </div>
      </div>
      </div>
    
   <!-- </div>-->
      <!-- Modal Footer -->
      <div class="modal-footer">
       <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      <button  id="btnPrint" type="button" class="btn btn-primary" onclick="imprimir()">Print</button>
      </div>
    
    </div>
    <!-- Modal Content: ends -->
    
  </div>
    </div>






