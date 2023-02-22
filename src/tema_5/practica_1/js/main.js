const SERVER_DIR = "http://localhost/tema_4/actividad_1/servicio";

function obtener_productos() {
    $.ajax({
        url: SERVER_DIR + "/productos",
        type: "GET",
        dataType: "json",
    })
        .done(function (data) {
            if (data.mensaje_error) {
                $("#respuesta").html(data.mensaje_error);
            } else {
                var html_output =
                    "<table><tr><th>COD</th><th>Nombre Corto</th><th>PVP</th></tr>";
                $.each(data.productos, function (_key, tupla) {
                    html_output += "<tr>";
                    html_output +=
                        '<td class="codigo">' + tupla["cod"] + "</td>";
                    html_output += "<td>" + tupla["nombre_corto"] + "</td>";
                    html_output += "<td>" + tupla["PVP"] + "</td>";
                    html_output += "</tr>";
                });
                html_output += "</table>";
                $("#productos").html(html_output);
            }
        })
        .fail(function (a, b) {
            $("#respuesta").html(error_ajax_jquery(a, b));
        });
}

$(document).ready(function () {
    obtener_productos();

    $(".codigo").click(function () {});
});
