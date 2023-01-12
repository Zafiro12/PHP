<?php
    session_name("login");
    session_start();

    require_once("views/config.php");


    function error_page($error_message) {
        http_response_code(500);
        echo '<html>
                <head>
                    <title>Error</title>
                </head>
                <body>
                    <h1>Error</h1>
                    <p>' . $error_message . '</p>
                </body>
            </html>';
        exit();
    }
    

    if (isset($_SESSION["usuario"]))
    {
        try
        {
            $consulta = "select * from usuarios where usuario=? and clave=?";
            $sentencia=$conexion->prepare($consulta);

            $datos[]=$_SESSION["usuario"];
            $datos[]=md5($_SESSION["clave"]);

            $sentencia->execute($datos);

            if ($sentencia->rowCount()>0)
            {
                // TODO $datos_usuario = ;
            }
        }
        catch(PDOException $e)
        {

        }
        $conexion = null;
    }
    else
    {
        require_once("views/login.php");
    }
?>