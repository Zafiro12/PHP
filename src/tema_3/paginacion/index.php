<?php
session_start();
$conexion = mysqli_connect("db", "jose", "josefa", "bd_foro") or die("<p>Imposible conectar. Error número " . mysqli_connect_errno() . ": " . mysqli_connect_error() . "</p>");

require_once "php/rellenar.php";
require_once "php/vaciar.php";

$num_usuarios_pagina = 10;
if (isset($_SESSION['num_usuarios_pagina'])) {
    $num_usuarios_pagina = $_SESSION['num_usuarios_pagina'];
}
$offset = 0;
$pagina = 1;
$busqueda = "";
if (isset($_POST['buscar']) && $_POST['buscar'] != "") {
    $busqueda = $_POST['buscar'];
    $_SESSION['buscar'] = $busqueda;
}

if (isset($_POST['limpiar'])) {
    unset($_POST['buscar']);
    unset($_SESSION['buscar']);
}

if (isset($_POST['num_usuarios_pagina'])) {
    $num_usuarios_pagina = $_POST['num_usuarios_pagina'];
    $_SESSION['num_usuarios_pagina'] = $num_usuarios_pagina;
}

if (isset($_GET['pagina'])) {
    $pagina = $_GET['pagina'];
    $offset = ($pagina - 1) * $num_usuarios_pagina;
}

if (isset($_SESSION['buscar']) && $_SESSION['buscar'] != "") {
    $sql = "SELECT count(*) FROM usuarios WHERE nombre LIKE '" . $_SESSION['buscar'] . "%'";
} else {
    $sql = "SELECT count(*) FROM usuarios";
}

if (!$resultado = mysqli_query($conexion, $sql)) {
    echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . mysqli_error($conexion) . "</p>";
    exit;
}

$fila = mysqli_fetch_array($resultado);
$num_paginas = ceil($fila[0] / $num_usuarios_pagina);

mysqli_free_result($resultado);



?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paginacion</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
            padding: 5px;
            margin: 10px;
        }

        button:hover {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Listado de los usuarios:</h1>

    <form action="index.php" method="post">
        <input type="submit" name="rellenar" value="Rellenar">
        <input type="submit" name="vaciar" value="Vaciar">
    </form>

    <form action="index.php" method="post">
        <label for="num_usuarios_pagina">Usuarios por página:</label>
        <select name="num_usuarios_pagina" onchange="this.form.submit()">
            <option value="10" <?php if ($num_usuarios_pagina == 10) echo "selected"; ?>>10</option>
            <option value="20" <?php if ($num_usuarios_pagina == 20) echo "selected"; ?>>20</option>
            <option value="50" <?php if ($num_usuarios_pagina == 50) echo "selected"; ?>>50</option>
            <option value="100" <?php if ($num_usuarios_pagina == 100) echo "selected"; ?>>100</option>
        </select>
        <label for="buscar">Buscar:</label>
        <input type="text" name="buscar" id="buscar" value="<?php if (isset($_SESSION['buscar'])) echo $_SESSION['buscar']; ?>">
        <input type="submit" value="Buscar">
        <input type="submit" name="limpiar" value="Limpiar">
    </form>

    <?php
    if (isset($_SESSION['buscar']) && $_SESSION['buscar'] != "") {
        $sql = "SELECT * FROM usuarios WHERE nombre LIKE '%" . $_SESSION['buscar'] . "%' LIMIT $num_usuarios_pagina OFFSET $offset";
    } else {
        $sql = "SELECT * FROM usuarios LIMIT $num_usuarios_pagina OFFSET $offset";
    }

    if (!$resultado = mysqli_query($conexion, $sql)) {
        echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . mysqli_error($conexion) . "</p>";
        exit;
    }

    if (mysqli_num_rows($resultado) == 0) {
        echo "<p>No se han encontrado filas</p>";
        exit;
    }
    ?>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Borrar</th>
            <th>Editar</th>
        </tr>
        <?php
        while ($fila = mysqli_fetch_array($resultado)) {
            echo "<tr><td><a href='#'>" . $fila['nombre'] . "</a></td>
            <td><a href='#'><img src='img/equis.png' height='10px'></a></td>
            <td><a href='#'><img src='img/editar.png' height='20px'></a></td></tr>";
        }

        mysqli_free_result($resultado);
        ?>
    </table>
    <form action="index.php" method="get">
        <?php

        if ($pagina > 1) {
            echo "<button type='submit' name='pagina' value='1'><<</button>";
            echo "<button type='submit' name='pagina' value='" . ($pagina - 1) . "'><</button>";
        }

        $max_paginas = 4;
        $inicio = 1;
        $fin = $num_paginas;

        if ($num_paginas > $max_paginas) {
            $inicio = $pagina - floor($max_paginas / 2);
            $fin = $pagina + floor($max_paginas / 2);

            if ($inicio < 1) {
                $inicio = 1;
                $fin = $max_paginas;
            }

            if ($fin > $num_paginas) {
                $inicio = $num_paginas - $max_paginas + 1;
                $fin = $num_paginas;
            }
        }

        for ($i = $inicio; $i <= $fin; $i++) {
            if ($i == $pagina) {
                echo "<button type='submit' name='pagina' value='$i' disabled>$i</button>";
            } else {
                echo "<button type='submit' name='pagina' value='$i'>$i</button>";
            }
        }

        if ($pagina < $num_paginas) {
            echo "<button type='submit' name='pagina' value='" . ($pagina + 1) . "'>></button>";
            echo "<button type='submit' name='pagina' value='$num_paginas'>>></button>";
        }
        ?>
    </form>
</body>

</html>
<?php
mysqli_close($conexion);
