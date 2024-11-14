
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
<div id="mvNuevoEjemplar2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
  
  <div class="modal-dialog modal-lg">
    
    <!-- Modal Content: begins -->
    <div class="modal-content">
      
      <!-- Modal Header -->
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="gridSystemModalLabel">Your Headings</h4>
      </div>
   <!--<div id="printThis" >-->
      <!-- Modal Body -->  
      
      <div class="modal-body" >
        <div class="body-message">
          <div id="printThis" >
         <table>
           <tr>
             <td><label> <h5 style="font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ASOCIACION NACIONAL DEL ECUADOR <br>DE CRIADORES Y PROPIETARIOS DEL CABALLOS DE PASO<br> REGISTRO GENEALOGICO DEL CABALLO PERUANO DE PASO</h5></label></td>
             <td><label style=" padding-left: 40px;"> <h1 style="font-size:3vw;font-weight: bold;"><p style="font-family: 'Times New Roman', Times, serif;"><font size="4">REPORTE DE MONTA</font></p></label></td>
           </tr>
         </table>
         <table>
           <tr style="border: 1px solid black;">
            <td style="border: 1px solid black;width: 10%;" height="40" colspan="1"><label style="text-align: center;font-weight: bold;font-size: 15px;">REG.<br> ASO PASO</label></td>
            <td style="border: 1px solid black;width: 38%;"> <label style="text-align: center;font-weight: bold;font-size: 18px;padding-left: 100px;">PADRILLO</label></td>
            <td style="border: 1px solid black;width: 19%;" colspan="2"> <label style="text-align: center;font-weight: bold;font-size: 25px;margin-left: 45px;">ADN</label></td>
           </tr>
           <tr >
             <td style="border: 1px solid black;width: 10%;" height="40" colspan="1"><label id="lblCodigoPadrillo" style="text-align: center;font-weight: bold;font-size: 15px;"></label></td>
             <td style="border: 1px solid black;width: 20%;"><label id="lblPadrillo" style="font-size: 15px;padding-left: 15px;"></label> </td>
             <td style="border: 1px solid black;text-align: center;vertical-align: middle;width: 10%"><label id="lblSiImgPadrillo"></label><label id="tdSiPadrillo" style="text-align: center;font-size: 15px;">SI</label></td>
             <td style="border: 1px solid black;text-align: center;vertical-align: middle;"><label id="lblNoImgPadrillo"></label><label  id="tdNoPadrillo" style="text-align: center;font-size: 15px;">NO</label></td>
             <td><label style="font-size: 12px;">&nbsp;&nbsp;FECHA:______<label id="lblFecCrea" style="text-decoration-line: underline;font-size: 15px;"></label>______</label></td>
           </tr>
         </table><br>
          <table>
           <tr style="border: 1px solid black;">
            <td style="border: 1px solid black;width: 10%;" height="40" colspan="1"><label style="text-align: center;font-weight: bold;font-size: 15px;">REG.<br> ASO PASO</label></td>
            <td style="border: 1px solid black;width: 38%;"> <label style="text-align: center;font-weight: bold;font-size: 18px;padding-left: 100px;">YEGUA</label></td>
            <td style="border: 1px solid black;width: 19%;" colspan="2"> <label  style="text-align: center;font-weight: bold;font-size: 25px;margin-left: 45px;">ADN</label></td>
            <td style="border: 1px solid black;width: 21%;" > <label style="text-align: center;font-weight: bold;font-size: 15px;padding-left: 15px;">FECHA DE MONTA</label></td>
            <td style="border: 1px solid black;width: 21%;" > <label style="text-align: center;font-weight: bold;font-size: 15px;padding-left: 5px;">DEBE PARIR</label></td>
           </tr>
           <tr>
           <td style="border: 1px solid black;width: 10%;" height="40" colspan="1"><label id="lblCodigoYegua" style="text-align: center;font-weight: bold;font-size: 15px;"></label></td>
             <td style="border: 1px solid black;width: 20%;"><label id="lblYegua" style="font-size: 15px;padding-left: 15px;"></label> </td>

             <td style="border: 1px solid black;text-align: center;vertical-align: middle;width: 10%" ><label id="lblSiImgYegua"></label><label id="tdSiYegua" style="text-align: center;font-size: 15px;">SI</label></td>
             <td style="border: 1px solid black;text-align: center;vertical-align: middle;" ><label id="lblNoImgYegua"></label><label id="tdNoYegua" style="text-align: center;font-size: 15px;">NO</label></td>
             
             <td style="border: 1px solid black;"><label id="lblFecMonta" style="text-align: center;font-size: 15px;"></label></td> 
             <td style="border: 1px solid black;"><label id="lblFecParir" style="text-align: center;font-size: 15px;"></label></td>
           </tr>
           <tr>
             <tr>
             <td style="border: 1px solid black;width: 10%;text-align: center;" colspan="7"><label style="text-align: center;margin-bottom: 0px;">MODO REPRODUCTIVO UTILIZADO</label></td>
           </tr>
           <tr>
             <td style="border: 1px solid black;width: 3%;text-align: center;" id="tdMN"> <label style="margin-bottom: 50px; margin-bottom: 0px;" >MONTA NATURAL </label></td>
             <td style="border: 1px solid black;width: 3%;text-align: center;" colspan="4">
              <table style="width: 100%;height: 100%;">
                <tr>
                  <td style="text-align: center;" colspan="4"> <label style="text-align: center;font-weight: bold;margin-bottom: px;padding-top: 20px">INSEMINACION CON: </label></td>
                </tr>
                <tr >
                  <td style="border: 1px solid black;text-align: center;" id="tdSF"><label style="text-align: center;font-weight: bold;" > SEMEN FRESCO</label></td>
                  <td style="border: 1px solid black;text-align: center;" id="tdSR"><label style="text-align: center;font-weight: bold;"> SEMEN REFRIGERADO</label></td>
                  <td style="border: 1px solid black;text-align: center;" id="tdSC"><label style="text-align: center;font-weight: bold;"> SEMEN CONGELADO</label></td>
                </tr>
              </table>
             </td>
             <td style="border: 1px solid black;width: 3%;text-align: center;text-align: left;" colspan="2"> <label style="margin-bottom: 20px;">&nbsp;TRANSFERENCIA DE EMBRION <br> &nbsp;ID. RECEPTORA:&nbsp;<span id="lblIdRecep"></span><br></td>
           </tr>
          </table>
          <table>
            <tr >
              <td height="90"></td>
            </tr>
            <tr>
              <td colspan="7">
                _______________<label><u></u></label>________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </td>
               <td colspan="7">
                _______________<label><u></u></label>_________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </td>
               <td colspan="7">
                _______________<label><u></u></label>_________________&nbsp;&nbsp;&nbsp;&nbsp;
              </td>
            </tr>
            <tr>
              <td colspan="7" style="text-align: center;"><label>ENCARGADO CRIADERO</label></td>
              <td colspan="7" style="text-align: center;"><label>OFICINA REGISTRO GYE</label></td>
              <td colspan="7" style="text-align: center;"><label>PROPIETARIO</label></td>
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






