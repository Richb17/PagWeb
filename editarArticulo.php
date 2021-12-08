<?php
include("funciones.php");
$msg = "";
autenticado();
if(isset($_GET['err']) && $_GET['err'] != ""){
    if($_GET['err'] == "0") $msg = "Se actualizo correctamente el articulo";
    if($_GET['err'] == "1") $msg = "Se debe utilizar el formulario de registro";
    if($_GET['err'] == "2") $msg = "Se deben llenar todos los campos";
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script type="text/javascript">
        function validaFRM(){
            if(document.getElementById("album").value=="" || 
                document.getElementById("artista").value=="" ||
                document.getElementById("precio").value=="" ||
                document.getElementById("stock").value==""){
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
    <form method="get" action="actualizaProd.php" onsubmit="return validaFRM()">
        <h3>Formulario de subida de archivos</h3>

        <?php 
            if($msg != "" ){
                echo "<div id=\"msgAlerta\"> $msg </div>";
            }
            else{
                echo "<div id=\"msgAlerta\"></div>";
            }
            $conexion = conectarBD();
            $res = $conexion->query("SELECT * FROM `productos` WHERE `idprod`=".$_GET['id']);
            if($res){
                $row = $res->fetch_array(MYSQLI_ASSOC);
                echo "<input type='hidden' id='idP' name='idprod' value='".$_GET['id']."'>";
                echo "Ingrese el nombre del álbum: <input type=\"text\" id=\"album\" name = \"album\" value=\"".$row['albumname']."\"><br>";
                echo "Ingrese el nombre del artista: <input type=\"text\" id=\"artista\" name = \"artista\" value=\"".$row['artistname']."\"><br>";
                echo "Ingrese el precio del árticulo: <input type=\"number\" id=\"precio\" required name=\"precio\" min=\"0\" value=\"".$row['prices']."\" step=\"0.01\"><br>";
                echo "Descripción del árticulo: <input type=\"text\" id=\"descripcion\" name = \"descripcion\" value=\"".$row['description']."\"><br>";
                $stock = $conexion->query("SELECT `quantity` FROM `stock` WHERE `id` = ".$row['idstock'].";");
                $value = $stock->fetch_array(MYSQLI_ASSOC);
                echo"Ingrese la cantidad de productos en stock: <input type=\"number\" id=\"stock\" name = \"stock\" value=\"".$value['quantity']."\"><br>";
            }else{
                header($ruta."Portada.php");
            }  
        ?>
        <input type="submit" value="Actualizar">
        <input type="reset" value="Cancelar"> <br>
        <a href="portada.php">Regresar a inicio</a>
    </form>
</body>
</html>