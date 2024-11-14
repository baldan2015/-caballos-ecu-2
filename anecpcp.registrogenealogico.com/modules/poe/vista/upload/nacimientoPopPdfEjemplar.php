<script src="../script/generales/loadNacPdf.js"></script>
<style>
.modal-dialog-customer-pdf-add { 
max-width : 80% ;
width : 100% ;
}
</style>

<div id="mvPdfEjemplar" class="modal   fade">
    <div class="modal-dialog  modal-lg modal-dialog-customer-pdf-add">
        <div class="modal-content " >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4  style="font-weight:bold;text-transform: uppercase;" class="modal-title">ADJUNTAR CERTIFICADOS PDF  - <span id="lblIdSolPdf"></span>       </h4>
            </div>
            <div class="modal-body">
          
 
        <div id="upload-wrapper">
 
        <h4 style="text-transform: uppercase;">Agregar Certificados del ejemplar: <span class="badge badge-pill badge-warning-tit" id="lblDatoHorsePdf" style="font-weight: bold;"></span> </h4>
        <form action="upload/processuploadNacPdf.php" method="post" enctype="multipart/form-data" id="MyUploadFormPdf">
       
       <div class="container-fluid">
        <div class="row">
            <div class="col-md-3" style="margin-bottom: 10px;">
              <label>Tipo de documento</label>
              <select class="form-control requerido" id="ddlTipoDocumento" onchange="tipoDoc()"></select>
            </div>
            <div class="col-md-4" style="margin-top: 16px;">
              <input name="pdf_file2" class="  btn   btn-default " style="width: 100%;" id="pdfInput2" type="file" /></div>
            <div class="col-md-4" style="margin-top: 16px;">
              <input type="submit2" class="btn   btn-info" id="submit-btn-pdf" value="&#9650; Subir Certificados"/>
            </div>

        </div>
       </div>

 
        <input name="idHorsePdf2" id="idHorsePdf" type="hidden" value='0' />
        <input name="idTipoDoc" id="idTipoDoc" type="hidden" value='0' />
        <!--<input name="hidNameHorse" id="hidNameHorse" type="hidden" value='<?=$_GET["nh"]?>' />
        <input name="hidPrefijoHorse" id="hidPrefijoHorse" type="hidden" value='<?=$_GET["prefh"]?>' />-->
        </form>
        <div id="outputPdf2"  class="table table-responsive" style="width: 100%;"> </div>
 
        </div>
        <div class="modal-footer"></div> 
        </div>
    </div>
</div>
</div>
<style>
.modal-dialog-customer-pdf { 
max-width : 80% ;
width : 80% ;
}
.doc-container {
    position: relative;
    padding-bottom: 100%;
    height:100%;
  
}
 
.doc-container iframe, .doc-container object, .doc-container embed {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    margin:0px;
}
</style>
  <div class="modal fade" id="mvPdf" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-customer-pdf">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="btnClosePdfView" >&times;</button>
          <h4 class="modal-title"> </h4>
        </div>
        <div class="modal-body">
          <!--<img src="" id="imgHorse" width="100%">-->
          <div  class="doc-container">
          <iframe id="ifrPDF" style="width: 100%;" frameborder="0" allowfullscreen></iframe>
        <div class="modal-footer">
          <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
        </div>

          </div>
        </div>
      </div> 
    </div>
  </div>


