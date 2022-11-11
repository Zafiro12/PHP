<?php
// Procesar datos del formulario cuando se envia el formulario
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Incluir archivo de configuracion
    require_once "config.php";
    
    // Preparar una declaracion de eliminacion
    $sql = "DELETE FROM employees WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Vincular variables a la declaracion preparada como parametros
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Establecer parametros
        $param_id = trim($_POST["id"]);
        
        // Intentar ejecutar la declaracion preparada
        if(mysqli_stmt_execute($stmt)){
            // Registros eliminados con exito. Redireccionar a la pagina de destino
            header("location: index.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Cerrar declaracion
    mysqli_stmt_close($stmt);
    
    // Cerrar conexion
    mysqli_close($link);
} else{
    // Verificar existencia del parametro id antes de procesar
    if(empty(trim($_GET["id"]))){
        // URL no contiene el parametro id. Redireccionar a error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar registro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
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
                    <h2 class="mt-5 mb-3">Eliminar registro</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Estás seguro de que quieres eliminar este registro?</p>
                            <p>
                                <input type="submit" value="Si" class="btn btn-danger">
                                <a href="index.php" class="btn btn-secondary">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>