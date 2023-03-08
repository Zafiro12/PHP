<?php
if(isset($_POST["btnAgregar"]))
{
    $error_referencia=$_POST["referencia"]==""||!is_numeric($_POST["referencia"])||$_POST["referencia"]<0;
    if(!$error_referencia)
    {
        $url=DIR_SERV."/repetido/libros/referencia/".urlencode($_POST["referencia"]);
        $respuesta=consumir_servicios_REST($url,"GET",$_SESSION["key"]);
        $obj=json_decode($respuesta);
        if(!$obj)
        {
            consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
            session_destroy();
            die(error_page("Examen Librería","Librería","<p>Error consumiendo el servicio REST: ".$url."</p>"));

        }

        if(isset($obj->error))
        {
            consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["api_session"]);
            session_destroy();
            die(error_page("Examen Librería","Librería","<p>".$obj->error."</p>"));
        }

        if(isset($obj->no_auth))
        {
            session_unset();
            $_SESSION["seguridad"]="El tiempo de sesión de la API ha expirado";
            header("Location:".$salto);
            exit;
        }
        $error_referencia=$obj->repetido;
    }
    $error_autor=$_POST["autor"]=="";
    $error_titulo=$_POST["titulo"]=="";
    $error_descripcion=$_POST["descripcion"]=="";
    $error_precio=$_POST["precio"]==""||!is_numeric($_POST["precio"])||$_POST["precio"]<=0;
    $error_portada=$_FILES["portada"]["name"]!="" && ($_FILES["portada"]["error"] || !getimagesize($_FILES["portada"]["tmp_name"]) || $_FILES["portada"]["size"]>500*1024);
    $error_form=$error_referencia||$error_autor||$error_titulo||$error_descripcion||$error_precio||$error_portada;
    if(!$error_form)
    {
        $datos["referencia"]=$_POST["referencia"];
        $datos["titulo"]=$_POST["titulo"];
        $datos["autor"]=$_POST["autor"];
        $datos["descripcion"]=$_POST["descripcion"];
        $datos["precio"]=$_POST["precio"];
        $datos["api_session"]=$_SESSION["key"]["api_session"];
        $url=DIR_SERV."/crearLibro";
        $respuesta=consumir_servicios_REST($url,"POST",$datos);
        $obj=json_decode($respuesta);
        if(!$obj)
        {
            consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["key"]);
            session_destroy();
            die(error_page("Examen Librería","Librería","<p>Error consumiendo el servicio REST: ".$url."</p>"));
        }

        if(isset($obj->error))
        {
            consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["key"]);
            session_destroy();
            die(error_page("Examen Librería","Librería","<p>".$obj->error."</p>"));
        }

        if(isset($obj->no_auth))
        {
            session_unset();
            $_SESSION["seguridad"]="El tiempo de sesión de la API ha expirado";
            header("Location:".$salto);
            exit;
        }

        $_SESSION["mensaje"]="Libro agregado con éxito";

        if($_FILES["portada"]["name"]!="")
        {
            $extension="";
            $array_nombre=explode(".",$_FILES["portada"]["name"]);
            if(count($array_nombre)>1)
                $extension=".".end($array_nombre);
            
            $nombre_portada="img_".$_POST["referencia"].$extension;
            @$var=move_uploaded_file($_FILES["portada"]["tmp_name"],"../images/".$nombre_portada);
            if($var)
            {
                $datos2["portada"]=$nombre_portada;
                $datos2["api_session"]=$_SESSION["key"]["api_session"];
                $url=DIR_SERV."/actualizarPortada/".urlencode($_POST["referencia"]);
                $respuesta=consumir_servicios_REST($url,"PUT",$datos2);
                $obj=json_decode($respuesta);
                if(!$obj)
                {
                    unlink("../images/".$nombre_portada);
                    consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["key"]);
                    session_destroy();
                    die(error_page("Examen Librería","Librería","<p>Error consumiendo el servicio REST: ".$url."</p>"));
                }

                if(isset($obj->error))
                {
                    unlink("../images/".$nombre_portada);
                    consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["key"]);
                    session_destroy();
                    die(error_page("Examen Librería","Librería","<p>".$obj->error."</p>"));
                }

                if(isset($obj->no_auth))
                {
                    unlink("../images/".$nombre_portada);
                    session_unset();
                    $_SESSION["seguridad"]="El tiempo de sesión de la API ha expirado";
                    header("Location:".$salto);
                    exit;
                }
                //Si llego aquí, se ha actualizado bien
            }
            else
                $_SESSION["mensaje"]="Libro agregado con éxito, pero con portada por defecto ya que no se ha podido mover imagen a carpeta destino"; 
        }   

        header("Location:index.php");
        exit;            
    }

}



if(isset($_POST["btnBorrar"]))
{
    $_SESSION["mensaje"]="El libro con referencia: ".$_POST["btnBorrar"]." ha sido borrado con éxito";
    header("Location:index.php");
    exit;
}

if(isset($_POST["btnEditar"]))
{
    $_SESSION["mensaje"]="El libro con referencia: ".$_POST["btnEditar"]." ha sido editado con éxito";
    header("Location:index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen Librería</title>
    <style>
        .enlinea{display:inline}
        .enlace{border:none;background:none;color:blue;text-decoration:underline;cursor:pointer}
        table,th, td{border:1px solid black}
        table{text-align:center;width:90%; margin:1em auto;border-collapse:collapse}
        th{background-color:#CCC}
        img{height:125px;float:left;margin-right:2em}
    </style>
</head>
<body>
    <h1>Librería</h1>
    <div>Bienvenido <strong><?php echo $datos_usu_log->lector;?></strong>
     - <form method="post" action="<?php echo $salto;?>" class="enlinea">
     <button name="btnSalir" class="enlace">Salir</button>
    </form>
    </div>
    <?php
    echo "<h3>Listado de los libros</h3>";
    $url=DIR_SERV."/obtenerLibros";
    $respuesta=consumir_servicios_REST($url,"GET");
    $obj=json_decode($respuesta);
    if(!$obj)
    {
        consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["key"]);
        session_destroy();
        die("<p>Error consumiendo el servicio: ".$url."</p></body></html>");
    }
    if(isset($obj->error))
    {
        consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["key"]);
        session_destroy();
        die("<p>".$obj->error."</p></body></html>");
    }
    echo "<table>";
    echo "<tr><th>Ref</th><th>Título</th><th>Acción</th></tr>";
    foreach($obj->libros as $libro)
    {
        echo "<tr>";
        echo "<td>".$libro->referencia."</td>";
        echo "<td><form action='index.php' method='post'>";
        echo "<input type='hidden' name='titulo' value='".$libro->titulo."'/>";
        echo "<input type='hidden' name='autor' value='".$libro->autor."'/>";
        echo "<input type='hidden' name='descripcion' value='".$libro->descripcion."'/>";
        echo "<input type='hidden' name='precio' value='".$libro->precio."'/>";
        echo "<input type='hidden' name='portada' value='".$libro->portada."'/>";
        echo "<button class='enlace' value='".$libro->referencia."' name='btnListar'>".$libro->titulo."</button></form></td>";
        echo "<td><form action='index.php' method='post'><button class='enlace' value='".$libro->referencia."' name='btnBorrar'>Borrar</button> - <button class='enlace' value='".$libro->referencia."' name='btnEditar'>Editar</button></form></td>";
        echo "</tr>";
    }
    echo "</table>";

    if(isset($_SESSION["mensaje"]))
    {
        echo "<p class='mensaje'>".$_SESSION["mensaje"]."</p>";
        unset($_SESSION["mensaje"]);
    }

    if(isset($_POST["btnListar"]))
    {
        echo "<h2>Detalles del Libro con Referencia ".$_POST["btnListar"]."</h2>";
        echo "<p><img src='../images/".$_POST["portada"]."'/></p>";
        echo "<p><strong>Título: </strong>".$_POST["titulo"]."</p>";
        echo "<p><strong>Autor: </strong>".$_POST["autor"]."</p>";
        echo "<p><strong>Descripción: </strong>".$_POST["descripcion"]."</p>";
        echo "<p><strong>Precio: </strong>".$_POST["precio"]."€</p>";
        echo "<form action='index.php' method='post'><button>Volver</button></form>";
    }
    else
    {
    ?>
    <h3>Agregar un nuevo libro</h3>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="referencia">Referencia: </label>
            <input type="text" name="referencia" id="referencia" value="<?php if(isset($_POST["referencia"])) echo $_POST["referencia"]; ?>"/>
            <?php
            if(isset($_POST["btnAgregar"])&&$error_referencia)
            {
                if($_POST["referencia"]=="")
                    echo "<span class='error'> * Campo vacío * </span>";
                elseif(!is_numeric($_POST["referencia"])||$_POST["referencia"]<0)
                    echo "<span class='error'> * No es un valor de referencia válido * </span>";
                else
                    echo "<span class='error'> * Referencia repetida * </span>";
            }
            ?>
        </p>
        <p>
            <label for="titulo">Título: </label>
            <input type="text" name="titulo" id="titulo" value="<?php if(isset($_POST["titulo"])) echo $_POST["titulo"]; ?>"/>
            <?php
            if(isset($_POST["btnAgregar"])&&$error_titulo)
            {
                 echo "<span class='error'> * Campo vacío * </span>";
            }
            ?>
        </p>
        <p>
            <label for="autor">Autor: </label>
            <input type="text" name="autor" id="autor" value="<?php if(isset($_POST["autor"])) echo $_POST["autor"]; ?>"/>
            <?php
            if(isset($_POST["btnAgregar"])&&$error_autor)
            {
                echo "<span class='error'> * Campo vacío * </span>";
            }
            ?>
        </p>
        <p>
            <label for="descripcion">Descripción: </label>
            <textarea name="descripcion" id="descripcion"><?php if(isset($_POST["descripcion"])) echo $_POST["descripcion"]; ?></textarea>
            <?php
            if(isset($_POST["btnAgregar"])&&$error_descripcion)
            {
                echo "<span class='error'> * Campo vacío * </span>"; 
            }
            ?>
        </p>
        <p>
            <label for="precio">Precio: </label>
            <input type="text" name="precio" id="precio" value="<?php if(isset($_POST["precio"])) echo $_POST["precio"]; ?>"/>
            <?php
            if(isset($_POST["btnAgregar"])&&$error_precio)
            {
                if($_POST["precio"]=="")
                    echo "<span class='error'> * Campo vacío * </span>";
                else
                    echo "<span class='error'> * No es un valor de precio válido * </span>";
                
            }
            ?>
        </p>
        <p>
            <label for="portada">Portada: </label>
            <input type="file" name="portada" id="portada" accept="image/*"/>
            <?php
            if(isset($_POST["btnAgregar"])&&$error_portada)
            {
                if($_FILES["portada"]["name"]!="")
                {
                    if($_FILES["portada"]["error"])
                        echo "<br/><span class='error'> * Error en la subida de la imagen al servidor * </span>";
                    elseif(!getimagesize($_FILES["portada"]["tmp_name"]) )
                        echo "<br/><span class='error'> * El archivo seleccionado no es un archivo imagen * </span>";
                    else
                        echo "<br/><span class='error'> * El tamaño del archivo seleccionado excede los 500KB * </span>";
                }
            }
            ?>
        </p>
        <p>
            <button name="btnAgregar" type="submit">Agregar</button>
        </p>
    </form>
    <?php
    }
    ?>
</body>
</html>
