<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen4 PHP</title>
    <style>
        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

        .enlinea {
            display: inline
        }

        table {
            border-collapse: collapse;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        .hora {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
<h1>Examen4 PHP</h1>
<div>
    Bienvenido <strong><?php echo $_SESSION["usuario"]; ?></strong> -
    <form class="enlinea" method="post" action="index.php">
        <button class="enlace" name="btnCerrarSesion">Salir</button>
    </form>
</div>
<h2>Su horario</h2>
<?php
echo entablarHorario($datos_usuario_log);
?>
</body>
</html>
