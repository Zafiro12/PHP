<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

$app->get('/obtenerLibros',function($request){
    
    echo json_encode(obtener_libros());
});

$app->post('/login', function($request){
    $datos[] = $request->getParam('lector');
    $datos[] = $request->getParam('clave');

    echo json_encode(login($datos));
});

$app->get('/logueado', function($request){
    session_id($request->getParam('api_session'));
    session_start();

    if (isset($_SESSION["tipo"])) {
        $datos[] = $_SESSION["usuario"];
        $datos[] = $_SESSION["clave"];
        echo json_encode(logueado($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

$app->post('/salir', function($request){
    session_id($request->getParam('api_session'));
    session_start();
    session_destroy();
    echo json_encode(array("log_out" => "Sesión cerrada correctamente"));
});

// Una vez creado servicios los pongo a disposición
$app->run();
