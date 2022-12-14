<?php
session_start();

// *ERRORES
$error_email = false;
$error_clave = false;

if (isset($_POST['email']) && isset($_POST['clave'])) {
    $email = $_POST['email'];
    $clave = $_POST['clave'];

    require_once "../assets/config.php";

    $sql = "SELECT email,clave FROM usuarios WHERE email ='$email'";
    $resultado = mysqli_query($link, $sql);

    if (mysqli_num_rows($resultado) != 0) {
        $fila = mysqli_fetch_assoc($resultado);
        if (md5($clave) == $fila['clave']) {
            $_SESSION['email'] = $email;
            header("Location: ../index.php");
        } else {
            $error_clave = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;

            height: 30vh;

            padding: 1rem;
            margin: 1rem;
        }

        .input {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <form action="login.php" method="post">
        <h2>Login</h2>

        <div class="input">
            <label for="email" hidden>Email</label>
            <?php if ($error_email) : ?>
                <span style="color: red;">El email no existe</span>
            <?php endif; ?>
            <input type="text" name="email" id="email" placeholder="Email" required <?php
                                                                                    if (isset($_POST['email'])) {
                                                                                        echo "value='" . $_POST['email'] . "'";
                                                                                    }
                                                                                    ?>>
        </div>

        <div class="input">
            <label for="clave" hidden>Clave</label><?php if ($error_clave) : ?>
                <span style="color: red;">*La clave no es correcta</span>
            <?php endif; ?>
            <input type="password" name="clave" id="clave" placeholder="Clave">
        </div>

        <div>
            <input type="submit" value="Login">
            <input type="submit" value="Registrarse" formaction="register.php">
        </div>
    </form>
</body>

</html>