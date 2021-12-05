<?php
    session_start();
    include("funciones.php");
    $msg = "";
    if(!isset($_SESSION["idusuario"])){
        header($ruta."Portada.php");
    }
    else{
        if($_SESSION['role'] == 1){
            header($ruta."Portada.php");
        }
        else{
            if(!isset($_POST['album']) || !isset($_POST['formato']) || !isset($_POST['imagen']) || !isset($_POST['titulo'])){
                $msg = "Por favor llenar el formulario";
                header($ruta."subirImagen.php");
            }
            else if($_POST['album']== "" || $_POST['formato']=="" || $_POST['imagen']=="" || $_POST['titulo']==""){
                $msg = "Algún valor del formulario se envio vacio, favor de llenar todos los campos";
                header($ruta."subirImagen.php");
            }
            else{
                
            }
        }
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
    <form method="post" enctype="multipart/form-data" action="subirImagen.php" onsubmit="return validaFRM()">
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