<?php
require_once "admin/conexion.php";
require_once "admin/config.php";
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

if (isset($_POST["login"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_clave || $error_usuario;

    if (!$error_form) {
        $conexion = new Conexion(HOST, DB, USER, PASSWORD);

        
    }
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
            <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
            <?php
                if (isset($_POST["usuario"]) && $error_usuario) {
                    if ($_POST["usuario"] == "") {
                        echo "<span style='color: red;'>*Campo vacío</span>";
                    } else {
                        echo "<span style='color: red;'>*El usuario no es correcto</span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña</label>
            <input type="password" name="clave" id="clave">
        </p>
        <input type="submit" name="login" value="Entrar">
        <input type="submit" formaction="#" value="Registrarse">
    </form>
</body>

</html>