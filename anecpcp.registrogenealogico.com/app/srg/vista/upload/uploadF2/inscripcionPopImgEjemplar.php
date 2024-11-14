<script src="script/generales/loadImagenIns.js"></script>
<style>
.modal-dialog-customer-img-add { 
max-width : 80% ;
width : 100% ;
}
 
</style>

<div id="mvImgEjemplar" class="modal   fade">
    <div class="modal-dialog  modal-lg modal-dialog-customer-img-add">
        <div class="modal-content " id="divContainer">
            <div class="modal-header bg-success">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4  style="font-weight:bold;text-transform: uppercase;" class="modal-title">ADJUNTAR IMAGENES  - <span id="lblIdSol"></span>       </h4>
            </div>
            <div class="modal-body">
          
 
          <div id="upload-wrapper">
 
        <h4 style="text-transform: uppercase;">Agregar Imagenes del ejemplar: <span class="badge badge-pill badge-warning-tit" id="lblDatoHorse" style="font-weight: bold;"></span> </h4>
        <form action="vista/upload/uploadF2/processuploadInsImg.php" method="post" enctype="multipart/form-data" id="MyUploadForm">
       <!--<form  id="MyUploadForm">-->
       <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
              <input name="image_file2" class="  btn  btn-default " style="width: 100%;" id="imageInput2" type="file" /></div>
            <div class="col-md-5">
             <span>
              <input  type="submit2" class="btn   btn-success" id="submit-btn" value="&#9650; Subir Imagen">
              </span>
            
              </div>
        </div>
      </div>

 
        <img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
        <input name="idHorse" id="idHorse" type="hidden" value='<?=$_GET["idHorse"]?>' />
        <input name="hidNameHorse" id="hidNameHorse" type="hidden" value='<?=$_GET["nh"]?>' />
        <input name="hidPrefijoHorse" id="hidPrefijoHorse" type="hidden" value='<?=$_GET["prefh"]?>' />
        </form>
        <div id="output2"  class="table table-responsive" style="width: 100%;"> </div>
 
        </div>
        <div class="modal-footer"></div> 
        </div>
    </div>
</div>
</div>
<style>
.modal-dialog-customer-img { 
max-width : 80% ;
width : 80% ;
}
</style>
  <div class="modal fade" id="mvImagen" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-customer-img">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="btnCloseImgView" >&times;</button>
          <h4 class="modal-title"> </h4>
        </div>
        <div class="modal-body">
   <img src="" id="imgHorse" width="100%">
      </div>
        <div class="modal-footer">
          <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
        </div>
      </div>
    </div>
  </div> 

