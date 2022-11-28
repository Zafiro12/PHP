<?php
    session_start();
    if (isset($_POST['reset'])) {
        session_destroy();
        header("Location: index.php");
    } 
    
    if (isset($_POST['numero']) &&  isset($_POST['subir'])) {
        $_SESSION['numero'] = $_POST['numero'] + 1;
    } elseif (isset($_POST['numero']) &&  isset($_POST['bajar'])) {
        $_SESSION['numero'] = $_POST['numero'] - 1;
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
    <title>Subir y bajar numero</title>
</head>
<body>
    <form action="index.php" method="post">
        <input type="submit" name="subir" value="+">
        <input type="hidden" name="numero" value="<?php echo $_SESSION['numero']; ?>">
        <?php echo $_SESSION['numero']; ?>
        <input type="submit" name="bajar" value="-"><br><br>
        <input type="submit" name="reset" value="Poner a cero">
    </form>
</body>
</html>