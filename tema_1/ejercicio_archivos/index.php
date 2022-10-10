<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo de Formulario</title>
</head>
<body>
<h1>Rellena tu CV</h1>
<form action="recepcion.php" method="post" enctype="multipart/form-data">
    <label for="nombre">Nombre:<br></label>
    <input type="text" name="nombre" id="nombre">
    <br><br>

    <label for="usuario">Usuario:<br></label>
    <input type="text" name="usuario" id="usuario">
    <br><br>

    <label for="pwd">Contraseña:<br></label>
    <input type="password" name="pwd" id="pwd">
    <br><br>

    <label for="nif">DNI<br></label>
    <input type="text" name="nif" id="nif" maxlength="9" minlength="9">
    <br><br>

    <label for="sexo">Sexo<br></label>
    <input type="radio" name="sexo" value="Hombre" id="sexo">Hombre<br>
    <input type="radio" name="sexo" value="Mujer" id="sexo">Mujer<br>
    <br><br>

    <label for="foto">Incluir mi foto (Archivo tipo imagen máx. 500kb):</label>
    <input type="file" name="foto" id="foto">
    <br><br>

    <input type="checkbox" name="sub" id="sub" checked="checked">
    <label for="sub">Subscribirse al boletín de Novedades</label>
    <br><br>

    <input type="submit" name="Guardar" value="Guardar cambios">
    <input type="reset" value="Borrar los datos introducidos">
</form>
</body>
</html>
