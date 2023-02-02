<table style="width: 500px;">
    <?php
    echo "<tr>";
    echo "<th>Código</th><td>" . $producto->cod . "</td></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<th>Nombre</th><td>" . $producto->nombre_corto . "</td></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<th>Descripción</th><td>" . $producto->descripcion . "</td></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<th>PVP</th><td>" . $producto->PVP . "</td></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<th>Familia</th><td>" . $producto->familia . "</td></td>";
    echo "</tr>";
    ?>
</table>
<br>
<a style="text-decoration: none; color: black" href="index.php?salir=1">
    <button style="cursor: pointer">
        Volver
    </button>
</a>
<hr>
