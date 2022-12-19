<?php
$conexion = mysqli_connect("db", "jose", "josefa", "bd_foro") or die("<p>Imposible conectar. Error número " . mysqli_connect_errno() . ": " . mysqli_connect_error() . "</p>");

require_once "php/rellenar.php";
require_once "php/vaciar.php";

$num_usuarios_pagina = 10;
$offset = 0;
$pagina = 1;

if (isset($_GET['pagina'])) {
    $pagina = $_GET['pagina'];
    $offset = ($pagina - 1) * $num_usuarios_pagina;
}

$sql = "SELECT count(id_usuario) FROM usuarios";

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
    </style>
</head>

<body>
    <h1>Listado de los usuarios:</h1>

    <form action="index.php" method="post">
        <input type="submit" name="rellenar" value="Rellenar">
        <input type="submit" name="vaciar" value="Vaciar">
    </form>

    <?php
    $sql = "SELECT * FROM usuarios LIMIT $num_usuarios_pagina OFFSET $offset";

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
    <?php
    
    if ($pagina > 1) {
        echo "<button><a href='index.php?pagina=1'><<</a></button>";
        echo "<button><a href='index.php?pagina=" . ($pagina - 1) . "'><</a></button>";
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
            echo "<button><a href='index.php?pagina=$i'><b>$i</b></a></button>";
        } else {
            echo "<button><a href='index.php?pagina=$i'>$i</a></button>";
        }
    }

    if ($pagina < $num_paginas) {
        echo "<button><a href='index.php?pagina=" . ($pagina + 1) . "'>></a></button>";
        echo "<button><a href='index.php?pagina=" . $num_paginas . "'>>></a></button>";
    }
    ?>
</body>

</html>
<?php
mysqli_close($conexion);
