<?php

use Slim\App;

require "./src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new App;


$app->get('/conexion_PDO', function () {

    echo json_encode(conexion_pdo(), JSON_FORCE_OBJECT);
});

$app->post('/login', function ($request) {
    $datos[] = $request->getParam('usuario');
    $datos[] = $request->getParam('clave');

    echo json_encode(login($datos));
});

$app->get('/horario/{id_usuario}', function ($request) {

    $id_usuario = $request->getAttribute("id_usuario");
    $resultado = json_encode(horario_usuario($id_usuario));
    echo $resultado;
});

$app->get('/usuarios', function () {

    $resultado = json_encode(usuarios_normales());
    echo $resultado;
});

$app->get('/tieneGrupo/{dia}/{hora}/{id_usuario}', function ($request) {

    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getAttribute("id_usuario");

    $resultado = json_encode(tiene_grupo($datos));
    echo $resultado;
});

$app->get('/grupos/{dia}/{hora}/{id_usuario}', function ($request) {

    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getAttribute("id_usuario");

    $resultado = json_encode(grupos($datos));
    echo $resultado;
});

$app->get('/gruposLibres/{dia}/{hora}/{id_usuario}', function ($request) {

    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getAttribute("id_usuario");

    $resultado = json_encode(grupos_libres($datos));
    echo $resultado;
});

$app->delete('/borrarGrupo/{dia}/{hora}/{id_usuario}/{id_grupo}', function ($request) {

    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getAttribute("id_usuario");
    $datos[] = $request->getAttribute("id_grupo");

    $resultado = json_encode(borrar_grupo($datos));
    echo $resultado;
});

$app->post('/insertarGrupo/{dia}/{hora}/{id_usuario}/{id_grupo}', function ($request) {

    $datos[] = $request->getAttribute("dia");
    $datos[] = $request->getAttribute("hora");
    $datos[] = $request->getAttribute("id_usuario");
    $datos[] = $request->getAttribute("id_grupo");

    $resultado = json_encode(insertar_grupo($datos));
    echo $resultado;
});


$app->run();
