<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
</head>

<body>
    <form action="ej2.php" method="post">
        <input type="text" name="input" required><br>
        <input type="text" name="desplazamiento"><br>
        <input type="submit" name="enviar" value="Enviar">
    </form>
    <?php
    	function codificar($texto)
    	{
    	    
    	}
    
    	if (isset($_POST['desplazamiento'])) {
	    	$input = $_POST['input'];
	    	$despl = 1;
	    	if (isset($_POST['desplazamiento'])) {
	    		$despl = $_POST['desplazamiento'];
	    	}
	    	echo "1er debug";
    	}
    ?>
</body>
</html>
