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
<?php include("includes/divSesion.php") ?>

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
    <title>Actualizar stock</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/actualizarStock.css">


    <link rel="shortcut icon" href="imgs/favicon.png" type="image/x-icon" />
    <script src="js/actualizarStock.js"></script>
    <?php

    if (isset($_GET["result"])) {
        $resultado = $_GET["result"];
        if ($resultado == 0) {
            echo '<script>alert("Base actualizada correctamente");</script>';
        } elseif ($resultado == 2) {
            echo '<script>alert("Compruebe que la extension del archivo es csv");</script>';
        } else {
            echo '<script>alert("Error interno por favor contacte con GrupoFTP");</script>';
        }
    }
    ?>


<body>
    <section class="sectionPrincipal">
        <header>
            <h1>Actualizar stock</h1>
        </header>
        <article>
            <form method="POST" action="upload.php" enctype="multipart/form-data">
                <p>Seleccione una campaña:</p>
                <select id="camapana" name="campana" class="datalist">
                    <option value="">NINGUNO</option>
                    <?php
                    $sql = "SELECT distinct(NNOMCAT)
                            FROM H_PEDCLIT
                            WHERE NNOMCAT != ''";
                    $registros = mysqli_query($DB, $sql) or die("**Error query " . mysqli_errno($DB) . ": " . mysqli_error($DB) . " $sql\n");
                    while ($row = mysqli_fetch_object($registros)) {
                        if ($row->NNOMCAT != "") {
                            if (isset($_POST["campana"]) and $_POST["campana"] == $row->NNOMCAT) {
                                echo '<option value="' . $row->NNOMCAT . '" selected>' . $row->NNOMCAT . '</option>';
                            } else {
                                echo '<option value="' . $row->NNOMCAT . '">' . $row->NNOMCAT . '</option>';
                            }
                        }
                    }
                    mysqli_free_result($registros);
                    ?>
                </select>
                <br>
                <br>

                <input type="radio" name="gender" value="total" required>
                <label for="">TOTAL (Pone a 0 todas las ref de la campaña y actualiza el fichero csv)</label><br>
                <input type="radio" name="gender" value="parcial" required>
                <label for="">PARCIAL (Actualiza las ref que coincidan con el fichero csv)</label><br>
                <br>
                <div>
                    <input type="file" name="uploadedFile" required />
                </div>
                <br>
                <input type="submit" name="uploadBtn" value="Actualizar" />
            </form>
            <br>
            <!--*******************************-->

            <!--****************************-->
            <form name="formCambiarImagenArticulo" action="php_peticiones/upload-ftp.php" method="POST" enctype="multipart/form-data">
                <h1>Modificar producto:</h1>

                <div class="flex">
                    <p>CREF del artículo a modificar:</p>
                    <input id="inp_CREFS" list="listaCREF" name="inp_CREFS" placeholder="REFERENCIAS" required>
                    <input type="button" name="btnCref" id="btnCref" value="buscar" onclick="cargaPrecios(); cargaColores()">
                </div>
                <datalist id="listaCREF">
                </datalist>
                <div class="flex" width=100%>

                    <div class="tabla tablaStock col-8">
                        <table class="hoverTable" id="tabla"></table>
                    </div>
                    <div class="col-4 flex btnStock">
                        <input type="button" name="btnStock" id="btnStock" value="Actualizar" />
                    </div>
                
                </div>

                

                <div>
                    <p>Precio Mayorista: <input type="number" id="id_precioMayorista" name="updateMayorista" step="0.01" class="precios" />
                        PVP: <input type="number" id="id_precioPVP" name="updatePVP" step="0.01" class="precios" />
                        <input type="button" name="uploadPrice_btn" value="Actualizar" id="id_btnActualizarPrecio" />
                    </p>
                </div>

                <div class="conjunto" id="conjunto">
                    <div class="col-img flex" id="divProducto"></div>
                    <div class="col-colores fotocolores" id="id_fotoColores"></div>
                </div>

                <br>
                <h4>Cambiar imagen producto:</h4>
                <div>
                    <label for="upload">Selecciona una imagen (.jpg)</label>
                    <input name="upload" type="file" accept="image/jpeg" />
                    <input type="submit" name="submit" value="ACTUALIZAR" target="request" />
                </div>
                <iframe id="request" style="position: absolute; width: 0; height: 0; border: 0;"></iframe>
            </form>
            <br>
            <form name="formCambiarImagenColores" action="php_peticiones/uploadColor-ftp.php" method="POST" enctype="multipart/form-data">
                <h4>Cambiar imagen color seleccionado:</h4>
                <div>
                    <select id="id_selectColores" name="id_selectColores">
                        <option>COLOR</option>
                    </select>

                    <label for="upload">Selecciona una imagen (.jpg)</label>
                    <input name="uploadColor" type="file" accept="image/jpeg" />
                    <input type="submit" name="submitColor" value="Actualizar" />
                </div>

            </form>
        </article>




    </section>

    <footer>Creado por GRUPO FTP</footer>
    <?php
    include("includes/divFooter.html");
    ?>



</body>


</html>