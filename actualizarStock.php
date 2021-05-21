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
    <title>Approach | Utilidades</title>
    <meta charset="utf-8" />
    <meta name="author" content="FTP Company">

    <meta name="description" content="Aplicación de gestión de registro de pedidos">
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
    <?php include("includes/divSesion.php") ?>
    <section class="sectionPrincipal ">
        <div class="centrar">
            <div class="cardP">

                <h1>Actualizar stock</h1>


                <form method="POST" action="upload.php" enctype="multipart/form-data">
                    <p>Seleccione una campa&ntildea:</p>
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
                    <label for="">TOTAL (Pone a 0 todas las ref de la campa&ntildea y actualiza el fichero csv)</label><br>
                    <input type="radio" name="gender" value="parcial" required>
                    <label for="">PARCIAL (Actualiza las ref que coincidan con el fichero csv)</label><br>
                    <br>

                    <input type="file" name="uploadedFile" required />

                    <br>
                    <input type="submit" name="uploadBtn" value="Actualizar" />
                </form>

            </div>
        </div>

        <br>
        <!--*******************************-->

        <!--****************************-->

        <form name="formCambiarImagenArticulo" action="php_peticiones/upload-ftp.php" method="POST" enctype="multipart/form-data" class="marginBotPalFooter">
            <div class="centrar">
                <div class="cardPTabla">
                    <h1>Modificar producto</h1>

                    <div class="flex centrarCref">
                        <p>CREF del art&iacuteculo a modificar:</p>
                        <input id="inp_CREFS" list="listaCREF" name="inp_CREFS" placeholder="REFERENCIAS" class="busqueda" required>
                        <input type="button" name="btnCref" id="btnCref" value="buscar" onclick="cargaPrecios(); cargaColores(); cargaCategorias()">
                    </div>
                    <datalist id="listaCREF">
                    </datalist>
                    <div class="flex" width=100%>

                        <div class="tabla tablaStock">
                            <table class="hoverTable" id="tabla"></table>
                        </div>
                    </div>
                    <div>
                        <p>Precio Mayorista: <input type="number" id="id_precioMayorista" name="updateMayorista" step="0.01" class="precios" />
                            PVP: <input type="number" id="id_precioPVP" name="updatePVP" step="0.01" class="precios" />
                            Colecci&oacuten: <select id="id_selectCategorias"></select>
                            Familia: <select id="id_selectFamilias"></select>
                        </p>
                    </div>

                    <div class="conjunto" id="conjunto">
                        <div class="col-img flex" id="divProducto"></div>
                        <div class="col-colores fotocolores" id="id_fotoColores"></div>
                    </div>

                    <div class="btnDiv">
                        <input type="button" name="btnActualizarProducto" id="id_btnActualizarProducto" value="Actualizar producto">
                    </div>

                </div>
            </div>


            <div class="flex col-6">

                <div class="cardP">

                    <h4>Actualizar imagen producto</h4>
                    <div class="col-12 flex">
                        <div class="col-6 marginTop">
                            <input name="upload" type="file" accept="image/jpeg" class="inputFotos" />
                            <p class="interlineado">formato .jpg</p>

                        </div>

                        <div class="col-6">
                            <input type="submit" name="submit" value="Actualizar imagen" target="request" />
                        </div>

                    </div>


                </div>
            </div>
        </form>

        <div class="flex col-6 moverArriba">

            <div class="cardP menosPaddingtop">
                <form name="formCambiarImagenColores" action="php_peticiones/uploadColor-ftp.php" method="POST" enctype="multipart/form-data">
                    <h4>Actualizar muestra de color</h4>
                    <div class="muestraColor">
                        <select id="id_selectColores" name="id_selectColores">
                            <option>COLOR</option>
                        </select>

                        <div class="btnDivImagenes">

                            <div class="col-6 marginTop">
                                <input name="uploadColor" type="file" accept="image/jpeg" class="inputFotos" />
                                <p class="interlineado">formato .jpg</p>
                            </div>
                            <input type="submit" name="submitColor" value="Actualizar muestra" class="margenesInput" />
                        </div>

                    </div>

                </form>
            </div>
        </div>




        

        <div class="centrar">
            <div class="cardP" id="divExport">
                <h1>Exportar datos</h1>

                <div class="flexExport">
                    <select name="" id="selectExportacion" >
                        <option default value="SELECT * FROM FPAGO">Pagos</option>
                    </select>
                    <input type="button" value="Descargar" id="btnExportar">
                </div>

            </div>
        </div>




    </section>
    <?php
    include("includes/divFooter.html");
    ?>
    <p id="firma"> Diseño y desarrollo web <a href="http://www.grupoftp.com" target="_blank" title="Grupo FTP Web" rel="nofollow">FTP Company</a></p>



</body>


</html>