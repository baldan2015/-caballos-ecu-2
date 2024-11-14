<?php //header('Content-type: application/json; charset=utf-8'); 
require("constante.php");
require(DIR_FUNCTION."conectar.php");
require(DIR_FUNCTION."queries.php");
require(DIR_FUNCTION."general.php");
$jsondata = array();
$data=grupoXCategoriaItems($_POST['id'],$link);
echo "<select id='ddlGrupo' class='dllEstilo'>";

if($_POST['id']!=-1){
	echo "<option value='-1'>TODOS</option>";
if(sizeof($data)>0){
for ($i=0; $i < sizeof($data); $i++) { 
	echo "<option value=".$data[$i]["id"].">".$data[$i]["nombre"]."</option>";
} 
}else{
	echo "<option value='-1'>No hay Grupos</option>";
}
}else{

		echo "<option value='-1'>TODOS</option>";
}

echo "</select>";
 
?>
<style>
.dllEstilo{

 width: 250px;

}
</style>