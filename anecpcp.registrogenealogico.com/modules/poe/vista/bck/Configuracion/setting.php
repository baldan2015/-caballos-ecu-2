 
<!--<script src="script/configuracion/setting.js"></script>-->
 <style>
  iframe {
    max-width: 100%;
    height: auto;
}
 </style>

<div style="float:left;background:#f6f6f6; width:100%; background:url('images/button/barra.png')100% 100% ;"> 
<div style=" float:left; margin-top:10px;  " >
<titulo>
    <span class="glyphicon glyphicon-list-alt" style="color:#04B431;"></span>
    CONFIGURACION DE SISTEMA
</titulo>
</div>

<!--
<div style=" float:right;  " class="toolButton ">
 
      <button id="btnVer"   title="Buscar ADN de ejemplares  " class="btn btn-default btn-lg" >
    <span class="glyphicon glyphicon-search"></span>  
    </button> 
     <button id="btnXls"  title="Exportar Datos a Excel" class="btn btn-default btn-lg" >
    <span class="glyphicon glyphicon-export"></span>
    </button>
    <button id="btnCancelar"  title="Reiniciar filtros de busqueda  " class="btn btn-default btn-lg" >
    <span class="glyphicon glyphicon-refresh"></span>
    </button>
&nbsp;&nbsp;
      <button id="btnClsTmp"  title="Eliminar reporte temporal de ADN" class="clsListTMP btn btn-default btn-lg" >
    <span class="glyphicon glyphicon-remove"></span>
    </button>

</div> -->
 </div>   

<br>
  <br><br>
  <form action="vista/configuracion/dataXls.php">
  <div class="container-fluid breadcrumb table-responsive " >
    <div  class="row">
       <div class="col-md-12">
      <ul><li> Exportar informacion de ejemplares registrados a la fecha en Base de Datos del Registro&nbsp;&nbsp;
      <button  type="submit"  id="btnXls"   title="Exportar datos de ejemplares" class="btn btn-default btn-md" >
    <span class="glyphicon glyphicon-search"></span>  Exportar datos de ejemplares.
    </button></li> </ul>
 <hr  style="border-color:#000;" />
</div>
</div>
  </div>
</form>
 
<!-- Modal -->
<div id="mvExportar" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Exportar Datos</h4>
      </div>
      <div class="modal-body">
         <iframe id="xls">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>