<?php
    require("../Clases/conexion.php");
    class DropDown{
        public $text;
        public $val;
    }
	$cn=new Connection();
	$link=$cn->Conectar();
    
    if(isset($_POST['opc'])){
        if($_POST['opc'] == 'listarConcurso'){
            echo listarConcurso($link);
        }elseif($_POST['opc'] == 'listarCategoria'){
            $idConcurso = $_POST['idConcurso'];
            echo listarCategoria($idConcurso,$link);
        }elseif($_POST['opc'] == 'listarGrupo'){
            $idCategoria = $_POST['idCategoria'];
            echo listarGrupo($idCategoria,$link);
        }elseif($_POST['opc'] == 'listarResultado'){
            $idConcurso = $_POST['idConcurso'];
            $idCategoria = $_POST['idCategoria'];
            $idGrupo = $_POST['idGrupo'];
            echo listarResultado($idConcurso,$idCategoria,$idGrupo,$link);
        }elseif($_POST['opc'] == 'validarCodigo'){
            $codigo = $_POST['codigo'];
            echo validarCodigo($codigo,$link);
        }elseif($_POST['opc'] == 'validarPuesto'){
            $idConcurso = $_POST['idConcurso'];
            $idCategoria = $_POST['idCategoria'];
            $idGrupo = $_POST['idGrupo'];
            $puesto = $_POST['puesto'];
            echo validarPuesto($idConcurso,$idCategoria,$idGrupo,$puesto,$link);
        }elseif($_POST['opc'] == 'agregarResultado'){
            $idConcurso = $_POST['idConcurso'];
            $idCategoria = $_POST['idCategoria'];
            $idGrupo = $_POST['idGrupo'];
            $codigo = $_POST['codigo'];
            $puesto = $_POST['puesto'];
            echo agregarResultado($idConcurso,$idCategoria,$idGrupo,$codigo,$puesto,$link);
        }elseif($_POST['opc'] == 'eliminarResultado'){
            $idResultado = $_POST['idResultado'];
            echo eliminarResultado($idResultado,$link);
        }elseif($_POST['opc'] == 'validarRepetido'){
            $idConcurso = $_POST['idConcurso'];
            $idCategoria = $_POST['idCategoria'];
            $idGrupo = $_POST['idGrupo'];
            $codigo = $_POST['codigo'];
            echo validarRepetido($idConcurso,$idCategoria,$idGrupo,$codigo,$link);
        }elseif($_POST['opc'] == 'actualizarResultado'){
            $idResultado = $_POST['idResultado'];
            $idConcurso = $_POST['idConcurso'];
            $idCategoria = $_POST['idCategoria'];
            $idGrupo = $_POST['idGrupo'];
            $propieNombre=$_POST['propie'];
            $puesto = $_POST['puesto'];
            echo actualizarResultado($idResultado,$idConcurso,$idCategoria,$idGrupo,$propieNombre,$puesto,$link);
        }
    }
    function actualizarResultado($idResultado,$idConcurso,$idCategoria,$idGrupo,$propieNombre,$puesto,$link){
        $sql = "select * from resultado where idConcurso = ".$idConcurso." and idCatego = ".$idCategoria." and idGrupo = ".$idGrupo." and propietario=".$propieNombre." and nroPuesto = ".$puesto." ";
       // echo $sql;
        $result = mysqli_query($link,$sql);
        if(mysql_num_rows($result) > 0){
            $r = 2;
        }else{
            $sql = "update resultado set propietario='".$propieNombre."' , nroPuesto = ".$puesto."  where idResultado = ".$idResultado."";
           // echo $sql;
            $result1 = mysqli_query($link,$sql);
            if($result1){
                $r = 1;
            }else{
                $r = 0;
            }
        }

        return $r;
    }
    function validarRepetido($idConcurso,$idCategoria,$idGrupo,$codigo,$link){
        $sql = "select * from resultado where idConcurso = ".$idConcurso." and idCatego = ".$idCategoria." and idGrupo = ".$idGrupo." and idEjemplar = '".$codigo."' ";
        $result = mysqli_query($link,$sql);
        return mysql_num_rows($result);
    }
    
    function eliminarResultado($idResultado,$link){
        $sql = "delete from resultado where idResultado = ".$idResultado;
        $result = mysqli_query($link,$sql);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    function agregarResultado($idConcurso,$idCategoria,$idGrupo,$codigo,$puesto,$link){

        $sql3="select propie from datos220206 where codigo='".$codigo."'  ";


        $rs3=mysql_query($sql3,$link)or die("Error en cadena de consulta 2 ".mysql_error($link));
        $n3=mysql_num_rows($rs3);   
         if($n3>0)
        {     
        $nombreProp=mysql_result($rs3,0,'propie');               
        }
       
       
        $sql = "insert into resultado (idConcurso,idCatego,idGrupo,idEjemplar,propietario,nroPuesto,activo) values (".$idConcurso.",".$idCategoria.",".$idGrupo.",'".$codigo."','".$nombreProp."',".$puesto.",0)";
        $result = mysqli_query($link,$sql);
        if($result){
            return true;
        }else {
            return false;
        }
    }
    function validarCodigo($codigo,$link){
        $sql = "select * from datos220206 where codigo = '".$codigo."' ";
        $result = mysqli_query($link,$sql);
        return mysql_num_rows($result);
    }
    function validarPuesto($idConcurso,$idCategoria,$idGrupo,$puesto,$link){
        $sql = "select * from resultado where idConcurso = ".$idConcurso." and idCatego = ".$idCategoria." and idGrupo = ".$idGrupo." and nroPuesto = ".$puesto;
        $result = mysqli_query($link,$sql);
        return mysql_num_rows($result);
    }
    function listarResultado($idConcurso,$idCategoria,$idGrupo,$link){
        $html = "";
        $html.= "<table style='width:90%;' border=1>";
        $html.= "<thead>";
        $html.= "<th>CODIGO</th>";
        $html.= "<th>NOMBRE</th>";
        $html.="<th>Propietario</th>";
        $html.= "<th>PUESTO</th>";
        $html.= "<th></th>";
        $html.= "</thead>";
        $html.= "<tbody>";
       
        $sql = "SELECT r.idResultado,r.idEjemplar,concat(d.prefij,space(1),d.nombre) as nombre,r.nroPuesto,r.propietario,d.propie from resultado as r inner join datos220206 as d on(d.codigo = r.idEjemplar)
                WHERE r.idConcurso=".$idConcurso." and    r.idCatego=".$idCategoria." and r.idGrupo=".$idGrupo." ORDER BY 4 ASC";

        $result = mysql_query($sql,$link)or die("Error en cadena de listarResultado ".mysql_error($link));
//echo $sql;
        if(mysql_num_rows($result) > 0){
            while($res = mysqli_fetch_array($result)){
                $nombrePropie="";
                if($res['propietario']==""){
                    $nombrePropie=$res['propie'];
                }else{
                    $nombrePropie=$res['propietario'];
                }
                //echo $nombrePropie;
               $html.= "<tr>";
               $html.= "<td align='center'>".$res['idEjemplar']."</td>";
               $html.= "<td>".$res['nombre']."</td>";
               $html.="<td align='center'><input type='text' size='45' id='txtPropietario_".$res['idResultado']."' value='".$nombrePropie."' onkeypress='return actualizarResultado(event,".$res['idResultado'].");' /></td>";
               $html.= "<td align='center'><input type='text' size='6' id='txtResultado_".$res['idResultado']."' value='".$res['nroPuesto']."' onkeypress='return actualizarResultado(event,".$res['idResultado'].");' /></td>";
               $html.= "<td align='center'><span class='icon-bin boton' onclick='return eliminarResultado(".$res['idResultado'].");' ></span></td>";
               $html.= "</tr>";
            }    
        }else{
            $html.= "<tr><td colspan='4' align='center'>No hay registros</td></tr>";
        }
        $html.= "</tbody>";
        $html.= "</table>";
        return $html;
    }
    function listarConcurso($link){
        $sql = "select idConcurso,nombre,fecha,juez,activo from concurso";
        $result = mysqli_query($link,$sql);
        while($res = mysqli_fetch_array($result)){
            $obj = new DropDown();
            $obj->text = $res['nombre'];
            $obj->val = $res['idConcurso'];
            $datos[] = $obj;
        }
        return json_encode($datos);
    }
    function listarCategoria($idConcurso,$link){
        $sql = "select idCatego,idConcurso,nombre,activo from categoria where idConcurso = ".$idConcurso;
        $result = mysqli_query($link,$sql);
        while($res = mysqli_fetch_array($result)){
            $obj = new DropDown();
            $obj->text = $res['nombre'];
            $obj->val = $res['idCatego'];
            $datos[] = $obj;
        }
        return json_encode($datos);
    }
    function listarGrupo($idCategoria,$link){
        $sql = "select idGrupo,idCatego,nombre,activo from grupo where idCatego = ".$idCategoria;
        $result = mysqli_query($link,$sql);
        while($res = mysqli_fetch_array($result)){
            $obj = new DropDown();
            $obj->text = $res['nombre'];
            $obj->val = $res['idGrupo'];
            $datos[] = $obj;
        }
        return json_encode($datos);
    }
?>