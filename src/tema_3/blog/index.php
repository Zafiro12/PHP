<?php
require_once "admin/conexion.php";
session_name("Blog_Curso22_23");
session_start();


function pagina_error($error)
{
    echo "<!DOCTYPE html>
    <html lang='es'>
    
    <head>
        <meta charset='UTF-8'>
        <title>Error</title>
    </head>
    
    <body>
        <h1>Ha ocurrido un error</h1>
        <p>" . $error . "</p>
        <button href='index.php'>Volver</button>
    </body>
    
    </html>";
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
</head>

<body>
    <h1>Blog personal</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Nombre de usuario</label>
            <input type="text" name="usuario" id="usuario">
        </p>
        <p>
            <label for="clave">Contraseña</label>
            <input type="password" name="clave" id="clave">
        </p>
        <input type="submit" value="Entrar">
        <input type="submit" formaction="#" value="Registrarse">
    </form>
</body>

</html>