<?php   
     require("../Clases/conexion.php");
    require("../Clases/resultado.php");
   //  require(DIR_FUNCTION."general.php");
            
    $cn=new Connection();
    $link=$cn->Conectar();

            $descrip = trim($_GET["term"]);


 $sql =" SELECT razonSocial as a from sgev_entidad where razonSocial like '%".$descrip."%' ";

          /*  $sql ="select distinct q.propie as a from (
    SELECT propie FROM datos220206 WHERE propie like '%".$descrip."%'
    union all
    SELECT criador  FROM datos220206 WHERE criador like '%".$descrip."%') q";
    */
          //  echo $sql;
           // $result = parent::ejecutar2($sql);
                $result = mysqli_query($link,$sql);
            
            while($fila = mysqli_fetch_array($result)){
                 $obj = new Autocompletar();
                 $obj->value = $fila['a'];
                 $obj->descripcion = $fila['a']; 

                 $producto[] = $obj;
                }
                //$obj->precio_venta=$fila->prec_venta;
               //  $obj->stock_almacen=$fila->stock_almacen;
                
                   mysqli_free_result($result);          
               
            
           
            echo json_encode($producto);
      

?>

    
 