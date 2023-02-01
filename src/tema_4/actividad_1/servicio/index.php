<?php

use Slim\App;

require __DIR__ . "/Slim/autoload.php";
require "funciones.php";

$app = new App;

$app->get("/productos", function () {
    echo json_encode(productos());
});

$app->get("/producto/{cod}", function ($request) {
    echo json_encode(producto($request->getAttribute("cod")));
});

$app->post("/producto/insertar", function ($request) {
    $datos[] = $request->getParameter("cod");
    $datos[] = $request->getParameter("nombre");
    $datos[] = $request->getParameter("nombre_corto");
    $datos[] = $request->getParameter("descripcion");
    $datos[] = $request->getParameter("PVP");
    $datos[] = $request->getParameter("familia");

    echo json_encode(insertar($datos));
});

$app->put("/producto/actualizar/{cod}", function ($request) {
    echo json_encode(productos());
});

$app->delete("/producto/borrar/{cod}", function ($request) {
    echo json_encode(borrar($request->getAttribute("cod")));
});

try {
    $app->run();
} catch (Throwable $e) {
    echo $e;
}
