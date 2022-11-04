<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Ejercicio 1</title>
</head>

<body>
	<?php
	$generar = isset($_POST["generar"]);
	function generarArchivo()
	{
		$filename = "./claves_polybios.txt";
		$file = fopen($filename, "w+");
		fwrite($file, "i/j;1;2;3;4;5" . PHP_EOL);
		fwrite($file, "1;");
		echo "i/j;1;2;3;4;5" . PHP_EOL;
		echo "1;";

		$i = ord("A");
		$contador = 0;
		$filas = 2;
		while (true) {
			if ($i > ord("Z")) break;

			if ($i == ord("J")) {
				$i++;
			}

			if ($contador == 5) {
				fwrite($file, PHP_EOL);
				echo PHP_EOL;
				fwrite($file, $filas . ";");
				echo $filas . ";";
				$filas++;
				$contador = 0;
			}

			fwrite($file, chr($i) . ";");
			echo chr($i) . ";";
			$contador++;
			$i++;
		}
		fclose($file);
	}
	?>
	<h1>Ejercicio 1. Generador de "claves_polybios.txt"</h1>
	<form action="ej1.php" method="post">
		<input type="submit" name="generar" value="Generar">
	</form>
	<?php
	if ($generar) {
		echo "<h2>Respuesta</h2>";
		echo "<textarea cols='30' rows='10'>";
		generarArchivo();
		echo "</textarea>";
	}
	?>
</body>

</html>