<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudios</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            display: flex;
            flex-flow: column wrap;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: auto;

            background-color: lightgray;
        }
        div {
            border: 1px solid black;
            border-radius: 3%;
        }
        form {
            display: flex;
            flex-flow: column wrap;
            justify-content: center;
            align-items: center;
            padding: 25px;
            
            border: 1px solid black;
            border-radius: 3%;
            background-color: white;

            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
        }
        form>div {
            margin: 10px;
            border: none;
        }
    </style>
</head>

<body>
    <form action="index.php" method="post">
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" name="texto" id="nombre">
        </div>

        <div>
            <label for="hombre">Hombre</label>
            <input type="radio" name="radio" id="hombre" value="hombre">

            <label for="mujer">Mujer</label>
            <input type="radio" name="radio" id="mujer" value="mujer">
        </div>

        <div>
            <label for="provincia">Provincia:</label>
            <select name="select" id="provincia">
                <option value="malaga">Málaga</option>
                <option value="cadiz">Cádiz</option>
                <option value="sevilla">Sevilla</option>
                <option value="huelva">Huelva</option>
            </select>
        </div>

        <div>
            <label for="descripcion">Descripción:</label>
            <textarea name="textarea" id="descripcion" cols="30" rows="5" style="resize: none;"></textarea>
        </div>

        <div>
            <label for="sub">Suscribirse</label>
            <input type="checkbox" name="checkbox" id="sub">
        </div>

        <div>
            <label for="archivo">Archivo:</label>
            <input type="file" name="file" id="archivo">
        </div>

        <input type="submit" name="submit" value="Enviar">
    </form>
</body>

</html>