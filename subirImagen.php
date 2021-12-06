<?php
    include("funciones.php");
    $msg = "";
    if(isset($_GET['err']) && $_GET['err'] != ""){
        if($_GET['err'] == "0") $msg = "Se subió el archivo correctamente";
        if($_GET['err'] == "1") $msg = "Se debe utilizar el formulario de registro";
        if($_GET['err'] == "2") $msg = "Se deben llenar todos los campos";
        if($_GET['err'] == "3") $msg = "No se encontró el producto que se especifico";
    }
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgregarProducto</title>

    <script type="text/javascript">
        function validaFRM(){
            if( document.getElementById("album").value=="" ||
                document.getElementById("formato").value==""||
                document.getElementById("titulo").value=="" ||
                document.getElementById("imagen").value==""){
                    document.getElementById("msgAlerta").innerHTML = "Por favor llene todos los campos.";
                    return false;
                }
            else{
                return true;
            }
        }
    </script>
</head>
<body>
    <h1>Sistema de control de archivos</h1>
    <form method="post" enctype="multipart/form-data" action="registraImagen.php" onsubmit="return validaFRM()">
        <h3>Formulario de subida de imagenes</h3>

        <?php 
            if($msg != "" ){
                echo "<div id=\"msgAlerta\"> $msg </div>";
            }
            else{
                echo "<div id=\"msgAlerta\"></div>";
            }
        ?>
        
        Ingrese el nombre del álbum al que pertenece la imagen: <input type="text" id="album" name = "album"><br>
        Ingrese el formato del árticulo: <input type="text" id="formato" name = "formato" placeholder = "(CD, Vinilo, Cassete)"><br>
        Ingrese el titulo de la imagen: <input type="text" id="titulo" name = "titulo"><br>
        Seleccione la imagen a subir: <input type="file" id="imagen" name="imagen" accept="image/*"><br>
        <input type="submit" value="Subir Imagen">
        <input type="reset" value="Cancelar"> <br>
        <a href="portada.php">Regresar a inicio</a>
    </form>
</body>
</html>
