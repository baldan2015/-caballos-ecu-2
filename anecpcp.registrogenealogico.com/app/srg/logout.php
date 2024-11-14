<? session_start();
  include_once ("entity/Constantes.php");
 
  session_destroy();
  header("Location: login.php");
  exit;
?>