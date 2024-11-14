<!-- Modal -->
<style>
  .campo {
    width: 100%;
    display: flex;
  }

  .campo .campo-1 {
    width: 50%;
  }

  .campo .campo-2 {
    width: 50%;
    text-align: end;
  }
</style>
<script src="../script/editarDatos.js"></script>
<div class="modal fade" id="modalEditarDatos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"> <span class="glyphicon glyphicon-check" aria-hidden="true"></span> Editar mis datos</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="container-fluid">
            <div class="panel panel-success">
              <div class="panel-heading">
                <div class="campo">
                  <div class="campo-1">
                    <b>Datos del socio</b>
                  </div>
                  <div class="campo-2">
                   <button class="btn btn-primary btn-sm" onclick="modalClave('show')">
                      <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Actualizar Datos</button>
                  </div>
                </div>



              </div>
              <div class="panel-body">
                <div class="col-md-4">
                  <label>Numero de documento: <span class="etiqueta">(*)</span> </label>
                  <input type="number" class="form-control" id="txtNumDoc">
                </div>
                <div class="col-md-4">
                  <label>Nombres: <span class="etiqueta">(*)</span> </label>
                  <input type="text" class="form-control" id="txtNombres">
                </div>
                <div class="col-md-4">
                  <label>Apellido Paterno: <span class="etiqueta">(*)</span> </label>
                  <input type="text" class="form-control" id="txtApePaterno">
                </div>
                <div class="col-md-4">
                  <label>Apellido Materno:</label>
                  <input type="text" class="form-control" id="txtApeMaterno">
                </div>
                <div class="col-md-8">
                  <label>Correo:  </label>
                  <input type="email" class="form-control" id="txtcorreo">
                  <input type="hidden" class="form-control" id="txtcorreoOld">
                </div>
                <div class="col-md-4">
                  <label>Telefono:  </label>
                  <input type="number" class="form-control" id="txttel">
                </div>
                <div class="col-md-4">
                  <label>Celular:  </label>
                  <input type="number" class="form-control" id="txtcel">
                </div>
                <div class="col-md-4">
                  <label>Prefijo: </label>
                  <input class="form-control" id="txtprefijo" disabled>
                </div>
              </div>
            </div>
          </div>


        </div>
        <!-- <div class="row">
          <div class="container-fluid">
            <div class="panel panel-success">
              <div class="panel-heading">
                <div class="campo">
                  <div class="campo-1">
                    <b>Datos del criador</b>
                  </div>
                  <div class="campo-2">
                    <button class="btn btn-primary btn-sm" onclick="validarCampos(2)"> 
                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Actualizar Datos</button>
                  </div>
                </div>

              </div>
              <div class="panel-body">
                <div class="col-md-6">
                  <label>Departamento de crianza: <span class="etiqueta">(*)</span> </label>
                  <select class="form-control" id="cboDepCri"></select>
                </div>
                <div class="col-md-6">
                  <label>Lugar crianza: <span class="etiqueta">(*)</span> </label>
                  <input class="form-control" id="txtlugarCrianza">
                </div>
              </div>
            </div>
          </div>

        </div>-->

        <div class="row">
          <div class="container-fluid">
            <div class="panel panel-success">
              <div class="panel-heading">

                <div class="campo">
                  <div class="campo-1">
                    <b>Datos para acceso web</b>
                  </div>
                  <div class="campo-2">
                    <button class="btn btn-primary btn-sm" onclick="validarCampos(3)">
                      <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Actualizar Datos</button>
                  </div>
                </div>
              </div>
              <div class="panel-body">
                <div class="col-md-4">
                  <label>Login</label>
                  <input class="form-control" id="txtlogin" disabled>
                </div>
                <div class="col-md-4">
                  <label>Nueva contraseña: <span class="etiqueta">(*)</span> </label>
                  <div class="input-group">
                    <input type="password" class="form-control" id="txtpasswordNew">
                    <div class="input-group-btn">
                      <button id="btnClaveNew" class="btn btn-default"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <label>Contraseña Actual: <span class="etiqueta">(*)</span> </label>
                  <div class="input-group">
                    <input type="password" class="form-control" id="txtpassword">
                    <div class="input-group-btn">
                      <button id="btnClave" class="btn btn-default"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModalPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Confirmar actualización</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <label>Ingrese contraseña:  </label>
            <div class="input-group">
              <input type="password"  class="form-control" id="txtvpassword">
            <span class="input-group-btn">
              <button type="button" class="btn btn-primary" onclick="validarCampos(1)">Continuar</button>
            </span>
            </div>
            
          </div>
        </div>

      </div>
    </div>
  </div>
</div>