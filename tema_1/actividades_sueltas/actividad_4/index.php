<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo de Formulario</title>
</head>
<body>
<?php

if (isset($_POST['Guardar'])) {
    ?>
    <h1>Datos recibidos</h1>
    <?php
    echo "<p><strong>Nombre: </strong>" . $_POST['nombre'] . "</p>";
    echo "<p><strong>Apellidos: </strong>" . $_POST['apellidos'] . "</p>";
    echo "<p><strong>Contraseña: </strong>" . $_POST['pwd'] . "</p>";
    echo "<p><strong>DNI: </strong>" . $_POST['nif'] . "</p>";
    if (isset($_POST['sexo'])) {
        echo "<p><strong>Sexo: </strong>" . $_POST['sexo'] . "</p>";
    }
    echo "<p><strong>Nacido en: </strong>" . $_POST['nacido'] . "</p>";
    echo "<p><strong>Comentarios: </strong>" . $_POST['comentarios'] . "</p>";
    if (isset($_POST['sub'])) {
        echo "<p><strong>Subscripción: </strong>Si</p>";
    } else {
        echo "<p><strong>Subscripción: </strong>No</p>";
    }
    ?>
    <?php
} else {
?>
<h1>Rellena tu CV</h1>
<form action="index.php" method="post" enctype="multipart/form-data">
    <label for="nombre">Nombre:<br></label>
    <input type="text" name="nombre" id="nombre" value="<?php
        if (isset($_POST['nombre'])) {
            echo $_POST['nombre'];
        } else {
            echo "";
        }
    ?>">
    <br>

    <label for="apellidos">Apellidos:<br></label>
    <input type="text" name="apellidos" id="apellidos" value="<?php
    if (isset($_POST['apellidos'])) {
        echo $_POST['apellidos'];
    } else {
        echo "";
    }
    ?>">
    <br>

    <label for="pwd">Contraseña:<br></label>
    <input type="password" name="pwd" id="pwd" value="<?php
    if (isset($_POST['pwd'])) {
        echo $_POST['pwd'];
    } else {
        echo "";
    }
    ?>">
    <br>

    <label for="nif">DNI<br></label>
    <input type="text" name="nif" id="nif" maxlength="9" minlength="9" value="<?php
    if (isset($_POST['nif'])) {
        echo $_POST['nif'];
    } else {
        echo "";
    }
    ?>">
    <br>

    <label for="sexo">Sexo<br></label>
    <input type="radio" name="sexo" value="Hombre" id="sexo">Hombre<br>
    <input type="radio" name="sexo" value="Mujer" id="sexo">Mujer<br>
    <br>

    <label for="foto">Incluir mi foto:</label>
    <input type="file" name="foto" id="foto">
    <br><br>

    <label for="nacido">Nacido en:</label>
    <select name="nacido" id="nacido">
        <option value="Málaga">Málaga</option>
    </select>
    <br><br>

    <label for="comentarios">Comentarios:</label>
    <textarea name="comentarios" id="comentarios" cols="30" rows="4"></textarea>
    <br><br>

    <input type="checkbox" name="sub" id="sub" checked="checked">
    <label for="sub">Subscribirse al boletín de Novedades</label>
    <br><br>

    <input type="submit" name="Guardar" value="Guardar cambios">
    <input type="reset" value="Borrar los datos introducidos">
</form>
<?php
}
?>
</body>
</html>