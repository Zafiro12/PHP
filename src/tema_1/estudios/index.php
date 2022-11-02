<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudios</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            display: flex;
            flex-flow: row wrap;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: auto;

            background-color: lightgray;

            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
        }

        #resultado {
            display: flex;
            flex-flow: column wrap;
            align-items: flex-start;
            padding: 10px;
            margin: 3%;

            border: 2px solid black;
            border-radius: 3%;
            background-color: white;
        }

        form {
            display: flex;
            flex-flow: column wrap;
            justify-content: center;
            align-items: center;
            padding: 25px;

            border: 2px solid black;
            border-radius: 3%;
            background-color: white;
        }

        form>div {
            margin: 10px;
        }
    </style>
</head>

<body>
    <?php
    function mantenerValor($nombre)
    { // Mantiene el valor de los campos de texto
        if (isset($_POST[$nombre])) {
            echo "value='" . $_POST[$nombre] . "'";
        }
    }

    function errorCampo($booleano)
    { // Coloca un span en caso de ser 'true'
        if ($booleano) {
            echo "<span style='color:red;'>*Campo Obligatorio</span>";
        }
    }

    // Se crean las variables de los errores
    // Es mejor inicializarlas con false y luego cambiar el valor al enviar
    $error_text = false;
    $error_radio = false;
    $error_file = false;

    if (isset($_POST['submit'])) {
        $error_text = empty($_POST['text']);
        $error_radio = !isset($_POST['radio']);
        $error_file = $_FILES['file']['name'] == "" || $_FILES['file']['size'] > 500 * 1000;
    }
    ?>

    <form action="index.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="nombre">Nombre:</label>
            <!--Cuidado con los espacios al colocar código dentro de las etiquetas-->
            <input type="text" name="text" id="nombre" <?php mantenerValor("text"); ?>> 
            <?php errorCampo($error_text) ?>
        </div>

        <div>
            <label for="hombre">Hombre</label>
            <input type="radio" name="radio" id="hombre" value="hombre">

            <label for="mujer">Mujer</label>
            <input type="radio" name="radio" id="mujer" value="mujer">

            <?php errorCampo($error_radio) ?>
        </div>

        <div>
            <label for="provincia">Provincia:</label>
            <select name="select" id="provincia">
                <option value="malaga">Málaga</option>
                <option value="cadiz">Cádiz</option>
                <option value="sevilla">Sevilla</option>
                <option value="huelva">Huelva</option>
            </select>
        </div>

        <div>
            <label for="descripcion">Descripción:</label>
            <textarea name="textarea" id="descripcion" cols="30" rows="5" style="resize: none;"><?php
                                                                                                if (isset($_POST['textarea'])) {
                                                                                                    echo $_POST['textarea'];
                                                                                                }
                                                                                                ?></textarea>
        </div>

        <div>
            <label for="sub">Suscribirse</label>
            <input type="checkbox" name="checkbox" id="sub" <?php
                                                            if (isset($_POST['checkbox'])) echo "checked";
                                                            ?>>
        </div>

        <div>
            <label for="archivo">Archivo:</label>
            <input type="file" name="file" id="archivo">
        </div>

        <div>
            <input type="submit" name="submit" value="Enviar">
            <input type="reset" value="Borrar">
        </div>

    </form>

    <?php
    if (isset($_POST['submit']) && !$error_text && !$error_radio) {
        echo "<div id='resultado'>";
        echo "<p>Nombre: " . $_POST['text'] . "</p>";
        echo "<p>Sexo: " . $_POST['radio'] . "</p>";
        echo "<p>Provincia: " . $_POST['select'] . "</p>";
        if (!empty($_POST['textarea'])) echo "<p>Descripción: " . $_POST['textarea'] . "</p>";
        if (!isset($_POST['checkbox'])) echo "<p>Suscripción: Inactiva</p>";
        else echo "<p>Suscripción: Activa</p>";

        if (!$error_file) {
            echo "<hr>";
            echo "<h2>Archivo</h2>";
            echo "<p>Nombre: " . $_FILES['file']['name'] . "</p>";

            if ($_FILES['file']['type'] == "text/plain") {
                echo "<h3>Contenido</h3>";
                $file = fopen($_FILES['file']['tmp_name'], "r");

                while (!feof($file)) {
                    $line = fgets($file);
                    echo "<p>$line</p>";
                }

                fclose($file);
            }
        }


        echo "</div>";
    }
    ?>
</body>

</html>