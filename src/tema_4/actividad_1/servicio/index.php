<?php
require __DIR__ . "/Slim/autoload.php";
require "funciones.php";

$app= new \Slim\App;

$app->get("/productos",function(){
    echo json_encode(productos() ,JSON_FORCE_OBJECT);
});

$app->run();
