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
/* TODO Terminar el resto de la api
$app->post("/producto/insertar", function ($request) {
    echo json_encode(productos());
});

$app->get("/productos/actualizar/{cod}", function ($request) {
    echo json_encode(productos());
});

$app->get("/productos/borrar/{cod}", function ($request) {
    echo json_encode(productos());
});
*/
try {
    $app->run();
} catch (Throwable $e) {
    echo $e;
}
