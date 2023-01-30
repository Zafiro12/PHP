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
    echo json_encode(productos());
});

$app->put("/productos/actualizar/{cod}", function ($request) {
    echo json_encode(productos());
});

$app->delete("/productos/borrar/{cod}", function ($request) {
    echo json_encode(productos());
});

try {
    $app->run();
} catch (Throwable $e) {
    echo $e;
}
