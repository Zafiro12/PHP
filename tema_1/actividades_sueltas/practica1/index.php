<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario</title>
</head>
<body>
<?php
function estaEnArray($valor, $array)
{
    foreach ($array as $item) {
        if ($item == $valor) {
            return true;
        }
    }
    return false;
}

if (isset($_POST['enviar']) && !empty($_POST['nombre']) && !empty($_POST['sexo'])) {
    $nombre = $_POST['nombre'];

    $nacimiento = $_POST['nacimiento'];

    $sexo = $_POST['sexo'];

    if ($sexo == 'hombre') {
        $sexo = 'Hombre';
    } else {
        $sexo = 'Mujer';
    }

    $aficiones = $_POST['aficion'];

    if (!empty($_POST['comentarios'])) {
        $comentarios = $_POST['comentarios'];
    } else {
        $comentarios = 'No especificado';
    }
    ?>
    <h1>Formulario enviado</h1>
    <p>Nombre: <?php echo $nombre; ?></p>
    <p>Nacimiento: <?php echo $nacimiento; ?></p>
    <p>Sexo: <?php echo $sexo; ?></p>
    <?php
    if (isset($_POST['aficion'])) {
        if (count($aficiones) > 0) {
            echo '<p>Aficiones: </p><ol>';
            foreach ($aficiones as $aficion) {
                echo '<li>' . $aficion . '</li>';
            }
            echo '</ol>';
        } else {
            echo '<p>No se ha seleccionado ninguna afición</p>';
        }
    } ?>
    <p>Comentarios: <?php echo $comentarios; ?></p>
    <?php
} else {
    $aficiones = array('futbol', 'baloncesto', 'tenis');
    ?>
    <h1>Esta es mi super página</h1>
    <form action="index.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" placeholder="Nombre" value="<?php
        if (isset($_POST['nombre'])) {
            echo $_POST['nombre'];
        }
        ?>">
        <?php
        if (isset($_POST['enviar']) && empty($_POST['nombre'])) {
            echo "<span style='color:red'>El nombre no puede estar vacío</span>";
        }
        ?>
        <br><br>

        <label for="nacimiento">Nacido en:</label>
        <select name="nacimiento" id="nacimiento">
            <option value="Malaga">Malaga</option>
            <option value="Sevilla">Sevilla</option>
            <option value="Jaen">Jaen</option>
        </select>
        <br><br>

        <span>Sexo:</span>
        <input type="radio" id="hombre" name="sexo" value="hombre"><label for="hombre">Hombre</label>
        <input type="radio" id="mujer" name="sexo" value="mujer"><label for="mujer">Mujer</label>
        <?php
        if (isset($_POST['enviar']) && empty($_POST['sexo'])) {
            echo "<span style='color:red'>Debe seleccionar un sexo</span>";
        }
        ?>
        <br><br>

        <span>Aficiones:</span>
        <input type="checkbox" id="futbol" name="aficion[]"
               value="futbol" <?php if (isset($_POST['aficion']) && estaEnArray('futbol', $_POST['aficion'])) {
            echo 'checked';
        } ?>><label for="futbol">Futbol</label>
        <input type="checkbox" id="tenis" name="aficion[]"
               value="tenis" <?php if (isset($_POST['aficion']) && estaEnArray('tenis', $_POST['aficion'])) {
            echo 'checked';
        } ?>><label for="tenis">Tenis</label>
        <input type="checkbox" id="baloncesto" name="aficion[]"
               value="baloncesto" <?php if (isset($_POST['aficion']) && estaEnArray('baloncesto', $_POST['aficion'])) {
            echo 'checked';
        } ?>><label for="baloncesto">Baloncesto</label>
        <br><br>

        <label for="comentarios">Comentarios:</label>
        <textarea name="comentarios" id="comentarios" cols="30" rows="10" <?php if (isset($_POST['comentarios'])) {
            echo "value=\"" . $_POST['comentarios'] . "\"";
        } ?>></textarea>
        <br><br>

        <input type="submit" value="Enviar" name="enviar">
    </form>
    <?php
}
?>
</body>
</html>
