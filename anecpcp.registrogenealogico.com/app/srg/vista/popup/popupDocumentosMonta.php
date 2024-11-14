<style>
    .modal-dialog-customer-pdf {
        max-width: 80%;
        width: 80%;
        height: 70%;
    }

    .doc-container {
        position: relative;
        padding-bottom: 50%;
    }

    .doc-container iframe,
    .doc-container object,
    .doc-container embed {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        margin: 0px;
        height: 100%;
    }

    .btnPdf {
        background-image: url('images/icono/pdf_2.png');
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        height: 20px;
        width: 15px;
    }
</style>
<div class="modal fade" id="mvVerArchivo" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-customer-pdf">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Vista Previa del Documento</h4>
            </div>
            <div class="modal-body">
                <div class="doc-container">
                    <iframe id="verpdf" style="width: 100%;" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>