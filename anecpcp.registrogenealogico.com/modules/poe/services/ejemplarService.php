<?php ini_set('safe_mode', false);
require "../entidad/Constantes.php";
$curl = curl_init();
$headers=getallheaders();
curl_setopt_array($curl, array(
  CURLOPT_URL =>Constantes::K_URL_SERVICIO,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST" ,
  CURLOPT_POSTFIELDS => $_POST,
  CURLOPT_HTTPHEADER => array(
    "Authorization: ".$headers['Authorization']
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

?>
