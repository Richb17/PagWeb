<?php
include("include/funciones.php");

# Conectamos con MySQL
$conexion = conectarBD();
 
# Buscamos la imagen a mostrar
$result = $conexion->query("SELECT * FROM `imagenes` WHERE id=".$_GET["id"]);
$row = $result->fetch_array(MYSQLI_ASSOC);
 
# Mostramos la imagen
header("Content-type:".$row["tipo"]);
echo $row["content"];
?>