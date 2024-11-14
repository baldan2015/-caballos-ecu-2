<?php
require_once '../jwt/vendor/autoload.php';
require_once '../jwt/auth.php';

//$key = 'TEONF2ANECPCP';

//if(!isset($_POST['p'])) die('No ha definido la página a visualizar');
if(!isset($_POST['key'])) die('No ha definido la llave');


//$page = strtolower($_POST['p']);
$key = strtolower($_POST['key']);

require_once "../jwt/controllers/autentica.php";


?>