<?PHP require("../../../constante.php");
require(DIR_LEVEL_MOD_POE . "Funciones/general.php");
require("../header.php");
require(DIR_LEVEL_MOD_POE . DIR_VALIDAR);
if (ValidarSession()) {
    require("../libs.php");
    $activo9 = "active";
?>
    <style type="text/css">
        .tituloTop {
            color: #3c763d;
            text-transform: uppercase;
            font-family: Franklin Gothic Medium;
            font-size: 24px;

        }

        .button-text {
            display: block;
        }

        @media only screen and (max-width: 600px) {
            .tituloTop {
                margin-left: 0px !important;
            }

            .button-text {
                display: none;
            }
        }

        @media only screen and (min-width: 768px) {
            .tituloTop {
                margin-left: 0px !important;
            }

            .button-text {
                display: none;
            }
        }

        #lblCantidadSol {
            font-size: 20px;
        }

        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="../libs/datatables-1.10.23/datatables.min.css" />
    <script type="text/javascript" src="../libs/datatables-1.10.23/datatables.min.js"></script>
    <script type="text/javascript" src="../script/notificaciones.js"></script>

    <table border=1 cellpadding=0 cellspacing=0 width=100%>
        <?
        require("../barra.php");
        // require("../validarPoe.php");
        $dato = obtenerIdPropietario($_SESSION["xid"]);
        //echo "<br><br><br><br><br><br><br><br><br><br><br><br>".$_SESSION["xid"];
        if ($dato == 0) {
            die("<br><br><br><br><br><br><br><br><br><br><br><br><center><span style='font-weight:bold; font-size:12px';>Ud No puede registrar inscripciones de ejemplares. El usuario no tiene código del Propietario.<br>Contáctese con el administrador</span></center><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>");
            exit();
        }
        ?>
        </tr>
    </table>
    <div class="container-fluid">
        <div class="row fondoFilaCabecera">
            <div class="col-md-8 tituloTop">
                <img src="../../../home/img/ins.jpg" class="image_redonda" />
                <span>
                    &nbsp; Buzón Electrónico <span class="badge badge-pill badge-danger-tit" id='lblTituloPoe'><?= $periodo ?></span>
                    <span class="badge badge-success" id="lblCantidadSol">0</span>
                </span>

            </div>
            <div class="col-md-4 text-right" style="margin-top: 16px;  ">

                <input type="hidden" id="hidIdProp" value="<?= $_SESSION['xid'] ?>" />
                <input type="hidden" id="hidIdPoe" value="<?= $_SESSION[VAR_PERIODO_SESION] ?>" />

                <div style="float: right; margin-top: -7px;">
                    <div class="btn-group" role="group" aria-label="...">
                        <button onclick="window.location.href='../../../socio.php';" data-toggle='tooltip' title="Ir a mis operaciones " class="btn   btn-primary">
                            <span class="glyphicon glyphicon-home"></span> Ir a mis trámites
                        </button>
                    </div>
                </div>
            </div>
            <div class="container-fluid" style="padding-top: 70px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="" style="text-align:initial;">
                                            <h5>Filtros de búsqueda</h5>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="" style="text-align: end;">
                                            <div class="btn-group" role="group" aria-label="...">
                                                <button id="btnMensajesFiltro" class="btn btn-default">
                                                    <span class="glyphicon glyphicon-envelope"></span> Mensajes
                                                </button>

                                                <button id="btnAprobarFiltro" class="btn btn-default">
                                                    <span class="glyphicon glyphicon-inbox"></span> Por Aprobar
                                                </button>

                                                <button id="btnTodosFiltro" class="btn btn-default">
                                                    <span class="glyphicon glyphicon-refresh"></span> Todos
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12" style="margin-top:10px !important;">
                        <table id="grid" class="table  row-border table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nro</th>
                                    <th>Fecha</th>
                                    <th>Mensajes</th>
                                    <th style="width: 150px;">Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?
require("popup/popupDetalleNotificacion.php");
} else {
    header("Location: " . DIR_LEVEL_MOD_POE);
}

?>