<?PHP unset($_SESSION['xid']);//session_unregister('xid');
unset($_SESSION['xusu']);//session_unregister('xusu');
unset($_SESSION['_periodoPoe']);//session_unregister('_periodoPoe');
session_unset($_SESSION['xid']);
session_unset($_SESSION['xusu']);
session_unset($_SESSION['_periodoPoe']); 
unset($_SESSION['cc']);
//include("constante.php");
//include("Funciones/conectar.php");
//require(DIR_CABECERA);

?>
<script language='javascript'> 
	if (typeof(Storage) !== "undefined") {
	 	localStorage.removeItem("Authorization");
		localStorage.clear();
	} else {
	    alert.alert("LocalStorage no soportado en este navegador");
	}

document.location.replace('index.php');
</script>