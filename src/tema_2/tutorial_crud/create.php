<?php
// Incluir archivo de configuracion
require_once "config.php";
 
// Definir variables e inicializar con valores vacios
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";
 
// Procesar datos del formulario cuando se envia el formulario
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validar nombre
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Introduce un nombre.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Introduce un nombre válido.";
    } else{
        $name = $input_name;
    }
    
    // Validar direccion
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Introduce una dirección.";     
    } else{
        $address = $input_address;
    }
    
    // Validar salario
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Introduce el salario.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Introduce un valor válido positivo.";
    } else{
        $salary = $input_salary;
    }
    
    // Verificar errores de entrada antes de insertar en la base de datos
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Preparar una declaracion de insercion
        $sql = "INSERT INTO employees (name, address, salary) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Vincular variables a la declaracion preparada como parametros
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_address, $param_salary);
            
            // Establecer parametros
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            
            // Intentar ejecutar la declaracion preparada
            if(mysqli_stmt_execute($stmt)){
                // Registros creados con exito. Redireccionar a la pagina de destino
                header("location: index.php");
                exit();
            } else{
                echo "Algo ha salido mal, intentalo más tarde.";
            }
        }
         
        // Cerrar declaracion
        mysqli_stmt_close($stmt);
    }
    
    // Cerrar conexion
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear empleado</title>
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
                    <h2 class="mt-5">Crear empleado</h2>
                    <p>Rellena este formulario para subir el empleado a la base de datos.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Dirección</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Salario</label>
                            <input type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $salary_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>