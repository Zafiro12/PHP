<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Rimas</title>
</head>

<body>
    <?php
    if (isset($_POST['enviar']) && isset($_POST['palabra1']) && isset($_POST['palabra2'])) {
        $palabra1 = $_POST['palabra1'];
        $palabra2 = $_POST['palabra2'];

        function riman($palabra1, $palabra2)
        {
            if (substr($palabra1, -3) == substr($palabra2, -3)) {
                return "Riman mucho";
            }
            if (substr($palabra1, -2) == substr($palabra2, -2)) {
                return "Riman un poco";
            }
            return "No riman";
        }

    ?>
        <form action="index.php" method="post">
            <label for="palabra1">Palabra 1</label>
            <input type="text" name="palabra1" id="palabra1" required <?php if (isset($_POST['palabra1'])) {
                                                                            echo "value='" . $palabra1 . "'";
                                                                        } ?>>
            <?php
            if (strlen($palabra1) < 3) {
                echo "*La palabra 1 debe tener al menos 3 caracteres";
            }
            ?><br>
            <label for="palabra2">Palabra 2</label>
            <input type="text" name="palabra2" id="palabra2" required <?php if (isset($_POST['palabra2'])) {
                                                                            echo "value='" . $palabra2 . "'";
                                                                        } ?>>
            <?php
            if (strlen($palabra2) < 3) {
                echo "*La palabra 2 debe tener al menos 3 caracteres";
            }
            ?><br>
            <input type="submit" name="enviar" id="enviar" value="Rimar">
        </form>
        <?php
        if (strlen($palabra1) >= 3 && strlen($palabra2) >= 3) {
            echo "<p>".riman($palabra1, $palabra2)."</p>";
        }
    } else { ?>
        <form action="index.php" method="post">
            <label for="palabra1">Palabra 1</label>
            <input type="text" name="palabra1" id="palabra1" required><br>
            <label for="palabra2">Palabra 2</label>
            <input type="text" name="palabra2" id="palabra2" required><br>
            <input type="submit" name="enviar" id="enviar" value="Rimar">
        </form>
    <?php
    }
    ?>
</body>

</html>