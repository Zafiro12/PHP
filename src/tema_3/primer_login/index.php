<?php
if (!isset($_SESSION['email'])) {
    header("Location: views/login.php");
    exit;
}
require_once "assets/config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
</head>

<body>
    <h1>Funcionaaaa</h1>
</body>

</html>