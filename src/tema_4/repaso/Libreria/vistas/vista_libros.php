<?php
echo "<h2>Listado de los libros</h2>";
$url=DIR_SERV."/obtenerLibros";
$respuesta=consumir_servicios_REST($url,"GET");
$obj=json_decode($respuesta);
if(!$obj)
{
    if(isset($_SESSION["usuario"]))
    {
        consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["key"]);
        session_destroy();
    }

    die("<p>Error consumiendo el servicio: ".$url."</p></body></html>");
}

if(isset($obj->error))
{
    if(isset($_SESSION["usuario"]))
    {
        consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["key"]);
        session_destroy();
    }
    die("<p>".$obj->error."</p></body></html>");
}
echo "<div id='libros'>";
foreach($obj->libros as $libro)
{
    echo "<div class='libro'>";
    echo "<img src='images/".$libro->portada."' title='".$libro->titulo."' alt='".$libro->titulo."'/><br/>";
    echo $libro->titulo." - ".$libro->precio." €";
    echo "</div>";
} 

echo "</div>";
?>