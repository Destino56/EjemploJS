<?php
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
    <title>Actualizar stock</title>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="imgs/favicon.png" type="image/x-icon" />
    <script src="js/actualizarStock.js"></script>
    <?php
    $resultado = $_GET["result"];
    if (isset($_GET["result"])) {
        if ($resultado == 0) {
            echo '<script>alert("Base actualizada correctamente");</script>';
        } elseif ($resultado == 2) {
            echo '<script>alert("Compruebe que la extension del archivo es csv");</script>';
        } else {
            echo '<script>alert("Error interno por favor contacte con GrupoFTP");</script>';
        }
    }
    ?>
</head>

<body>
    <header>
        <h1>Actualizar stock</h1>
    </header>
    <section>      
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
                <input type="radio" name="gender" value="total" required>TOTAL (Pone a 0 todas las ref de la campaña y actualiza el fichero csv)<br>
                <input type="radio" name="gender" value="parcial" required>PARCIAL (Actualiza las ref que coincidan con el fichero csv)<br>
                <br>
                <div>
                    <input type="file" name="uploadedFile" required />
                </div>
                <br>
                <input type="submit" name="uploadBtn" value="Actualizar" />
            </form>
            <br><!--*******************************-->

            <!--****************************-->
            <form name="formCambiarImagenArticulo" action="php_peticiones/upload-ftp.php" method="POST" enctype="multipart/form-data">
                <h1>Modificar precio:</h1>
                <p>CREF del artículo a modificar:
                    <input id="inp_CREFS" list="listaCREF" name="inp_CREFS" placeholder="REFERENCIAS" required onchange="cargaPrecios(); cargaColores() ">
                    <datalist id="listaCREF">
                    </datalist>

                </p>
                <div>
                    <p>Precio Mayorista: <input type="number" id="id_precioMayorista" name="updateMayorista" step="0.01"/>
                        PVP: <input type="number" id="id_precioPVP" name="updatePVP" step="0.01"/>
                        <input type="button" name="uploadPrice_btn" value="Actualizar" /></p>
                </div>
                <img id="id_img_producto" src="">
                <br>
                <h4>Cambiar imagen producto:</h4>
                <div>
                    <label for="upload">Selecciona una imagen</label>
                    <input name="upload" type="file" />
                    <input type="submit" name="submit" value="Guardar" />
                </div>
            </form>
                <br>
            <form name="formCambiarImagenColores" action="php_peticiones/uploadColor-ftp.php" method="POST" enctype="multipart/form-data">
                <h4>Cambiar imagen color seleccionado:</h4>
                <div>
                    <select id="id_selectColores" name="id_selectColores">
                        <option>COLOR</option>
                    </select>

                    <label for="upload">Selecciona una imagen</label>
                    <input name="uploadColor" type="file"/>
                    <input type="submit" name="submitColor" value="Guardar" />
                </div>
                <div id="id_fotoColores">
                </div>
            </form>
        </article>
    </section>
    <br>
    <br>
    <footer>
        Creado por GrupoFTP
    </footer>
</body>

</html>
