<?php
if(!isset($_GET['t'])) die('Debe especificar el token');

$token = $_GET['t'];

$var=Auth::GetData(        $token    );

echo ($var->name);
print_r( $var);

/*var_dump(
    Auth::GetData(
        $token
    )
);*/