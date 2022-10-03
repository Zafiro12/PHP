<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <form action="index.php" method="post">
        <label for="palabra">Traducir números romanos a números arabes:</label>
        <input type="text" name="palabra" id="palabra" required>
        <input type="submit" value="Comprobar" name="submit">
    </form>
    <?php
    if (isset($_POST['submit'])) {
        $palabra = $_POST['palabra'];
        $palabra = strtoupper($palabra);
        $romano = true;

        for ($i = 0; $i < strlen($palabra); $i++) {
            if (
                $palabra[$i] != 'I' && $palabra[$i] != 'V' && $palabra[$i] != 'X' && $palabra[$i] != 'L' &&
                $palabra[$i] != 'C' && $palabra[$i] != 'D' && $palabra[$i] != 'M'
            ) {
                $romano = false;
            }
        }
        if ($romano) {
            $arabe = 0;
            $conversion = array(
                'I' => 1,
                'V' => 5,
                'X' => 10,
                'L' => 50,
                'C' => 100,
                'D' => 500,
                'M' => 1000
            );
            for ($i = 0; $i < strlen($palabra); $i++) {
                if ($i + 1 < strlen($palabra) && $conversion[$palabra[$i]] < $conversion[$palabra[$i + 1]]) {
                    $arabe += $conversion[$palabra[$i + 1]] - $conversion[$palabra[$i]];
                    $i++;
                } else {
                    $arabe += $conversion[$palabra[$i]];
                }
            }
            echo "<p>El número romano es: " . $arabe . "</p>";
        } else {
            echo "<p>El número romano $palabra no es válido</p>";
        }
    }
    ?>
</body>

</html>