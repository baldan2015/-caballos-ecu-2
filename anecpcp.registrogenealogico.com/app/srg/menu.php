<?session_start();
include_once ("entidad/Constantes.php");
?>
<style type="text/css">
	.badge-danger {  font-size: 8px;   background-color: #d9534f;}
</style>
<nav class="navbar navbar-default navbar-static navbar-fixed-top " style="background:#459e00;">
    <div class="navbar-header">
		<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<!--<a class="navbar-brand" href="#">        </a>-->

            <img src="images/logo/logo.jpg"  style="margin-top: 5px;" />
        
	</div>
	
	
	<div class="collapse navbar-collapse js-navbar-collapse">
        
        <ul class="nav navbar-nav">
			<li class="dropdown dropdown-large">
				<a href="?" class="dropdown-toggle"   style="color:#fff;"> 
                   <span class="glyphicon glyphicon-home"></span> Inicio</a>
                
            </li>
        </ul>
        
        
		<ul class="nav navbar-nav">
			<li class="dropdown dropdown-large">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color:#fff;"> 
                   <span class="glyphicon glyphicon-cog"></span> Gestionar Ejemplares<b class="caret"> </b></a>
				
				<ul class="dropdown-menu dropdown-menu-large row">
				<?php if($_SESSION[Constantes::K_SESSION_CARGO_USUARIO]==1 || $_SESSION[Constantes::K_SESSION_CARGO_USUARIO]==2){?>
					<li class="col-sm-3">
						<ul>
							<li class="dropdown-header">Mantenimientos</li>
							<li><a href="?obj=<?php echo md5('vista/mantenimiento/pelaje.php');?>">Pelaje</a></li>
							<li><a href="?obj=<?php echo md5('vista/mantenimiento/departamento.php');?>">Departamentos</a></li>
							<li><a href="?obj=<?php echo md5('vista/mantenimiento/tipoDoc.php');?>">Tipo Documento</a></li>
                           
                            <li><a href="?obj=<?php echo md5('vista/mantenimiento/resena.php');?>">Reseña</a></li>
							<li class="divider"></li>
							<li class="dropdown-header">Entidades</li>
							<li><a href="?obj=<?php echo md5('vista/mantenimiento/entidad.php');?>">Criadores - Propietarios - Socios</a></li>
							<li class="divider"></li>
							<li class="dropdown-header">Concursos</li>
							<li><a href="?obj=<?php echo md5('vista/mantenimiento/concursos.php');?>">Registros  <span class="badge badge-danger">new</span></a></li>
							<li><a href="?obj=<?php echo md5('vista/mantenimiento/resultados.php');?>">Resultados  <span class="badge badge-danger">new</span></a></li>
							<!--<li><a href="#"></a></li>
							<li><a href="#">Asociados</a></li></li>-->
						</ul>
					</li>
					<li class="col-sm-3">
						<ul>
							<li class="dropdown-header">Ejemplares</li>
							<!--<li><a href="?obj=<?php echo md5('vista/mantenimiento/registrarEjemplar.php');?>">Registrar Ejemplar</a></li>-->
							<li><a href="?obj=<?php echo md5('vista/mantenimiento/ejemplar.php');?>">Gestionar Ejemplar</a></li>
								<li class="divider"></li>
							<li class="dropdown-header">Proceso en Linea</li>
							<li><a href="?obj=<?php echo md5('vista/proceso/inscripcion.php');?>"> Inscripciones <span class="badge badge-danger">new</span></a></li>
							<li><a href="?obj=<?php echo md5('vista/proceso/nacimiento.php');?>"> Nacimientos <span class="badge badge-danger">new</span></a></li>
							<li><a href="?obj=<?php echo md5('vista/proceso/monta.php');?>"> Servicio de monta <span class="badge badge-danger">new</span></a></li>
							<li><a href="?obj=<?php echo md5('vista/proceso/novedades.php');?>"> Novedades <span class="badge badge-danger">new</span></a></li>
                            	<li class="divider"></li>
                            <li class="dropdown-header">Transferencias</li>
							<li><a href="?obj=<?php echo md5('vista/mantenimiento/transferencia.php');?>">Gestionar Transfer.</a></li>
							<!--<li><a href="#">Aprobar Transferencias</a></li>
                            <li><a href="#">Consultar</a></li>
							-->
							<li class="divider"></li>
							<li class="dropdown-header">Cierre Mensual</li>
							<li><a href="?obj=<?php echo md5('vista/reporte/rptCierreMes.php');?>">Reportes</a></li>
						</ul>
					</li>
			<?php }?>	
			<?php if($_SESSION[Constantes::K_SESSION_CARGO_USUARIO]==1 || $_SESSION[Constantes::K_SESSION_CARGO_USUARIO]==2 || $_SESSION[Constantes::K_SESSION_CARGO_USUARIO]==3){ ?>
			<li class="col-sm-3">
				<ul>
					<li class="dropdown-header">Consultas</li>
					<li><a href="?obj=<?php echo md5('vista/consulta/ejemplar.php');?>">General Ejemplar.</a></li>
					<li class="dropdown-header">Reportes</li>
					    <li class="divider"></li>
					<li><a href="?obj=<?php echo md5('vista/reporte/rptAdn.php');?>">Reporte ADN</a></li>
					<li><a href="?obj=<?php echo md5('vista/reporte/rptNumEjemXCriador.php');?>">Número Nacidos X Criador</a></li>
					<li><a href="?obj=<?php echo md5('vista/reporte/rptNumNacXTipo.php');?>">Número Nacidos X T.E </a></li>
					<!--<li><a href="?obj=<?php echo md5('vista/reporte/rptNumServY.php');?>">Servicio Yegua Anual</a>
					</li>
					<li><a href="?obj=<?php echo md5('vista/reporte/rptNumServP.php');?>">Servicio Potro Anual</a>
					</li>-->
					<li><a href="?obj=<?php echo md5('vista/reporte/rptCriadorPrefijo.php');?>">Criador - Prefijo</a></li>
					<li><a href="?obj=<?php echo md5('vista/reporte/rptCriadorDpto.php');?>">Criador x Departamento</a></li>
					 <li class="divider"></li>
				</ul>
			</li>
			<?php }?>		
            
            <?php if($_SESSION[Constantes::K_SESSION_CARGO_USUARIO]==1){ ?>
            <li class="col-sm-3">
						<ul>
							<li class="dropdown-header">Accesos y seguridad</li>
							<li><a href="?obj=<?php echo md5('vista/mantenimiento/oficina.php');?>">Oficina</a></li>
							<li><a href="?obj=<?php echo md5('vista/mantenimiento/usuarioRol.php');?>">Usuarios - Perfil</a></li>
							<li><a href="?obj=<?php echo md5('vista/configuracion/setting.php');?>">Configurador - SRG</a></li>
							<li class="divider"></li>
						</ul>
					</li>
			<?php }?>
				</ul>
			</li>
			
		</ul>
		
        <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">	
            <a href="?obj=<?php echo md5('vista/proceso/inscripcion.php');?>" style="color: #f9f6f6;">
                <span class="glyphicon glyphicon-paperclip" style="left: 40px; font-size: 19px;" data-toggle="tooltip" data-placement="bottom" title="Nuevas Solicitudes de inscripción">
                	<span id="cantInscripciones" class="badge badge-danger noti-icon-badge" style="display: inline-block;position: relative;top: -14px;left:-27px;padding-top: 2px;padding-right: 4px;padding-bottom: 2px;padding-left: 4px; font-size: 15px;">
                	</span>
            	</span>
            </a> 
        </li>

        <li class="dropdown">	<a href="?obj=<?php echo md5('vista/proceso/nacimiento.php');?>" style="color: #f9f6f6;"><span class="glyphicon glyphicon-bell" style="left: 15px;font-size: 19px;" data-toggle="tooltip" data-placement="bottom" title="Nuevas Solicitudes de nacimiento">
        	<span id="cantNacimientos" class="badge badge-danger noti-icon-badge" style="display: inline-block;position: relative;top: -14px;left:-27px;padding-top: 2px;padding-right: 4px;padding-bottom: 2px;padding-left: 4px; font-size: 15px;"></span></span></a> </li>

        	<li class="dropdown">	<a href="?obj=<?php echo md5('vista/proceso/novedades.php');?>" style="color: #f9f6f6;"><span class="glyphicon glyphicon-envelope" style="font-size: 19px;" data-toggle="tooltip" data-placement="bottom" title="Nuevas novedades de ejemplares">
        	<span id="cantNovedades" class="badge badge-danger noti-icon-badge" style="display: inline-block;position: relative;top: -14px;left:-25px;padding-top: 2px;padding-right: 4px;padding-bottom: 2px;padding-left: 4px; font-size: 15px;"></span></span></a> </li>
                                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <span class="glyphicon glyphicon-user"></span>
                                       BIENVENIDO:  <?=isset($_SESSION['Login'])?$_SESSION['Login']:""?>
                                        <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <div class="navbar-content">
                                                    <div class="row">
                                                        
                                                        <div class="col-md-9">
                                                            <span><?=isset($_SESSION['NombresCompletos'])?$_SESSION['NombresCompletos']:''?></span>
                                                            <p class="text-muted small">
                                                                <?=isset($_SESSION['Correo'])?$_SESSION['Correo']:''?></p>
                                                            <p class="text-muted small">
                                                              PERFIL:   <?=isset($_SESSION['Rol'])?$_SESSION['Rol']:''?></p>
                                                            <div class="divider">
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="navbar-footer">
                                                    <div class="navbar-footer-content">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <a href="login.php" class="btn btn-default btn-sm pull-right">Finalizar sesi&oacute;n</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
		
	</div><!-- /.nav-collapse -->
</nav> 