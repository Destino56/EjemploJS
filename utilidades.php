<?php
//Revisa que todas las cookies necesarias
if (!isset($_COOKIE['usuario']) or !isset($_COOKIE['codAg'])) {
    header('Location: index.php');
}

if (!isset($_COOKIE['admin'])) {
    die("Usted no tiene permisos de acceso a esta pagina.");
}




?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="FTP Company">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="imgs/favicon.png" type="image/x-icon" />
    <meta name="description" content="Aplicación de gestión de registro de pedidos">
    <title>Approach | Seleccionar Cliente</title>
    <!-- Externos head -->
    <link rel="stylesheet" href="css/estilos.css">

    <!-- HTML5 shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>

<body>
    <div id="contenedor">
        <header>
            <nav>
                <?php include('includes/divSesion.php'); ?>
                <p class="migas">
                    <a href="home.php">Inicio</a> / &nbsp;Utilidades</a>
                </p>
                <div class="clear"></div>
            </nav>
        </header>
        <section id="home">
            <h1>UTILIDADES</h1>
            <article>
                <div id="botonescont">
                    <a href="utilidadesAgentes.php" title="Venta a Cliente">
                        <div class="btonhome">
                            <img class="imgresponsiveHome" src="imgs/cliente.png" />
                            <h2 class="desactivo">AGENTES</h2>
                        </div>
                    </a>


                    <a href="actualizarStock.php" title="Compra a Proveedor">
                        <div class="btonhome">
                            <img class="imgresponsiveHome" src="imgs/vender.png" />
                            <h2>STOCK<br></h2>
                        </div>
                    </a>
                </div>
                <div class="clear"></div>
            </article>
        </section>
        <?php include('includes/divFooter.html'); ?>
    </div>
    <p id="firma"> Diseño y desarrollo web <a href="http://www.grupoftp.com" target="_blank" title="Grupo FTP Web" rel="nofollow">FTP Company</a></p>
</body>

</html>