<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Peliculas</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <div class="centrar">
        <?php
        // Incluir archivo de configuracion
        require_once "sql/config.php";

        function visualizarDatos($link, $tabla, ...$columnas)
        {
            $sql = "SELECT * FROM $tabla";
            if ($result = mysqli_query($link, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    echo "<table>";
                    echo "<tr>";

                    //coger el titulo de las columnas
                    $sql = "SHOW COLUMNS FROM $tabla";
                    $cols = mysqli_query($link, $sql);

                    // Mostrar los titulos de las columnas
                    while ($col = mysqli_fetch_array($cols)) {
                        if (in_array($col[0], $columnas)) {
                            echo "<th>" . $col[0] . "</th>";
                        }
                    }

                    mysqli_free_result($cols);

                    echo "<th><a href='index.php?accion=insertar'>+Pelicula</a></th>";
                    echo "</tr>";

                    while ($row = mysqli_fetch_array($result)) {
                        $id = $row['id_pelicula']; // Cambiar id si es necesario
                        echo "<tr>";
                        foreach ($columnas as $col) {
                            if ($col == "titulo") {
                                echo "<td><a href='index.php?accion=ver&id=$id'>" . $row[$col] . "</a></td>";
                            } else if ($col == "caratula") { // Quitar condicion si no es necesaria
                                echo "<td><img src='" . $row[$col] . "' width='100vw' height='auto'></td>";
                            } else {
                                echo "<td>" . $row[$col] . "</td>";
                            }
                        }
                        echo "<td>";
                        echo "<a href='index.php?accion=editar&id=$id'>Editar</a>";
                        echo " || ";
                        echo "<a href='index.php?accion=borrar&id=$id'>Borrar</a>";
                        echo "</td>";
                        echo "</tr>";
                    }

                    mysqli_free_result($result);

                    echo "</table>";
                } else {
                    echo "<span style='color:red;font-style: italic;'>No hay registros.<span>";
                }
            } else {
                echo "ERROR: No se pudo ejecutar $sql. " . mysqli_error($link);
            }
        }

        if (isset($_GET['accion']) || isset($_POST['accion'])) {
            $accion = $_GET['accion'] ?? $_POST['accion'];
        } else {
            $accion = "listar";
        }

        if ($accion == "listar") {
        ?>

            <header>
                <h1>Peliculas</h1>
            </header>
            <main>
                <?php
                visualizarDatos($link, "peliculas", "id_pelicula", "titulo", "caratula");
                mysqli_close($link);
                ?>
                <main>


                <?php
            } elseif ($accion == "insertar") {
                function insertar($link, $tabla, ...$args)
                {
                    $sql = "SHOW COLUMNS FROM $tabla";
                    $columnas = mysqli_query($link, $sql);
                    $sql = "INSERT INTO $tabla (";

                    //salta la primera columna que es el id
                    $columnas->fetch_assoc();

                    while ($columna = $columnas->fetch_assoc()) {
                        $sql .= $columna['Field'] . ",";
                    }

                    $sql = substr($sql, 0, -1) . ") VALUES (";
                    foreach ($args as $arg) {
                        $sql .= "'$arg',";
                    }
                    $sql = substr($sql, 0, -1) . ")";

                    if (mysqli_query($link, $sql)) {
                        return true;
                    } else {
                        return false;
                    }
                }

                $error_insercion = $error_titulo = $error_director = $error_tematica = $error_sinopsis = $error_caratula = false;
                $titulo = $director = $tematica = $sinopsis = $caratula = "";

                if (isset($_POST['insertar'])) {
                    $titulo = $_POST['titulo'];
                    $director = $_POST['director'];
                    $tematica = $_POST['tematica'];
                    $sinopsis = $_POST['sinopsis'];
                    $caratula = $_FILES['caratula'];

                    if (empty($titulo)) {
                        $error_titulo = true;
                    }
                    if (empty($director)) {
                        $error_director = true;
                    }
                    if (empty($tematica)) {
                        $error_tematica = true;
                    }
                    if (empty($sinopsis)) {
                        $error_sinopsis = true;
                    }
                    if ($caratula["name"] == "" && $caratula["error"] == 4) {
                        $caratula = "img/default.png";
                    } else if ($caratula['type'] == "image/jpeg" || $caratula['type'] == "image/png") {
                        $caratula = "img/" . $caratula['name'];
                        move_uploaded_file($caratula['tmp_name'], $caratula);
                    } else {
                        $error_caratula = true;
                    }

                    if (!$error_titulo && !$error_director && !$error_tematica && !$error_sinopsis && !$error_caratula) {
                        if (insertar($link, "peliculas", $titulo, $director, $tematica, $sinopsis, $caratula)) {
                            $accion = "listar";
                        } else {
                            $error_insercion = true;
                        }
                    }
                } if ($accion == "insertar") {
                ?>
                    <header>
                        <h1>Insertar pelicula</h1>
                    </header>
                    <main>
                        <?php
                        visualizarDatos($link, "peliculas", "id_pelicula", "titulo", "caratula");

                        if ($error_insercion) {
                            echo "<span style='color:red;font-style: italic;'>Error al insertar los datos, vuleve a intentarlo más tarde</span>";
                        }
                        ?>
                        <h2>Insertar una pelicula</h2>
                        <form action="index.php" method="post" class="centrar" enctype="multipart/form-data">
                            <?php if ($error_titulo) { ?>
                                <span style="color:red;font-style: italic;">El titulo no es válido.</span>
                            <?php } ?>
                            <div class="input">
                                <label for="titulo">titulo</label>
                                <input type="text" name="titulo" id="titulo" value="<?php echo $titulo; ?>">
                            </div>

                            <?php if ($error_director) { ?>
                                <span style="color:red;font-style: italic;">El director no es válido.</span>
                            <?php } ?>
                            <div class="input">
                                <label for="director">director</label>
                                <input type="text" name="director" id="director" value="<?php echo $director; ?>">
                            </div>

                            <?php if ($error_tematica) { ?>
                                <span style="color:red;font-style: italic;">La tematica no es válida.</span>
                            <?php } ?>
                            <div class="input">
                                <label for="tematica">tematica</label>
                                <input type="text" name="tematica" id="tematica" value="<?php echo $tematica; ?>">
                            </div>

                            <?php if ($error_sinopsis) { ?>
                                <span style="color:red;font-style: italic;">La sinopsis no es válida.</span>
                            <?php } ?>
                            <div class="input">
                                <label for="sinopsis">sinopsis</label>
                                <textarea name="sinopsis" id="sinopsis" cols="30" rows="10"><?php echo $sinopsis; ?></textarea>
                            </div>

                            <?php if ($error_caratula) { ?>
                                <span style="color:red;font-style: italic;">La caratula no es válida.</span>
                            <?php } ?>
                            <div class="input">
                                <label for="caratula">caratula</label>
                                <input type="file" name="caratula" id="caratula">
                            </div>

                            <div class="input">
                                <input type="hidden" name="accion" value="<?php echo $accion; ?>">
                            </div>

                            <div>
                                <input type="submit" name="insertar" value="Insertar" class="boton">
                                <input type="submit" formaction="index.php?accion=listar" value="Volver" class="boton">
                            </div>

                        </form>
                    </main>


                <?php
            }}
                ?>
    </div>
</body>

</html>