<script src="script/reporte/reporte.cierre.mes.js"></script>
 
<style type="text/css">
#divResult{
    overflow: auto; 
    height: 500px; 
    border: 1px solid #dddddd;
    background: #fff;
}
#divResumen  {
    font-size: 11px;
    font-weight: bold;
    
}
.tbDatoMain  {
    font-size: 11px;
    border:1 px;
    width:100%  ;
}
.tbDatoMain tr:hover{  
    background: #e9e9e9;
    font-weight: bold;
}
.tbDatoMain th{
   border: 1px solid #dddddd;
   text-align:center;
   height: 30px;
   background: #dddddd;
}
.tdTotal{
   font-weight: bold;
   text-align: center;
   border: 1px solid #dddddd;
}
.tbValor{
  width: 100%;
}
.tdAnio{
  text-align:center;
  border-bottom-style: solid;
  border: 1px solid #dddddd;
}
.tdValor{
  text-align:center;
}
.borderCell{
   border: 1px solid #dddddd;
 }
 .tdHasValue{
  width:100%;
  background:#e7f5d1 ;
  color:black;
}

#radioBtn  .notActive{
    color: #000; 
    background-color: #fff;
}
#radioBtnCastrado .notActive{
    color: #000;/*#3276b1; */
    background-color: #fff;
}
</style>

<div style="float:left;background:#f6f6f6; width:100%; background:url('images/button/barra.png')100% 100% ;"> 
<div style=" float:left; margin-top:10px;  " >
<titulo>
    <span class="glyphicon glyphicon-list-alt" style="color:#04B431;"></span>
    REPORTES :: CIERRE MENSUAL
</titulo>
</div>
<div style=" float:right; margin-top:5px; " class="toolButton ">
<div class="btn-group" role="group" aria-label="...">
      <button id="btnVer"   title="Buscar reporte  " class="btn btn-default btn-md" >
    <span class="glyphicon glyphicon-search"></span>  &nbsp;Buscar
    </button> 
     <button id="btnXls"  title="Exportar Datos a Excel" class="btn btn-default btn-md" >
    <span class="glyphicon glyphicon-save"></span>&nbsp;Exportar
    </button>
    <button id="btnPrint"  title="Imprimir resumen consolidado" class="btn btn-default btn-md" >
    <span class="glyphicon glyphicon-print"></span>&nbsp;Imprimir Consolidado
    </button>

    <button id="btnCancelar"  title="Reiniciar filtros de búsqueda  " class="btn btn-default btn-md" >
    <span class="glyphicon glyphicon-refresh"></span>&nbsp;Nueva Busqueda
    </button>
</div>
  
</div>
 </div>    
 <div class="container-fluid breadcrumb table-responsive "><BR> <BR> 
<div   class="row">
          <div class="col-md-2">
            <Label>Periodo - A&ntilde;o</Label>
           <input type="number" id="txtPeriodo" max="2070" min="1970"   class="form-control" >
          </div>
           <div class="col-md-2">
            <Label>Mes cierre</Label>
            <input type="number" id="txtMes"    max="12" min="1" class="form-control">
          </div>
           <div class="col-md-4">
            <Label>ORIGEN EJEMPLAR</Label><BR>
            <div id="radioBtn" class="btn-group">
              <a class="btn btn-success btn-sm active " data-toggle="hidOrigen" data-title="T" title="No considerar origen">TODOS</a>
              <a class="btn btn-success btn-sm notActive" data-toggle="hidOrigen" data-title="N"  title="Considerar s&oacute;lo ejemplares nacionales">NACIONAL</a>
               <a class="btn btn-success btn-sm notActive" data-toggle="hidOrigen" data-title="I"  title="Considerar s&oacute;lo ejemplares importados">IMPORTADO</a>
            </div>
            <input type="hidden" name="hidOrigen" id="hidOrigen" value="T">
         
          </div>
       
         <!--     <div class="col-md-2">
            <Label>EJEMPLAR CAPADO</Label><br>
             <div id="radioBtnCastrado" class="btn-group">
              <a class="btn btn-default btn-sm active" data-toggle="hidCastrado" data-title="T" title="Considerar todos los ejemplares">TODOS</a>
              <a class="btn btn-default btn-sm notActive" data-toggle="hidCastrado" data-title="C" title="Considerar s&oacute;lo ejemplares castrados">S&oacute;lo Castrado</a>
               
            </div>
            <input type="hidden" name="hidCastrado" id="hidCastrado" value="T">
          </div> --> <input type="hidden" name="hidCastrado" id="hidCastrado" value="T">
           <div class="col-md-4">
            <Label>TIPO REPORTE</Label><br>
             <div id="radioBtnTipoReporte" class="btn-group">
              <a class="btn btn-default btn-sm active" data-toggle="hidTipoReporte" data-title="I" title="Reporte registros de inscripciones de ejemplares">Inscripciones</a>
              <a class="btn btn-default btn-sm notActive" data-toggle="hidTipoReporte" data-title="T" title="Reporte de registros de transferencias de ejemplares">Transferencias</a>
               
            </div>
            <input type="hidden" name="hidTipoReporte" id="hidTipoReporte" value="I">
          </div>
         <!-- <div class="col-md-2">
             <Label>&nbsp;</Label>
            <button class="btn btn-primary">Buscar</button>
            <button class="btn btn-primary">Cancelar</button>
            <button class="btn btn-primary">Exportar</button>
          </div> -->

  
</div>

 

          <div   class="row">
              <div class="col-md-12"  > 
                <br>
                  <div id="divResult">
                    <table  class='tbDatoMain'>
                        <tr>
                          <th><b>ID EJEMPLAR</b></th>
                          <th><b>PREFIJO</b></th>
                          <th><b>NOMBRE</b></th>
                          <th><b>FEC NAC.</b></th>                          
                          <th><b>PELAJE</b></th>
                          <th><b>PROPIETARIO</b></th>
                          <th><b>CRIADOR</b></th>
                          <th><b>FEC INS.</b></th>
                          <th><b>ORGIGEN.</b></th>
                          <th><b>FEC CAPADO</b></th>    
                            <th><b>Usu. Creaci&oacute;n</b></th>    
                             <th><b>Fec. Creaci&oacute;n</b></th>   
                        </tr>
                    </table>

                  </div>
             </div>
          </div>
          <div   class="row">
              <div class="col-md-12"  > 
                 <div id="divResumen">Número de registros encontrados: 0</div>
                   
              </div>
          </div>

  </div>

  