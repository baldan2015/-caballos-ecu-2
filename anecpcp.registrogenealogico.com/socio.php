<?
require("constante.php");
require(DIR_CABECERA);
require(DIR_VALIDAR);
if (ValidarSession()) {
  /*CAMBIO DE USUARIO SESION*/
  if (isset($_GET['prfl'])) {

    $idPropSel = base64_decode($_GET['prfl']);
    $idPropNuevo = (int)$idPropSel;
    if (isset($_SESSION['usuarios'])) {
      if (is_array($_SESSION['usuarios']) && sizeof($_SESSION['usuarios'] > 1)) {
        for ($i = 0; $i < sizeof($_SESSION['usuarios']); $i++) {
          if ($idPropNuevo == $_SESSION['usuarios'][$i]->idPropietario) {
            $_SESSION['xusu'] = $_SESSION['usuarios'][$i]->razonSocial;
            $_SESSION['xid'] = $idPropNuevo;
            $_SESSION['xstatus'] = $_SESSION['usuarios'][$i]->estado;
            break;
          } else {

            unset($_SESSION['xusu']);
            unset($_SESSION['xid']);
            unset($_SESSION['xstatus']);
          }
        }
      }
    }
  }

  /*
$usuarios=$_SESSION['usuarios'];
$_SESSION['xusu']=$usuarios[0]->razonSocial;//session_register('xusu');
$_SESSION['xid']=$usuarios[0]->idPropietario;//session_register('xid');
$_SESSION['xstatus']=$usuarios[0]->estado;//session_register('xstatus');
echo "<pre>";   print_r($_SESSION );echo "</pre>";
*/
?>

  <link href="home/css/heroic-features.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/styles.css">
  <link href="styles/menu2.css" rel="stylesheet">

  <link href="admin/scripts/alerts/themes/alertify.core.css" rel="stylesheet" />
  <link href="admin/scripts/alerts/themes/alertify.default.css" rel="stylesheet" />
  <script src="admin/scripts/alerts/lib/alertify.min.js"></script>




  <link href="scripts/jquery-ui-1.11.4.custom.green/jquery-ui.css" rel="stylesheet">
  <script src="scripts/jquery-ui-1.11.4.custom.green/external/jquery/jquery.js"></script>
  <script src="scripts/jquery-ui-1.11.4.custom.green/jquery-ui.js"></script>



  <script src="libs/bootstrap-3.3.7/js/bootstrap.js"></script>
  <link href="libs/bootstrap-3.3.7/css/bootstrap.css" rel="stylesheet" />

  <link href="libs/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
  <script src="libs/bootstrap-select/js/bootstrap-select.min.js"></script>



  <link rel="stylesheet" type="text/css" href="modules/poe/libs/datatables-1.10.23/datatables.min.css" />
  <script type="text/javascript" src="modules/poe/libs/datatables-1.10.23/datatables.min.js"></script>



  <script src="scripts/loading.js"></script>
  <script type="text/javascript" src="socio.js"></script>

  <style type="text/css">
    .image_redonda {
      filter: drop-shadow(0 0 7px black);
    }

    body {
      background-image: url('images/logo/7742.jpg');
      background-size: 100% 115%;
    }

    /*#divNotificaciones{
  background-color: red;
 }
 */

    .table>thead>tr>th,
    .table>tbody>tr>th,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>tbody>tr>td,
    .table>tfoot>tr>td {
      padding: 3px !important;
      line-height: 1.42857143;
      vertical-align: top;
      border-top: 1px solid #ddd;
    }

    .table {
      width: 100%;
      max-width: 100%;
      margin-bottom: 5px !important;
    }
  </style>
  </head>

  <body>


    <?
    $margin_top = "style='margin-top:-76px;'";
    require(DIR_BARRA);
    ?>

    <!--<script src="home/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>-->


    <input type="hidden" id="hidIdProp" value="<?= $_SESSION['xid'] ?>" />
    <!-- Page Content -->
    <div class="container-fluid" style="margin-top: -20px; width: 99%;   ">

      <!-- Jumbotron Header -->
      <!--   <div class="  my-3" style="background: #f8f9fa; padding-left: 20px; padding-bottom: 20px;" >-->
      <div class="row">
        <div class="col-lg-9 ">
          <h1>Mis Tr&aacute;mites. <span class="glyphicon glyphicon-folder-open"></span></h1>
          <p class="lead" style="color: gray;">Esta sección contiene los servicios de la asociación que pone a sus disposición para una mejor gestión de sus ejemplares. </p>
          <button class="eje btn btn-success btn-md">Ver mis ejemplares! <span style="color:#fff;background-color: #343a40;" class="badge badge-dark" id="cantMisEjemplares"></span></button>

        </div>
        <div class="col-lg-3 col-md-3 mb-2">
          <div style="padding-top: 15px;">
            <div class="panel panel-default">
              <ul class="list-group">
                <div id="divNotificaciones">

                </div>
                <li class="list-group-item">
                  <button id="btnNotificacion" class="btn btn-default form-control btnNotificacion">
                    <span class="glyphicon glyphicon-envelope"></span> Ir a buzón electrónico</button>
                  </button>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <br>

      <!--</div>-->

      <!-- Page Features -->
      <div class="row text-center">

        <div class="col-lg-3 col-md-6 mb-4">

          <div class="panel panel-default">
            <div class="panel-body">
              <img class="card-img-top image_redonda" style="width: 100%;height: 220px;margin-top: -10px;" src="home/img/mon.jpg" alt="">
              <div class="card-body">
                <h4 class="card-title">Registro Monta&nbsp;<span data-toggle="tooltip" title="Número de reporte de montas registrados" style="background-color: #28a745;" class="badge badge-success" id="cantMonta"></span></h4>
                <p class="card-text">Reportes de montas de yeguas.</p><br>
              </div>
            </div>
            <div class="panel-heading">
              <button class="mon btn btn-info">Ir a registro</button>
            </div>
          </div>

        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="panel panel-default">
            <div class="panel-body">
              <img class="card-img-top image_redonda" style="width: 100%; height: 220px;margin-top: -10px;" src="home/img/nac.jpg" alt="">
              <div class="card-body">
                <h4 class="card-title">Nacimientos &nbsp;<span data-toggle="tooltip" title="Número de nacimientos registrados" style="background-color: #28a745;" class="badge badge-success" id="cantNacimiento"></span></h4>
                <p class="card-text">Registrar los nacimiento de sus ejemplares.</p><br>
              </div>
            </div>
            <div class="panel-heading">
              <button class="nac btn btn-primary">Ir a nacimientos</button>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">

          <div class="panel panel-default">
            <div class="panel-body">
              <img class="card-img-top image_redonda" style="width: 100%;margin-top: -10px;" src="home/img/ins.jpg" alt="">
              <div class="card-body">
                <h4 class="card-title">Inscripciones&nbsp;<span data-toggle="tooltip" title="Número de reportes de inscripciones registrados" data style="background-color: #28a745;" class="badge badge-success" id="cantInscipcion"></span></h4>

                <p class="card-text">Registrar Solicitudes de inscripciones de ejemplares</p>
              </div>
            </div>
            <div class="panel-heading">

              <button class="ins btn btn-warning">Ir a inscripciones</button>

            </div>
          </div>



        </div>

        <div class="col-lg-3 col-md-6 mb-4">
          <div class="panel panel-default">
            <div class="panel-body">
              <h4 class="card-title"><span style="font-weight: bold;">Reportar Novedades</span>&nbsp;<span style="background-color: #28a745;" class="badge badge-success" id="cantNovedades"></span></h4>
              </h4>
              <p class="card-text">Sección de novedades de ejemplares: Fallecimientos,Castraciones y Transferencias</p>

              <p class="card-text"> <button class="fac form-control btn btn-default" onclick="popupFallecidos();"> <i class='fas fa-horse'></i> Reportar Fallecimientos <span style="color: #fff;background-color:#343a40; " class="badge badge-dark" id="cantFallecido"></span></button></p>
              <p class="card-text"> <button class="cas form-control btn btn-default" onclick="popupCastracion();">Reportar Castraciones <span style="color: #fff;background-color: #343a40;" class="badge badge-dark" id="cantCastrado"></span></button></p>
              <p class="card-text"> <button class="tran form-control btn btn-default" onclick="popupTransferido();">Reportar Transferencias <span style="color: #fff;background-color: #343a40;" class="badge badge-dark" id="cantTransferido"></span></button></p>
              <br>
              <br> <br>
            </div>
            <div class="panel-heading">
              <!-- <button  class="mon btn btn-info">Ir a registro!</button>-->
            </div>
          </div>
        </div>



      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->


  </body>

  </html>
  <script>
    $(function() {

      $(".eje").click("on", function() {
        document.location.href = "profile.php";
      });
      $(".ins").click("on", function() {
        document.location.href = "modules/poe/vista/form9.php?SetIdPoe=0";
      });
      $(".nac").click("on", function() {
        document.location.href = "modules/poe/vista/form10.php?SetIdPoe=0";
      });
      $(".mon").click("on", function() {
        document.location.href = "modules/poe/vista/form11.php?SetIdPoe=0";
      });
      $(".btnNotificacion").click("on", function() {
         window.location.href="modules/poe/vista/notificaciones.php";
      });
    });
  </script>


<?
  require("popup/popupFalleceEjemplar.php");
  require("popup/popupCastradoEjemplar.php");
  //require("modules/poe/vista/popup/popupTransferidoEjemplar.php");
  require("popup/popupTransferidoEjemplar.php");
  require("popup/popupDetalleNotificacion.php");
} else {
  //echo "<pre>";   print_r($_SESSION );echo "</pre>";
  if (isset($_SESSION['usuarios'])) {
    if (is_array($_SESSION['usuarios']) && sizeof($_SESSION['usuarios']) == 0) {
      $message = "<span >Usuario y contraseña no coinciden. Vuelve a intentarlo.</span>&nbsp;&nbsp;<img src='img/b_usrdrop.png'>  ";
    }
  }
  require(DIR_LOGIN);
}
