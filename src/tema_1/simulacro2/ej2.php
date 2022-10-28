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
    	function codificar($texto, $des) {
    	    for ($i=0; $i < strlen($texto); $i++) { 
                $letra = $texto[$i];
                if (ord($letra) <= ord('Z') && ord($letra) >= ord('A')) {
                    if(ord($letra)+$des > ord('Z')) {
                        $letra = ord('A') + ((ord($letra)+ $des) - ord('Z'));
                    } else {
                        $letra = ord($letra) + $des;
                    }
                    $texto[$i] = chr($letra);
                }
            }
            return $texto;
    	}
    
    	if (isset($_POST['enviar'])) {
	    	$input = $_POST['input'];
	    	$despl = 1;
	    	if (!empty($_POST['desplazamiento'])) {
	    		$despl = $_POST['desplazamiento'];
	    	}
	    	echo codificar($input, $despl);
    	}
    ?>
</body>
</html>
