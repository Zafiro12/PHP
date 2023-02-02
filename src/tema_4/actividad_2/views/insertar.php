<?php
if (isset($_POST["insertar"])) {
    $error_cod = $_POST["cod"] == "";
    $error_nombre_corto = $_POST["nombre_corto"] == "";
    $error_PVP = $_POST["PVP"] == "";
    $error_form = $error_cod || $error_nombre_corto || $error_PVP;

    if (!$error_form) {
        $repetido = json_decode(consumir_servicios_REST(URL . "producto/" . $_POST["cod"], "GET"))->producto;

        if (!$repetido) {
            $datos["cod"] = $_POST["cod"];
            $datos["nombre"] = $_POST["nombre"];
            $datos["nombre_corto"] = $_POST["nombre_corto"];
            $datos["descripcion"] = $_POST["descripcion"];
            $datos["PVP"] = $_POST["PVP"];
            $datos["familia"] = $_POST["familia"];

            consumir_servicios_REST(URL . "producto/insertar", "POST", $datos);

            session_destroy();
            header("Location: index.php");
            exit();
        } else {
            $error_cod = true;
        }
    }
}

$familias = json_decode(consumir_servicios_REST(URL . "familias", "GET"));
?>
<h1>Insertar producto</h1>
<form action="index.php" method="post">
    <p>
        <label for="cod">Código:</label>
        <input type="text" name="cod" id="cod">
    </p>

    <p>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre">
    </p>

    <p>
        <label for="nombre_corto">Nombre corto:</label>
        <input type="text" name="nombre_corto" id="nombre_corto">
    </p>

    <p>
        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" cols="30" rows="10" style="resize: none"></textarea>
    </p>

    <p>
        <label for="PVP">PVP:</label>
        <input type="number" name="PVP" id="PVP">
    </p>

    <p>
        <label for="familia" hidden>Familia</label>
        <select name="familia" id="familia">
            <?php
            foreach ($familias->familias as $familia) {
                echo "<option value='$familia->cod'>" . $familia->nombre . "</option>";
            }
            ?>
        </select>
    </p>
    <input type="submit" name="insertar" value="Insertar">
</form>
<br>
<a style="text-decoration: none; color: black" href="index.php?salir=1">
    <button style="cursor: pointer">
        Volver
    </button>
</a>
<hr>