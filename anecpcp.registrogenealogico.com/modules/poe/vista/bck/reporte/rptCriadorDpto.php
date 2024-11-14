<script src="script/reporte/reporte.criador.departamento.js"></script>
 
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
</style>

<div style="float:left;background:#f6f6f6; width:100%; background:url('images/button/barra.png')100% 100% ;"> 
<div style=" float:left; margin-top:10px;  " >
<titulo>
    <span class="glyphicon glyphicon-list-alt" style="color:#04B431;"></span>
    REPORTE CRIADORES / PROPIETARIOS POR DEPARTAMENTO
</titulo>
</div>
<div style=" float:right;  " class="toolButton ">
 
      <button id="btnVer"   title="Buscar reporte  " class="btn btn-default btn-lg" >
    <span class="glyphicon glyphicon-search"></span>  
    </button> 
     <button id="btnXls"  title="Exportar Datos a Excel" class="btn btn-default btn-lg" >
    <span class="glyphicon glyphicon-save"></span>
    </button>
    <button id="btnCancelar"  title="Reiniciar filtros de búsqueda  " class="btn btn-default btn-lg" >
    <span class="glyphicon glyphicon-refresh"></span>
    </button>
 &nbsp;&nbsp;&nbsp;&nbsp;
  
</div>
 </div>   
 <div class="container-fluid breadcrumb table-responsive ">
        <div   class="row">
                  <div class="col-md-5">
                    <Label>Nombre Apellidos / Razon Social</Label>
                   <input type="text" id="txtCriador"   class="form-control" >
                  </div>
                   <div class="col-md-5">
                    <Label>Departamentos</Label>
                    <select id="lstDpto"   class="form-control select"></select>
                  </div>
                   <div class="col-md-2">
                    <Label for="chkProp" >Sólo propietarios</Label>
                   <input class="form-control" type="checkbox" id="chkProp" />
                  </div>
        </div>



          <div   class="row">
              <div class="col-md-3"  > 
                <br>
                <div id="divResultConsol">
                    <table  class='tbDatoMain'>                        
                        <tr><th><b>Departamento</b></th><th><b>Cantidad</b></th>
                        </tr>
                   </table>
                </div>
              </div>
              <div class="col-md-9"  > 
                <br>
                  <div id="divResult">
                    <table  class='tbDatoMain'>                        
                        <tr><th><b>Tipo Doc</b></th>
                          <th><b>Num Doc</b></th>
                          <th><b>Nombres Apellidos /Razon Social</b></th>
                          <th><b>Prefijo</b></th>
                          <th><b>Dpto</b></th>
                          <th><b>Lugar Crianza</b></th>
                        </tr>
                   </table>

                  </div>
             </div>
          </div>
          <div   class="row">
              <div class="col-md-5"  > 
              
                   
              </div>
          
              <div class="col-md-7"  > 
                 <div id="divResumen">Número de registros encontrados: 0</div>
                   
              </div>
          </div>

  </div>

  