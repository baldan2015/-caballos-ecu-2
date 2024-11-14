<?php //header('Content-type: application/json; charset=utf-8'); 
require("constante.php");
require(DIR_FUNCTION."conectar.php");
require(DIR_FUNCTION."queries.php");
require(DIR_FUNCTION."general.php");
$jsondata = array();



function ConcursoLista($link){
$sql="SELECT idConcurso,nombre FROM concurso WHERE activo=1 and fecha > date(now() )";
$rs=mysql_query($sql,$link)or die("Error en cadena de ConcursoItems ".mysql_error($link));
$n=mysql_num_rows($rs);	
while($rows=mysqli_fetch_array($rs))
			{
				$arrayrs[]=array(
						 'id'=>$rows[0],	
						 'nombre'=>$rows[1]
						  );
			}
mysql_close($link);
return $arrayrs;
}

$data=ConcursoLista($link);
//$data2=ConcursoInscripcion($link);
//echo "<pre>";print_r($data);
echo "<select id='ddlConcurso' class='dllEstilo' style='width:200px;'>";
echo "<option value='-1'>Seleccione Concurso</option>";
if(sizeof($data)>0){
	//if(sizeof($data2)==0){
			for ($i=0; $i < sizeof($data); $i++) { 
				echo "<option value=".$data[$i]["id"].">".$data[$i]["nombre"]."</option>";
			} 
	//}else{
	//		echo "<option value=-1>Ya tiene un catalogo</option>";
	//	}
}else{
	echo "<option value='-1'>No hay Concursos</option>";
}
echo "</select>";
  
    //exit(); 
?>
<script>
$(function(){

	$("#ddlConcurso").on("change",function(){
		listarCategoXConcurso($(this).val());
	});
});
</script>
<style>
.dllEstilo{

 /*width: 250px;*/

}
</style>