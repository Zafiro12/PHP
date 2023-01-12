<?php
    session_name("login");
    session_start();

    require_once("sql/config.php");


    function error_page($error_message) {
        http_response_code(500);
        echo '<html>
                <head>
                    <title>Error</title>
                </head>
                <body>
                    <h1>Error</h1>
                    <p>' . $error_message . '</p>
                </body>
            </html>';
        exit();
    }
    

    if (isset($_SESSION["usuario"]))
    {
        echo "Logeado";
    }
    else
    {
        require_once("views/login.php");
    }
?>