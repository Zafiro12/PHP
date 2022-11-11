<?php
// Comprobar si el formulario ha sido enviado
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Incluir archivo de configuracion
    require_once "config.php";

    // Preparar una declaracion de seleccion
    $sql = "SELECT * FROM employees WHERE id = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Vincular variables a la declaracion preparada como parametros
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Establecer parametros
        $param_id = trim($_GET["id"]);

        // Intentar ejecutar la declaracion preparada
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                /* Coger el resultado como un array asociativo. Como el conjunto de resultados contiene solo una fila, 
                no es necesario usar el bucle while */

                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                // Recuperar valor de cada campo
                $name = $row["name"];
                $address = $row["address"];
                $salary = $row["salary"];
            } else {
                // URL no contiene el parametro id valido. Redireccionar a error page
                header("location: error.php");
                exit();
            }
        } else {
            echo "Algo ha salido mal, intentalo más tarde.";
        }
    }

    // Cerrar declaracion
    mysqli_stmt_close($stmt);

    // Cerrar conexion
    mysqli_close($link);
} else {
    // URL no contiene el parametro id valido. Redireccionar a error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ver registro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">Ver registro</h1>
                    <div class="form-group">
                        <label>Nombre</label>
                        <p><b><?php echo $row["name"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Dirección</label>
                        <p><b><?php echo $row["address"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Salario</label>
                        <p><b><?php echo $row["salary"]; ?></b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Volver</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>