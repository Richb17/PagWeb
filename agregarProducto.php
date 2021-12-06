<?php
    include("funciones.php");
    $msg = "";
    autenticado();
    if(isset($_GET['err']) && $_GET['err'] != ""){
        if($_GET['err'] == "0") $msg = "Se subio correctamente el articulo";
        if($_GET['err'] == "1") $msg = "Se debe utilizar el formulario de registro";
        if($_GET['err'] == "2") $msg = "Se deben llenar todos los campos";
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
            if(document.getElementById("album").value=="" || 
                document.getElementById("artista").value=="" ||
                document.getElementById("precio").value=="" ||
                document.getElementById("formato").value==""||
                document.getElementById("stock").value==""||
                document.getElementById("titulo").value==""){
                    document.getElementById("msgAlerta").innerHTML = "Por favor llene todos los campos.";
                    return false;
                }
            else{
                document.getElementById("nombreStock").value = document.getElementById("album").value+"-"+document.getElementById("artista").value+"-"+document.getElementById("formato").value;
                return true;
            }
        }
    </script>
</head>
<body>
    <h1>Sistema de control de archivos</h1>
    <form method="post" enctype="multipart/form-data" action="registroProd.php" onsubmit="return validaFRM()">
        <h3>Formulario de subida de archivos</h3>

        <?php 
            if($msg != "" ){
                echo "<div id=\"msgAlerta\"> $msg </div>";
            }
            else{
                echo "<div id=\"msgAlerta\"></div>";
            }
        ?>
        
        Ingrese el nombre del álbum: <input type="text" id="album" name = "album"><br>
        Ingrese el nombre del artista: <input type="text" id="artista" name = "artista"><br>
        Ingrese el precio del árticulo: <input type="number" id="precio" required name="precio" min="0" placeholder="0.00" step="0.01"><br>
        Ingrese el formato del árticulo: <input type="text" id="formato" name = "formato" placeholder = "(CD, Vinilo, Cassete)"><br>
        Ingrese el género principal del árticulo: <input type="text" id="genero" name = "genero"><br>
        <input type="hidden" id="nombreStock" name="nombreStock">
        Descripción del árticulo: <input type="text" id="descripcion" name = "descripcion"><br>
        Ingrese la cantidad de productos en stock: <input type="number" id="stock" name = "stock"><br>
        <input type="hidden" id="titulo" name="titulo" value="Imagen Portada">
        Seleccione la imagen de portada del articulo: <input type="file" id="imagen" name="imagen" accept="image/*"><br>
        <input type="submit" value="Subir Producto">
        <input type="reset" value="Cancelar"> <br>
        <a href="portada.php">Regresar a inicio</a>
    </form>
</body>
</html>