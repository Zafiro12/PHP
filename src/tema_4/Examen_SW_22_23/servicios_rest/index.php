<?php
session_name("Api_SW_22_23");
session_start();

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;


$app->get('/conexion_PDO', function () {
    echo json_encode(conexion_pdo());
});

$app->post('/login', function ($request) {
    $datos = $request->getParams();

    $respuesta = login($datos);

    if (isset($respuesta["usuario"])) {
        $_SESSION["usuario"] = $respuesta["usuario"];
        $_SESSION["api_session"] = $respuesta["api_session"];
    }

    echo json_encode($respuesta);
});

$app->get('/logueado', function ($request) {
    $datos = $request->getParams();
    if (isset($_SESSION["usuario"]) && isset($_SESSION["api_session"])) {
        if ($_SESSION["api_session"] == $datos["api_session"]) {
            echo json_encode(array("usuario" => $_SESSION["usuario"]));
        } else {
            echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
        }
    } else {
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

$app->get('/salir', function ($request) {
    $datos = $request->getParams();
    if (isset($_SESSION["usuario"]) && isset($_SESSION["api_session"])) {
        if ($_SESSION["api_session"] == $datos["api_session"]) {
            session_destroy();
            echo json_encode(array("log_out" => "Sesión cerrada"));
        }
    }
});

$app->get('/obtenerLibros', function () {
    echo json_encode(obtenerLibros());
});

$app->post('/crearLibro', function ($request) {
    $datos = $request->getParams();

    /*if ($_SESSION["api_session"] != $datos["api_session"]) {
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
        return;
    }*/

    echo json_encode(crearLibro($datos));
});

$app->put('/actualizarPortada/{referencia}', function ($request) {
    $datos = $request->getParams();
    $referencia = $request->getAttribute("referencia");

    /*if ($_SESSION["api_session"] != $datos["api_session"]) {
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
        return;
    }*/

    echo json_encode(actualizarPortada($referencia, $datos));
});

// Una vez creado servicios los pongo a disposición
$app->run();
