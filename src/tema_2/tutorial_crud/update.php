<?php
// Incluir archivo de configuracion
require_once "config.php";
 
// Definir variables e inicializar con valores vacios
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";
 
// Procesar datos del formulario cuando se envia el formulario
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Obtener valor de entrada
    $id = $_POST["id"];
    
    // Validar nombre
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validar direccion
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validar salario
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }
    
    // Verificar errores de entrada antes de actualizar la base de datos
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Preparar una declaracion de actualizacion
        $sql = "UPDATE employees SET name=?, address=?, salary=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Vincular variables a la declaracion preparada como parametros
            mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_address, $param_salary, $param_id);
            
            // Establecer parametros
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            $param_id = $id;
            
            // Intentar ejecutar la declaracion preparada
            if(mysqli_stmt_execute($stmt)){
                // Registros actualizados con exito. Redireccionar a la pagina de destino
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
} else{
    // Verificar existencia del parametro id antes de procesar
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Obtener parametro de URL
        $id =  trim($_GET["id"]);
        
        // Preparar una declaracion de seleccion
        $sql = "SELECT * FROM employees WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Vincular variables a la declaracion preparada como parametros
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Establecer parametros
            $param_id = $id;
            
            // Intentar ejecutar la declaracion preparada
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Coger el resultado como un array asociativo. Como el conjunto de resultados contiene solo una fila, 
                no es necesario usar el bucle while */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Recuperar valor de campo individual
                    $name = $row["name"];
                    $address = $row["address"];
                    $salary = $row["salary"];
                } else{
                    // URL no contiene un parametro valido. Redireccionar a la pagina de error
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Algo ha salido mal, intentalo más tarde.";
            }
        }
        
        // Cerrar declaracion
        mysqli_stmt_close($stmt);
        
        // Cerrar conexion
        mysqli_close($link);
    }  else{
        // URL no contiene el parametro id. Redireccionar a la pagina de error
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar registro</title>
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
                    <h2 class="mt-5">Actualizar registro</h2>
                    <p>Edite los campos para actualizar el registro.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>