<?php if (file_exists("../../data/EjemplarDataXls.php")) include_once("../../data/EjemplarDataXls.php");
  class EjemplarLogicaXls{
        public $context;
        public function EjemplarLogicaXls(){
            $this->context = new EjemplarDataXls();
        }
        public function buscarSearchXls($id,$pref,$nom,$prop,$cria,$genero,$emin,$emax,$estado,$ente,$start=1, $limit=100,$sidx=1,$sord=""){
            $registros = $this->context->buscarSearchXls($id,$pref,$nom,$prop,$cria,$genero,$emin,$emax,$estado,$ente,$start,$limit,$sidx,$sord);
            return $registros;
        }
  }
?>
