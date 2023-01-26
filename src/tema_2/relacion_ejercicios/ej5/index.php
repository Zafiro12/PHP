<?php
session_start();
if (isset($_POST['reset'])) {
    session_destroy();
    header("Location: funciones.php");
} 

if (isset($_POST['numero']) &&  isset($_POST['derecha'])) {
    if ($_POST['numero'] > 300) {
        $_POST['numero'] = -300;
        $_SESSION['numero'] = -300;
    }
    $_SESSION['numero'] = $_POST['numero'] + 20;
} elseif (isset($_POST['numero']) &&  isset($_POST['izquierda'])) {
    if ($_POST['numero'] < -300) {
        $_POST['numero'] = 300;
        $_SESSION['numero'] = 300;
    }
    $_SESSION['numero'] = $_POST['numero'] - 20;
} else {
    $_SESSION['numero'] = 0;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slider</title>
</head>

<body>
    <form action="index.php" method="post">
        <input type="submit" name="izquierda" value="<">
        <input type="submit" name="derecha" value=">">
        <input type="hidden" name="numero" value="<?php echo $_SESSION['numero']; ?>">
        <br><svg version="1.1" xmlns=http://www.w3.org/2000/svg width="600px" height="20px" viewbox="-300 0 600 20">
            <line x1="-300" y1="10" x2="300" y2="10" stroke="black" stroke-width="5" />
            <circle cx="<?php echo $_SESSION['numero']; ?>" cy="10" r="8" fill="red" />
        </svg><br>
        <input type="submit" name="reset" value="Resetear">
    </form>
</body>

</html>