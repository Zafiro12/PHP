<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen Librería</title>
    <style>
        .enlinea{display:inline}
        .enlace{border:none;background:none;color:blue;text-decoration:underline;cursor:pointer}
        #libros{overflow:hidden}
        .libro{float:left;width:33.3333%; text-align:center;margin:1.5em 0}
        .libro img{width:70%}
    </style>
</head>
<body>
    <h1>Librería</h1>
    <div>Bienvenido <strong><?php echo $datos_usu_log->lector;?></strong>
     - <form method="post" action="<?php echo $salto;?>" class="enlinea">
     <button name="btnSalir" class="enlace">Salir</button>
    </form>
    </div>
    <?php
    require "vistas/vista_libros.php";
    
    ?>
</body>
</html>
