<?php
if(isset($_POST["btnLogin"]))
{
    $error_usuario=$_POST["usuario"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_form=$error_usuario||$error_clave;
    if(!$error_form)
    {
        $url=DIR_SERV."/login";
        $datos["lector"]=$_POST["usuario"];
        $datos["clave"]=md5($_POST["clave"]);
        $respuesta=consumir_servicios_REST($url,"POST",$datos);
        $obj=json_decode($respuesta);
        if(!$obj)
            die(error_page("Examen Librería","Librería","<p>".$respuesta."</p>"));
        
        if(isset($obj->error))
            die(error_page("Examen Librería","Librería","<p>".$obj->error."</p>"));

        if(isset($obj->mensaje))
        {
            $error_usuario=true;
        }
        else
        {
            $_SESSION["usuario"]=$datos["lector"];
            $_SESSION["clave"]=$datos["clave"];
            $_SESSION["ultimo_acceso"]=time();
            $_SESSION["key"]["api_session"]=$obj->api_session;
            if($obj->usuario->tipo=="normal")
                header("Location:index.php");
            else
                header("Location:admin/index.php");
            exit();
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
    <title>Examen Librería</title>
    <style>
        #libros{overflow:hidden}
        .libro{float:left;width:33.3333%; text-align:center;margin:1.5em 0}
        .libro img{width:70%}
    </style>
</head>
<body>
    <h1>Librería</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>"/>
            <?php
            if(isset($_POST["btnLogin"])&& $error_usuario)
            {
                if($_POST["usuario"]=="")
                    echo "<span class='error'> * Campo vacío * </span>";
                else
                    echo "<span class='error'> * Usuario y/o clave incorrectos * </span>";
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave"/>
            <?php
            if(isset($_POST["btnLogin"])&& $error_clave)
                echo "<span class='error'> * Campo vacío * </span>";
            ?>
        </p>
        <p>
            <button type="submit" name="btnLogin">Login</button>
        </p>
    </form>

    <?php
    if(isset($_SESSION["seguridad"]))
    {
        echo "<p class='mensaje'>".$_SESSION["seguridad"]."</p>";
        session_destroy();
    }

    require "vistas/vista_libros.php";
    
    ?>
</body>
</html>