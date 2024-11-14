
<script src="libs/Chart.js-release/Chart.min.js"></script>
<script src="script/reporte/reporte.num.serv.yegua.js"></script>

 
<style type="text/css">
  #divResultDet{
    overflow: auto; 
    height: 450px; 
    border: 1px solid #dddddd;
    background: #fff;
}
#divResult{
    overflow: auto; 
    height: 500px; 
    border: 1px solid #dddddd;
    background: #fff;
}
#divResumen,#divResumenDet  {
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
.tbDatoMain td{
   
   height: 30px;
   
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
   text-align: center;  
 }
 .tdHasValue{
  width:100%;
  background:#e7f5d1 ;
  color:black;
}
.borderCellResu{
   font-weight: bold;
   text-align: center;  
   border: 1px solid #dddddd;
   background: #dddddd;
 }
</style>

<div style="float:left;background:#f6f6f6; width:100%; background:url('images/button/barra.png')100% 100% ;"> 
<div style=" float:left; margin-top:10px;  " >
<titulo>
    <span class="glyphicon glyphicon-list-alt" style="color:#04B431;"></span>
    REPORTE SERVICIOS DE YEGUA POE - ANUAL
</titulo>
</div>
<div style=" float:right;  " class="toolButton ">
 
      <button id="btnVer"   title="Buscar ADN de ejemplares  " class="btn btn-default btn-lg" >
    <span class="glyphicon glyphicon-search"></span>  
    </button> 
     <button id="btnXls"  title="Exportar Datos a Excel" class="btn btn-default btn-lg" >
    <span class="glyphicon glyphicon-save"></span>
    </button>
    <button id="btnCancelar"  title="Reiniciar filtros de busqueda  " class="btn btn-default btn-lg" >
    <span class="glyphicon glyphicon-refresh"></span>
    </button>
 &nbsp;&nbsp;&nbsp;&nbsp;
  
</div>
 </div>   
 <div class="container-fluid breadcrumb table-responsive ">
<div   class="row">
          <div class="col-md-6">
            <Label>DESDE</Label>
           <input type="number" id="txtDesde" value="2000"  max="2050" min="1920" class="form-control" >
          </div>
           <div class="col-md-6">
            <Label>HASTA</Label>
            <input type="number" id="txtHasta" value="2018" max="2050" min="1920" class="form-control">
          </div>
          
           

  
</div>
          <div   class="row">
              <div class="col-md-6"  > 
                <br>
                  <div id="divResult">
                    <table  class='tbDatoMain'>
                       <tr>
                          <th><b>A&Ntilde;O POE </b></th>   
                          <th><b>NUM REGISTRO POE  </b></th>    
                          <th><b>NUM NACIDO A&Ntilde;O  SIGUIENTE - SGE  </b></th> 
                          <th><b>DIFERENCIA %</b></th>    
                      </tr>
                    </table>

                  </div>
             </div>
             <div class="col-md-6"  > 
              <canvas id="bar-chart" width="600" height="400"></canvas>
             </div>
          </div>
          <div   class="row">
              <div class="col-md-12"  > 
                 <div id="divResumen">Número de registros encontrados: 0</div>
                   
              </div>
          </div>

  </div>

  <div class="modal fade" id="mvListaDet" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-customer-grlEjemplar">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Detalle</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" id="hidAnioSel"    >
              Filtrar por ejemplar:  <input type="text" id="txtNombreDet"   class="form-control" >
              <div id="divResultDet"></div>
              <div id="divResumenDet"></div>
        </div>
          
        <div class="modal-footer">
          
          <button type="button" class="btn btn-primary" id="btnXlsDet"  >Exportar Lista</button>
          &nbsp;&nbsp;
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  