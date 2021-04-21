<?php
    //clase para actualizar el color de un articulo

    $color = $_POST["id_selectColores"];

    //echo $color;

    $connection = ftp_connect("hosting.ftpcomputers.info");
    $login = ftp_login($connection, "antonioalonso_ftpagentes_u", "bzbMtbMDS5#");
    if( (!$connection) || (!$login)){
        echo 'No se pudo conectar';
    }else{
        echo 'Conectado correctamente <br>' ;
        $temp = explode(".", $_FILES['uploadColor']['name']);
        $source_file = $_FILES['uploadColor']['tmp_name'];
        $destino_nombre = "web/imgs/muestras/" . $color . ".jpg";
        //$nombre=$_FILES['upload']['name'];
        $upload = ftp_put($connection, $destino_nombre, $source_file, FTP_BINARY);

        if ($upload){
            echo "<script>
                    window.location= '../actualizarStock.php'
                    alert('Imagen actualizada');
                </script>";
        }else{
            echo "          No se ha podido subir la imágen";
        }
    }

?>