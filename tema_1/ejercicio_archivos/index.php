<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejemplo de Formulario</title>
</head>

<body>
    <?php
    function validar_dni($dni)
    {
        $letra = substr($dni, -1);
        $numeros = substr($dni, 0, -1);
        if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros % 23, 1) == $letra && strlen($letra) == 1 && strlen($numeros) == 8) {
            return true;
        } else {
            return false;
        }
    }

    if (isset($_POST['enviar'])) {
        $error_archivo = $_FILES["foto"]["name"] == "" || $_FILES["foto"]["error"] || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1000;
        $error_dni = !validar_dni($_POST['nif']);
        $error_nombre = $_POST['nombre'] == "" || strlen($_POST['nombre']) > 20;
        $error_usuario = $_POST['usuario'] == "" || strlen($_POST['usuario']) > 20;
        $error_contrasena = $_POST['pwd'] == "" || strlen($_POST['pwd']) > 20;
        if (!$error_archivo && !$error_dni && !$error_nombre && !$error_usuario && !$error_contrasena) {
            $nombre = $_POST['nombre'];
            $usuario = $_POST['usuario'];
            $contrasena = $_POST['pwd'];
            $nif = $_POST['nif'];
            $foto = $_FILES['foto']['name'];
            $sexo = $_POST['sexo'];
            $sub = $_POST['sub'];
    ?>
            <h1>Datos Enviados</h1>
        <?php
            echo "<p>Nombre: $nombre</p>";
            echo "<p>Usuario: $usuario</p>";
            echo "<p>Contraseña: $pwd</p>";
            echo "<p>NIF: $nif</p>";
            echo "<p>Sexo: $sexo</p>";
            echo "<p>Foto: $foto</p>";
            echo "<p>Suscripción: $sub</p>";
        }
    } else {
        ?>

        <h1>Rellena tu CV</h1>
        <form action="index.php" method="post" enctype="multipart/form-data">
            <label for="nombre">Nombre:<br></label>
            <input type="text" name="nombre" id="nombre" value="<?php
                                                                if (isset($_POST['enviar'])) {
                                                                    echo $_POST['nombre'];
                                                                }
                                                                ?>"><?php if (isset($_POST['enviar']) && $_POST['nombre'] == "") {
                                                                        echo "<span style='color:red;'>* Campo Obligatorio</span>";
                                                                    } ?>
            <br><br>

            <label for="usuario">Usuario:<br></label>
            <input type="text" name="usuario" id="usuario" value="<?php
                                                                    if (isset($_POST['enviar'])) {
                                                                        echo $_POST['usuario'];
                                                                    }
                                                                    ?>"><?php if (isset($_POST['enviar']) && $_POST['usuario'] == "") {
                                                                            echo "<span style='color:red;'>* Campo Obligatorio</span>";
                                                                        } ?>
            <br><br>

            <label for="pwd">Contraseña:<br></label>
            <input type="password" name="pwd" id="pwd"><?php if (isset($_POST['enviar']) && $_POST['pwd'] == "") {
                                                            echo "<span style='color:red;'>* Campo Obligatorio</span>";
                                                        } ?>
            <br><br>

            <label for="nif">DNI<br></label>
            <input type="text" name="nif" id="nif" value="<?php
                                                            if (isset($_POST['enviar'])) {
                                                                echo $_POST['nif'];
                                                            }
                                                            ?>"><?php if (isset($_POST['enviar'])) {
                                                                    $nif = $_POST['nif'];
                                                                    if ($nif == "") {
                                                                        echo "<span style='color:red;'>* Campo Obligatorio</span>";
                                                                    } elseif (validar_dni($nif) == false) {
                                                                        echo "<span style='color:red;'>* NIF no válido</span>";
                                                                    }
                                                                } ?>
            <br><br>

            <label for="sexo">Sexo<br></label>
            <input type="radio" name="sexo" value="Hombre" id="sexo" checked>Hombre<br>
            <input type="radio" name="sexo" value="Mujer" id="sexo">Mujer<br>
            <br><br>

            <label for="foto">Incluir mi foto (Archivo tipo imagen máx. 500kb):</label>
            <input type="file" name="foto" id="foto">
            <br><br>

            <input type="checkbox" name="sub" id="sub" checked>
            <label for="sub">Subscribirse al boletín de Novedades</label>
            <br><br>

            <input type="submit" name="enviar" value="Guardar cambios">
            <input type="reset" value="Borrar los datos introducidos">
        </form>
    <?php
    }
    ?>
</body>

</html>