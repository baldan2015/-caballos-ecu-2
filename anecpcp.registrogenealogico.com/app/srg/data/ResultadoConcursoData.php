<?php

date_default_timezone_set('UTC');

include_once("modelo.php");
if (file_exists("../entidad/ResultadoConcurso.php")) include_once("../entidad/ResultadoConcurso.php");
if (file_exists("../entidad/Resultado.inc.php"))  include_once("../entidad/Resultado.inc.php");

if (file_exists("../../entidad/ResultadoConcurso.php")) include_once("../../entidad/ResultadoConcurso.php");
if (file_exists("../../entidad/Resultado.inc.php"))  include_once("../../entidad/Resultado.inc.php");

class ResultadoConcursoData extends dal
{

    public $retorno;
    function __construct()
    {
        parent::dal();
        $retorno = new Resultado();
    }


    public function insertar($concurso, $ejemplar, $puesto, $propietario, $grupo, $categoria, $idProp, $usuario)
    {
        $retorno = new Resultado();

        $sql = "CALL SGESI_RESULTADO_CONCURSO_EJEMPLAR('$concurso','$ejemplar','$puesto','$propietario','$grupo','$categoria','$idProp',$usuario)";
        $result = parent::ejecutar2($sql);
        //echo $sql;
        if ($result) {
            if ($fila = mysqli_fetch_array($result)) {
                if ($fila[0] == 1) {
                    $retorno->result = 1;
                } else {
                    $retorno->result = 2;
                }
            }
        } else {
            $retorno->result = 0;
        }

        return  $retorno;
    }

    public function editar($codigo, $concurso, $ejemplar, $puesto, $propietario, $grupo, $categoria, $idProp, $usuario)
    {
        $retorno = new Resultado();
        $sql = "CALL SGESU_RESULTADO_CONCURSO('$codigo','$concurso','$ejemplar','$puesto','$propietario','$grupo','$categoria','$idProp','$usuario',@vresultado)";
        $result = parent::ejecutar2($sql, '@vresultado');
        //echo $sql;
        if ($result) {
            if ($fila = mysqli_fetch_array($result)) {
                if ($fila[0] == 1) {
                    $retorno->result = 1;
                } else {
                    $retorno->result = 2;
                }
            }
        } else {
            $retorno->result = 0;
        }
        return  $retorno;
    }

    public function eliminar($codigo, $usuario)
    {
        $retorno = new Resultado();
        $sql = "CALL SGESD_RESULTADOS_CONCURSO_X_ID('$codigo','$usuario')";
        $result = parent::ejecutar2($sql);
        //ECHO $sql;
        if ($result) {
            if ($fila = mysqli_fetch_array($result)) {
                if ($fila[0] == 1) {
                    $retorno->result = 1;
                } else {
                    $retorno->result = 2;
                }
            }
        } else {
            $retorno->result = 0;
        }
        return  $retorno;
    }

    //function para buscar
    public function buscar($nombre, $fecha, $start, $limit, $sidx, $sord)
    {
        $retorno = new Resultado();
        $sql = "CALL SGESS_RESULTADO_CONCURSO_JQGRID('$nombre','$fecha','$start','$limit','$sidx','$sord')";
        //echo $sql ;
        $result = parent::ejecutar2($sql);
        $collection = [];
        while ($fila = mysqli_fetch_object($result)) {

            $obj = new ResultadoConcurso();
            $obj->idResultado = $fila->idResultado;
            $obj->idConcurso = $fila->idConcurso;
            $obj->concurso = $fila->concurso;
            $obj->idEjemplar = $fila->idEjemplar;
            $obj->nroPuesto = $fila->nroPuesto;
            $obj->propietario = $fila->propietario;
            $obj->desGrupo = $fila->desGrupo;
            $obj->desCategoria = $fila->desCategoria;
            $obj->juez = $fila->juez;
            $obj->fecha = $fila->fecha;
            $collection[] = $obj;
        }
        return $collection;
    }
    public function numeroRegistro($nomConcurso, $fecha)
    {
        // $retorno=new Resultado();
        $sql = "CALL SGESS_CUENTA_RESULTADO_CONCURSO_JQGRID('$nomConcurso','$fecha')";
        // echo $sql ;
        $result = parent::ejecutar2($sql);
        $num_row = 0;
        while ($fila = mysqli_fetch_object($result)) {
            $num_row = $fila->num_row;
        }
        return $num_row;
    }
    public function datosConcurso($id)
    {
        $sql = "CALL SGESS_RESULTADO_CONCURSO_X_ID('$id')";
        $result = parent::ejecutar2($sql);
        $collection = [];

        while ($fila = mysqli_fetch_object($result)) {
            $obj = new stdClass();
            $obj->idResultado = $fila->idResultado;
            $obj->idConcurso = $fila->idConcurso;
            $obj->nombre = $fila->nombre;
            $obj->fecha = $fila->fechastring;
            $obj->juez = $fila->juez;
            $obj->desCategoria = $fila->desCategoria;
            $obj->desGrupo = $fila->desGrupo;
            $obj->idEjemplar = $fila->idEjemplar;
            $obj->nroPuesto = $fila->nroPuesto;
            $obj->nombreEjemplar = $fila->nombreEjemplar;
            $obj->idProp = $fila->idProp;
            $obj->propietario = $fila->propietario;
            $collection[] = $obj;
        }
        return $collection;
    }
    public function listarEjemplares($nombreEjemplar,$start,$limit,$sidx,$sord){
        $sql="CALL SGESS_EJEMPLAR('$nombreEjemplar','$start','$limit','$sidx','$sord')";
        $result = parent::ejecutar2($sql);
        //echo $sql;
        $collection = [];
        while($fila = mysqli_fetch_object($result)){
            $obj = new stdClass();
            $obj->codigo = $fila->codigo;
            $obj->ejemplar = $fila->prefij.' - '.$fila->nombre;
            $obj->idProp = $fila->idProp;
            $obj->propietario = $fila->propietario;
            $collection[]=$obj;
        }
        return $collection;
    }
    public function numeroRegistroEjemplares($nomConcurso){
        $sql = "CALL SGESS_CUENTA_EJEMPLAR('$nomConcurso')";
        $result = parent::ejecutar2($sql);
        $num_row = 0;
        while ($fila = mysqli_fetch_object($result)) {
            $num_row = $fila->num_row;
        }
        return $num_row;
    }
    public function ComboConcursos(){
        $sql = "CALL SGESS_CONCURSOS()";
        $result = parent::ejecutar2($sql);
        $collection = [];
        while($fila = mysqli_fetch_object($result)){
            $obj = new stdClass();
            $obj->id = $fila->idConcurso;
            $obj->nombre = $fila->nombre;
            $obj->fecha = $fila->fecha;
            $obj->juez = $fila->juez;
            $obj->activo = $fila->activo;
            $collection[]=$obj;
        }
        return $collection;
    }
}
