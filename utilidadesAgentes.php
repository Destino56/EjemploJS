<?php
//Revisa que todas las cookies necesarias
if (!isset($_COOKIE['usuario']) or !isset($_COOKIE['codAg'])) {
    header('Location: index.php');
}

if (!isset($_COOKIE['admin'])) {
    die("Usted no tiene permisos de acceso a esta pagina.");
}

//Conecta a la base de datos
include('includes/conexionmysqli.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!--LIBRERIA JQUERY-->
    <script src="js/jquery-2.1.1.min.js"></script>
    <!--SCRIPT PARA DESACTIVAR EL INTRO EN LOS BOTONES SUBMIT DE LOS FORM-->
    <script type="text/javascript">
        $(document).ready(function() {
            $("form").keypress(function(e) {
                if (e.which == 13) {
                    return false;
                }
            });
        });
    </script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/actualizarStock.css">

    <link rel="shortcut icon" href="imgs/favicon.png" type="image/x-icon" />
    <script src="js/utilidadesAgentes.js"></script>
    <title>Approach | Utilidades Agentes</title>
</head>

<body>
    <?php include("includes/divSesion.php") ?>

    <div class="centrar sectionPrincipal">
        <div class="cardPTabla">
            <h1>Agentes</h1>

            <p><input type="text" placeholder="Agente" id="txtAgente">
                <input type="button" class="btnAgente" value="Buscar" id="btnBuscarAgente">
            </p>

            <div class="flex col-12">
                <div class="col-6">
                    <div class="list-group" id="list-group">

                    </div>
                </div>

                <div class="col-6">
                    <div class="flex datosAgente">
                        <label for="aNombre">Nombre</label>
                        <input type="text" class="inMedio" placeholder="Nombre" id="aNombre">
                        <label for="aApellido">Apellido </label>
                        <input type="text" class="inGrande" placeholder="Apellido" id="aApellido">
                    </div>
                    <div class="flex datosAgente">
                        <label for="aPassword">Clave</label>
                        <input type="text" class="inMedio" placeholder="Contraseña" id="aPassword">
                        <label for="aRPassword">Repetir clave</label>
                        <input type="text" class="inMedio" placeholder="Contraseña" id="aRPassword">
                    </div>
                    <div class="flex datosAgente">
                        <label for="aPassword">Email</label>
                        <input type="email" class="inGrande" placeholder="Email" id="aEmail">
                    </div>

                    <div class="flex btnActAgente">

                        <input type="button" value="Actualizar agente" id="btnActualizarAgente">
                        <input type="button" class="btnBorrar" value="Borrar agente" id="btnBorrarAgente">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="centrar divInsertar">
        <div class="cardInsertar cardP">
            <form name="formInsertar">
                <p>
                    <input class="inputsInsertar inp_insert" id="id_inpInsertarNombre" type="text" placeholder="Nombre">
                    <input class="inputsInsertar inp_insert" id="id_inpInsertarApellido" type="text" placeholder="Apellido">
                    <input class="inputsInsertar inp_insert" id="id_inpInsertarPass" type="text" placeholder="Contraseña">
                </p>

                <p>
                    <input class="inputsInsertar" id="id_inpInsertarEmail" type="text" placeholder="Email">
                    Admin: <select class="inputsInsertar" id="id_inpInsertarAdmin">
                        <option value="0">No</option>
                        <option value="1">Si</option>
                    </select>
                    Nacionalidad: <select class="inputsInsertar" id="id_inpInsertarCodNac">
                        <option value="ESP">España</option>
                        <option value="PORT">Portugal</option>
                    </select>
                </p>
                <input type="button" value="Insertar agente" onclick="insertaAgente()">
            </form>
        </div>
    </div>

    <?php
    include("includes/divFooter.html");
    ?>
    <p id="firma"> Diseño y desarrollo web <a href="http://www.grupoftp.com" target="_blank" title="Grupo FTP Web" rel="nofollow">FTP Company</a></p>

</body>

</html>
