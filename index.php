<?php
//IMPORTAMOS EL ARCHIVO CONFIG 
require_once 'config/config.php';
// CAPTURRA LA URL ACTUAL
$currentPageUrl = $_SERVER['REQUEST_URI'];

//VERIIFICAR SI EXISTE LA RUTA ADMIN
$isAdmin = strpos($currentPageUrl, '/' . ADMIN ) !== false;

//COMPROBAR SI EXISTE GET PARA CREAR URLS AMIGABLES
$ruta = empty($_GET['url']) ? 'principal/index' : $_GET['url'];

//CREAR UN ARRAY APARTIR DE LA RUTA
$array = explode('/', $ruta);
print_r($array);

//VALIDAR SI NOS ENCONTRAMOS EN AL RUTA
if ($isAdmin && (count($array) == 1
    || (count($array) == 2 && empty($array[1])))
    && $array[0] == ADMIN) {
    //CREAR CONTROLADOR
    $controller = 'admin';
    $metodo = 'login';
} else {
    $indiceUrl = ($isAdmin) ? 1 : 0;
    $controller = ucfirst($array[$indiceUrl]);
    $metodo = 'index';
}
echo 'Nombre controller: ' . $controller . '<br>';
echo 'Nombre metodo: ' . $metodo . '<br>';


//VALIDAR METODOS
$metodoIndice = ($isAdmin) ? 2 : 1;
if (!empty($array[$metodoIndice]) && $array[$metodoIndice] != ''){
    $metodo = $array[$metodoIndice];
}
$parametro = '';
$parametroIndice = ($isAdmin) ? 3 : 2;
if (!empty($array[$metodoIndice]) && $array[$metodoIndice] != '') { 
    for ($i = $parametroIndice; $i < count($array); $i++) {
    $parametro .= $array[$i] . ', ';
    }
    $parametro = trim($parametro, ',');
}
//VALIDAR DIRECTORIO DE CONTROLADORES
$dirControllers = ($isAdmin) ?  'controllers/admin/'. $controller . '.php' : 'controllers/principal/'. $controller . '.php';
echo $dirControllers;

if (file_exists($dirControllers)) {
    require_once $dirControllers; 
    $controller = new $controller();
    if (method_exists($controller, $metodo)) { 
        $controller->$metodo ($parametro);
    } else {
    echo 'METODO NO EXISTE';
    }
    }else{
    
    echo 'CONTROLADOR NO EXISTE';
    }
?>
 
