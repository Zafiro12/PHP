<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In PDO</title>
</head>

<body>
    <h1>Log In con PDO</h1>

    <form action="index.php" method="post">
        <div>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" />
        </div>

        <div>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave" />
        </div>

        <div>
            <input type="submit" name="login" value="Log In" />
            <input type="reset" value="Borrar" />
        </div>
    </form>
</body>

</html>