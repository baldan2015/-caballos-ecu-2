<?php //header('Content-type: application/json; charset=utf-8'); 
require("constante.php");
require(DIR_FUNCTION."conectar.php");
require(DIR_FUNCTION."queries.php");
require(DIR_FUNCTION."general.php");
$jsondata = array();
$data=CategoriaXConcursoItems($_POST['id'],$link);
echo "<select id='ddlCategoria' class='dllEstilo'>";

if($_POST['id']!=-1){
echo "<option value='-1'>Seleccione Categoria</option>";	
if(sizeof($data)>0){
for ($i=0; $i < sizeof($data); $i++) { 
	echo "<option value=".$data[$i]["id"].">".$data[$i]["nombre"]."</option>";
} 
}else{
	echo "<option value='-1'>No hay Categorias</option>";
}
}else{

		echo "<option value='-1'>Seleccione Concurso</option>";
}

echo "</select>";
  
    //exit(); 
?>
<script>
$(function(){

	$("#ddlCategoria").on("change",function(){
		listarGrupoXCatego($(this).val());
	});
});
</script>
<style>
.dllEstilo{

 width: 250px;

}
</style>