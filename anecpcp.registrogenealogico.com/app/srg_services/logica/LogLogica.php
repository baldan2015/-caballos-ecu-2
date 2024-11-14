<?php
    if (file_exists("../data/LogData.php")) {
        require_once("../data/LogData.php");
    }
    
    class LogLogica{
        
        public $context;
        public function LogLogica(){
            $this->context = new LogData();
        }

        public function ExisteSessionId($idSession){
            $existe = $this->context->ExisteSessionId($idSession);
            return $existe;
        }
    }
?>
