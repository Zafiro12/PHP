<?php
    session_name("login");
    session_start();

    require_once("sql/config.php");


    if (isset($_SESSION["usuario"]))
    {
        echo "Logeado";
    }
    else
    {
        if (isset($_POST["login"]))
        {
            $error_usuario = $_POST["usuario"] == "";
            $error_clave = $_POST["clave"] == "";
            $error_form = $error_usuario || $error_clave;

            if (!$error_form)
            {
                try
                {
                    $conn = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
                    
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    echo "Connected successfully"; 
                }
                catch(PDOException $e)
                {
                    die("Connection failed: " . $e->getMessage());
                }

                try
                {
                    $consulta = "select * from usuarios where usuario=? and clave=?";
                    $sentencia=$conexion->prepare($consulta);

                    $datos[]=$_POST["usuario"];
                    $datos[]=md5($_POST["clave"]);

                    $sentencia->execute($datos);

                    if ($sentencia->rowCount()>0)
                    {
                        $_SESSION["usuario"] = $datos[0];
                        $_SESSION["clave"] = $datos[1];
                        $_SESSION["ultimo_acceso"] = time();

                        header("Location:index.php");
                        exit();
                    }
                    else
                    {
                        $error_usuario = true;
                    }
                }
                catch(PDOException $e)
                {
                    $sentencia=null;
                    $conexion=null;
                    die("Connection failed: " . $e->getMessage());
                }
            }
        }
    ?>

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
                <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>" />
                <?php
                    if (isset($_POST["usuario"]) && $error_usuario)
                    {
                        if ($_POST["usuario"] == "")
                        {
                            echo "<span style='color: red;'>*Campo vacío</span>";
                        }
                        else
                        {
                            echo "<span style='color: red;'>*El usuario no es correcto</span>";
                        }
                    }
                ?>
            </div>

            <div>
                <label for="clave">Contraseña:</label>
                <input type="password" name="clave" id="clave" />
                <?php
                    if (isset($_POST["clave"]) && $error_clave)
                    {
                        echo "<span style='color: red;'>*Campo vacío</span>";
                    }
                ?>
            </div>

            <div>
                <input type="submit" name="login" value="Log In" />
                <input type="reset" value="Borrar" />
            </div>
        </form>
    </body>

    </html>
<?php
}
