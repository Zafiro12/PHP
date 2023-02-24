const SERVER_DIR = "http://localhost/tema_4/actividad_1/servicio";

function volver() {
    $("#respuesta").html("");
}

function addProducto() {
    $("#respuesta").html(
        "<h2 style='text-align: center;'>Añadir producto</h2>" +
            "<form id='addForm'>" +
            "<label for='cod'>Código</label>" +
            "<input type='text' id='cod' name='cod' required>" +
            "<label for='nombre_corto'>Nombre corto</label>" +
            "<input type='text' id='nombre_corto' name='nombre_corto' required>" +
            "<label for='nombre'>Nombre</label>" +
            "<input type='text' id='nombre' name='nombre' required>" +
            "<label for='descripcion'>Descripción</label>" +
            "<input type='text' id='descripcion' name='descripcion' required>" +
            "<label for='PVP'>PVP</label>" +
            "<input type='number' id='PVP' name='PVP' required>" +
            "<input type='submit' value='Añadir'>" +
            "</form>"
    );
}

function getProducto(codigo) {
    $.ajax({
        url: SERVER_DIR + "/producto/" + codigo,
        type: "GET",
        dataType: "json",
    })
        .done(function (data) {
            if (!data) {
                $("#respuesta").html(
                    '<h2 style="text-align: center;">ERROR</h2><p>No se ha podido obtener el producto</p>'
                );
            } else {
                let html_output =
                    "<table style='width:500px; margin:5px;'><tr><th>" +
                    data.producto["cod"] +
                    "</th></tr>";
                html_output +=
                    "<tr><td>" + data.producto["nombre_corto"] + "</td></tr>";
                html_output +=
                    "<tr><td>" + data.producto["descripcion"] + "</td></tr>";
                html_output += "<tr><td>" + data.producto["PVP"] + "</td></tr>";
                html_output += "</table>";
                html_output +=
                    "<button style='margin-bottom:50px;' onclick='volver()'>Volver</button>";
                $("#respuesta").html(html_output);
            }
        })
        .fail(function (_a, b) {
            $("#respuesta").html("Error en la petición: " + b);
        });
}

function getProductos() {
    $.ajax({
        url: SERVER_DIR + "/productos",
        type: "GET",
        dataType: "json",
    })
        .done(function (data) {
            if (!data) {
                $("#respuesta").html(
                    '<h2 style="text-align: center;">ERROR</h2><p>No se ha podido obtener la lista de productos</p>'
                );
            } else {
                let html_output =
                    '<table><tr><th>COD</th><th>Nombre Corto</th><th>PVP</th><th id="add" colspan="2">Añadir producto</th></tr>';
                $.each(data.productos, function (_key, tupla) {
                    html_output += "<tr>";
                    html_output +=
                        '<td class="codigo">' + tupla["cod"] + "</td>";
                    html_output += "<td>" + tupla["nombre_corto"] + "</td>";
                    html_output += "<td>" + tupla["PVP"] + "</td>";
                    html_output +=
                        '<td class="editar">Editar</td><td class="borrar">Borrar</td>';
                    html_output += "</tr>";
                });
                html_output += "</table>";
                $("#productos").html(html_output);
                $(".codigo").click(function () {
                    $("#respuesta").html(getProducto($(this).html()));
                });
                $("#add").click(function () {
                    $("#respuesta").html(addProducto());
                });
            }
        })
        .fail(function (_a, b) {
            $("#respuesta").html("Error en la petición: " + b);
        });
}

$(document).ready(function () {
    getProductos();
});
