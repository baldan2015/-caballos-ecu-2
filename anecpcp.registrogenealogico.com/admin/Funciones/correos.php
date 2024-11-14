<?
function enviarcorreo($mail,$session,$pwd)
{


$destinatario=$mail;
$asunto="Datos de Usuario";
$cuerpo="Su datos para el acceso al registro genealógico son : <br>Usuario:".$session." <br>clave: ".$pwd.".";

//para el envío en formato HTML
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From: <luisrobinwongponce@hotmail.com>\r\n"; 

//mail($destinatario,$asunto,$cuerpo,$headers) ;

mail($destinatario,$asunto,$cuerpo,"luisrobinwongponce@hotmail.com"); 

}

?>