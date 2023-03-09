<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;



$app->get('/conexion_PDO',function($request){

    echo json_encode(conexion_pdo());
});

$app->post('/login',function($request){
    $datos[] = $request->getParam("usuario");
    $datos[] = $request->getParam("clave");
    
    echo json_encode(login($datos));
});

$app->get('/logueado',function($request){
    session_id($request->getParam("api_session"));
    session_start();
    
    if (isset($_SESSION["usuario"])) {
        $datos[] = $_SESSION["usuario"]["usuario"];
        $datos[] = $_SESSION["usuario"]["clave"];

        echo json_encode(logueado($datos));
    } else {
        session_destroy();
        $respuesta["no_auth"] = "No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }
});

$app->post('/salir',function($request){
    session_id($request->getParam("api_session"));
    session_start();
    session_destroy();

    $respuesta["log_out"] = "Cerrada sesión en la API";
    echo json_encode($respuesta);
});

$app->get('/usuario/{id_usuario}',function($request){
    session_id($request->getParam("api_session"));
    session_start();
    
    if (isset($_SESSION["usuario"])) {
        $datos[] = $request->getAttribute("id_usuario");

        echo json_encode(usuario($datos));
    } else {
        session_destroy();
        $respuesta["no_auth"] = "No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }
});

$app->get('/usuariosGuardia/{dia}/{hora}',function($request){
    session_id($request->getParam("api_session"));
    session_start();
    
    if (isset($_SESSION["usuario"])) {
        $datos[] = $request->getAttribute("dia");
        $datos[] = $request->getAttribute("hora");

        echo json_encode(usuariosGuardia($datos));
    } else {
        session_destroy();
        $respuesta["no_auth"] = "No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }
});

$app->get('/deGuardia/{dia}/{hora}/{id_usuario}',function($request){
    session_id($request->getParam("api_session"));
    session_start();
    
    if (isset($_SESSION["usuario"])) {
        $datos[] = $request->getAttribute("dia");
        $datos[] = $request->getAttribute("hora");
        $datos[] = $request->getAttribute("id_usuario");

        echo json_encode(deGuardia($datos));
    } else {
        session_destroy();
        $respuesta["no_auth"] = "No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }
});

// Una vez creado servicios los pongo a disposición
$app->run();
