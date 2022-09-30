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
    <br>

    <label for="apellidos">Apellidos:<br></label>
    <input type="text" name="apellidos" id="apellidos">
    <br>

    <label for="pwd">Contraseña:<br></label>
    <input type="password" name="pwd" id="pwd">
    <br>

    <label for="nif">DNI<br></label>
    <input type="text" name="nif" id="nif" maxlength="9" minlength="9">
    <br>

    <label for="sexo">Sexo<br></label>
    <input type="radio" name="sexo" value="Hombre" id="sexo">Hombre<br>
    <input type="radio" name="sexo" value="Mujer" id="sexo">Mujer<br>
    <br>

    <label for="foto">Incluir mi foto:</label>
    <input type="file" name="foto" id="foto">
    <br><br>

    <label for="nacido">Nacido en:</label>
    <select name="nacido" id="nacido">
        <option value="Málaga">Málaga</option>
    </select>
    <br><br>

    <label for="comentarios">Comentarios:</label>
    <textarea name="comentarios" id="comentarios" cols="30" rows="4"></textarea>
    <br><br>

    <input type="checkbox" name="sub" id="sub" checked="checked">
    <label for="sub">Subscribirse al boletín de Novedades</label>
    <br><br>

    <input type="submit" name="Guardar" value="Guardar cambios">
    <input type="reset" value="Borrar los datos introducidos">
</form>
</body>
</html>
