<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Formulario</title>
    <style>
        form {
            display: flex;
            flex-direction: column;
            width: 15em;
        }
    </style>
</head>

<body>
    <?php

    $error_titulo = false;
    $error_director = false;
    $error_produccion = false;
    $error_nacionalidad = false;
    $error_duracion = false;
    $error_actores = false;
    $error_guion = false;
    $error_anio = false;
    $error_restriccion = false;
    $error_sinopsis = false;
    $error_caratula = false;

    if (isset($_POST["enviar"])) {
        $error_titulo = empty($_POST["titulo"]);
        $error_director = empty($_POST["director"]);
        $error_produccion = empty($_POST["produccion"]);
        $error_nacionalidad = empty($_POST["nacionalidad"]);
        $error_duracion = empty($_POST["duracion"]) || !is_numeric($_POST["duracion"]) || $_POST["duracion"] < 0 || $_POST["duracion"] > 999;
        $error_actores = empty($_POST["actores"]);
        $error_guion = empty($_POST["guion"]);
        $error_anio = empty($_POST["anio"]) || !is_numeric($_POST["anio"]) || $_POST["anio"] < 0 || $_POST["anio"] > 9999;
        $error_restriccion = empty($_POST["restriccion"]);
        $error_sinopsis = empty($_POST["sinopsis"]);
        if (isset($_FILES["caratula"])) {
            $error_caratula = $_FILES["caratula"]["error"] != 0 || $_FILES["caratula"]["type"] != "image/jpeg";
        } else {
            $error_caratula = true;
        }
    }

    if (isset($_POST["enviar"]) && !$error_titulo && !$error_director && !$error_produccion && !$error_nacionalidad && !$error_duracion && !$error_actores && !$error_guion && !$error_anio && !$error_restriccion && !$error_sinopsis) {
        echo "<h1>Formulario - Ejercicio 9</h1>";
        echo "<h2>Los datos introducidos son:</h2>";
        echo "Título: " . $_POST["titulo"] . "<br>";
        echo "Director: " . $_POST["director"] . "<br>";
        echo "Producción: " . $_POST["produccion"] . "<br>";
        echo "Nacionalidad: " . $_POST["nacionalidad"] . "<br>";
        echo "Duración: " . $_POST["duracion"] . "<br>";
        echo "Actores: " . $_POST["actores"] . "<br>";
        echo "Guion: " . $_POST["guion"] . "<br>";
        echo "Año: " . $_POST["anio"] . "<br>";
        echo "Restricción: " . $_POST["restriccion"] . "<br>";

        if (isset($_FILES["caratula"]) && !$error_caratula) {
            echo "Carátula:<br>";
            echo "<ul>";
            echo "<li>Nombre: " . $_FILES["caratula"]["name"] . "</li>";
            echo "<li>Tipo: " . $_FILES["caratula"]["type"] . "</li>";
            echo "<li>Tamaño: " . $_FILES["caratula"]["size"] . "</li>";
            echo "<li>Nombre temporal: " . $_FILES["caratula"]["tmp_name"] . "</li>";
            echo "<li>Error: " . $_FILES["caratula"]["error"] . "</li>";
            echo "</ul>";
            echo "<hr>";
            echo "<img src='" . $_FILES["caratula"]["tmp_name"] . "' alt='Carátula' width='200px' height='200px'>";
        } else {
            echo "Carátula: No se ha subido ninguna carátula o es errónea.<br>";
        }
        echo "<hr>";
        echo "Sinopsis: " . $_POST["sinopsis"] . "<br>";
    } else {
    ?>
        <h1>Formulario - Ejercicio 9</h1>
        <h2>Cinem@s</h2>

        <form action="index.php" method="post" enctype="multipart/form-data">
            <label for="titulo">Titulo</label>
            <input type="text" name="titulo" id="titulo" value="<?php
                                                                if (isset($_POST["enviar"]) && !$error_titulo) {
                                                                    echo $_POST["titulo"];
                                                                } ?>">
            <?php
            if (isset($_POST["enviar"]) && $error_titulo) {
                echo "<span style='color: red'>El campo es obligatorio</span>";
            }
            ?>

            <label for="director">Director</label>
            <input type="text" name="director" id="director" value="<?php
                                                                    if (isset($_POST["enviar"]) && !$error_director) {
                                                                        echo $_POST["director"];
                                                                    } ?>">
            <?php
            if (isset($_POST["enviar"]) && $error_director) {
                echo "<span style='color: red'>El campo es obligatorio</span>";
            }
            ?>

            <label for="produccion">Producción</label>
            <input type="text" name="produccion" id="produccion" value="<?php
                                                                        if (isset($_POST["enviar"]) && !$error_produccion) {
                                                                            echo $_POST["produccion"];
                                                                        } ?>">
            <?php
            if (isset($_POST["enviar"]) && $error_produccion) {
                echo "<span style='color: red'>El campo es obligatorio</span>";
            }
            ?>

            <label for="nacionalidad">Nacionalidad</label>
            <input type="text" name="nacionalidad" id="nacionalidad" value="<?php
                                                                            if (isset($_POST["enviar"]) && !$error_nacionalidad) {
                                                                                echo $_POST["nacionalidad"];
                                                                            } ?>">
            <?php
            if (isset($_POST["enviar"]) && $error_nacionalidad) {
                echo "<span style='color: red'>El campo es obligatorio</span>";
            }
            ?>

            <label for="duracion">Duración</label>
            <input type="number" name="duracion" id="duracion" value="<?php
                                                                        if (isset($_POST["enviar"]) && !$error_duracion) {
                                                                            echo $_POST["duracion"];
                                                                        } ?>">(minutos)
            <?php
            if (isset($_POST["enviar"]) && $error_duracion) {
                echo "<span style='color: red'>El campo es obligatorio y debe ser un número entre 0 y 999</span>";
            }
            ?>

            <label for="actores">Actores</label>
            <input type="text" name="actores" id="actores" value="<?php
                                                                    if (isset($_POST["enviar"]) && !$error_actores) {
                                                                        echo $_POST["actores"];
                                                                    } ?>">
            <?php
            if (isset($_POST["enviar"]) && $error_actores) {
                echo "<span style='color: red'>El campo es obligatorio</span>";
            }
            ?>

            <label for="guion">Guión</label>
            <input type="text" name="guion" id="guion" value="<?php
                                                                if (isset($_POST["enviar"]) && !$error_guion) {
                                                                    echo $_POST["guion"];
                                                                } ?>">
            <?php
            if (isset($_POST["enviar"]) && $error_guion) {
                echo "<span style='color: red'>El campo es obligatorio</span>";
            }
            ?>

            <label for="anio">Año</label>
            <input type="number" name="anio" id="anio" value="<?php
                                                                if (isset($_POST["enviar"]) && !$error_anio) {
                                                                    echo $_POST["anio"];
                                                                } ?>">
            <?php
            if (isset($_POST["enviar"]) && $error_anio) {
                echo "<span style='color: red'>El campo es obligatorio y debe ser un número entre 0 y 9999</span>";
            }
            ?>

            <label for="genero">Género</label>
            <select name="genero" id="genero">
                <option value="accion" <?php
                                        if (isset($_POST["enviar"]) && $_POST["genero"] == "accion") {
                                            echo "selected";
                                        }
                                        ?>>Acción
                </option>
                <option value="aventura" <?php
                                            if (isset($_POST["enviar"]) && $_POST["genero"] == "aventura") {
                                                echo "selected";
                                            }
                                            ?>>Aventura
                </option>
                <option value="comedia" <?php
                                        if (isset($_POST["enviar"]) && $_POST["genero"] == "comedia") {
                                            echo "selected";
                                        }
                                        ?>>Comedia
                </option>
                <option value="drama" <?php
                                        if (isset($_POST["enviar"]) && $_POST["genero"] == "drama") {
                                            echo "selected";
                                        }
                                        ?>>Drama
                </option>
                <option value="fantasia" <?php
                                            if (isset($_POST["enviar"]) && $_POST["genero"] == "fantasia") {
                                                echo "selected";
                                            }
                                            ?>>Fantasía
                </option>
                <option value="musical" <?php
                                        if (isset($_POST["enviar"]) && $_POST["genero"] == "musical") {
                                            echo "selected";
                                        }
                                        ?>>Musical
                </option>
                <option value="romantica" <?php
                                            if (isset($_POST["enviar"]) && $_POST["genero"] == "romantica") {
                                                echo "selected";
                                            }
                                            ?>>Romántica
                </option>
                <option value="terror" <?php
                                        if (isset($_POST["enviar"]) && $_POST["genero"] == "terror") {
                                            echo "selected";
                                        }
                                        ?>>Terror
                </option>
            </select>

            <label>Restricciónes de edad<br>
                <input type="radio" name="restriccion" id="tp" value="tp" <?php
                                                                            if (isset($_POST["enviar"]) && !$error_restriccion) {
                                                                                if ($_POST["restriccion"] == "tp") {
                                                                                    echo "checked";
                                                                                }
                                                                            }
                                                                            ?>>Todos los públicos<br>
                <input type="radio" name="restriccion" id="siete" value="siete" <?php
                                                                                if (isset($_POST["enviar"]) && !$error_restriccion) {
                                                                                    if ($_POST["restriccion"] == "siete") {
                                                                                        echo "checked";
                                                                                    }
                                                                                }
                                                                                ?>>Mayores de 7 años<br>
                <input type="radio" name="restriccion" id="mayores" value="mayores" <?php
                                                                                    if (isset($_POST["enviar"]) && !$error_restriccion) {
                                                                                        if ($_POST["restriccion"] == "mayores") {
                                                                                            echo "checked";
                                                                                        }
                                                                                    }
                                                                                    ?>>Mayores de 18 años
            </label>
            <?php
            if (isset($_POST["enviar"]) && $error_restriccion) {
                echo "<span style='color: red'>El campo es obligatorio</span>";
            }
            ?>

            <label for="sinopsis">Sinopsis</label>
            <textarea name="sinopsis" id="sinopsis" cols="30" rows="10"><?php
                                                                        if (isset($_POST["enviar"])) {
                                                                            echo $_POST["sinopsis"];
                                                                        }
                                                                        ?>
    </textarea>


            <label for="caratula">Carátula</label>
            <input type="file" name="caratula" id="caratula">

            <input type="submit" name="enviar" value="Enviar">
            <input type="reset" name="borrar" value="Borrar">
        </form>

    <?php
    }
    ?>
</body>

</html>