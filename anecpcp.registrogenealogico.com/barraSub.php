<div class="cssBarraSubMenu"  >
			   <?php 
					if(isset($_SESSION['xusu']) && isset($_SESSION['xid']))
					{
					if($_SESSION['xusu']=="Desconocido")
					{ echo "<img src='img/b_usrdrop.png'>".$_SESSION['xusu'];}
					else
					{
					   echo "<img src='img/b_usrcheck.png'>&nbsp;Bienvenido: ".$_SESSION['xusu'];
					}
					}
					else
					{
					echo "<img src='img/b_usrdrop.png'>Usuario no ha iniciado session !";
					}
					?>
				 
				 &nbsp;&nbsp;|&nbsp;&nbsp;
				 <a href="logoff.php" title='finalizar sesión actual' ><span>Cerrar Sesión</span></a> 
</div>