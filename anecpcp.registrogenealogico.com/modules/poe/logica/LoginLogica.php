<?php
    if (file_exists("../data/LoginData.php")) {
        include_once("../data/LoginData.php");
    }
    if (file_exists("../entidad/Login.php")) {
        include_once("../entidad/Login.php");
        
    }
      if (file_exists("../entity/personaUsuario.php")) {
        include_once("../entity/personaUsuario.php");
        
    }
    
    class LoginLogica{
        
        public $context;
        public function LoginLogica(){
            $this->context = new LoginData();
        }

        public function ValidarLogin($entity){
            $usuario = $this->context->ValidarLogin($entity);
            return $usuario;
        }
    }
?>
